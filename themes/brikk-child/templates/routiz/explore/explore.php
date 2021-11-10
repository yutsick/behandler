<?php

defined('ABSPATH') || exit;

global $rz_explore;

?>
<a id="listing_switch" href="#">
    <span id="listing_switch_text" >Skjul kort</span>
    <span class="listing_switch_icon">
        <span class="listing_switch_icon_table">
            <img src="/wp-content/themes/brikk-child/images/listing_switch_icon_table_red.svg" alt="img">
        </span>
        <span class="listing_switch_icon_maps">
            <img src="/wp-content/themes/brikk-child/images/listing_switch_icon_maps_white.svg" alt="img">
        </span>
    </span>
</a>
<div class="contain-page">
    
    <div class="contain-page-map">
        <?php Rz()->the_template('routiz/explore/map/map'); ?>
    </div>
    <div class="contain-page-sid explore-behandler">
        <?php Rz()->the_template('routiz/explore/filters'); ?>
        <?php Rz()->the_template('routiz/explore/listings'); ?>
    </div>
</div>
