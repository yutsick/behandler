<?php

namespace Routiz\Inc\Src;

use \Routiz\Inc\Src\Request\Request;

class Icon_Sets {

    use \Routiz\Inc\Src\Traits\Singleton;

    function __construct() {

        // register post type
        add_action( 'init', [ $this, 'register_post_types' ] );

        // metabox
        add_action( 'add_meta_boxes' , [ $this, 'register_meta_boxes' ] );

    }

    function register_post_types() {

        $singular = esc_html__( 'Icon Set', 'routiz' );
		$plural = esc_html__( 'Icon Sets', 'routiz' );

		$rewrite = [
			'slug' => 'icon-set',
			'with_front' => false,
			'feeds' => false,
			'pages' => false
		];

		register_post_type( 'rz_icon_set',
			apply_filters( 'routiz/post_type/icon-set', [
				'labels' => [
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => $plural,
					'all_items'             => sprintf( esc_html__( '%s', 'routiz' ), $plural ),
					'add_new' 				=> esc_html__( 'Add New', 'routiz' ),
					'add_new_item' 			=> sprintf( esc_html__( 'Add %s', 'routiz' ), $singular ),
					'edit' 					=> esc_html__( 'Edit', 'routiz' ),
					'edit_item' 			=> sprintf( esc_html__( 'Edit %s', 'routiz' ), $singular ),
					'new_item' 				=> sprintf( esc_html__( 'New %s', 'routiz' ), $singular ),
					'view' 					=> sprintf( esc_html__( 'View %s', 'routiz' ), $singular ),
					'view_item' 			=> sprintf( esc_html__( 'View %s', 'routiz' ), $singular ),
					'search_items' 			=> sprintf( esc_html__( 'Search %s', 'routiz' ), $plural ),
					'not_found' 			=> sprintf( esc_html__( 'No %s found', 'routiz' ), $plural ),
					'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s found in trash', 'routiz' ), $plural ),
					'parent' 				=> sprintf( esc_html__( 'Parent %s', 'routiz' ), $singular ),
				],
                'taxonomies'            => [],
                'show_in_menu'          => 'edit.php?post_type=rz_listing_type',
				'public' 				=> false,
				'show_ui' 				=> true,
				'publicly_queryable' 	=> false,
				'exclude_from_search' 	=> true,
				'hierarchical' 			=> false,
				'rewrite' 				=> $rewrite,
				'query_var' 			=> true,
				'supports' 				=> [ 'title' ],
				'has_archive' 			=> false,
				'show_in_nav_menus' 	=> true,
                'capability_type'       => 'post',
                'map_meta_cap'          => true,
			])
		);

    }

    public function register_meta_boxes() {

        // listing types
        add_meta_box(
            'rz-icon-set-options',
            _x( 'Icon Set Options', 'Icon set options in wp-admin', 'routiz' ),
            [ $this, 'meta_boxes_icon_set' ],
            'rz_icon_set'
        );

    }

    static function meta_boxes_icon_set( $post ) {
        Rz()->the_template('admin/metabox/icon-set');
    }

}
