<?php get_header(); ?>
    <div class="container">
        <div class="page_title">
            <h1>
                <?php single_cat_title(); ?>
            </h1>
        </div>
        <div class="page_description">
            <?php
            $categories = get_the_category();
            $category_id = $categories[0]->cat_ID;
            $cat_description = category_description($category_id);
            echo $cat_description;
            ?>
        </div>
    </div>
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="article_container">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('templates/short-article'); ?>
                <?php endwhile; ?>
            </div>
            <div class="brk-paging">
                <?php echo Brk()->pagination(); ?>
            </div>
        <?php else: ?>
            <?php get_template_part('templates/content-none'); ?>
        <?php endif; ?>
    </div>
<?php get_footer();
