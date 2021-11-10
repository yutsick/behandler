<?php

defined('ABSPATH') || exit;

global $rz_explore;

?>

<div class="rz-dynamic rz-dynamic-map">


    <label class="rz-geo-sync">
        <div class="rz-checkbox rz-no-select">
            <input type="checkbox" name="rz_geo_sync" value="1" checked="checked">
            <span class="rz-transition"></span>
            <em><?php esc_html_e('Search as I move the map', 'routiz'); ?></em>
        </div>
    </label>

    <?php if( get_option('rz_google_api_key') ): ?>
        <div class="rz-explore-map" id="rz-explore-map"></div>
        <div class="rz-map-zoom">
            <a href="#" class="rz--zoom-in" data-action="explore-map-zoom-in"><i class="fas fa-plus"></i></a>
            <a href="#" class="rz--zoom-out" data-action="explore-map-zoom-out"><i class="fas fa-minus"></i></a>
        </div>
        <?php do_action('routiz/after_map'); ?>
    <?php else: ?>
        <div class="rz-explore-map rz--no-map">
            <strong><?php esc_html_e( 'Map can\'t be displayed, please add Google Map Api Key', 'routiz' ); ?></strong>
        </div>
    <?php endif; ?>

    <?php Rz()->the_template('routiz/explore/map/markers'); ?>
    <?php Rz()->the_template('routiz/explore/map/infoboxes'); ?>

    <span class="rz-map-overlay"></span>

    <?php Rz()->preloader(); ?>

</div>
