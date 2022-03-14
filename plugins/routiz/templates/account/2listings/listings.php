<?php

use \Routiz\Inc\Src\Request\Request;

defined('ABSPATH') || exit;

$listings = \Routiz\Inc\Src\Woocommerce\Account\Account::get_listings();
$request = Request::instance();
$page = $request->has('onpage') ? $request->get('onpage') : 1;

?>

<?php if( $listings->have_posts() ): ?>
    <div class="rz-boxes">
        <?php while( $listings->have_posts() ) : $listings->the_post(); ?>
            <?php Rz()->the_template('routiz/account/listings/row'); ?>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
<?php else: ?>
    <p><?php esc_html_e( 'No listings were found', 'routiz' ); ?></p>
<?php endif; ?>

<div class="rz-paging">
    <?php

        echo Rz()->pagination([
            'base' => add_query_arg( [ 'onpage' => '%#%' ], wc_get_account_endpoint_url( 'listings' ) ),
            'format' => '?onpage=%#%',
            'current' => $page,
            'total' => $listings->max_num_pages,
        ]);

    ?>
</div>

<?php Rz()->the_template( 'routiz/account/listings/modal/modal' ); ?>
<?php Rz()->the_template( 'routiz/account/listings/promotion/modal/modal' ); ?>
<?php Rz()->the_template( 'routiz/account/listings/booking-calendar/modal/modal' ); ?>
<?php Rz()->the_template( 'routiz/account/listings/booking-ical/modal/modal' ); ?>