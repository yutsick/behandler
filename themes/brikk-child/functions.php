<?php

/*
 * Enqueue child css
 *
 */
add_action('wp_enqueue_scripts', function () {
//  $child_theme_version  = wp_get_theme('brikk');
    wp_enqueue_style('brk-child-style', get_template_directory_uri() . '/style.css', ['brk-style']);
    wp_enqueue_style('brk-child-customization', get_stylesheet_directory_uri() . '/css/customize.css', true);
    wp_enqueue_style('account-customization', get_stylesheet_directory_uri() . '/css/customize2.css', true);

    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/scripts/common.js', array('jquery'));
    wp_enqueue_script('child-custom-script', get_stylesheet_directory_uri() . '/scripts/customize.js', array('jquery'));
});

function true_enqueue_styles()
{
    wp_enqueue_style('brk-vg-style-fonts', get_stylesheet_directory_uri() . '/fonts/stylesheet.css', true);
    wp_enqueue_style('brk-vg-style-main', get_stylesheet_directory_uri() . '/css/vg-style-main.css', true);
    wp_enqueue_style('brk-vg-style-media', get_stylesheet_directory_uri() . '/css/vg-style-media.css', true);
    
}
add_action('wp_enqueue_scripts', 'true_enqueue_styles', 20);

/*
 * Enqueue breadcrumb
 *
 */
include get_template_directory() . '../../brikk-child/inc/breadcrumbs.php';


/*
 * Remove generated BRs in Contact Form 7
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/*
* Remove checkout fields
*/
function wc_remove_checkout_fields( $fields ){
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_email'] );
    unset( $fields['billing']['billing_phone'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_first_name'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['order']['order_comments'] );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );

/**Change order status to Complete */

add_filter( 'woocommerce_thankyou', 'update_order_status', 10, 1 );

function update_order_status( $order_id ) {
  if ( !$order_id ){
    return;
  }
  $order = new WC_Order( $order_id );
  if ( 'processing' == $order->status) {
    $order->update_status( 'completed' );
  }
  return;
}
add_action('acf/input/admin_head', 'my_head_input');
function my_head_input(){
  ?>
  <style>
    .text-black, .text-black li{color:#000 !important;}
  </style>
  <?php
}

function wpa_author_endpoints(){
    add_rewrite_endpoint( 'gallery', EP_AUTHORS );
}
add_action( 'init', 'wpa_author_endpoints' );

function wpa_author_template( $template = '' ){
    global $wp_query;
    if( array_key_exists( 'gallery', $wp_query->query_vars ) )
        $template = locate_template( array( 'gallery.php', $template ), false );
		
    return $template;
}
add_filter( 'author_template', 'wpa_author_template' );