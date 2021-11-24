<?php
/*
Template Name: Main Page
Template Post Type: page
*/
?>
<?php global $rz_explore; 
$args = array(
    'post_type' => 'rz_listing',
    'meta_query' => [ [
        'key'	=>	'rz_listing_type',
        'value'	=>	'3440',
    ] ],
);
?>

<?php get_header(); ?>
<main class="brk-main">
    <div class="brk-content">
        <article <?php post_class(); ?>>

            <div class="brk-page-content">
                <?php the_content(); ?>

                <div class="s-steps brk-row">
                    <!--Get repeater-->
                    <?php if (have_rows('steps')): ?>
                        <?php while (have_rows('steps')): the_row(); ?>

                            <?php $steps_head = get_sub_field('steps_head'); ?>
                            <?php $steps_description = get_sub_field('steps_description'); ?>

                            <div class="s-steps-item">
                                <?php $image = get_sub_field('steps_icon');
                                if (!empty($image)): ?>
                                    <div class="s-steps__image">
                                        <picture>
                                            <source media="(max-width: 799px)" srcset="<?php echo esc_url($image['url']); ?>">
                                            <source media="(min-width: 800px)" srcset="<?php echo esc_url($image['url']); ?>">
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                                        </picture>
                                    </div>
                                <?php endif; ?>
                                <h3><?php echo $steps_head; ?></h3>
                                <p><?php echo $steps_description; ?></p>
                                <?php if (get_field('steps_link_link')): ?>
                                    <a href="<?php the_field('steps_link_link'); ?>" class="btn rz-button rz-large rz-button-accent rz-action-dynamic-explore">
                                        <?php the_field('steps_link_text'); ?>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.3672 11.4328L16.5125 8.74766C16.4445 8.68906 16.3578 8.65625 16.2664 8.65625C16.2664 11.1484 16.2664 8.65625 16.2656 11.1094H3.5625C3.45937 11.1094 3.375 11.1937 3.375 11.2969V12.7031C3.375 12.8063 3.45937 12.8906 3.5625 12.8906L16.3344 12.9201C16.3344 15.3438 16.3344 12.9201 16.3344 15.3438C16.3789 15.3438 16.4234 15.3273 16.4562 15.2969L20.3672 12.5672C20.4483 12.4966 20.5134 12.4095 20.558 12.3116C20.6025 12.2138 20.6256 12.1075 20.6256 12C20.6256 11.8925 20.6025 11.7862 20.558 11.6884C20.5134 11.5905 20.4483 11.5034 20.3672 11.4328Z"
                                                  fill="white"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <div class="s-featured brk-row">
                    <div class="s-featured-heading">
                        <?php if (get_field('therapist_declaration_head')): ?>
                            <h2><?php the_field('therapist_declaration_head'); ?></h2>
                        <?php endif; ?>
                        <?php if (get_field('therapist_declaration_text')): ?>
                            <?php the_field('therapist_declaration_text'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="s-featured-slider">
                        <?php $query = new WP_Query( $args ); ?>
                        <?php if ($query->have_posts()): ?>
                            <?php while ($query->have_posts()): $query->the_post(); ?>
                                <li class="rz-listing-item <?php Rz()->listing_class(); ?>">
                                    <?php Rz()->the_template('routiz/explore/listing/listing'); ?> 
                                </li>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="s-last-articles">
                <?php if (get_field('latest_articles_head')): ?>
                    <div class="brk-row">
                        <h2 class="h2 text-white"><?php the_field('latest_articles_head'); ?></h2>
                    </div>
                <?php endif; ?>

                <div class="s-last-articles-container brk-row">
                    <?php
                    $image = get_field('latest_articles_img');
                    if (!empty($image)): ?>
                        <div class="col">
                            <picture>
                                <source media="(max-width: 799px)" srcset="<?php echo esc_url($image['url']); ?>">
                                <source media="(min-width: 800px)" srcset="<?php echo esc_url($image['url']); ?>">
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                            </picture>
                        </div>
                    <?php endif; ?>
                    <div class="col">
                        <?php
                        $featured_posts = get_field('latest_articles_list');
                        if ($featured_posts): ?>
                            <?php foreach ($featured_posts as $post):
                                // Setup this post for WP functions (variable must be named $post).
                                setup_postdata($post); ?>
                                <div class="last-article">
                                    <time datetime="<?php echo get_the_date('Y-m-d H:i'); ?>">
                                        <?php echo get_the_date('j.m.Y'); ?>
                                    </time>
                                    <h3 class="text-white"><?php the_title(); ?></h3>
                                    <?php if (get_field('article_except')): ?>
                                        <p>
                                            <?php the_field('article_except'); ?>
                                        </p>
                                    <?php endif; ?>
                                    <a href="<?php the_permalink(); ?>" class="btn-s-arrow">Læs mere</a>
                                </div>
                            <?php endforeach; ?>
                            <?php
                            // Reset the global post object so that the rest of the page works correctly.
                            wp_reset_postdata(); ?>
                        <?php endif; ?>

                    </div>
                </div>
                <?php if (get_field('latest_articles_link_link')): ?>
                    <div class="brk-row">
                        <a href="<?php the_field('latest_articles_link_link'); ?>" class="btn-centered btn-bordered btn-bordered--white"><?php the_field('latest_articles_link_text'); ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="s-form">
                <div class="brk-row s-form-container">
                    <div class="s-form-image" style="background-image: url('/wp-content/themes/brikk-child/images/s-form.jpg');"></div>
                    <div class="b-form">
                        <?php if (get_field('form_head')): ?>
                            <div class="form__head">
                                <?php the_field('form_head'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('form_slag')): ?>
                            <div class="form__slag">
                                <?php the_field('form_slag'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (get_field('form_description')): ?>
                            <div class="form__description">
                                <?php the_field('form_description'); ?>
                            </div>
                        <?php endif; ?>
                        <?php echo do_shortcode('[contact-form-7 id="2716" title="Contact form 1"]'); ?>
                    </div>
                </div>
            </div>

        </article>
    </div>

    <?php $page_id = get_the_ID(); ?>
    <?php wp_link_pages(); ?>
    <?php if (comments_open($page_id)): ?>
        <?php comments_template(); ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>



