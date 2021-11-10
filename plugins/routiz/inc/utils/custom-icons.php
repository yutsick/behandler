<?php

namespace Routiz\Inc\Utils;

class Custom_Icons {

    use \Routiz\Inc\Src\Traits\Singleton;

    function __construct() {
        // ..
    }

    public function get_sets() {

        $upload_dir = wp_upload_dir();

    	$custom_icons = [];

    	$posts = get_posts([
    		'post_type' => 'rz_icon_set',
    		'post_status' => 'publish',
    		'posts_per_page' => -1,
    	]);

    	foreach( $posts as $post ) {
    		$meta = Rz()->get_meta( 'rz_custom_icon_set', $post->ID );

    		if( $meta !== '' ) {
    			$custom_icons[ $post->post_name ] = $meta;
    			$custom_icons[ $post->post_name ]['name'] = get_the_title( $post->ID );
    			$custom_icons[ $post->post_name ]['css_url'] = $this->get_css_url( $post->ID );
    		}
    	}

    	return $custom_icons;

	}

    public function get_css_url( $post_id = 0 ) {

    	if ( ! $post_id ) {
    		$post_id = get_the_ID();
    	}

    	$icon_set = Rz()->get_meta( 'rz_custom_icon_set', $post_id );

    	return ! empty( $icon_set['icon_dir_name'] ) ? RZ_ICONS_URI . $icon_set['icon_dir_name'] . '/style.css' : '';
    }

}
