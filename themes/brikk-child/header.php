<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site brikk-child/header.php">
    
<?php $user = wp_get_current_user();

if (get_the_author_meta('rz_role', $user->ID) == 'business'){
        
        // echo'/business';
        // $url = '/business';
        // wp_redirect( home_url() );
        // exit; ?>
        
        <script>
           // location.href = '<?php // echo home_url(); ?>/my-account/';
        </script>
        
	<?php if( ! ( function_exists('routiz') and Rz()->is_submission() ) ): ?>
		<?php get_template_part('templates/mobile/header'); ?>
		<?php get_template_part('templates/header'); ?>
	<?php endif; ?>
        
<?php }else if(get_the_author_meta('rz_role', $user->ID) == 'customer'){
    
        // echo'/customer';
        // $url = '/customer';
        // wp_redirect( home_url() );
        // exit; ?>

    <script>
       // location.href = '<?php // echo home_url(); ?>/user-account/';
    </script>
    
	<?php if( ! ( function_exists('routiz') and Rz()->is_submission() ) ): ?>
		<?php get_template_part('templates/header-customer'); ?>
	<?php endif; ?>
	
 <?php }else{  ?>
    
	<?php if( ! ( function_exists('routiz') and Rz()->is_submission() ) ): ?>
		<?php get_template_part('templates/mobile/header'); ?>
		<?php get_template_part('templates/header'); ?>
	<?php endif; ?>

 <?php }  ?>
