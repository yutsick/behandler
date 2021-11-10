<?php
/*
Template Name: Page Blog
Template Post Type: page
*/ ?>
<?php get_header(); ?>
    <div class="container">
        <?php if (get_field('page_declaration_head')): ?>
            <div class="page_title">
                <h1>
                    <?php the_field('page_declaration_head'); ?>
                </h1>
            </div>
        <?php endif; ?>

        <?php if (get_field('page_declaration_text')): ?>
            <div class="page_description">
                <p>
                    <?php the_field('page_declaration_text'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="article_container">
            <?php
            $current = absint(
                max(
                    1,
                    get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' )
                )
            );
            $posts_per_page = 6;
            $query          = new WP_Query(
                [
                    'post_type'      => 'post',
                    'posts_per_page' => $posts_per_page,
                    'paged'          => $current,
                ]
            );
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    get_template_part('templates/short-article');
                }
                wp_reset_postdata();

                ?>
                <div class="pagination" style="width: 100%">
                    <?php
                    echo wp_kses_post(
                        paginate_links(
                            [
                                'total'   => $query->max_num_pages,
                                'current' => $current,
                            ]
                        )
                    );
                    ?>
                </div>
                <?php

            } else {
                global $wp_query;
                $wp_query->set_404();
                status_header( 404 );
                nocache_headers();
                require get_404_template();
            }
            ?>
        </div>
    </div>
<?php get_footer();
