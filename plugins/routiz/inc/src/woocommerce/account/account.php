<?php

namespace Routiz\Inc\Src\Woocommerce\Account;

use \Routiz\Inc\Src\Form\Component as Form;
use \Routiz\Inc\Src\Wallet;
use \Routiz\Inc\Src\Request\Request;
use \Routiz\Inc\Src\Traits\Singleton;

class Account {

    use Singleton;

    public $pages = [];

    function __construct() {

        add_action( 'init', [ $this, 'add_endpoints' ] );

        add_filter( 'woocommerce_account_menu_items', [ $this, 'new_menu_items' ] );

        add_action( 'woocommerce_after_my_account', [ $this, 'account_dashboard' ] );

        add_action( 'routiz/account/actions', [ $this, 'actions' ] );
        // add_action( 'routiz/account/edit_save', [ $this, 'edit_save' ] );

        add_action( 'routiz/account/notifications/update', [ $this, 'account_notifications_update' ] );


    }

    public function account_dashboard() {
        Rz()->the_template('account/dashboard/dashboard');
    }

    public function add_page( $page ) {
        $this->pages[ $page['endpoint'] ] = $page;
    }

    public function new_menu_items( $items ) {

		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );

		$items += array_column( array_filter( $this->pages, function( $page ) {
			return $page['show_in_menu'];
		}), 'title', 'endpoint');

		$items['customer-logout'] = $logout;

		foreach( $items as $key => $item ) {

            if ( in_array( $key, array_keys( $this->pages ) ) ) {
				$items[ $key ] = $this->pages[ $key ];
			}

            switch( $key ) {
                case 'dashboard':
                    $items['dashboard'] = [
                        'title' => esc_html__( 'Dashboard', 'routiz' ),
                        'order' => 1,
                    ]; break;
                case 'listings':
                    $items['listings']['title'] = esc_html__( 'Listings', 'routiz' ); break;
                case 'entries':
                    $items['entries'] = [
                        'title' => esc_html__( 'Entries', 'routiz' ),
                        'order' => 5,
                    ]; break;
                case 'messages':
                    $items['messages'] = [
                        'title' => esc_html__( 'Messages', 'routiz' ),
                        'order' => 6,
                    ]; break;
                case 'payouts':
                    $items['payouts'] = [
                        'title' => esc_html__( 'Payouts', 'routiz' ),
                        'order' => 7,
                    ]; break;
                case 'notification-settings':
                    $items['notification-settings'] = [
                        'title' => esc_html__( 'Notifications', 'routiz' ),
                        'order' => 8,
                    ]; break;
            }

		}

		$items = $this->sort_by_prop( $items, 'order' );

		foreach ( $items as $key => $item ) {
			if ( is_array( $item ) && ! empty( $item['title'] ) ) {
				$items[ $key ] = $item['title'];
			}
		}

		return $items;

    }

    public function sort_by_prop( $array, $prop_name, $reverse = false ) {

		$sorted = [];

		foreach ( $array as $itemKey => $item ) {

            if ( ! is_array( $item ) ) {
				$item = [ 'title' => $item, 'order' => 25, 'endpoint' => $itemKey ];
			}

			if ( ! isset( $item[ $prop_name ] ) ) {
				$item[ $prop_name ] = 25;
			}

			if ( ! isset( $item[ 'endpoint' ] ) ) {
				$item[ 'endpoint' ] = $itemKey;
			}

			$sorted[ $item[ $prop_name ] ][] = $item;

		}

		$reverse ? krsort( $sorted ) : ksort( $sorted );

		$result = [];
		foreach ( $sorted as $sub_array ) foreach ( $sub_array as $item ) {
			$result[ $item['endpoint'] ] = $item;
		}

		return $result;
	}

    public function add_endpoints() {

		foreach ( $this->pages as $page ) {

			add_rewrite_endpoint( $page['endpoint'], EP_ROOT | EP_PAGES );

			add_action(
				sprintf( 'woocommerce_account_%s_endpoint', $page['endpoint'] ),
				function() use ( $page ) {

                    global $post, $wpdb;

                    do_action( 'routiz/account/actions' );

                    $request = Request::instance();

                    if( $request->has('action') ) {

                        switch( $request->get('action') ) {
                            case 'cancel_payout':

                                if( apply_filters( 'routiz/account/payout/enable_cancellation', true ) ) {

                                    if( ! wp_verify_nonce( $request->get('_wpnonce'), 'routiz_account_cancel_payout' ) ) {
                                        return;
                                    }

                                    $payout_id = (int) $request->get('id');

                                    if( $payout_id ) {

                                        $payout = $wpdb->get_row( $wpdb->prepare("
                                            SELECT *
                                            FROM {$wpdb->prefix}routiz_wallet_payouts
                                            WHERE id = %d
                                            and status = 'pending'
                                            AND user_id = %d
                                            LIMIT 1
                                        ", $payout_id, get_current_user_id() ), OBJECT );

                                        if( $payout ) {

                                            // add to owner wallet
                                            $wallet = new Wallet( $payout->user_id );
                                            $wallet->add_funds( $payout->amount, null, 'canceled_payout' );

                                            // delete payout row
                                            $wpdb->delete( $wpdb->prefix . 'routiz_wallet_payouts', [ 'id' => $payout->id ] );

                                        }

                                    }
                                }

                                Rz()->the_template( $page['template'] );

                                break;
                        }

                    }else{

                        Rz()->the_template( $page['template'] );

                    }

				}
			);

		}

	}

    static function get_listings() {

        $request = Request::instance();
        $page = $request->has('onpage') ? $request->get('onpage') : 1;
        $posts_per_page = 12;

        return new \WP_Query([
            'post_type' => 'rz_listing',
            'post_status' => [ 'publish', 'pending', 'pending_payment', 'expired' ],
            'author' => get_current_user_id(),
            'posts_per_page' => $posts_per_page,
            'offset' => ( $page - 1 ) * $posts_per_page,
        ]);

    }

    static function get_entries( $type = 'ingoing' ) {

        $request = Request::instance();
        $page = $request->has('onpage') ? $request->get('onpage') : 1;
        $posts_per_page = 12;

        $args = [
            'post_type' => 'rz_entry',
            'post_status' => [ 'publish', 'pending', 'pending_payment', 'declined'/*, 'cancelled'*/ ],
            'posts_per_page' => $posts_per_page,
            'offset' => ( $page - 1 ) * $posts_per_page,
        ];

        // outgoing
        if( $type == 'outgoing' ) {
            $args['meta_query'] = [
                [
                    'key' => 'rz_request_user_id',
                    'value' => get_current_user_id(),
                    'compare' => '=',
                ]
            ];
        }
        // ingoing
        else{
            $args['author'] = get_current_user_id();
        }

        return new \WP_Query( $args );

    }

    static public function actions() {

        $request = Request::instance();

        if( $request->has('action') ) {
            switch( $request->get('action') ) {
                case 'delete_listing':

                    do_action('routiz/account/lising/before_delete');

                    // security
                    if( wp_verify_nonce( $request->get('_wpnonce'), 'routiz_account_listing_action' ) ) {
                        $post = get_post( (int) $request->get('id') );

                        // delete only own items
                        if( $post and $post->post_author == get_current_user_id() ) {

                            // only listing post types
                            if( get_post_type( $post->ID ) == 'rz_listing' ) {
                                wp_trash_post( $post->ID );
                            }
                        }
                    }

                    if( class_exists('woocommerce') ) {
                        wp_redirect( wc_get_account_endpoint_url('listings') );
                        exit;
                    }

                    break;

            }
        }

    }

    public function account_notifications_update() {

        if( isset( $_POST ) and is_array( $_POST ) ) {
            foreach( $_POST as $field_id => $field_value ) {
                if( strpos( $field_id, 'rz_is_user_notification_' ) === 0 ) {
                    update_user_meta( get_current_user_id(), $field_id, ! $field_value );
                }
            }
        }

    }

}
