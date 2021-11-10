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

                    <p class="regis-text">Udfyld felterne og opret din behandlerprofil her ff.</p>

                    <div class="u-column2 col-2">

                            <form method="post" action="/form_wizard_step/" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="in_first_name">Fornavn <span class="required">*</span></label>
                                    <input id="in_first_name" type="text" name="first_name" value="<?php echo esc_attr(get_the_author_meta('first_name', $user->ID)); ?>" class="regular-text"/>
                                </p>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="in_last_name">Efternavn <span class="required">*</span></label>
                                    <input id="in_last_name" type="text" name="last_name" value="<?php echo esc_attr(get_the_author_meta('last_name', $user->ID)); ?>" class="regular-text"/>
                                </p>

                            
                            
                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="nav_pa_clinik">Navn på klinik <span class="required">*</span></label>
                                    <input id="nav_pa_clinik" type="text" name="nav_pa_clinik" value="<?php echo esc_attr(get_the_author_meta('nav_pa_clinik', $user->ID)); ?>" class="regular-text"/>
                                    <input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
                                </p>
                            

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="gadenavn_og_nummer">Gadenavn og nummer</label>
                                    <input id="gadenavn_og_nummer" type="text" name="gadenavn_og_nummer" value="<?php echo esc_attr(get_the_author_meta('gadenavn_og_nummer', $user->ID)); ?>" class="regular-text"/>
                                </p>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="postnummer">Postnummer</label>
                                    <input id="postnummer" type="text" name="postnummer" value="<?php echo esc_attr(get_the_author_meta('postnummer', $user->ID)); ?>" class="regular-text"/>
                                </p>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="in_email">E-Mail <span class="required">*</span></label>
                                    <input id="in_email" type="text" name="email" value="<?php echo esc_attr(get_the_author_meta('email', $user->ID)); ?>" class="regular-text"/>
                                </p>
                                
                            

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="telephone">Telefon</label>
                                    <input id="telephone" type="text" name="telephone" value="<?php echo esc_attr(get_the_author_meta('telephone', $user->ID)); ?>" class="regular-text"/>
                                </p>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="cvr">CVR </label>
                                    <input id="cvr" type="text" name="cvr" value="<?php echo esc_attr(get_the_author_meta('cvr', $user->ID)); ?>" class="regular-text"/>
                                </p>
                            

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_password"><?php esc_html_e( 'Kodeord', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required />
                                </p>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_password2"><?php  _e( 'Gentag din adgangskode', 'woocommerce' ); ?> <span class="required">*</span></label>
                                    <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
                                </p>
                                
                                
                                
                                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide referencekode">
                                    <h4><label for="refkode">Referencekode </label></h4>
                                    <p>Hvis du har en henvisningskode, skal du indtaste den i nedenstående felt.</p>
                                    <input id="refkode" type="text" name="refkode" value="<?php echo esc_attr(get_the_author_meta('refkode', $user->ID)); ?>" class="regular-text"/>
                                </div>

                                <div class="terms">Når du klikker accepter og fortsæt, accepterer du automatisk vores <a href="#" class="">vilkår og betingelser</a></div>  

                               

                                <p class="woocommerce-form-row form-row">
                                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                    <button type="submit" class="woocommerce-Button woocommerce-button button  rz-button rz-button-accent rz-small" name="register-test" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Accepter og fortsæt', 'woocommerce' ); ?></button>
                                </p>

             

                            </form>

                    </div>
                     
                </div>

            </div>
        </div>

    </div>
</div>
<?php get_footer('registration'); ?>
