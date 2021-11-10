<?php get_header('registration'); 
global $client;
?>
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
        </div>

        <div class="regis-for">
            <div class="u-columns col2-set" id="customer_login">

                <div class="u-column1 col-1">

                    <h2><?php esc_html_e( 'Opret profil', 'woocommerce' ); ?></h2>

                    <p class="regis-text">Udfyld felterne og opret din behandlerprofil her.</p>

                    <?php 
                    $client = 'business';
                    include 'woocommerce/myaccount/form-register.php';
                    ?>
                     
                </div>

            </div>
        </div>

    </div>
</div>
<?php get_footer('registration'); ?>
