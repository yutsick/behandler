<?php
/**
 * Class WC_Bookings_Google_Calendar_Connection
 *
 * @package WooCommerce/Bookings
 */

/**
 * Google Calendar Connection.
 */
class WC_Bookings_Google_Calendar_Connection extends WC_Settings_API {

	const CONNECT_WOOCOMMERCE_URL = WC_BOOKINGS_CONNECT_WOOCOMMERCE_URL;

	const TOKEN_TRANSIENT_TIME = 3500;

	const DAYS_OF_WEEK = array(
		1 => 'monday',
		2 => 'tuesday',
		3 => 'wednesday',
		4 => 'thursday',
		5 => 'friday',
		6 => 'saturday',
		7 => 'sunday',
	);

	/**
	 * The single instance of the class.
	 *
	 * @var $_instance
	 * @since 1.13.0
	 */
	protected static $_instance = null;

	/**
	 * Name for nonce to update calendar settings.
	 *
	 * @since 1.13.0
	 * @var string self::NONCE_NAME
	 */
	const NONCE_NAME = 'bookings_calendar_settings_nonce';

	/**
	 * Action name for nonce to update calendar settings.
	 *
	 * @since 1.13.0
	 * @var string self::NONCE_ACTION
	 */
	const NONCE_ACTION = 'submit_bookings_calendar_settings';

	/**
	 * If the service is currently is a poll operation with google.
	 *
	 * @var bool
	 */
	protected $polling = false;

	/**
	 * WooCommerce Logger instance.
	 *
	 * @var WC_Logger_Interface
	 */
	protected $log;

	/**
	 * Google Service from SDK.
	 *
	 * @var Google_Service_Calendar
	 */
	protected $service;

	/**
	 * If form_fields has been initialized.
	 *
	 * @var bool
	 */
	private $form_fields_initialized = false;

	/**
	 * Init and hook in the integration.
	 */
	private function __construct() {

		$this->plugin_id = 'wc_bookings_';
		$this->id        = 'google_calendar_wooconnect';

		$this->maybe_migrate_old_settings();

		// Actions.
		add_action( 'woocommerce_api_wc_bookings_google_calendar', array( $this, 'oauth_redirect' ) );

		add_action( 'init', array( $this, 'register_booking_update_hooks' ) );

		add_action( 'woocommerce_before_booking_global_availability_object_save', array( $this, 'sync_global_availability' ) );

		add_action( 'woocommerce_bookings_before_delete_global_availability', array( $this, 'delete_global_availability' ) );

		add_action( 'trashed_post', array( $this, 'remove_booking' ) );
		add_action( 'untrashed_post', array( $this, 'sync_untrashed_booking' ) );
		add_action( 'wc-booking-poll-google-cal', array( $this, 'poll_google_calendar_events' ) );
		add_action( 'shutdown', array( $this, 'maybe_schedule_poller' ) );

		add_action( 'woocommerce_bookings_update_google_client', array( $this, 'maybe_enable_legacy_integration' ), 1, 5 );
	}

	/**
	 * Get configured calendar id.
	 *
	 * @return string
	 */
	protected function get_calendar_id() {
		return $this->get_option( 'calendar_id' );
	}

	/**
	 * Get configured sync preference
	 *
	 * @return string
	 */
	protected function get_sync_preference() {
		return $this->get_option( 'sync_preference' );
	}

	/**
	 * Get WC_Logger if enabled.
	 *
	 * @return WC_Logger|null
	 */
	protected function get_logger() {
		if ( null === $this->log && 'yes' === $this->get_option( 'debug' ) ) {
			if ( class_exists( 'WC_Logger' ) ) {
				$this->log = new WC_Logger();
			} else {
				$this->log = WC()->logger();
			}
		}
		return $this->log;
	}

	/**
	 * Logging method.
	 *
	 * @param string $message Log message.
	 * @param array  $context Optional. Additional information for log handlers.
	 * @param string $level   Log level.
	 *                        Available options: 'emergency', 'alert',
	 *                        'critical', 'error', 'warning', 'notice',
	 *                        'info' and 'debug'.
	 *                        Defaults to 'info'.
	 */
	private function log( $message, $context = array(), $level = WC_Log_Levels::NOTICE ) {
		$logger = $this->get_logger();
		if ( is_null( $logger ) ) {
			return;
		}

		if ( ! isset( $context['source'] ) ) {
			$context['source'] = $this->id;
		}

		$logger->log( $level, $message, $context );
	}

	/**
	 * $this->id changed so we need to migrate any old settings that may exist.
	 */
	private function maybe_migrate_old_settings() {
		$existing_options = get_option( $this->get_option_key(), null );
		if ( null !== $existing_options || ! $this->is_integration_active() ) {
			return; // Already migrated or existing config never setup.
		}
		$old_settings = get_option( 'wc_bookings_google_calendar_settings', null );

		if ( ! empty( $old_settings ) ) {
			unset( $old_settings['client_id'] ); // Client id and secret not used anymore.
			unset( $old_settings['client_secret'] );
			add_option( $this->get_option_key(), $old_settings );
		}
	}

	/**
	 * Override parent to only init form_fields if needed.
	 *
	 * @return array
	 */
	public function get_form_fields() {
		if ( ! $this->form_fields_initialized ) {
			$this->form_fields_initialized = true; // We intentionally set this before init so we avoid any infinite loops.
			$this->init_form_fields();
		}
		return parent::get_form_fields();
	}

	/**
	 * Returns WC_Bookings_Google_Calendar_Settings singleton
	 *
	 * Ensures only one instance of WC_Bookings_Google_Calendar_Settings is created.
	 *
	 * @since 1.13.0
	 * @return WC_Bookings_Google_Calendar_Connection - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Update settings values from form.
	 *
	 * @since 1.13.0
	 */
	public function maybe_save_settings() {
		if ( isset( $_POST[ self::NONCE_NAME ] )
			&& wp_verify_nonce( wc_clean( wp_unslash( $_POST[ self::NONCE_NAME ] ) ), self::NONCE_ACTION ) ) {
			$this->process_admin_options();

			if ( isset( $_POST['Submit'] ) ) {
				do_action( 'wc_bookings_calendar_settings_on_save', $this );

				echo '<div class="updated"><p>' . esc_html__( 'Settings saved.', 'woocommerce-bookings' ) . '</p></div>';
			}
		}
	}

	/**
	 * Generates full HTML form for the instance settings.
	 *
	 * @since 1.13.0
	 */
	public static function generate_form_html() {
		self::instance()->maybe_save_settings();
		?>
			<form method="post" action="" id="bookings_settings">
				<?php self::instance()->admin_options(); ?>
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'woocommerce-bookings' ); ?>" />
					<?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME ); ?>
				</p>
			</form>
		<?php
	}

	/**
	 * Attempt to schedule/unschedule poller once AS is ready.
	 */
	public function maybe_schedule_poller() {
		if ( ! $this->is_integration_active() || 'both_ways' !== $this->get_sync_preference() ) {
			as_unschedule_action( 'wc-booking-poll-google-cal', array(), 'bookings' );

			return;
		}

		if ( ! as_next_scheduled_action( 'wc-booking-poll-google-cal' ) ) {
			$poll_interval = 1; // minutes.
			as_schedule_recurring_action( time(), $poll_interval * MINUTE_IN_SECONDS, 'wc-booking-poll-google-cal', array(), 'bookings' );
		}
	}

	/**
	 * Registers booking object lifecycle events.
	 * Needs to happen after init because of the dynamic hook names.
	 */
	public function register_booking_update_hooks() {
		foreach ( $this->get_booking_is_paid_statuses() as $status ) {
			// We have to do it this way because of the dynamic hook name.
			add_action( 'woocommerce_booking_' . $status, array( $this, 'sync_new_booking' ) );
		}

		add_action( 'woocommerce_booking_cancelled', array( $this, 'remove_booking' ) );
		add_action( 'woocommerce_booking_process_meta', array( $this, 'sync_edited_booking' ) );
	}

	/**
	 * Returns an authorized API client.
	 *
	 * @return Google_Client the authorized client object
	 */
	protected function get_client() {
		$client = new Google_Client();
		$client->setApplicationName( 'WooCommerce Bookings Google Calendar Integration' );
		$client->setScopes( Google_Service_Calendar::CALENDAR );
		$access_token  = get_transient( 'wc_bookings_gcalendar_access_token' );
		$refresh_token = get_option( 'wc_bookings_gcalendar_refresh_token' );

		$client->setAccessType( 'offline' );

		do_action( 'woocommerce_bookings_update_google_client', $client );

		$client->setRedirectUri( WC()->api_request_url( 'wc_bookings_google_calendar' ) );

		// Refresh the token if it's expired. Note that we need a refresh token for this.
		if ( $refresh_token && empty( $access_token ) ) {
			$access_token = $this->renew_access_token( $refresh_token, $client );
			if ( $access_token && isset( $access_token['access_token'] ) ) {
				unset( $access_token['refresh_token'] ); // unset this since we store it in an option.
				set_transient( 'wc_bookings_gcalendar_access_token', $access_token, self::TOKEN_TRANSIENT_TIME );
			} else {
				$this->log(
					sprintf(
						'Unable to fetch access token with refresh token. Google sync disabled until re-authenticated. Error: "%s", "%s"',
						isset( $access_token['error'] ) ? $access_token['error'] : '',
						isset( $access_token['error_description'] ) ? $access_token['error_description'] : ''
					),
					array(),
					WC_Log_Levels::ERROR
				);
				$this->delete_legacy_integration();
			}
		}

		// It may be empty, e.g. in case refresh token is empty.
		if ( ! empty( $access_token ) ) {
			$access_token['refresh_token'] = $refresh_token;
			try {
				$client->setAccessToken( $access_token );
			} catch ( InvalidArgumentException $e ) {
				// Something is wrong with the access token, customer should try to connect again.
				$this->log( sprintf( 'Invalid access token. Reconnect with Google necessary. Code %s. Message: %s.', $e->getCode(), $e->getMessage() ) );
				$this->delete_legacy_integration();
			}
		}

		return $client;
	}

	/**
	 * Activates Google Integration without connect.woocommerce.com if site was previously setup with it's own app.
	 *
	 * @param Google_Client $client Google Client App.
	 */
	public function maybe_enable_legacy_integration( Google_Client $client ) {
		$legacy_settings = get_option( 'wc_bookings_google_calendar_settings', null );

		if ( $legacy_settings && $this->is_integration_active() &&
			! empty( $legacy_settings['client_id'] ) && ! empty( $legacy_settings['client_secret'] ) ) {
			$client->setClientId( $legacy_settings['client_id'] );
			$client->setClientSecret( $legacy_settings['client_secret'] );
		}
	}

	/**
	 * Delete old options from before version 1.15.0 so they are no longer used and merchant must re-authenticate.
	 */
	private function delete_legacy_integration() {
		$deleted = delete_option( 'wc_bookings_google_calendar_settings' );

		if ( $deleted ) {
			delete_option( 'wc_bookings_gcalendar_refresh_token' );
			delete_transient( 'wc_bookings_gcalendar_sync_token' );
			delete_transient( 'wc_bookings_gcalendar_access_token' );
			$client = $this->get_client();
			$client->setClientId( null );
			$client->setClientSecret( null );
			WC_Admin_Notices::add_custom_notice(
				'bookings_google_calendar_connection',
				'<strong>' . __( 'Google Calendar', 'woocommerce-bookings' ) . '</strong> ' .
				sprintf(
					// Translators: %s url.
					__( 'Calendar Sync lost connection. You must <a href="%s">Re-Authenticate</a>', 'woocommerce-bookings' ),
					$this->get_google_auth_url()
				)
			);
		}
	}

	/**
	 * Set a new sync token (used when Google returns one)
	 *
	 * @param string $sync_token Google sync token.
	 */
	protected function set_sync_token( $sync_token ) {
		set_transient( 'wc_bookings_gcalendar_sync_token', $sync_token, self::TOKEN_TRANSIENT_TIME );
	}

	/**
	 * Get sync token.
	 *
	 * @return string
	 */
	protected function get_sync_token() {
		return get_transient( 'wc_bookings_gcalendar_sync_token' );
	}

	/**
	 * This is called by API requesters. We are not doing it on the constructor
	 * as it takes some time to init the service, so only init when necessary.
	 */
	protected function maybe_init_service() {
		if ( empty( $this->service ) ) {
			$this->service = new Google_Service_Calendar( $this->get_client() );
		}
	}

	/**
	 * Get Google Events (paginated)
	 *
	 * @param array $params Current parameters.
	 * @return array
	 */
	protected function get_event_page( $params = array() ) {
		$this->maybe_init_service();

		$request_params = array(
			'timeZone' => wc_booking_get_timezone_string(),
		);
		if ( ! empty( $this->page_token ) ) {
			$request_params              = $params;
			$request_params['pageToken'] = $this->page_token;
		} else {
			$sync_token = $this->get_sync_token();
			if ( ! empty( $sync_token ) ) {
				$request_params['syncToken'] = $sync_token;
				if ( isset( $params['maxResults'] ) ) {
					$request_params['maxResults'] = $params['maxResults'];
				}
			} else {
				$request_params = $params;
			}
		}

		try {
			$results = $this->service->events->listEvents( $this->get_calendar_id(), $request_params );
		} catch ( Exception $e ) {
			return array(
				'events'   => array(),
				'has_next' => false,
				'error'    => $e->getCode(),
			);
		}

		$this->page_token = $results->getNextPageToken();

		$sync_token = $results->getNextSyncToken();
		if ( ! empty( $sync_token ) ) {
			$this->set_sync_token( $sync_token );
		}

		return array(
			'events'   => $results->getItems(),
			'has_next' => empty( $sync_token ),
			'error'    => 0,
		);
	}

	/**
	 * Get a list of calendar events.
	 *
	 * @return array
	 */
	public function get_events() {
		$events = array();

		$params = apply_filters(
			'woocommerce_bookings_gcal_events_request',
			array(
				'singleEvents' => false,
				'timeMin'      => date( 'c' ),
				'timeMax'      => date( 'c', strtotime( 'now +2 years' ) ),
				'timeZone'     => wc_booking_get_timezone_string(),
			)
		);

		do {
			$page_result = $this->get_event_page( $params );

			// Full sync case.
			if ( 410 === (int) $page_result['error'] ) {
				$page_result['has_next'] = true;
				$this->set_sync_token( '' ); // Unset expired token.
				continue; // Repeat same request.
			}

			if ( 0 !== (int) $page_result['error'] ) {
				$this->log( $page_result['error'] );

				// TODO: Unhandled error. Handle it somehow.
			}

			$events = array_merge( $events, $page_result['events'] );
		} while ( $page_result['has_next'] ); // Final page will include a syncToken.

		return $events;
	}

	/**
	 * Method for polling data from Google API.
	 *
	 * Sync path: Google API -> Bookings
	 * The sync path Bookings -> Google API will be handled by `action` and `filter` events.
	 */
	public function poll_google_calendar_events() {
		if ( 'both_ways' !== $this->get_sync_preference() || ! $this->is_integration_active() ) {
			return;
		}

		$this->polling = true;
		try {
			$this->log( 'Getting Google Calendar List from Google Calendar API...' );

			/**
			 * Global Availability Data store instance.
			 *
			 * @var WC_Global_Availability_Data_Store $global_availability_data_store
			 */
			$global_availability_data_store = WC_Data_Store::load( WC_Global_Availability::DATA_STORE );

			$events = $this->get_events();

			foreach ( $events as $event ) {
				$availabilities = $global_availability_data_store->get_all(
					array(
						array(
							'key'     => 'gcal_event_id',
							'value'   => $event['id'],
							'compare' => '=',
						),
					)
				);

				if ( empty( $availabilities ) ) {

					$booking_ids = WC_Booking_Data_Store::get_booking_ids_by( array( 'google_calendar_event_id' => $event['id'] ) );

					if ( ! empty( $booking_ids ) ) {
						// Google event is an existing booking not a manually created event for the global availability.
						// Ignore changes for now in future we may allow editing bookings from google calendar.
						continue;
					}

					// If no global availability found, just create one.
					$global_availability = new WC_Global_Availability();
					if ( 'cancelled' !== $event->getStatus() ) {
						$this->update_global_availability_from_event( $global_availability, $event );
						$global_availability->save();
					}

					continue;
				}

				foreach ( $availabilities as $availability ) {
					$event_date        = new WC_DateTime( $event['updated'] );
					$availability_date = $availability->get_date_modified();

					if ( $event_date > $availability_date ) {
						// Sync Google Event -> Global Availability.
						if ( 'cancelled' !== $event->getStatus() ) {

							$this->update_global_availability_from_event( $availability, $event );
							$availability->save();
						} else {
							$availability->delete();
						}
					}
				}
			}
		} catch ( Exception $e ) {
			$this->log( 'Error while getting list of events' );
		}
		$this->polling = false;
	}

	/**
	 * Initialize integration settings form fields.
	 *
	 * @return void
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'authorization'   => array(
				'title' => __( 'Authorization', 'woocommerce-bookings' ),
				'type'  => 'google_calendar_authorization',
			),
			'calendar_id'     => array(
				'title'       => __( 'Calendar', 'woocommerce-bookings' ),
				'type'        => 'select',
				'description' => __( 'Enter with your Calendar.', 'woocommerce-bookings' ),
				'desc_tip'    => true,
				'default'     => '',
				'options'     => $this->get_calendar_list_options(),
				'display_check' => array( $this, 'display_connection_settings' ),
			),
			'sync_preference' => array(
				'type'         => 'select',
				'title'        => __( 'Sync Preference', 'woocommerce-bookings' ),
				'options'      => array(
					'both_ways' => __( 'Sync both ways - between Store and Google', 'woocommerce-bookings' ),
					'one_way'   => __( 'Sync one way - from Store to Google', 'woocommerce-bookings' ),
				),
				'description'  => __( 'Manage the sync flow between your Store calendar and Google calendar.', 'woocommerce-bookings' ),
				'desc_tip'     => true,
				'default'      => 'one_way',
				'display_check' => array( $this, 'display_connection_settings' ),
			),
			'testing'         => array(
				'title'       => __( 'Testing', 'woocommerce-bookings' ),
				'type'        => 'title',
				'description' => '',
			),
			'debug'           => array(
				'title'       => __( 'Debug Log', 'woocommerce-bookings' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable logging', 'woocommerce-bookings' ),
				'default'     => 'no',
				/* translators: 1: log file path */
				'description' => sprintf( __( 'Log Google Calendar events, such as API requests, inside %s', 'woocommerce-bookings' ), '<code>woocommerce/logs/' . $this->id . '-' . sanitize_file_name( wp_hash( $this->id ) ) . '.txt</code>' ),
			),
		);
	}

	/**
	 * Generate Settings HTML.
	 *
	 * Extends base class html generation to add 'display_check' parameter to each
	 * field. 'display_check', is a callable that enables/disables the display of
	 * the field.
	 *
	 * @param array $form_fields (default: array()) Array of form fields.
	 * @param bool  $echo Echo or return.
	 * @return string the html for the settings
	 * @since  1.15.0
	 */
	public function generate_settings_html( $form_fields = array(), $echo = true ) {
		if ( empty( $form_fields ) ) {
			$form_fields = $this->get_form_fields();
		}
		foreach ( $form_fields as $index => $field ) {
			// Delete fields if they have an "enable_check" function that returns false.
			if ( isset( $field['display_check'] ) && ! call_user_func( $field['display_check'] ) ) {
				unset( $form_fields[ $index ] );
			}
		}
		return parent::generate_settings_html( $form_fields, $echo );
	}

	/**
	 * Whether or not connection settings should be displayed.
	 *
	 * Checks Google connection status so connection settings can be hidden
	 * if there is no active action.
	 *
	 * @return bool Whether or not connection settings should be displayed.
	 * @since  1.15.0
	 */
	protected function display_connection_settings() {
		$access_token  = $this->get_client()->getAccessToken();
		$refresh_token = get_option( 'wc_bookings_gcalendar_refresh_token' );
		return $access_token && $refresh_token;
	}

	/**
	 * Returns an array to feed the calendar list select input
	 *
	 * @return array
	 */
	private function get_calendar_list_options() {
		$this->maybe_init_service();
		$options = array( '' => __( 'Select a calendar from the list', 'woocommerce-bookings' ) );

		if ( $this->is_integration_active() ) {
			try {
				return array_reduce(
					$this->service->calendarList->listCalendarList()->items,
					function( $carry, $item ) {
						$carry[ $item['id'] ] = $item['summary'];
						return $carry;
					},
					$options
				);
			} catch ( Exception $e ) {
				$this->log( 'Error while getting the list of calendars: ' . $e->getMessage() );
			}
		}

		return $options;
	}

	/**
	 * Validate the Google Calendar Authorization field.
	 * Really it performs the oauth_logout if the disconnect button is clicked.
	 *
	 * @param string $key Current Key.
	 * @param string $value Value of field.
	 *
	 * @return string
	 */
	public function validate_google_calendar_authorization_field( $key, $value ) {
		if ( 'logout' === $value ) {
			$this->oauth_logout();
		}
		return '';
	}

	/**
	 * Generate the Google Calendar Authorization field.
	 *
	 * @param  mixed $key
	 * @param  array $data
	 *
	 * @return string
	 */
	public function generate_google_calendar_authorization_html( $key, $data ) {
		$access_token  = $this->get_client()->getAccessToken();
		$refresh_token = get_option( 'wc_bookings_gcalendar_refresh_token' );
		ob_start();
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<?php echo wp_kses_post( $data['title'] ); ?>
			</th>
			<td class="forminp">
				<?php if ( ! $refresh_token ) : ?>
					<p class="submit">
						<a class="button button-primary" href="<?php echo esc_attr( $this->get_google_auth_url() ); ?>">
							<?php esc_html_e( 'Connect with Google', 'woocommerce-bookings' ); ?>
						</a>
					</p>
				<?php elseif ( $access_token ) : ?>
					<p><?php esc_html_e( 'Successfully authenticated.', 'woocommerce-bookings' ); ?></p>
					<p class="submit"><button class="button button-primary" name="<?php echo esc_attr( $this->get_field_key( $key ) ); ?>" value="logout"><?php esc_html_e( 'Disconnect', 'woocommerce-bookings' ); ?></button></p>
				<?php else : ?>
					<p><?php esc_html_e( 'Unable to authenticate.' ); ?></p>
					<p class="submit"><a class="button button-primary" href="<?php echo esc_attr( $this->get_google_auth_url() ); ?>"><?php esc_html_e( 'Re-Connect with Google', 'woocommerce-bookings' ); ?></a></p>
				<?php endif; ?>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * Admin Options.
	 */
	public function admin_options() {
		echo '<p>' . esc_html__( 'To start syncing with Google Calendar, click the "Connect with Google" button below to authorize your store to access your Google calendar.', 'woocommerce-bookings' ) . '</p>';

		echo '<table class="form-table">';
			$this->generate_settings_html();
		echo '</table>';
	}

	/**
	 * OAuth Logout.
	 *
	 * @return bool
	 */
	protected function oauth_logout() {
		$this->log( 'Leaving the Google Calendar app...' );

		$client       = $this->get_client();
		$access_token = $client->getAccessToken();

		if ( ! empty( $access_token['access_token'] ) ) {
			if ( $client->getClientId() ) {
				$body = $client->revokeToken( $access_token );
			} else {
				$response = wp_remote_post(
					self::CONNECT_WOOCOMMERCE_URL . '/revoke/google',
					array(
						'body' => array( 'access_token' => $access_token ),
					)
				);
				$body     = json_decode( wp_remote_retrieve_body( $response ), true );
			}
			if ( $body['success'] ) {
				echo '<div class="updated fade"><p><strong>' . esc_html__( 'Google Calendar', 'woocommerce-bookings' ) . '</strong> ' . esc_html__( 'Account disconnected successfully!', 'woocommerce-bookings' ) . '</p></div>';
			} else {
				echo '<div class="error fade"><p><strong>' . esc_html__( 'Google Calendar', 'woocommerce-bookings' ) . '</strong> ' . esc_html__( 'Failed to disconnect to your account, please try again, if the problem persists, turn on Debug Log option and see what is happening.', 'woocommerce-bookings' ) . '</p></div>';
			}
		} else {
			echo '<div class="updated fade"><p><strong>' . esc_html__( 'Google Calendar', 'woocommerce-bookings' ) . '</strong> ' . esc_html__( 'Account not properly connected, reset successfully!', 'woocommerce-bookings' ) . '</p></div>';
		}

		delete_option( 'wc_bookings_gcalendar_refresh_token' );
		delete_transient( 'wc_bookings_gcalendar_sync_token' );
		delete_transient( 'wc_bookings_gcalendar_access_token' );

		// Delete legacy settings since we will resync with official app.
		delete_option( 'wc_bookings_google_calendar_settings' );

		$logger = $this->get_logger();
		if ( $logger ) {
			$logger->add( $this->id, 'Left the Google Calendar App. successfully' );
		}

		return true;
	}

	/**
	 * Process the oauth redirect.
	 *
	 * @return void
	 */
	public function oauth_redirect() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied!', 'woocommerce-bookings' ) );
		}

		$redirect_args = array(
			'post_type' => 'wc_booking',
			'page'      => 'wc_bookings_settings',
			'tab'       => 'connection',
		);
		$access_token = array(
			'access_token'  => $_GET['access_token'],
			'expires_in'    => $_GET['expires_in'],
			'scope'         => $_GET['scope'],
			'token_type'    => $_GET['token_type'],
			'created'       => $_GET['created'],
			'refresh_token' => $_GET['refresh_token'],
		);

		$client = $this->get_client();
		$client->setAccessToken( $access_token );
		unset( $access_token['refresh_token'] ); // unset this since we store it in an option.
		set_transient( 'wc_bookings_gcalendar_access_token', $access_token, self::TOKEN_TRANSIENT_TIME );
		update_option( 'wc_bookings_gcalendar_refresh_token', $client->getRefreshToken() );

		if ( ! empty( $access_token['access_token'] ) ) {
			WC_Admin_Notices::add_custom_notice(
				'bookings_google_calendar_connection',
				'<strong>' . esc_html__( 'Google Calendar', 'woocommerce-bookings' ) . '</strong> ' . esc_html__( 'Account connected successfully!', 'woocommerce-bookings' )
			);
			$this->log(
				sprintf(
					'Google Oauth successful.'
				)
			);
		} else {
			$this->log(
				sprintf(
					'Google Oauth failed with "%s", "%s"',
					isset( $_GET['error'] ) ? $_GET['error'] : '',
					isset( $_GET['error_description'] ) ? $_GET['error_description'] : ''
				),
				array(),
				WC_Log_Levels::ERROR
			);
			WC_Admin_Notices::add_custom_notice(
				'bookings_google_calendar_connection',
				'<strong>' . esc_html__( 'Google Calendar', 'woocommerce-bookings' ) . '</strong> ' . esc_html__( 'Failed to connect to your account, please try again, if the problem persists, turn on Debug Log option and see what is happening.', 'woocommerce-bookings' )
			);
		}
		wp_safe_redirect( add_query_arg( $redirect_args, admin_url( '/edit.php?' ) ) );
		exit;
	}

	/**
	 * Sync new Booking with Google Calendar.
	 *
	 * @param  int $booking_id Booking ID.
	 *
	 * @return void
	 */
	public function sync_new_booking( $booking_id ) {
		if ( $this->is_edited_from_meta_box() || 'wc_booking' !== get_post_type( $booking_id ) ) {
			return;
		}
		$this->sync_booking( $booking_id );
	}

	/**
	 * Check if Google Calendar settings are supplied and we're authenticated.
	 *
	 * @return bool True is calendar is set, false otherwise.
	 */
	public function is_integration_active() {
		$refresh_token = get_option( 'wc_bookings_gcalendar_refresh_token' );

		return ! empty( $refresh_token );
	}

	/**
	 * Sync an event resource with Google Calendar.
	 * https://developers.google.com/google-apps/calendar/v3/reference/events
	 *
	 * @param   int $booking_id Booking ID.
	 * @return  object|boolean Parsed JSON data from the http request or false if error
	 */
	public function get_event_resource( $booking_id ) {
		if ( $booking_id < 0 ) {
			return false;
		}

		$booking  = get_wc_booking( $booking_id );
		$event_id = $booking->get_google_calendar_event_id();
		$event    = false;

		$this->maybe_init_service();

		try {
			$event = $this->service->events->get( $this->get_calendar_id(), $event_id );
		} catch ( Exception $e ) {
			$this->log( 'Error while getting event for Booking ' . $booking_id . ': ' . $e->getMessage() );
		}

		return $event;
	}

	/**
	 * Sync Booking with Google Calendar.
	 *
	 * @param  int $booking_id Booking ID.
	 */
	public function sync_booking( $booking_id ) {
		if ( ! $this->is_integration_active() || 'wc_booking' !== get_post_type( $booking_id ) ) {
			return;
		}

		$this->maybe_init_service();

		// Booking data.
		$booking         = get_wc_booking( $booking_id );
		$event_id        = $booking->get_google_calendar_event_id();
		$product_id      = $booking->get_product_id();
		$order           = $booking->get_order();
		$product         = wc_get_product( $product_id );
		$booking_product = get_wc_product_booking( $product_id );
		$resource        = $booking_product->get_resource( $booking->get_resource_id() );
		$timezone        = wc_booking_get_timezone_string();
		$description     = '';
		$customer        = $booking->get_customer();

		$booking_data = array(
			__( 'Booking ID', 'woocommerce-bookings' )   => $booking_id,
			__( 'Booking Type', 'woocommerce-bookings' ) => is_object( $resource ) ? $resource->get_title() : '',
			__( 'Persons', 'woocommerce-bookings' )      => $booking->has_persons() ? array_sum( $booking->get_persons() ) : 0,
		);

		foreach ( $booking_data as $key => $value ) {
			if ( empty( $value ) ) {
				continue;
			}

			$description .= sprintf( '%s: %s', rawurldecode( $key ), rawurldecode( $value ) ) . PHP_EOL;
		}

		$edit_booking_url = admin_url( sprintf( 'post.php?post=%s&action=edit', $booking_id ) );

		// Add read-only message.
		/* translators: %s URL to edit booking */
		$description .= PHP_EOL . sprintf( __( 'NOTE: this event cannot be edited in Google Calendar. If you need to make changes, <a href="%s" target="_blank">please edit this booking in WooCommerce</a>.', 'woocommerce-bookings' ), $edit_booking_url );

		if ( is_a( $order, 'WC_Order' ) ) {
			foreach ( $order->get_items() as $order_item_id => $order_item ) {
				if ( $order_item_id !== WC_Booking_Data_Store::get_booking_order_item_id( $booking_id ) ) {
					continue;
				}
				foreach ( $order_item->get_meta_data() as $order_meta_data ) {
					$the_meta_data = $order_meta_data->get_data();

					if ( is_serialized( $the_meta_data['value'] ) ) {
						continue;
					}

					$description .= sprintf( '%s: %s', html_entity_decode( $the_meta_data['key'] ), html_entity_decode( $the_meta_data['value'] ) ) . PHP_EOL;
				}
			}
		}

		$event = $this->get_event_resource( $booking_id );
		if ( empty( $event ) ) {
			$event = new Google_Service_Calendar_Event();
		}

		// If the user edited the description on the Google Calendar side we want to keep that data intact.
		if ( empty( trim( $event->getDescription() ) ) ) {
			$event->setDescription( wp_kses_post( $description ) );
		}

		// Set the event data.
		$product_title = $product ? html_entity_decode( $product->get_title() ) : __( 'Booking', 'woocommerce-bookings' );
		$event->setSummary( wp_kses_post( sprintf( "%s, %s - #%s", $customer->name, $product_title, $booking->get_id() ) ) );

		// Set the event start and end dates.
		$start = new Google_Service_Calendar_EventDateTime();
		$end   = new Google_Service_Calendar_EventDateTime();

		if ( $booking->is_all_day() ) {
			// 1440 min = 24 hours. Bookings includes 'end' in its set of days, where as GCal uses that
			// as the cut off, so we need to add 24 hours to include our final 'end' day.
			// https://developers.google.com/google-apps/calendar/v3/reference/events/insert
			$start->setDate( date( 'Y-m-d', $booking->get_start() ) );
			$end->setDate( date( 'Y-m-d', $booking->get_end() + 1440 ) );
		} else {
			$start->setDateTime( date( 'Y-m-d\TH:i:s', $booking->get_start() ) );
			$start->setTimeZone( $timezone );
			$end->setDateTime( date( 'Y-m-d\TH:i:s', $booking->get_end() ) );
			$end->setTimeZone( $timezone );
		}

		$event->setStart( $start );
		$event->setEnd( $end );

		/**
		 * Update Google event before sync.
		 *
		 * Optional filter to allow third parties to update content of Google event when a booking is created or updated.
		 *
		 * @param Google_Service_Calendar_Event $event Google event object being added or updated.
		 * @param WC_Booking                    $booking Booking object being synced to Google calendar.
		 */
		$event = apply_filters( 'woocommerce_bookings_gcalendar_sync', $event, $booking );

		try {
			if ( empty( $event->getId() ) ) {
				$event = $this->service->events->insert( $this->get_calendar_id(), $event );
			} else {
				$this->service->events->update( $this->get_calendar_id(), $event->getId(), $event );
			}

			$booking->set_google_calendar_event_id( wc_clean( $event->getId() ) );

			update_post_meta( $booking->get_id(), '_wc_bookings_gcalendar_event_id', $event->getId() );
		} catch ( Exception $e ) {
			$this->log( 'Error while adding/updating Google event: ' . $e->getMessage() );
		}
	}

	/**
	 * Sync Booking with Google Calendar when booking is edited.
	 *
	 * @param  int $booking_id Booking ID.
	 *
	 * @return void
	 */
	public function sync_edited_booking( $booking_id ) {
		if ( ! $this->is_edited_from_meta_box() ) {
			return;
		}
		$this->maybe_sync_booking_from_status( $booking_id );
	}

	/**
	 * Sync Booking with Google Calendar when booking is untrashed.
	 *
	 * @param  int $booking_id Booking ID.
	 *
	 * @return void
	 */
	public function sync_untrashed_booking( $booking_id ) {
		$this->maybe_sync_booking_from_status( $booking_id );
	}

	/**
	 * Remove/cancel the booking in Google Calendar
	 *
	 * @param  int $booking_id Booking ID.
	 *
	 * @return void
	 */
	public function remove_booking( $booking_id ) {
		if ( 'wc_booking' !== get_post_type( $booking_id ) ) {
			return;
		}

		$this->maybe_init_service();

		$booking  = get_wc_booking( $booking_id );
		$event_id = $booking->get_google_calendar_event_id();

		if ( $event_id ) {
			try {
				$resp = $this->service->events->delete( $this->get_calendar_id(), $event_id );

				if ( 204 === $resp->getStatusCode() ) {
					$this->log( 'Booking removed successfully!' );

					// Remove event ID.
					update_post_meta( $booking->get_id(), '_wc_bookings_gcalendar_event_id', '' );
				} else {
					$this->log( 'Error while removing the booking #' . $booking->get_id() . ': ' . print_r( $resp, true ) );
				}
			} catch ( Exception $e ) {
				$this->log( 'Error while deleting event from Google: ' . $e->getMessage() );
			}
		}
	}

	/**
	 * Maybe remove / sync booking based on booking status.
	 *
	 * @param int $booking_id Booking ID.
	 *
	 * @return void
	 */
	public function maybe_sync_booking_from_status( $booking_id ) {
		global $wpdb;

		$status = $wpdb->get_var( $wpdb->prepare( "SELECT post_status FROM $wpdb->posts WHERE post_type = 'wc_booking' AND ID = %d", $booking_id ) );

		if ( 'cancelled' === $status ) {
			$this->remove_booking( $booking_id );
		} elseif ( in_array( $status, $this->get_booking_is_paid_statuses(), true ) ) {
			$this->sync_booking( $booking_id );
		}
	}

	/**
	 * Get booking's post statuses considered as paid.
	 *
	 * @return array
	 */
	private function get_booking_is_paid_statuses() {
		/**
		 * Use this filter to add custom booking statuses that should be considered paid.
		 *
		 * @since 1.14.1
		 *
		 * @param array  $statuses All booking statuses considered to be paid.
		 */
		return apply_filters( 'woocommerce_booking_is_paid_statuses', array( 'confirmed', 'paid', 'complete' ) );
	}

	/**
	 * Is edited from post.php's meta box.
	 *
	 * @return bool
	 */
	public function is_edited_from_meta_box() {
		return (
			! empty( $_POST['wc_bookings_details_meta_box_nonce'] )
			&&
			wp_verify_nonce( $_POST['wc_bookings_details_meta_box_nonce'], 'wc_bookings_details_meta_box' )
		);
	}

	/**
	 * Maybe delete Global Availability from Google.
	 *
	 * @param WC_Global_Availability $availability Availability to delete.
	 */
	public function delete_global_availability( WC_Global_Availability $availability ) {
		$this->maybe_init_service();

		if ( $availability->get_gcal_event_id() ) {
			try {
				$this->service->events->delete( $this->get_calendar_id(), $availability->get_gcal_event_id() );
			} catch ( Exception $e ) {
				$this->log( 'Error while deleting event from Google: ' . $e->getMessage() );
			}
		}
	}

	/**
	 * Sync Global Availability to Google.
	 *
	 * @param WC_Global_Availability $availability Global Availability object.
	 */
	public function sync_global_availability( WC_Global_Availability $availability ) {
		if ( ! $this->is_integration_active() ) {
			return;
		}

		if ( ! $availability->get_changes() ) {
			// nothing changed don't waste time syncing.
			return;
		}

		if ( $this->polling ) {
			// Event is coming from google don't send it back.
			return;
		}

		$this->maybe_init_service();

		if ( $availability->get_gcal_event_id() ) {
			try {
				$event     = $this->service->events->get( $this->get_calendar_id(), $availability->get_gcal_event_id() );
				$supported = $this->update_event_from_global_availability( $event, $availability );
				if ( $supported ) {
					$this->service->events->update( $this->get_calendar_id(), $event->getId(), $event );
				}
			} catch ( Exception $e ) {
				$this->log( 'Error while syncing global availability to Google: ' . $e->getMessage() );
			}
		}
	}

	/**
	 * Update global availability object with data from google event object.
	 *
	 * @param WC_Global_Availability        $availability WooCommerce Global Availability object.
	 * @param Google_Service_Calendar_Event $event Google calendar event object.
	 *
	 * @return bool
	 */
	private function update_global_availability_from_event( WC_Global_Availability $availability, Google_Service_Calendar_Event $event ) {
		$availability->set_gcal_event_id( $event->getId() )
			->set_title( $event->getSummary() )
			->set_bookable( 'no' )
			->set_priority( 10 )
			->set_ordering( 0 );

		// TODO: check timezones.
		if ( $event->getRecurrence() ) {
			$availability->set_range_type( 'rrule' );
			$availability->set_rrule( join( "\n", $event->getRecurrence() ) );
			if ( $event->getStart()->getDateTime() ) {
				$availability->set_from_range( $event->getStart()->getDateTime() );
				$availability->set_to_range( $event->getEnd()->getDateTime() );
			} else {
				$availability->set_from_range( $event->getStart()->getDate() );
				$availability->set_to_range( $event->getEnd()->getDate() );
			}
		} elseif ( $event->getStart()->getDateTime() ) {

			$start_date = new WC_DateTime( $event->getStart()->getDateTime() );
			$end_date   = new WC_DateTime( $event->getEnd()->getDateTime() );

			try {
				// Our date ranges are inclusive, Google's are not, so shift the range (e.g. [10:00, 11:00] -> [10:01. 10:59])
				$start_date->add( new DateInterval( 'PT60S' ) );
				$end_date->sub( new DateInterval( 'PT1S' ) );
			} catch ( Exception $e ) {
				$this->log( $e->getMessage() );
				// Should never happen.
			}

			$availability->set_range_type( 'custom:daterange' )
				->set_from_date( $start_date->format( 'Y-m-d' ) )
				->set_to_date( $end_date->format( 'Y-m-d' ) )
				->set_from_range( $start_date->format( 'H:i' ) )
				->set_to_range( $end_date->format( 'H:i' ) );

		} else {

			$start_date = new WC_DateTime( $event->getStart()->getDate() );
			$end_date   = new WC_DateTime( $event->getEnd()->getDate() );

			try {
				// Our date ranges are inclusive, Google's are not.
				$end_date->sub( new DateInterval( 'P1D' ) );
			} catch ( Exception $e ) {
				$this->log( $e->getMessage() );
				// Should never happen.
			}

			$availability->set_range_type( 'custom' )
				->set_from_range( $start_date->format( 'Y-m-d' ) )
				->set_to_range( $end_date->format( 'Y-m-d' ) );

		}
		return true;
	}

	/**
	 * Update google event object with data from global availability object.
	 *
	 * @param Google_Service_Calendar_Event $event Google calendar event object.
	 * @param WC_Global_Availability        $availability WooCommerce Global Availability object.
	 *
	 * @return bool
	 */
	private function update_event_from_global_availability( Google_Service_Calendar_Event $event, WC_Global_Availability $availability ) {
		$event->setSummary( $availability->get_title() );
		$timezone        = wc_booking_get_timezone_string();
		$start           = new Google_Service_Calendar_EventDateTime();
		$end             = new Google_Service_Calendar_EventDateTime();
		$start_date_time = new WC_DateTime();
		$end_date_time   = new WC_DateTime();

		switch ( $availability->get_range_type() ) {
			case 'custom:daterange':
				$start_date_time = new WC_DateTime( $availability->get_from_date() . ' ' . $availability->get_from_range() );
				$start->setDateTime( $start_date_time->format( 'Y-m-d\TH:i:s' ) );
				$start->setTimeZone( $timezone );
				$event->setStart( $start );

				$end_date_time = new WC_DateTime( $availability->get_to_date() . ' ' . $availability->get_to_range() );
				$end->setDateTime( $end_date_time->format( 'Y-m-d\TH:i:s' ) );
				$end->setTimeZone( $timezone );
				$event->setEnd( $end );
				break;
			case 'custom':
				$start_date_time = new WC_DateTime( $availability->get_from_range() );
				$start->setDate( $start_date_time->format( 'Y-m-d' ) );
				$event->setStart( $start );

				$end_date_time = new WC_DateTime( $availability->get_to_range() );
				$end_date_time->add( new DateInterval( 'P1D' ) );
				$end->setDate( $end_date_time->format( 'Y-m-d' ) );
				$event->setEnd( $end );
				break;
			case 'months':
				$start_date_time->setDate(
					date( 'Y' ),
					$availability->get_from_range(),
					1
				);

				$start->setDate( $start_date_time->format( 'Y-m-d' ) );
				$event->setStart( $start );

				$number_of_months = 1 + intval( $availability->get_to_range() ) - intval( $availability->get_from_range() );

				$end_date_time = $start_date_time->add( new DateInterval( 'P' . $number_of_months . 'M' ) );

				$end->setDate( $end_date_time->format( 'Y-m-d' ) );
				$event->setEnd( $end );

				$event->setRecurrence(
					array(
						'RRULE:FREQ=YEARLY',
					)
				);

				break;
			case 'weeks':
				$start_date_time->setDate(
					date( 'Y' ),
					1,
					1
				);

				$end_date_time->setDate(
					date( 'Y' ),
					1,
					2
				);

				$all_days     = join( ',', array_keys( \RRule\RRule::$week_days ) );
				$week_numbers = join( ',', range( $availability->get_from_range(), $availability->get_to_range() ) );
				$rrule        = "RRULE:FREQ=YEARLY;BYWEEKNO=$week_numbers;BYDAY=$all_days";

				$start->setDate( $start_date_time->format( 'Y-m-d' ) );
				$event->setStart( $start );

				$end->setDate( $end_date_time->format( 'Y-m-d' ) );
				$event->setEnd( $end );

				$event->setRecurrence(
					array(
						$rrule,
					)
				);
				break;
			case 'days':
				$start_day = intval( $availability->get_from_range() );
				$end_day   = intval( $availability->get_to_range() );

				$start_date_time->modify( 'this ' . self::DAYS_OF_WEEK[ $start_day ] );
				$start->setDate( $start_date_time->format( 'Y-m-d' ) );
				$event->setStart( $start );

				$end_date_time = $start_date_time->modify( 'this ' . self::DAYS_OF_WEEK[ $end_day ] );

				$end->setDate( $end_date_time->format( 'Y-m-d' ) );
				$event->setEnd( $end );

				$event->setRecurrence(
					array(
						'RRULE:FREQ=WEEKLY',
					)
				);

				break;
			case 'time:1':
			case 'time:2':
			case 'time:3':
			case 'time:4':
			case 'time:5':
			case 'time:6':
			case 'time:7':
				list( , $day_of_week ) = explode( ':', $availability->get_range_type() );

				$start_date_time->modify( 'this ' . self::DAYS_OF_WEEK[ $day_of_week ] );
				$end_date_time->modify( 'this ' . self::DAYS_OF_WEEK[ $day_of_week ] );
				$rrule = 'RRULE:FREQ=WEEKLY';

				// fall through please.
			case 'time':
				if ( ! isset( $rrule ) ) {
					$rrule = 'RRULE:FREQ=DAILY';
				}

				list( $start_hour, $start_min ) = explode( ':', $availability->get_from_range() );
				$start_date_time->setTime( $start_hour, $start_min );

				list( $end_hour, $end_min ) = explode( ':', $availability->get_to_range() );
				$end_date_time->setTime( $end_hour, $end_min );

				$start->setDateTime( $start_date_time->format( 'Y-m-d\TH:i:s' ) );
				$start->setTimeZone( $timezone );
				$event->setStart( $start );

				$end->setDateTime( $end_date_time->format( 'Y-m-d\TH:i:s' ) );
				$end->setTimeZone( $timezone );
				$event->setEnd( $end );

				$event->setRecurrence(
					array(
						$rrule,
					)
				);
				break;

			default:
				// That should be everything, anything else is not supported.
				return false;
		}
		return true;
	}

	/**
	 * Renew access token with refresh token. Must pass through connect.woocommerce.com middleware.
	 *
	 * @param string        $refresh_token Refresh Token.
	 * @param Google_Client $client Google Client Object.
	 *
	 * @return array
	 */
	private function renew_access_token( $refresh_token, $client ) {

		if ( $client->getClientId() ) {
			return $client->fetchAccessTokenWithRefreshToken( $refresh_token );
		}

		$response     = wp_remote_post(
			self::CONNECT_WOOCOMMERCE_URL . '/renew/google',
			array(
				'body' => array( 'refresh_token' => $refresh_token ),
			)
		);
		$access_token = json_decode( wp_remote_retrieve_body( $response ), true );
		return $access_token;
	}

	/**
	 * Get google login url from connect.woocommerce.com.
	 *
	 * @return string
	 */
	private function get_google_auth_url() {
		$client = $this->get_client();

		if ( $client->getClientId() ) {
			return $client->createAuthUrl();
		}
		return add_query_arg(
			array(
				'redirect' => WC()->api_request_url( 'wc_bookings_google_calendar' ),
			),
			self::CONNECT_WOOCOMMERCE_URL . '/login/google'
		);
	}
}
