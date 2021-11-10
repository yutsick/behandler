<?php
/*
Template Name: Page About us
Template Post Type: page
*/ ?>
<?php get_header(); ?>
    <div class="about__main" style="background-image: url('<?php the_field('about_us_bg'); ?>');">
        <div class="container color-w">
            <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(); ?>
        </div>
        <div class="container">
            <div class="about__main_info">
                <?php if (get_field('about_us_head')): ?>
                    <div class="about__main_info-head">
                        <h1><?php the_field('about_us_head'); ?></h1>
                    </div>
                <?php endif; ?>
                <?php if (get_field('about_us_slag')): ?>
                    <div class="about__main_info-text">
                        <?php the_field('about_us_slag'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="about__description">
            <?php if (get_field('about_us_description_head')): ?>
                <div class="about__description_head">
                    <h2>
                        <?php the_field('about_us_description_head'); ?>
                    </h2>
                </div>
            <?php endif; ?>
            <?php if (get_field('about_us_description_text')): ?>
                <div class="about__description_text">
                    <?php the_field('about_us_description_text'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="about__advantage">
        <div class="container">
            <div class="about__advantage_list">

                <!--Get repeater-->
                <?php if (have_rows('about_us_advantages')): ?>
                    <?php $i = 1; ?>
                    <?php while (have_rows('about_us_advantages')): the_row(); ?>
                        <?php
                        // Get parent value.
                        $about_us_advantages_text = get_sub_field('about_us_advantages_text');
                        ?>
                        <div class="advantage__item">
                            <div class="advantage__item_numb">
                                <?php echo $i; ?>
                            </div>
                            <?php
                            $image = get_sub_field('about_us_advantages_icon');

                            if (!empty($image)): ?>
                                <div class="advantage__item_icon">
                                    <img src="<?php echo esc_url($image['url']); ?>"
                                         alt="<?php echo esc_attr($image['alt']); ?>"/>
                                </div>
                            <?php endif; ?>
                            <?php if ($about_us_advantages_text): ?>
                                <div class="advantage__item_text">
                                    <?php echo $about_us_advantages_text; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php $i++; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="paper__white">
        <div class="container">
            <div class="paper">
                <div class="paper__info">
                    <?php if (get_field('white_article_head')): ?>
                        <div class="paper__info_head">
                            <h2>
                                <?php the_field('white_article_head'); ?>
                            </h2>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('white_article_text')): ?>
                        <div class="paper__info_text">
                            <?php the_field('white_article_text'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="paper__image">
                    <?php
                    $image = get_field('white_article_img');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="paper__pinks">
        <div class="container">
            <div class="paper">
                <div class="paper__info">
                    <?php if (get_field('pink_article_head')): ?>
                        <div class="paper__info_head">
                            <h2>
                                <?php the_field('pink_article_head'); ?>
                            </h2>
                        </div>
                    <?php endif; ?>
                    <?php if (get_field('pink_article_text')): ?>
                        <div class="paper__info_text">
                            <?php the_field('pink_article_text'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="paper__image">
                    <?php
                    $image = get_field('pink_article_img');
                    if (!empty($image)): ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"/>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="price__info">
        <div class="container">
            <?php if (get_field('prices_head')): ?>
                <div class="price__info_head">
                    <h2><?php the_field('prices_head'); ?></h2>
                </div>
            <?php endif; ?>
            <?php if (get_field('prices_text')): ?>
                <div class="price__info_text">
                    <?php the_field('prices_text'); ?>
                </div>
            <?php endif; ?>
            <div class="contain-rate">
                <?php
                $gratis = get_field('gratis');
                if ($gratis): ?>
                    <div class="price__info_rate">
                        <div class="rate">
                            <div class="rate__head">
                                <h4><?php echo $gratis['gratis_head']; ?></h4>
                            </div>
                            <div class="rate__text">
                                <?php echo $gratis['gratis_text']; ?>
                            </div>
                            <div class="rate__numb">
                                <div class="rate__numb_big"><?php echo $gratis['gratis_number']; ?></div>
                                <div class="rate__numb_smn">
                                    <div class="rate__numb_smn-i"><?php echo $gratis['gratis_number_prefix']; ?></div>
                                    <div class="rate__numb_smn-o"><?php echo $gratis['gratis_number_sufix']; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="price__info_make">
                            <ul>
                                <?php $gratis_list = $gratis['gratis_list']; ?>
                                <?php foreach ($gratis_list as $value) { ?>
                                    <li class="<?php echo $value['gratis_list_class']; ?>">
                                        <?php echo $value['gratis_list_text']; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                $gratis = get_field('kommission');
                if ($gratis): ?>
                    <div class="price__info_rate">
                        <div class="rate">
                            <div class="rate__head">
                                <h4><?php echo $gratis['gratis_head']; ?></h4>
                            </div>
                            <div class="rate__text">
                                <?php echo $gratis['gratis_text']; ?>
                            </div>
                            <div class="rate__numb">
                                <div class="rate__numb_big"><?php echo $gratis['gratis_number']; ?></div>
                                <div class="rate__numb_smn">
                                    <div class="rate__numb_smn-i"><?php echo $gratis['gratis_number_prefix']; ?></div>
                                    <div class="rate__numb_smn-o"><?php echo $gratis['gratis_number_sufix']; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="price__info_make">
                            <ul>
                                <?php $gratis_list = $gratis['gratis_list']; ?>
                                <?php foreach ($gratis_list as $value) { ?>
                                    <li class="<?php echo $value['gratis_list_class']; ?>">
                                        <?php echo $value['gratis_list_text']; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                $gratis = get_field('abonnement');
                if ($gratis): ?>
                    <div class="price__info_rate">
                        <div class="rate">
                            <div class="rate__head">
                                <h4><?php echo $gratis['gratis_head']; ?></h4>
                            </div>
                            <div class="rate__text">
                                <?php echo $gratis['gratis_text']; ?>
                            </div>
                            <div class="rate__numb">
                                <div class="rate__numb_big"><?php echo $gratis['gratis_number']; ?></div>
                                <div class="rate__numb_smn">
                                    <div class="rate__numb_smn-i"><?php echo $gratis['gratis_number_prefix']; ?></div>
                                    <div class="rate__numb_smn-o"><?php echo $gratis['gratis_number_sufix']; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="price__info_make">
                            <ul>
                                <?php $gratis_list = $gratis['gratis_list']; ?>
                                <?php foreach ($gratis_list as $value) { ?>
                                    <li class="<?php echo $value['gratis_list_class']; ?>">
                                        <?php echo $value['gratis_list_text']; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <div class="contact__us">
                <?php if (get_field('form_head')): ?>
                    <div class="contact__us_head">
                        <h2><?php the_field('form_head'); ?></h2>
                    </div>
                <?php endif; ?>
                <?php if (get_field('form_text')): ?>
                    <div class="contact__us_text">
                        <?php the_field('form_text'); ?>
                    </div>
                <?php endif; ?>
                <?php echo do_shortcode( '[contact-form-7 id="2716" title="Contact form 1"]' );?>
                <!--
                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="in-name" class="display-none">Navn</label>
                            <input type="text" class="form-control" id="in-name" placeholder="Navn">
                        </div>

                        <div class="form-group">
                            <label for="in-mail" class="display-none">E-mail adresse</label>
                            <input type="email" class="form-control" id="in-mail" placeholder="E-mail adresse">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="in-text" class="display-none">Skriv besked</label>
                        <textarea class="form-control" id="in-text" rows="3" placeholder="Skriv besked"></textarea>
                    </div>
                    <div class="form-group justify-end">
                        <button type="submit" class="btn-button-send">Sende</button>
                    </div>
                </form>
                -->
            </div>
        </div>
    </div>

<?php get_footer();
