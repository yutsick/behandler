<?php

namespace Routiz\Inc\Src\Explore;

use \Routiz\Inc\Src\Traits\Singleton;
use \Routiz\Inc\Src\Request\Request;

class Query {

    use Singleton;

    public $posts_per_page;
    public $page;
    public $query = [];
    public $meta_query = [
        'relation' => 'OR',
    ];

    function __construct() {

        global $rz_explore;

        $this->request = Request::instance();
        $this->page = $this->request->has('onpage') ? $this->request->get('onpage') : 1;

        if( $rz_explore->type ) {
            $this->posts_per_page = (int) $rz_explore->type->get('rz_listings_per_page');
        }else{
            $global_listings_per_page = (int) get_option('rz_global_listings_per_page');
            $this->posts_per_page = $global_listings_per_page ? $global_listings_per_page : (int) get_option( 'posts_per_page' );
        }

    }

    /*
     * listing sorting
     *
     */
    public function sorting() {

        /*if( $this->request->has('sorting') ) {
            switch( $this->request->get('sorting') ) {

                // top rated
                case 'top_rated':
                    return [
                        'meta_key' => 'rz_review_rating_average',
                        'orderby' => [
                            'meta_value_num' => 'DESC',
                            'date' => 'DESC',
                        ],
                        'order' => 'DESC'
                    ];
            }

        }*/

        // default by priority
        return [
            'meta_key' => 'rz_priority',
            'orderby' => [
                'meta_value_num' => 'DESC',
                'date' => 'DESC',
            ],
            'order' => 'DESC'
        ];

    }

    public function paging() {

        if( $this->request->has('onpage') ) {
            return [
                'offset' => ( $this->page - 1 ) * $this->posts_per_page
            ];
        }

    }

    public function post_title() {

        if( $this->request->has('post_title') ) {
            add_filter( 'posts_where', [ $this, 'where_title' ], 10, 2 );
            return [
                'rz_search_post_title' => $this->request->get('post_title')
            ];
        }

    }

    public function post_content() {

        if( $this->request->has('post_content') ) {
            add_filter( 'posts_where', [ $this, 'where_content' ], 10, 2 );
            return [
                'rz_search_post_content' => $this->request->get('post_content')
            ];
        }

    }

    public function search_term() {

        if( $this->request->has('search_term') ) {
            add_filter( 'posts_where', [ $this, 'where_term' ], 10, 2 );
            return [
                'rz_search_post_term' => $this->request->get('search_term')
            ];
        }
    }

    // TODO: add booking dates filter
    public function booking_dates() {

        // booking_dates_start
        // booking_dates_end

    }

    public function get() {

        $this->booking_dates();

        $this->add_query( $this->sorting() )
        ->add_query( $this->paging() )
        ->add_query( $this->post_title() )
        ->add_query( $this->post_content() )
        ->add_query( $this->search_term() )
        // ->add_query( $this->booking_dates() )
        ->add_query([
            'post_status' => 'publish',
            'post_type' => 'rz_listing',
            'posts_per_page' => $this->posts_per_page,
            'meta_query' => $this->meta_query,
            
        ]);

        // dd( $this->query );

    }

    public function add_query( $query ) {

        if( ! $query ) {
            return $this;
        }

        $this->query = array_merge( $this->query, $query );

        return $this;

    }

    public function add_meta_query( $id = null, $meta_query = [], $relation = 'AND' ) {

        if( ! $meta_query ) {
            return $this;
        }

        // main meta query
        if( is_null( $id ) ) {

            $this->meta_query = array_merge( $this->meta_query, $meta_query );
            return $this;

        }

        // sub meta query
        if( ! array_key_exists( $id, $this->meta_query ) ) {
            $this->meta_query[ $id ] = [
                'relation' => $relation
            ];
        }

        $this->meta_query[ $id ] = array_merge( $this->meta_query[ $id ], $meta_query );

        return $this;

    }

    public function fetch() {

        $this->get();

        // d( $this->query );

        $this->posts = new \WP_Query( $this->query );
        $this->clear_filters();

    }

    public function clear_filters() {

        remove_filter( 'posts_where', [ $this, 'where_title' ], 10 );
        remove_filter( 'posts_where', [ $this, 'where_content' ], 10 );
        remove_filter( 'posts_where', [ $this, 'where_term' ], 10 );

    }

    /*
     * search post title
     *
     */
    function where_title( $where, $wp_query ) {

        global $wpdb;

        if( $search_term = $wp_query->get('rz_search_post_title') ) {
            $where .= " AND {$wpdb->posts}.post_title LIKE '%" . stripslashes( $wpdb->esc_like( $search_term ) ) . "%'";
        }

        return $where;

    }

    /*
     * search post content
     *
     */
    function where_content( $where, $wp_query ) {

        global $wpdb;

        if( $search_term = $wp_query->get('rz_search_post_content') ) {
            // $where .= " AND {$wpdb->posts}.post_content LIKE '%" . $wpdb->esc_like( $search_term ) . "%'";
            $where .= " AND {$wpdb->posts}.post_content LIKE '%" . stripslashes( $wpdb->esc_like( $search_term ) ) . "%'";
        }

        return $where;

    }

    /*
     * search post term ( title + content )
     *
     */
    function where_term( $where, $wp_query ) {

        global $wpdb;

        if( $search_term = $wp_query->get( 'rz_search_post_term' ) ) {
            $where .= " AND ( {$wpdb->posts}.post_content LIKE '%" . $wpdb->esc_like( $search_term ) . "%' OR {$wpdb->posts}.post_title LIKE '%" . $wpdb->esc_like( $search_term ) . "%')";
        }

        return $where;

    }

}
