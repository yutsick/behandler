<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header("registration");

$key = array_key_first((WC()->cart->get_cart())); 
$product_id = ( WC() -> cart -> cart_contents[$key]['product_id']);
$product = wc_get_product( $product_id );
?>
<!-- Start template -->
<style>
	header{
		display:none;
	}
</style>
<div class="contain-registration rz-relative">
    <div class="registration-imag rz-relative h-auto">
        <a href="/wizard_plan" id="'history-back" class="history-back" onClick=".history.back()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.63342 11.4328L12.4881 3.74766C12.5561 3.68906 12.6428 3.65625 12.7342 3.65625H14.8084C14.9819 3.65625 15.0616 3.87187 14.9303 3.98438L6.72249 11.1094H20.4381C20.5412 11.1094 20.6256 11.1937 20.6256 11.2969V12.7031C20.6256 12.8062 20.5412 12.8906 20.4381 12.8906H6.72483L14.9326 20.0156C15.0639 20.1305 14.9842 20.3438 14.8108 20.3438H12.6662C12.6217 20.3438 12.5772 20.3273 12.5444 20.2969L3.63342 12.5672C3.55229 12.4966 3.48723 12.4095 3.44265 12.3116C3.39807 12.2138 3.375 12.1075 3.375 12C3.375 11.8925 3.39807 11.7862 3.44265 11.6884C3.48723 11.5905 3.55229 11.5034 3.63342 11.4328Z" fill="#CDC6CC"/>
            </svg>
            Tilbage
        </a>
    </div>
	<div class="rz-absolute text-white din-plan">
		<h2 class="">Din plan</h2>
		<div class="red-plan-checkout">
			<h3><?php echo $product -> name; ?></h3>
			<p><?php echo $product -> short_description; ?></p>
			<!-- <div class="rz-flex rz-justify-center rz-align-center">
				<div class="percent rz-mr-1">5</div>
				<div class="perc-desc ">
					<div class="text-bold perc-sign">%</div>
					<div>Per booking</div>
				</div>
			</div> -->
			<div class="rz-price rz-ml-5">
				<p>
					<span class="woocommerce-Price-amount amount">
						<bdi class="text-white">
							<span class="woocommerce-Price-currencySymbol text-white">DKK</span>
							&nbsp; 
							<?php echo $product -> price; ?>
						</bdi>
					</span>
				</p>
			</div>
			<div class="price__info_make">
                <div class="price__info_make text-white">
					<?php echo $product -> description; ?>
				</div>
            </div>
		</div>
	</div>
    <div class="registration-form mb-100">

        <div class="regis-top">
            <div class="regis-top-logo">
                <a href="<?php echo  get_home_url();?>">
                    <img src="/wp-content/themes/brikk-child/images/logo-dark.png" alt="img" width="225">
                </a>
            </div>
        </div>

        <div class="regis-for">
            <div class="u-columns">

                <div class="u-column1 col-1">

                    <h2><?php esc_html_e( 'Vælg din plan', 'woocommerce' ); ?></h2>

                    <p class="regis-text">Her køber du adgang til <a href="http://behandler.net">Behandler.net</a>. Det er altid muligt at skifte betalingsplan og 
						tilvælge ekstra funktioner. Da du har valgt Kommissionsplanen, trækker vi kun penge, når der bookes 
						behandlinger igennem os. Hvis du har spørgsmål til funktioner eller planer, står vores team altid klar
						 til at gennemgå din virksomheds behov med dig.</p>
					<!-- enter stripe card -->



					<?php
					/**End template */


					//do_action( 'woocommerce_before_checkout_form', $checkout );

					// If checkout registration is disabled and not logged in, the user cannot checkout.
					if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
						echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
						return;
					}

					?>

					<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

						
						<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
						
						
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

						<div id="order_review" class="woocommerce-checkout-review-order">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>

						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

					</form>

					<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
				
                </div>

            </div>
        </div>

    </div>
</div>