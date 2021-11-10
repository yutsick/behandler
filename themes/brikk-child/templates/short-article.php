<div class="short_article">
    <div class="short_article_img">
        <?php
        $image = get_field('article_image');
        if (!empty($image)): ?>
            <a href="<?php the_permalink();?>">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
            </a>
        <?php endif; ?>
    </div>
    <div class="short_article_head">
        <h4>
            <?php the_title(); ?>
        </h4>
    </div>
    <div class="short_article_except">
        <?php if (get_field('article_except')): ?>
            <p>
                <?php the_field('article_except'); ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="short_article_link">
        <a href="<?php the_permalink(); ?>">
            Læs mere
            <img src="/wp-content/themes/brikk-child/images/read-more-arrow.svg" alt="img">
        </a>
    </div>
</div>