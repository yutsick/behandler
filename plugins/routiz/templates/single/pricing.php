<?php

use \Routiz\Inc\Src\Request\Request;
use \Routiz\Inc\Src\Listing\Listing;

defined('ABSPATH') || exit;

global $rz_listing;

$request = Request::instance();
$rz_listing = new Listing( $request->get('listing_id') );
$action = $rz_listing->type->get_action('booking');
$checkin = $request->get('checkin');
$checkout = $request->get('checkout');

/*
 * handle bookings with single date selection and set checkout date
 *
 */
if( $action->get_field('selection_type') == 'single' ) {
    if( $checkin ) {
        $checkout = $checkin + 86400; // add one day based on checkin
    }
}

if( ! $rz_listing->type->get('rz_allow_pricing') ) {
    return;
}

$pricing = $rz_listing->get_booking_date_range_price(
    $checkin,
    $checkout,
    $request->get('guests'),
    $request->get('addons')
);

/*if( $pricing->processing <= 0 ) {
    return;
}*/

?>

<table>
    <tbody>
        <tr>
            <td><?php esc_html_e('Res. length', 'routiz'); ?></td>
            <td>&#10005; <?php echo (int) $pricing->nights; ?></td>
        </tr>
        <tr>
            <td><?php esc_html_e('Price', 'routiz'); ?></td>
            <td><?php echo Rz()->format_price( $pricing->base ); ?></td>
        </tr>
        <?php if( $pricing->guest_price ): ?>
            <tr>
                <td><?php esc_html_e('Extra guests', 'routiz'); ?></td>
                <td><?php echo Rz()->format_price( $pricing->guest_price ); ?></td>
            </tr>
        <?php endif; ?>
        <?php if( $pricing->long_term ): ?>
            <tr>
                <td><?php esc_html_e('Long term discounts', 'routiz'); ?></td>
                <td>&#8722;&nbsp;<?php echo Rz()->format_price( $pricing->long_term ); ?></td>
            </tr>
        <?php endif; ?>
        <?php if( $pricing->security_deposit ): ?>
            <tr>
                <td><?php esc_html_e('Security deposit', 'routiz'); ?></td>
                <td><?php echo Rz()->format_price( $pricing->security_deposit ); ?></td>
            </tr>
        <?php endif; ?>
        <?php if( $pricing->service_fee ): ?>
            <tr>
                <td><?php esc_html_e('Service fee', 'routiz'); ?></td>
                <td><?php echo Rz()->format_price( $pricing->service_fee ); ?></td>
            </tr>
        <?php endif; ?>
        <?php if( $pricing->extras ): ?>
            <?php foreach( $pricing->extras as $extra ): ?>
                <tr>
                    <td><?php echo esc_html( $extra->name ); ?></td>
                    <td><?php echo Rz()->format_price( $extra->type == 'single_fee' ? $extra->price : $extra->price * $pricing->nights ); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if( $pricing->addons ): ?>
            <?php foreach( $pricing->addons as $addon ): ?>
                <tr>
                    <td><?php echo esc_html( $addon->name ); ?></td>
                    <td><?php echo Rz()->format_price( $addon->price ); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php $payment_processing_percentage = (int) $rz_listing->type->get('rz_payment_processing_percentage'); ?>
        <?php if( $pricing->payment_processing == 'percentage' and $payment_processing_percentage > 0 ): ?>
            <tr>
                <td><?php echo esc_html( $pricing->payment_processing_name ); ?></td>
                <td><?php echo (int) $payment_processing_percentage; ?>%</td>
            </tr>
        <?php else: ?>
            <tr>
                <td><?php echo esc_html( $pricing->payment_processing_name ); ?></td>
                <td>&nbsp;</td>
            </tr>
        <?php endif; ?>
        <tr>
            <td><strong><?php esc_html_e('Total', 'routiz'); ?></strong></td>
            <td><strong><?php echo Rz()->format_price( $pricing->total ); ?></strong></td>
        </tr>
        <tr>
            <td><strong><?php esc_html_e('Due now', 'routiz'); ?></strong></td>
            <td><strong><?php echo Rz()->format_price( $pricing->processing ); ?></strong></td>
        </tr>
    </tbody>
</table>
