<?php

defined('ABSPATH') || exit;

global $rz_listing;

$rz_listing = new \Routiz\Inc\Src\Listing\Listing();
$cover_type = $rz_listing->type->get('rz_display_listing_cover');

?>

<div class="rz-listing<?php $rz_listing->the_classes(); ?> i-pr" <?php $rz_listing->the_attrs(); ?>>

    <?php if ($cover_type == 'image' or $cover_type == 'slider'): ?>
        <div class="rz-listing-cover">
            <div class="rz-listing-cover-inner">

                <?php Rz()->the_template('routiz/explore/listing/gallery'); ?>

                <?php Rz()->the_template('routiz/explore/listing/priority'); ?>

                <?php Rz()->the_template('routiz/explore/listing/badges'); ?>

            </div>
        </div>
    <?php elseif ($cover_type == 'author'): ?>

        <?php Rz()->the_template('routiz/explore/listing/author'); ?>

    <?php endif; ?>
    
    <?php if (!$rz_listing->type->get('rz_display_hide_listing_details')): ?>
        <a class="rz-listing-content" href="/author/<?php the_author(); ?>"<?php if ($rz_listing->type->get('rz_open_listing_new_tab')) {
            echo ' target="_blank"';
        } ?>>


            <span class="behandler-author-name">
            <?php Rz()->the_template('routiz/explore/listing/heading'); ?>
            </span>

            <?php if ($cover_type == 'author'): ?>
                <?php Rz()->the_template('routiz/explore/listing/priority'); ?>
            <?php endif; ?>

            <?php Rz()->the_template('routiz/explore/listing/details-content'); ?>

            <?php Rz()->the_template('routiz/explore/listing/details-bottom'); ?>

            <span class="behandler-status">
                <span class="behandler-status-icon">
                    <img src="/wp-content/themes/brikk-child/images/behandler-status-icon.svg" alt="img">
                </span>
                <span class="behandler-status-text">
                    Behandler af højeste kaliber
                </span>
            </span>

        </a>

        <div class="card-details-bottom-button">
            <div class="card-details-bottom-button-contact">
                <a href="#">
                    <img src="/wp-content/themes/brikk-child/images/mail.svg" alt="img">
                    Kontakt
                </a>
            </div>
            <div class="card-details-bottom-button-booking">
                <a href="<?php the_permalink();?>">
                    <img src="/wp-content/themes/brikk-child/images/calendar.svg" alt="img">
                    Book tid
                </a>
            </div>
        </div>
    <?php endif; ?>

</div