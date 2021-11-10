<?php

/**
 * The plugin bootstrap file
 *
 * Plugin Name:       Routiz
 * Plugin URI:        n/a
 * Description:       Listing & Directory management tool
 * Version:           1.4.1
 * Author:            Utillz
 * Author URI:        n/a
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       routiz
 * Domain Path:       /languages
 */

if( ! defined( 'ABSPATH' ) ) {
    return;
}

/*
 * textdomain
 *
 */
if( ! function_exists('rz_load_textdomain') ) {
    function rz_load_textdomain() {
    	load_plugin_textdomain( 'routiz', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }
    add_action( 'init', 'rz_load_textdomain' );
}

/*
 * const
 *
 */
define( 'RZ_PLUGIN', __FILE__ );
define( 'RZ_PATH', wp_normalize_path( plugin_dir_path( __FILE__ ) . DIRECTORY_SEPARATOR ) );
define( 'RZ_PATH_CACHE', RZ_PATH . 'inc/extensions/blade/cache/' );
define( 'RZ_URI', plugin_dir_url( __FILE__ ) );
define( 'RZ_VERSION', '1.4.1' );

$upload_dir = wp_upload_dir();

define( 'RZ_ICONS_PATH', trailingslashit( $upload_dir['basedir'] ) . 'routiz-icons/' );
define( 'RZ_ICONS_URI', trailingslashit( $upload_dir['baseurl'] ) . 'routiz-icons/' );

/*
 * autoloader
 *
 */
require_once RZ_PATH . 'inc/autoloader.php';
