<?php
/*
Template Name: Page Registration User
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
                <a href="/login/">Log ind</a>
            </div>
        </div>

        <div class="regis-for">
            <div class="u-columns col2-set" id="customer_login">

                <div class="u-column1 col-1">

                    <h2><?php esc_html_e( 'Registrering', 'woocommerce' ); ?></h2>

                    <p class="regis-text">Søger eller tilbyder du behandling?</p>

                    <a href="/registration-user-in/" class="rz-button-accent w-100">
                        Opret bruger
                    </a>

                </div>

                <div class="eller_title">
                    Eller
                </div>

                <div class="eller_list">
                    <div class="eller_button eller_facebook">
                        <a href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.4604 0H3.53787C1.59204 0 0 1.59204 0 3.53787V20.4621C0 22.408 1.59204 24 3.53787 24H20.4621C22.408 24 24 22.408 24 20.4621V3.53787C23.9982 1.59204 22.408 0 20.4604 0ZM20.2331 12.8097H17.3851V23.1138H13.1237V12.8097H10.9921V9.25771H13.1237V7.12615C13.1237 4.22863 14.3266 2.50481 17.7495 2.50481H20.5948V6.05594H18.8153C17.485 6.05594 17.3966 6.5539 17.3966 7.47993L17.3851 9.25771H20.609L20.2322 12.8097H20.2331Z" fill="#395185"/>
                            </svg>
                            Log ind med Facebook
                        </a>
                    </div>
                    <div class="eller_button eller_google">
                        <a href="#">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.8055 10.0415H21V10H12V14H17.6515C16.827 16.3285 14.6115 18 12 18C8.6865 18 6 15.3135 6 12C6 8.6865 8.6865 6 12 6C13.5295 6 14.921 6.577 15.9805 7.5195L18.809 4.691C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12C2 17.5225 6.4775 22 12 22C17.5225 22 22 17.5225 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z" fill="#FFC107"/>
                                <path d="M3.15234 7.3455L6.43784 9.755C7.32684 7.554 9.47984 6 11.9993 6C13.5288 6 14.9203 6.577 15.9798 7.5195L18.8083 4.691C17.0223 3.0265 14.6333 2 11.9993 2C8.15834 2 4.82734 4.1685 3.15234 7.3455Z" fill="#FF3D00"/>
                                <path d="M12.0002 22C14.5832 22 16.9302 21.0115 18.7047 19.404L15.6097 16.785C14.5719 17.5742 13.3039 18.001 12.0002 18C9.39916 18 7.19066 16.3415 6.35866 14.027L3.09766 16.5395C4.75266 19.778 8.11366 22 12.0002 22Z" fill="#4CAF50"/>
                                <path d="M21.8055 10.0415H21V10H12V14H17.6515C17.2571 15.1082 16.5467 16.0766 15.608 16.7855L15.6095 16.7845L18.7045 19.4035C18.4855 19.6025 22 17 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z" fill="#1976D2"/>
                            </svg>
                            Log ind med Google
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<?php get_footer('registration'); ?>
