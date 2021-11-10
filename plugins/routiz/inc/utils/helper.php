<?php

namespace Routiz\Inc\Utils;

use \Routiz\Inc\Src\Form\Component as Form;

class Helper {

    use \Routiz\Inc\Src\Traits\Singleton;

    public $debug;
    public $assets_min;

    function __construct() {

        $this->debug = ( defined('WP_DEBUG') and WP_DEBUG == true );
        $this->assets_min = ! $this->debug ? '.min' : '';

    }

    public function get_meta( $key, $post_id = null, $single = true, $default = '' ) {

        if( is_null( $post_id ) ) { $post_id = get_the_ID(); }
        if( ! metadata_exists( 'post', $post_id, $key ) ) { return $default; }
        return get_post_meta( $post_id, $key, $single );

    }

    public function get_array( $key, $post_id = null, $single = true, $default = [] ) {

        $value = $this->get_meta( $key, $post_id, $single, $default );
        return empty( $value ) ? [] : $value;

    }

    public function jsoning( $key, $post_id = null ) {

        $value = $this->json_decode( $this->get_meta( $key, $post_id ) );
        return ( is_array( $value ) or is_object( $value ) ) ? $value : [];

    }

    public function child_template_path( $name ) {

        $template_path = sprintf( '%s/templates/%s.php', get_stylesheet_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function theme_template_path( $name ) {

        $template_path = sprintf( '%s/templates/%s.php', get_template_directory(), $name );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function plugin_template_path( $name ) {

        $template_path = sprintf( '%stemplates/%s.php', RZ_PATH, str_replace( 'routiz/', '', $name ) );

        if( file_exists( $template_path ) ) {
            return $template_path;
        }

        return null;

    }

    public function the_template( $name ) {

        echo $this->get_template( $name );

    }

    public function get_template_path( $name ) {

        // child theme
        if( is_child_theme() and $child_template_path = $this->child_template_path( $name ) ) {
            return $child_template_path;
        }
        // theme
        elseif( $theme_template_path = $this->theme_template_path( $name ) ) {
            return $theme_template_path;
        }
        // plugin
        elseif( $plugin_template_path = $this->plugin_template_path( $name ) ) {
            return $plugin_template_path;
        }

        return null;

    }

    public function get_template( $name ) {

        if( ! $template_path = $this->get_template_path( $name ) ) {
            return;
        }

        ob_start();
        include $template_path;
        return ob_get_clean();

    }

    public function is_json( $string ) {

        json_decode( $string );
        return ( json_last_error() == JSON_ERROR_NONE );

    }

    public function json_decode( $string, $assoc = false ) {

        if( is_array( $string ) ) {
            return $string;
        }

        // $string = str_replace( "\r\n", '\r\n', $string );
        // return json_decode( stripslashes( $string ), $assoc );
        return json_decode( str_replace( '__NEW_LINE__', '\r\n', stripslashes( str_replace( '\r\n', '__NEW_LINE__', $string ) ) ), $assoc );

    }

    public function attrs( $arr ) {

        return implode(' ', array_map( function( $value, $key ) {
            return sprintf( '%s="%s"', $key, $value );
        }, $arr, array_keys( $arr ) ) );

    }

    public function sanitize( $data ) {

        if( is_array( $data ) ) {
            foreach( $data as $k => $v ) {
                $data[ $k ] = is_array( $v ) ? $this->sanitize( $v ) : sanitize_text_field( $v );
            }
        }else{
            $data = sanitize_text_field( $data );
        }
        return $data;

    }

    public function to_array( $data ) {

        if( is_array( $data ) ) {
            foreach( $data as $k => $v ) {
                $data[ $k ] = is_array( $v ) ? $this->sanitize( $v ) : $v;
            }
        }
        return $data;

    }

    public function preloader() {
        Rz()->the_template('routiz/globals/preloader');
    }

    public function get_custom_taxonomies() {

        $custom_taxonomies = [];
        $custom_taxonomies_items = Rz()->json_decode( get_option( 'rz_custom_taxonomies', true ) );

        if( is_array( $custom_taxonomies_items ) ) {
            foreach( $custom_taxonomies_items as $custom_taxonomies_item ) {
                $custom_taxonomies[] = $custom_taxonomies_item->fields;
            }
        }

        return $custom_taxonomies;
    }

    public function dummy( $icon = null, $height_ratio = null, $background_color = null, $color = null ) {

        if( empty( $icon ) ) {
            $icon = 'far fa-image';
        }

        $style = '';
        $style .= $height_ratio ? 'padding-top:' . $height_ratio . '%;' : '';
        $style .= $background_color ? 'background-color:' . $background_color . '!important;' : '';
        $style .= $color ? 'color:' . $color . ';' : '';
        return '<div class="rz-dummy-image" style="' . $style . '"><i class="' . $icon . '"></i></div>';

    }

    /*public function get_action( $action ) {

		ob_start();
			do_action( $action );
		return ob_get_clean();

	}*/

    public function get_first_array_image( $array, $size = 'rz_listing' ) {

        if( isset( $array[0] ) and isset( $array[0]->id ) ) {
            return $this->get_image( $array[0]->id, $size );
        }

        return;

    }

    public function get_image( $attachment_id, $size = 'rz_listing' ) {

        $image_attrs = wp_get_attachment_image_src( $attachment_id, $size );

        if( isset( $image_attrs[0] ) ) {
            return $image_attrs[0];
        }

    }

    public function paged() {

        if ( get_query_var('paged') ) {
	        return get_query_var('paged');
	    }elseif( get_query_var('page') ) {
	        return get_query_var('page');
	    }else{
	        return 1;
	    }

	}

    // custom paginate_links
    public function pagination( $args = [] ) {

        global $wp_query, $wp_rewrite;

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $url_parts = explode( '?', $pagenum_link );

        // Get max pages and current page out of the current query, if available.
        $total = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
        $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

        // URL base depends on permalink settings.
        $format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        $defaults = [
            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
            'format' => $format, // ?page=%#% : %#% is replaced by the page number
            'total' => $total,
            'current' => $current,
            'end_size' => 1,
            'mid_size' => 2,
            'add_args' => [], // array of query args to add
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => '',
        ];

        $args = wp_parse_args( $args, $defaults );

        if ( ! is_array( $args['add_args'] ) ) {
            $args['add_args'] = [];
        }

        // Merge additional query vars found in the original URL into 'add_args' array.
        if ( isset( $url_parts[1] ) ) {
            // Find the format argument.
            $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
            $format_query = isset( $format[1] ) ? $format[1] : '';
            wp_parse_str( $format_query, $format_args );

            // Find the query args of the requested URL.
            wp_parse_str( $url_parts[1], $url_query_args );

            unset( $url_query_args['action'] );

            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach ( $format_args as $format_arg => $format_arg_value ) {
                unset( $url_query_args[ $format_arg ] );
            }

            $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
        }

        // Who knows what else people pass in $args
        $total = (int) $args['total'];
        if ( $total < 2 ) {
            return;
        }
        $current  = (int) $args['current'];
        $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
        if ( $end_size < 1 ) {
            $end_size = 1;
        }
        $mid_size = (int) $args['mid_size'];
        if ( $mid_size < 0 ) {
            $mid_size = 2;
        }

        $add_args = $args['add_args'];
        $r = '';
        $page_links = [];
        $dots = false;

        // prev
        if ( $current && 1 < $current ) :
            $link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
            $link = str_replace( '%#%', $current - 1, $link );
            if ( $add_args ) {
                $link = add_query_arg( $add_args, $link );
            }
            $link .= $args['add_fragment'];

            $page_links[] = sprintf(
                '<a class="prev page-numbers rz-action-dynamic-explore" href="%s">%s</a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url( apply_filters( 'paginate_links', $link ) ),
                '<i class="fas fa-angle-left"></i>'
            );
        endif;

        for ( $n = 1; $n <= $total; $n++ ) :

            if ( $n == $current ) :

                $page_links[] = sprintf(
                    '<span aria-current="%s" class="page-numbers current">%s</span>',
                    'page',
                    $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number']
                );

                $dots = true;

            else :

                if ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) :

                    $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
                    $link = str_replace( '%#%', $n, $link );
                    if ( $add_args ) {
                        $link = add_query_arg( $add_args, $link );
                    }
                    $link .= $args['add_fragment'];

                    $page_links[] = sprintf(
                        '<a class="page-numbers rz-action-dynamic-explore" href="%s">%s</a>',
                        /** This filter is documented in wp-includes/general-template.php */
                        esc_url( apply_filters( 'paginate_links', $link ) ),
                        $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number']
                    );

                    $dots = true;

                elseif ( $dots ) :

                    $page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
                    $dots = false;

                endif;
            endif;
        endfor;

        // next
        if ( $current && $current < $total ) :
            $link = str_replace( '%_%', $args['format'], $args['base'] );
            $link = str_replace( '%#%', $current + 1, $link );
            if ( $add_args ) {
                $link = add_query_arg( $add_args, $link );
            }
            $link .= $args['add_fragment'];

            $page_links[] = sprintf(
                '<a class="next page-numbers rz-action-dynamic-explore" href="%s">%s</a>',
                /** This filter is documented in wp-includes/general-template.php */
                esc_url( apply_filters( 'paginate_links', $link ) ),
                '<i class="fas fa-angle-right"></i>'
            );
        endif;

        $r .= "<ul class='page-numbers'>\n\t<li>";
        $r .= join( "</li>\n\t<li>", $page_links );
        $r .= "</li>\n</ul>\n";

        return $r;

    }

    // TODO: use request class
    public function get_explore_page_url( $params = [], $inject_type = true ) {

        global $rz_explore;

        // for multiple listing types, inject default type
        // if( $inject_type and ! isset( $params['type'] ) and $rz_explore->total_types > 1 ) {
        //     $params['type'] = esc_attr( $this->get_meta( 'rz_slug', $rz_explore->main_type ) );
        // }

        // unprefix param keys
        $unprefixed = [];
        foreach( $params as $key => $param ) {
            $unprefixed[ $this->unprefix( $key ) ] = $param;
        }

        return add_query_arg( $unprefixed, get_permalink( get_option('rz_page_explore') ) );

    }

    public function get_submission_page_url() {

        if( ! $page_submission = get_option('rz_page_submission') ) {
            return '#';
        }

        return get_permalink( $page_submission );

    }

    public function term_id_to_slug( $term_id, $taxonomy ) {

        if( is_array( $term_id ) ) {
            $term_slugs = [];
            foreach( $term_id as $id ) {
                $term = get_term( $id, $taxonomy );
                if( ! is_wp_error( $term ) ) {
                    $term_slugs[] = $term->slug;
                }
            }
            return $term_slugs;
        }else{
            $term = get_term( $term_id, $taxonomy );
            if( ! is_wp_error( $term ) ) {
                return $term->slug;
            }
        }

        return;

    }

    public function is_prefixed( $id ) {
        return substr( $id, 0, 3 ) == 'rz_';
    }

    public function is_post_field( $id ) {
        return in_array( $id, Form::Post_Fields );
    }

    public function prefix_keys( $array ) {

        $prefixed = [];
        foreach( $array as $key => $value ) {
            $prefixed[ $this->prefix( $key ) ] = $value;
        }
        return $prefixed;

    }

    public function prefix_item( $item ) {
        if( isset( $item->fields->key ) ) {
            $item->fields->key = Rz()->prefix( $item->fields->key );
        }
        return $item;
    }

    public function prefix( $id ) {

        if( empty( $id ) ) {
            return;
        }

        if(
            ! $this->is_post_field( $id ) and
            ! $this->is_prefixed( $id )
        ) {
            return sprintf( 'rz_%s', $id );
        }

        return $id;
    }

    public function unprefix( $id ) {
        return $this->is_prefixed( $id ) ? preg_replace( '/^rz_/', '', $id ) : $id;
    }

    public function is_error( $thing ) {
        return $thing instanceof \Routiz\Inc\Src\Error;
    }

    public function get_listing_statuses() {
		return apply_filters(
			'routiz_listing_statuses', [
                'publish' => _x( 'Active', 'post status', 'routiz' ),
				'draft' => _x( 'Draft', 'post status', 'routiz' ),
				'pending' => _x( 'Pending Approval', 'post status', 'routiz' ),
				'pending_payment' => _x( 'Pending Payment', 'post status', 'routiz' ),
                'expired' => _x( 'Expired', 'post status', 'routiz' ),
                'cancelled' => _x( 'Cancelled', 'post status', 'routiz' ),
			]
		);
	}

    public function get_plan_statuses() {
		return apply_filters(
			'routiz_plan_statuses', [
                'publish' => _x( 'Active', 'post status', 'routiz' ),
				'draft' => _x( 'Inactive', 'post status', 'routiz' ),
				'used' => _x( 'Used', 'post status', 'routiz' ),
				'cancelled' => _x( 'Cancelled', 'post status', 'routiz' ),
			]
		);
	}

    public function get_promotion_statuses() {
		return apply_filters(
			'routiz_promotion_statuses', [
                'publish' => _x( 'Active', 'post status', 'routiz' ),
				'draft' => _x( 'Inactive', 'post status', 'routiz' ),
				'expired' => _x( 'Expired', 'post status', 'routiz' ),
				'cancelled' => _x( 'Cancelled', 'post status', 'routiz' ),
			]
		);
	}

    public function get_entry_statuses() {
		return apply_filters(
			'routiz_entry_statuses', [
                'publish' => _x( 'Active', 'post status', 'routiz' ),
				'pending' => _x( 'Pending', 'post status', 'routiz' ),
				'pending_payment' => _x( 'Pending Payment', 'post status', 'routiz' ),
				'declined' => _x( 'Declined', 'post status', 'routiz' ),
				// 'cancelled' => _x( 'Cancelled', 'post status', 'routiz' ),
				'trash' => _x( 'Trash', 'post status', 'routiz' ),
			]
		);
	}

    public function get_report_statuses() {
		return apply_filters(
			'routiz_report_statuses', [
                'publish' => _x( 'Reviewed', 'post status', 'routiz' ),
				'pending' => _x( 'Pending Review', 'post status', 'routiz' ),
				'trash' => _x( 'Trash', 'post status', 'routiz' ),
			]
		);
	}

    public function get_claim_statuses() {
		return apply_filters(
			'routiz_claim_statuses', [
                'publish' => _x( 'Complete', 'post status', 'routiz' ),
                'draft' => _x( 'Inactive', 'post status', 'routiz' ),
				'pending' => _x( 'Pending Review', 'post status', 'routiz' ),
				'trash' => _x( 'Trash', 'post status', 'routiz' ),
			]
		);
	}

    public function get_status( $post = null ) {

    	$post = get_post( $post );
    	$status = $post->post_status;

        switch( $post->post_type ) {
            case 'rz_plan': $statuses = $this->get_plan_statuses(); break;
            case 'rz_promotion': $statuses = $this->get_promotion_statuses(); break;
            case 'rz_report': $statuses = $this->get_report_statuses(); break;
            case 'rz_entry': $statuses = $this->get_entry_statuses(); break;
            case 'rz_claim': $statuses = $this->get_claim_statuses(); break;
            default: $statuses = $this->get_listing_statuses(); break;
        }


    	if ( isset( $statuses[ $status ] ) ) {
    		$status = $statuses[ $status ];
    	}else{
    		$status = esc_html__( 'Not assigned', 'routiz' );
    	}

    	return apply_filters( 'routiz_status', $status, $post );

    }

    public function get_entry_types() {
        return apply_filters(
			'routiz_entry_types', [
                'booking' => _x( 'Daily Reservation', 'entry type', 'routiz' ),
                'booking_hourly' => _x( 'Hourly Reservation', 'entry type', 'routiz' ),
                'booking_appointments' => _x( 'Appointment', 'entry type', 'routiz' ),
				'application' => _x( 'Application', 'entry type', 'routiz' ),
				'purchase' => _x( 'Purchase', 'entry type', 'routiz' ),
			]
		);
    }

    public function get_entry_type( $id ) {

        $types = $this->get_entry_types();

        if( array_key_exists( $id, $types ) ) {
            return $types[ $id ];
        }

        return esc_html__( 'Undefined entry type', 'routiz' );
    }

    public function get_priority_labels() {
        return apply_filters(
			'routiz_priority_labels', [
                1 => _x( 'Featured', 'priority status', 'routiz' ),
				2 => _x( 'Promoted', 'priority status', 'routiz' ),
			]
		);
    }

    public function get_action_type_label( $action_type_id ) {

        switch( $action_type_id ) {
            case 'contact': return esc_html__('Contact', 'routiz'); break;
            case 'application': return esc_html__('Application', 'routiz'); break;
            case 'booking': return esc_html__('Booking', 'routiz'); break;
            case 'location': return esc_html__('Location', 'routiz'); break;
        }

    }

    public function format_price( $num ) {

        $currency_place = get_option('rz_currency_place');
        $currency_symbol = get_option('rz_currency_symbol');

        $decimals = get_option('rz_decimals');
        $decimal_separator = get_option('rz_decimal_separator');
        $thousands_separator = get_option('rz_thousands_separator');

        $num = number_format( floatval( $num ), $decimals, $decimal_separator, $thousands_separator );

        return sprintf( $currency_place == 'left' ? '<span class="rz--currency">%1$s</span><span class="rz--amount">%2$s</span>' : '<span class="rz--amount">%2$s</span><span class="rz--currency">%1$s</span>', $currency_symbol, $num );

    }

    public function format_url( $url ) {
        return str_replace( '[siteurl]', get_site_url(), $url );
    }

    public function format_menu_link( $url ) {
        return str_replace( '/__site_url', get_site_url(), $url );
    }

    public function non_logged_in_account_page() {

        $wc_account_url = class_exists( 'woocommerce' ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : '#';

        return is_user_logged_in() ? '#' : $wc_account_url;

    }

    function short_number( $num ) {

        $units = ['', 'K', 'M', 'B', 'T'];

        for ( $i = 0; $num >= 1000; $i++ ) {
            $num /= 1000;
        }

        return round( $num, 1 ) . $units[ $i ];

    }

    function allowed_html() {
        return [
            'a' => [
                'href' => [],
                'title' => [],
                'rel' => true,
                'target' => true,
            ],
            'br' => [],
            'em' => [],
            'strong' => [],
            'p' => [],
            'i' => [
                'class' => []
            ],
        ];
    }

    function is_explore() {

        if( ! is_page() ) {
            return;
        }

        $page_object = get_queried_object();
        if( $page_object->ID == get_option('rz_page_explore') ) {
            return true;
        }

        return false;

    }

    function is_submission() {

        if( ! is_page() ) {
            return;
        }

        $page_object = get_queried_object();
        if( $page_object->ID == get_option('rz_page_submission') ) {
            return true;
        }

        return false;

    }

    function is_explore_type() {

        global $rz_explore;

    }

    function get_field_date( $field_date ) {

        $timezone = new \DateTimeZone('GMT');
        $now = new \DateTime('now', $timezone);

        preg_match( '/^([0-9]{2})\/([0-9]{2})$/', $field_date, $matches );
        $day = isset( $matches[1] ) ? (int) $matches[1] : 0;
        $month = isset( $matches[2] ) ? (int) $matches[2] : 0;

        try {
            $date = new \DateTime( "{$now->format('Y')}-{$month}-{$day}", $timezone );
            return $date->getTimestamp();
        }catch( \Exception $e ) {
            return null;
        }

    }

    function is_date_between( $start, $end, \DateTime $date ) {

        $timezone = new \DateTimeZone('GMT');
        $date_unix = $date->getTimestamp();

        if( $start <= $date_unix and $end >= $date_unix ) {
            return true;
        }

        return;

    }

    function is_weekend( $date ) {

        $timezone = new \DateTimeZone('GMT');

        switch( get_option('rz_weekends') ) {
            case 'fri_sat_sun': $weekend_days = [ 5, 6, 7 ]; break;
            case 'sun_mon': $weekend_days = [ 7, 1 ]; break;
            case 'fri_sat': $weekend_days = [ 5, 6 ]; break;
            default: $weekend_days = [ 6, 7 ]; // sat_sun
        }

        return in_array( (int) $date->format('N'), $weekend_days );

    }

    function get_payment_processing_types() {
        return apply_filters('routiz/payment/processing_types', [
            'full' => esc_html__('Process full payment', 'routiz'),
            'percentage' => esc_html__('Process percentage payment', 'routiz'),
            'security_deposit' => esc_html__('Process only security deposit', 'routiz'),
            'service_fee' => esc_html__('Process only service fee', 'routiz'),
            'locally' => esc_html__('Process full payment locally', 'routiz'),
        ]);
    }

    public function get_pre_defined() {
        return [
            'post_title',
            'post_content',
            'price',
            'location__address',
            'location__geo_city',
            'guests',
        ];
    }

    public function local_i18n( $timestamp ) {

        $tz_str = wp_timezone_string();
        $tz = new \DateTimeZone( $tz_str ? $tz_str : 'GMT' );

        // the date in the local timezone
        $date = new \DateTime( null, $tz );
        $date->setTimestamp( $timestamp );
        $date_str = $date->format('Y-m-d H:i:s');

        // pretend the local date is GMT to get the timestamp to pass to date_i18n()
        $gmt_timezone = new \DateTimeZone('GMT');
        $gmt_date = new \DateTime( $date_str, $gmt_timezone );

        return $gmt_date->getTimestamp();

    }

    public function to_time( $timestamp ) {
        if( (int) $timestamp != $timestamp ) {
            return strtotime( $timestamp );
        }
        return $timestamp;
    }

    public function local_date_i18n( $timestamp, $format = null ) {
        $timestamp = $this->to_time( $timestamp );
        return date_i18n( $format ? $format : get_option('date_format'), $this->local_i18n( $timestamp ), true );
    }

    public function local_time_i18n( $timestamp, $format = null ) {
        $timestamp = $this->to_time( $timestamp );
        return date_i18n( $format ? $format : get_option('time_format'), $this->local_i18n( $timestamp ), true );
    }

    public function local_datetime_i18n( $timestamp ) {
        $timestamp = $this->to_time( $timestamp );
        return sprintf( '%s %s', $this->local_date_i18n( $timestamp ), $this->local_time_i18n( $timestamp ) );
    }

    public function random( $length = 32 ) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr( str_shuffle( str_repeat( $chars, ceil( $length / strlen( $chars ) ) ) ), 1, $length );
    }

    public function listing_class() {

        $classes = [];

        $listing_type_id = $this->get_meta( 'rz_listing_type' );

        $classes[] = sprintf( 'rz-display-type--%s', $this->get_meta( 'rz_display_listing_type', $listing_type_id ) );

        echo implode( ' ', $classes );

    }

    public function get_geolocation_restrictions() {

        if( $geolocation_restrictions = get_option('rz_geolocation_restrictions') ) {

            // multiple
            if( strpos( $geolocation_restrictions, ',' ) !== false ) {
                return array_map('trim', explode( ',', $geolocation_restrictions ) );
            }
            // single
            else{
                return $geolocation_restrictions;
            }
        }

        return [];

    }

}
