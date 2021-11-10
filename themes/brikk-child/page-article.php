<?php
/*
Template Name: Page Article
Template Post Type: post
*/
?>
<?php get_header(); ?>
    <div class="container">
        <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(); ?>
    </div>

    <div class="container">
        <div class="case">
            <div class="article">
                <div class="article_head">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                </div>


                <?php
                $image = get_field('article_image');
                if (!empty($image)): ?>
                    <div class="article_image">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                    </div>
                <?php endif; ?>

                <div class="article_tags">
                    <div class="article_tags_author">
                        <?php
                        $current_user = wp_get_current_user();
                        echo $current_user->display_name;
                        ?>
                    </div>
                    <div class="article_tags_text">
                        <?php
                        the_tags('', '');
                        ?>
                    </div>
                </div>
                <div class="article_text">
                    <?php if (get_field('article_text')): ?>
                        <?php the_field('article_text'); ?>
                    <?php endif; ?>
                </div>
                <div class="article_links">
                    <div class="article_links_head">
                        Del link
                    </div>
                    <div class="article_links_link">
                        <a href="#">
                            <img src="/wp-content/themes/brikk-child/images/ico-fb.svg" alt="img">
                        </a>
                        <a href="#">
                            <img src="/wp-content/themes/brikk-child/images/ico-tw.svg" alt="img">
                        </a>
                        <a href="#">
                            <img src="/wp-content/themes/brikk-child/images/ico-in.svg" alt="img">
                        </a>
                    </div>
                </div>
            </div>
            <div class="sidebar">
                <div class="sidebar_head">
                    <h2>Relevante artikler</h2>
                </div>
                <div class="sidebar_link">

                    <?php
                    // задаем нужные нам критерии выборки данных из БД
                    $args = array(
                        'posts_per_page' => -1,
                    );

                    // запрос
                    $query = new WP_Query($args); ?>

                    <?php if ($query->have_posts()) : ?>

                        <!-- пагинация -->

                        <!-- цикл -->
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                $image = get_field('article_image');
                                if (!empty($image)): ?>
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                         alt="<?php echo esc_attr($image['alt']); ?>"/>
                                <?php endif; ?>
                                <span><?php the_title(); ?></span>
                            </a>
                        <?php endwhile; ?>
                        <!-- конец цикла -->

                        <!-- пагинация -->

                        <?php wp_reset_postdata(); ?>

                    <?php else : ?>
                        <p><?php esc_html_e('Нет постов по вашим критериям.'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>