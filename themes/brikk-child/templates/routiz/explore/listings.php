<?php

defined('ABSPATH') || exit;

global $rz_explore;

?>



<div class="rz-dynamic rz-dynamic-listings">
    <div class="rz-explore-listings">
        <div class="rz--title">
            <h3 class="rz--name">
                Behandlere
             </h3>
        </div>

        <?php if ($rz_explore->total_types): 
     
          
            ?>
            <?php if ($rz_explore->query()->posts->have_posts()): ?>

            <div class="brk-listing-summary">
                <div class="brk--viewing">
                    <?php

                    global $rz_explore;

                    $from = ($rz_explore->query()->page - 1) * $rz_explore->query()->posts_per_page + 1;
                    $to = $from + $rz_explore->query()->posts_per_page - 1;

                    ?>
                    <p>
                        <?php echo sprintf(
                            esc_html__('Showing %s &ndash; %s of %s results', 'brikk'),
                            $from,
                            $to > $rz_explore->query()->posts->found_posts ? $rz_explore->query()->posts->found_posts : $to,
                            $rz_explore->query()->posts->found_posts
                        ); ?>
                    </p>
                </div>
                <div class="brk--sorting">
                    <?php esc_html_e('Sorted by priority & newest', 'brikk'); ?>
                </div>
            </div>

        <?php

        $cols = 5;

        if ($rz_explore->get_display_type() == 'map') {
            $cols = 2;
        }

        ?>

            <ul id="listing_switch_num" class="rz-listings" data-cols="2">
                <?php while ($rz_explore->query()->posts->have_posts()): $rz_explore->query()->posts->the_post(); ?>
                    <li class="rz-listing-item <?php Rz()->listing_class(); ?>">
                    
                        <?php Rz()->the_template('explore/listing/listing'); ?>
                    </li>
                    <?php Rz()->the_template('explore/listing/banner'); ?>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </ul>

            <script>
                let listing_switch = document.getElementById("listing_switch");
                let listing_switch_num = document.getElementById("listing_switch_num");
                let listing_switch_text = document.getElementById("listing_switch_text");
                let listing_switch_icon = document.querySelector(".listing_switch_icon");
                let listing_switch_icon_table = document.querySelector(".listing_switch_icon_table > img");
                let listing_switch_icon_maps = document.querySelector(".listing_switch_icon_maps > img");
                let contain_page_sid = document.querySelector(".contain-page-sid");
                let contain_page_map = document.querySelector(".contain-page-map");


                listing_switch.onclick = function (e) {
                    e.preventDefault();
                    if (listing_switch_num.getAttribute('data-cols')  == 3) {
                        jQuery(listing_switch_num).attr('data-cols', '2');
                        listing_switch_text.textContent = 'Skjul kort';
                        listing_switch_icon.classList.add("active")
                        jQuery(listing_switch_icon_table).attr('src', '/wp-content/themes/brikk-child/images/listing_switch_icon_table_white.svg');
                        jQuery(listing_switch_icon_maps).attr('src', '/wp-content/themes/brikk-child/images/listing_switch_icon_maps_red.svg');
                        contain_page_sid.classList.remove("active");
                        contain_page_map.classList.remove("in-active");
                    } else if (listing_switch_num.getAttribute('data-cols')  == 2){
                        jQuery(listing_switch_num).attr('data-cols', '3');
                        listing_switch_text.textContent = 'Vis kort';
                        listing_switch_icon.classList.remove("active")
                        jQuery(listing_switch_icon_table).attr('src', '/wp-content/themes/brikk-child/images/listing_switch_icon_table_red.svg');
                        jQuery(listing_switch_icon_maps).attr('src', '/wp-content/themes/brikk-child/images/listing_switch_icon_maps_white.svg');
                        contain_page_sid.classList.add("active");
                        contain_page_map.classList.add("in-active");
                    }
                }
            </script>

        <?php Rz()->the_template('routiz/explore/paging'); ?>

        <?php else: ?>

            <h5><?php esc_html_e('No results were found', 'brikk'); ?></h5>

        <?php endif; ?>

        <?php else: ?>

            <h5><?php esc_html_e('No listing types were found', 'brikk'); ?></h5>

        <?php endif; ?>

    </div>

</div>
