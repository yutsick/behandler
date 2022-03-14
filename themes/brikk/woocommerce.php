<?php get_header(); ?>
<!-- Content brikk/woocommerce.php -->
<?php
$is_explore = false;
if( function_exists('routiz') ) {
	$is_explore = Rz()->is_explore();
} ?>

<div class="brk-container brikk/woocommerce.php">

	<?php if( is_shop() ): ?>
		<?php get_template_part('templates/title'); ?>
	<?php endif; ?>

	<div class="brk-row">
		<?php woocommerce_content(); ?>
	</div>

</div>

<?php if( function_exists('is_account_page') and is_account_page() ): ?>
	<?php Brk()->the_template('account/footer'); ?>
<?php endif; ?>
<!-- Content brikk/woocommerce.php -->

<?php get_footer();
