<?php
/*
Template Name: Page Login
Template Post Type: page
*/ ?>
<?php get_header('registration'); ?>
<div class="contain-registration">
    <div class="registration-imag">
        <a href="#" id="'history-back" class="history-back" onClick="history.back()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.63342 11.4328L12.4881 3.74766C12.5561 3.68906 12.6428 3.65625 12.7342 3.65625H14.8084C14.9819 3.65625 15.0616 3.87187 14.9303 3.98438L6.72249 11.1094H20.4381C20.5412 11.1094 20.6256 11.1937 20.6256 11.2969V12.7031C20.6256 12.8062 20.5412 12.8906 20.4381 12.8906H6.72483L14.9326 20.0156C15.0639 20.1305 14.9842 20.3438 14.8108 20.3438H12.6662C12.6217 20.3438 12.5772 20.3273 12.5444 20.2969L3.63342 12.5672C3.55229 12.4966 3.48723 12.4095 3.44265 12.3116C3.39807 12.2138 3.375 12.1075 3.375 12C3.375 11.8925 3.39807 11.7862 3.44265 11.6884C3.48723 11.5905 3.55229 11.5034 3.63342 11.4328Z" fill="#CDC6CC"/>
            </svg>
            Tilbage
        </a>
    </div>
    <div class="registration-form">

        <div class="regis-top">
            <div class="regis-top-logo">
                <a href="<?php echo  get_home_url();?>">
                    <img src="/wp-content/themes/brikk-child/images/logo-dark.png" alt="img" width="225">
                </a>
            </div>
            <div class="regis-top-link">
                <a href="/registrer-gratis/">Registrer gratis</a>
            </div>
        </div>

        <div class="regis-for">
            <?php wc_get_template('myaccount/form-login.php'); ?>
        </div>

    </div>
</div>

<?php 
$user = wp_get_current_user();

    if (get_the_author_meta('rz_role', $user->ID) == 'business'){
        
        // echo'/business';
        // $url = '/business';
        // wp_redirect( home_url() );
        // exit;
        
        ?>
            <script>
                location.href = '<?php echo home_url(); ?>/my-account/';
            </script>
        
        <?php
     
    }else if(get_the_author_meta('rz_role', $user->ID) == 'customer'){
    
        // echo'/customer';
        // $url = '/customer';
        // wp_redirect( home_url() );
        // exit;
        
            ?>
            <script>
                location.href = '<?php echo home_url(); ?>/my-account/';
            </script>
        
        <?php
        
    }



if(0){
    // echo'/home';
    // $url = '/home';
    // wp_redirect( home_url() );
    // exit;
    
    
        ?>
        <script>
            location.href = '<?php echo home_url(); ?>/homeeeeeee';
        </script>
    
    <?php
}

// $current_user = wp_get_current_user();

// echo '<pre>';
// var_dump($current_user);
// echo '</pre>';

// if( $current_user->exists() ){
// 	echo ' on. <br />';
	
	
// 	echo 'Username: '         . $current_user->user_login     . '<br />';
// }
// else {
// 	echo 'Не авторизован.';
// }
?>
<?php get_footer('registration'); ?>
