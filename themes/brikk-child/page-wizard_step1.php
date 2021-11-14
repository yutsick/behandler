<?php get_header('registration'); 

global $step;
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

                    <h2><?php esc_html_e( 'Hvilke behandlinger tilbyder du?', 'woocommerce' ); ?></h2>

                    <p class="regis-text">Her kan du enten vælge behandler fra vores liste, eller du kan tilføje dine egne i bunden af siden.</p>
                    <p class="regis-text">Du indstiller selv priserne og sessionernes varighed.</p>
                    <!-- Show autor's listings -->
                    <div class="rz-grid">
                        <?php 
                        
                            
                           $args = array(
								'post_type' => 'rz_listing',
								'author' => wp_get_current_user() -> ID,

								'meta_query' => [ [
									'key'	=>	'rz_listing_type',
									'value'	=>	'624',
								] ],
							
							);
							$query = new WP_Query( $args );
                            
                            if ( $query->have_posts() ) {
                                while ( $query->have_posts() ) {
                                    $query->the_post();
                                    $fields = get_post_custom();
                                ?>
                                <div class="rz-col-6 rz-col-sm-12 rz-mb-3">
                                    <div class="list_card">
                                        <h3>
                                            <?php the_title(); ?>
                                        </h3>
                                        <div class="rz-flex">
                                            <div class="price">
                                                Kr <?php 
                                                echo $fields['rz_price'][0];
                                                ?>
                                            </div>
                                            <span class=delimiter>|</span>
                                            <div class="time">
                                                <?php 
                                                $tt = json_decode($fields['rz_time_availability'][0]);
                                                echo ($tt[0]->{'fields'}->{'duration'}/60).' min';
                                                ?> 
                                            </div>
                                        </div>
                                        <div class="list_desc rz-mt-3">
                                            <?php echo $fields['post_content'][0]; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                
                                }
                                wp_reset_postdata();
                            } 

                        ?>
                    </div>
                    <!-- Include submission form -->
                    <?php include 'page-add-listing.php'?>
              
              

                    <form method="post" action="/form_wizard_step/" class="woocommerce-form woocommerce-form-register register" >
                        <input type="hidden" value="first" name="step">
                        <?php 
                        $step = 'first';
                        do_action("wizard_form", $step); ?>
                        
                        <p class="woocommerce-form-row form-row">
				            <?php wp_nonce_field(); ?>
                            <button type="submit" class="woocommerce-Button woocommerce-button button  rz-button rz-button-accent rz-small" name="register_step1" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Accepter og fortsæt', 'woocommerce' ); ?></button>
			            </p>
                        

                    </form>
                    <?php 
                    ?>
                     
                </div>

            </div>
        </div>

    </div>
</div>
<?php get_footer('registration'); ?>
