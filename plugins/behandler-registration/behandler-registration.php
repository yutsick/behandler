<?php
/*
  Plugin Name: Behandler Registration
  Plugin URI: https://betasprint.com
  Description: Custom registration form for the Behandler.net website.
  Version: 1.0
  Author: Betasprint 
  Author URI: https://betasprint.com
 */

add_action('show_user_profile', 'add_extra_social_links2');
add_action('edit_user_profile', 'add_extra_social_links2');
function add_extra_social_links2($user)
{
    ?>
    <h3>Yderligere brugerdata</h3>

    <table class="form-table">
        

        <?php 
            if (get_the_author_meta('rz_role', $user->ID) == 'business'){
         
        ?>

        <!-- <tr>
            <th><label for="facebook_profile">Gadenavn og nummer</label></th>
            <td><input type="text" name="gadenavn_og_nummer" value="<?php echo esc_attr(get_the_author_meta('gadenavn_og_nummer', $user->ID)); ?>" class="regular-text"/></td>
        </tr> -->

        <!-- <tr>
            <th><label for="twitter_profile">Postnummer</label></th>
            <td><input type="text" name="postnummer" value="<?php echo esc_attr(get_the_author_meta('postnummer', $user->ID)); ?>" class="regular-text"/></td>
        </tr> -->

        <tr>
            <th><label for="google_profile">Google+ Profile</label></th>
            <td><input type="text" name="google_profile" value="<?php echo esc_attr(get_the_author_meta('google_profile', $user->ID)); ?>" class="regular-text"/></td>
        </tr>

        <tr>
            <th><label for="nav_pa_clinik">Navn på klinik</label></th>
            <td><input type="text" name="nav_pa_clinik" value="<?php echo esc_attr(get_the_author_meta('nav_pa_clinik', $user->ID)); ?>" class="regular-text"/></td>
        </tr>

        <tr>
            <th><label for="telephone">Telefon</label></th>
            <td><input type="text" name="telephone" value="<?php echo esc_attr(get_the_author_meta('telephone', $user->ID)); ?>" class="regular-text"/></td>
        </tr>

        <tr>
            <th><label for="refkode">Referencekode</label></th>
            <td><input type="text" name="refkode" value="<?php echo esc_attr(get_the_author_meta('refkode', $user->ID)); ?>" class="regular-text"/></td>
        </tr>

        <tr>
            <th><label for="behandlerID">Behandler Listing ID</label></th>
            <td><input type="text" name="behandlerID" value="<?php echo esc_attr(get_the_author_meta('behandlerID', $user->ID)); ?>" class="regular-text" disabled/></td>
        </tr>
          
    </table>
    <h3>Andre</h3>
    <table class="form-table">
        <tr>
            <th><label for="time">Hvor lang tid forinden kan man maskimalt booke tid?</label></th>
            <td><input type="text" name="time" value="<?php echo esc_attr(get_the_author_meta('time', $user->ID)); ?>" class="regular-text"/></td>
        </tr>
        <tr>
            <th><label for="rab">Er du RAB Godkendt?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="rab" value="<?php echo esc_attr(get_the_author_meta('rab', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
        <tr>
            <th><label for="sygesikring">Er du medlem af Sygesikring Danmark?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="sygesikring" value="<?php echo esc_attr(get_the_author_meta('sygesikring', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
        <tr>
            <th><label for="online_behandling">Tilbyder do online behandling?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="online_behandling" value="<?php echo esc_attr(get_the_author_meta('online_behandling', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
        <tr>
            <th><label for="alternativ_behandler">Er du ved at uddanne dig til alternativ behandler?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="alternativ_behandler" value="<?php echo esc_attr(get_the_author_meta('alternativ_behandler', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
    </table>
    <!-- Script for make checkboxes checked-->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
          
        var i = 0;
        var ch_box = document.querySelectorAll('.andre-checkbox');
        
         for (i = 0; i <= ch_box.length; i++){
            if (ch_box[i].getAttribute('value') == '1'){
                ch_box[i].setAttribute('checked', 'checked');
            }
         } 
         });
    </script>
    <?php  
            }
}

add_action('register_form','custom_add_action');
function custom_add_action($client){
    if ($client){
        add_extra_social_links($user, $client);
    } else {
        register_error_message($user);
        }
}

function register_error_message($user){?>
    <p><?php esc_html_e( 'There is some error during registration. Call the administrstor', 'brikk' ); ?></p>
<?php
}

add_action('woocommerce_register_form', 'add_extra_social_links_test');

function add_extra_social_links($user, $client)
{
   
    ?>
    <div class="rz-form-group rz-field rz-col-12" data-multiple="true" data-upload-type="image" data-type="upload" data-storage="request" data-disabled="no" data-heading="Upload gallery" data-id="gallery">
        <div class="rz-upload">
            <!-- button -->
            <label for="rz-upload-rz_gallery" class="rz-flex">
                    <div class="add-listing">
                        <div class="add-listing-inner">
                            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri();?>/images/camera.png" alt=""></div>
                            <p>Klik for at tilføje foto</p>
                            
                        </div>
                    </div>
                    
            </label>
            <!-- input -->
            <textarea class="rz-upload-input rz-none" type="text" name="rz_photo_main" placeholder=""></textarea>
            <input type="hidden" name="rz_gallery_id[]" value="" id="rz_gallery_id">
            <!-- file -->
            <div class="rz-none">
                <input class="rz-upload-file" type="file" id="rz-upload-rz_gallery" multiple="false">
            </div>

            <!-- field info -->
            <div class="rz-field-info rz-relative">
                <span>Maximum upload file size: 50 MB.</span>
                
                <div class="rz-preloader">
                        <i class="fas fa-sync"></i>
                </div>
            </div>
            

            <!-- image preview -->
            <div class="rz-image-preview rz-no-select">
            </div>
            
            <!-- error output -->
            <div class="rz-error-output"></div>

        </div>
    </div>

<!--      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_test">business <span class="required">*</span></label>
        <input id="in_test" type="text" name="test" value="<?php //echo esc_attr(get_user_meta('rz_role', $user->ID)); ?>" class="regular-text"/>
    </p> --> 
   
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_first_name">Fornavn <span class="required">*</span></label>
        <input id="in_first_name" type="text" name="first_name" value="<?php echo esc_attr(get_the_author_meta('first_name', $user->ID)); ?>" class="regular-text"/>
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_last_name">Efternavn <span class="required">*</span></label>
        <input id="in_last_name" type="text" name="last_name" value="<?php echo esc_attr(get_the_author_meta('last_name', $user->ID)); ?>" class="regular-text"/>
    </p>

    <?php 
    if ($client == 'business'){ ?>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="nav_pa_clinik">Navn på klinik <span class="required">*</span></label>
        <input id="nav_pa_clinik" type="text" name="nav_pa_clinik" value="<?php echo esc_attr(get_the_author_meta('nav_pa_clinik', $user->ID)); ?>" class="regular-text"/>
        <input type="hidden" id="client" name="client" value="<?php echo $client; ?>">
        <input type="hidden" id="location" name="location" value="/wizard_step1/">
    </p>
    <?php } else {
        if ($client == 'client'){ ?>
            <input type="hidden" id="location" name="location" value="/my-account/">
    <?php }
    }
    ?>

    <!-- <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="gadenavn_og_nummer1">Gadenavn og nummer</label>
        <input id="gadenavn_og_nummer1" type="text" name="gadenavn_og_nummer1" value="<?php echo esc_attr(get_the_author_meta('gadenavn_og_nummer', $user->ID)); ?>" class="regular-text"/>
    </p> -->


    <div class="rz-form-group rz-field rz-col-12" data-type="map" data-storage="request" data-disabled="no" data-heading="Location" data-id="location">
                  

                        <div class="rz-location">
                            <div class="rz-grid">

                                
                                <div class="rz-form-group rz-col-12 rz-col-md-12 rz-mb-4">
                                    <label class="rz-block rz-mb-2">Address</label>
                                    <input type="text" class="rz-map-address" name="rz_location[]" value="Copenhagen, Denmark" placeholder="e.g. Copenhagen">
                                </div>
                                <!-- <div class="rz-form-group rz-col-12 rz-col-md-12 rz-mb-4">
                                    <label class="rz-block rz-mb-2">Address</label>
                                    <input type="text" class="rz-map-address" name="gadenavn_og_nummer[]" value="Copenhagen, Denmark" placeholder="e.g. Copenhagen"> 
                                     <input type="text" class="rz-map-address" name="rz_location"  placeholder="e.g. Copenhagen"> 
                                
                                </div> -->
                                <div class="rz-form-group rz-col-6 rz-col-md-12 rz-mb-4 rz-none">
                                    <label class="rz-block rz-mb-2">Latitude</label>
                                    <input type="text" value="41.38506389999999" disabled>
                                    <input type="hidden" class="rz-map-lat" name="rz_location[]" value="55.676098">
                                </div>
                                <div class="rz-form-group rz-col-6 rz-col-md-12 rz-mb-4 rz-none">
                                    <label class="rz-block rz-mb-2">Longitude</label>
                                    <input type="text" value="2.1734034999999494" disabled>
                                    <input type="hidden" class="rz-map-lng" name="rz_location[]" value="12.568337">
                                </div>

                                <!-- geo information -->
                                <div class="rz-none">
                                    <input type="text" class="rz-map-country" name="rz_location[]" value="">
                                    <input type="text" class="rz-map-city" name="rz_location[]" value="">
                                    <input type="text" class="rz-map-city-alt" name="rz_location[]" value="">
                                </div>

                            </div>
                            <div class="rz-map"></div>
                        </div>
                    </div>


    <!-- <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="postnummer">Postnummer</label>
        <input id="postnummer" type="text" name="postnummer" value="<?php echo esc_attr(get_the_author_meta('postnummer', $user->ID)); ?>" class="regular-text"/>
    </p> -->

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_email">E-Mail <span class="required">*</span></label>
        <input id="in_email" type="text" name="email" value="<?php echo esc_attr(get_the_author_meta('email', $user->ID)); ?>" class="regular-text"/>
    </p>
    
    <?php
    if ($client == 'business'){ ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="telephone">Telefon</label>
        <input id="telephone" type="text" name="telephone" value="<?php echo esc_attr(get_the_author_meta('telephone', $user->ID)); ?>" class="regular-text"/>
    </p>

    <?php } ?>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_password"><?php esc_html_e( 'Kodeord', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required />
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_password2"><?php  _e( 'Gentag din adgangskode', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
    </p>
    
    <?php 
    if ($client == 'business'){ ?>
    <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide referencekode">
        <h4><label for="refkode">Referencekode </label></h4>
        <p>Hvis du har en henvisningskode, skal du indtaste den i nedenstående felt.</p>
        <input id="refkode" type="text" name="refkode" value="<?php echo esc_attr(get_the_author_meta('refkode', $user->ID)); ?>" class="regular-text"/>
    </div>
<?php
    } ?>
    <div class="terms">Når du klikker accepter og fortsæt, accepterer du automatisk vores <a href="#" class="">vilkår og betingelser</a></div>  
<?php }


add_action('wizard_form','wizard_steps');
function wizard_steps($step){
    if ($step == 'first'){
        wizard_step_first($user);
    }
    elseif ($step == 'second'){
        wizard_step_second($user);
    }
    else{
        echo ('None to display');
    }
}

function wizard_step_first($user){ ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <th><label for="time">Hvor lang tid forinden kan man maskimalt booke tid?</label></th>
        <td><select name="time" id="" value="<?php echo esc_attr(get_the_author_meta('time', $user->ID)); ?>" class="regular-text">
            <option value="Ingen forberedelsestid">Ingen forberedelsestid</option>
            <option value="15 minutter">15 minutter</option>
            <option value="30 minutter">30 minutter</option>
            <option value="1 time">1 time</option>
            <option value="1 time">2 timer</option>
            <option value="1 døgn">1 døgn</option>
        </select></td>
        <!-- <td><input type="text" name="time" value="<?php echo esc_attr(get_the_author_meta('time', $user->ID)); ?>" class="regular-text"/></td> -->
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide toggle">
        <label for="rab" class="switch">
            Er du RAB Godkendt?
            <input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="rab" id="rab" value="<?php echo esc_attr(get_the_author_meta('rab', $user->ID)); ?>" class="regular-text"/>
            <span class="slider round"></span>
        </label>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide toggle">
        <label for="sygesikring" class="switch">
            Er du medlem af Sygesikring Danmark?
            <input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="sygesikring" id="sygesikring" value="<?php echo esc_attr(get_the_author_meta('sygesikring', $user->ID)); ?>" class="regular-text"/>
            <span class="slider round"></span>
        </label>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide toggle">
        <label for="online_behandling" class="switch">
            Tilbyder do online behandling?
            <input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="online_behandling" id="online_behandling" value="<?php echo esc_attr(get_the_author_meta('online_behandling', $user->ID)); ?>" class="regular-text"/>
            <span class="slider round"></span>
        </label>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide toggle rz-mb-5">
        <label for="alternativ_behandler" class="switch">
            Er du ved at uddanne dig til alternativ behandler?
            <input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="alternativ_behandler" id="alternativ_behandler" value="<?php echo esc_attr(get_the_author_meta('alternativ_behandler', $user->ID)); ?>" class="regular-text"/>
            <span class="slider round"></span>
        </label>
    </p>
    <input type="hidden" id="location" name="location" value="/wizard_step2/">
    <script>
         
         $(".andre-checkbox" ).each(function( i ) {
            $(this).attr('value') == '1'? $(this).prop('checked', true): $(this).prop('checked', false);
         }
    </script>
<?php
}

function wizard_step_second(){?>
    <input type="hidden" id="location" name="location" value="/wizard_plan/">

<?php
}

// Добавьте код ниже в файл functions.php вашей темы для добавления поля подтверждения пароля в форме регистрации на странице Мой профиль.
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
    global $woocommerce;
    extract( $_POST );

    if ( strcmp( $password, $password2 ) !== 0 ) {
        return new WP_Error( 'registration-error', __( 'Adgangskodefejl.', 'woocommerce' ) );
    }
    return $reg_errors;
}



add_action('user_register', 'save_extra_social_links');
add_action('personal_options_update', 'save_extra_social_links');
add_action('edit_user_profile_update', 'save_extra_social_links');
add_action('user_register', 'user_Autoregister' );


function user_Autoregister($user_id){
    if ((!is_user_logged_in() && $_POST['client'] == 'business')){
        wp_set_auth_cookie( $user_id );
        $user_test = $user_id;

        do_action ('additional',$user_id);
    }
    if( isset( $_POST['location'] ) && $location = $_POST['location'] ){
        wp_safe_redirect( $location );
        exit();
    }
}

function save_extra_social_links($user_id)
{
    
    
    update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    update_user_meta($user_id, 'email', sanitize_text_field($_POST['email']));
    // update doctor's fields 
        update_user_meta($user_id, 'rz_role', sanitize_text_field($_POST['client']));
        update_user_meta($user_id, 'nav_pa_clinik', sanitize_text_field($_POST['nav_pa_clinik']));
        update_user_meta($user_id, 'telephone', sanitize_text_field($_POST['telephone']));
        update_user_meta($user_id, 'refkode', sanitize_text_field($_POST['refkode']));
        update_user_meta($user_id, 'time', sanitize_text_field($_POST['time']));
        update_user_meta($user_id, 'rab', sanitize_text_field($_POST['rab']));
        update_user_meta($user_id, 'sygesikring', sanitize_text_field($_POST['sygesikring']));
        update_user_meta($user_id, 'online_behandling', sanitize_text_field($_POST['online_behandling']));
        update_user_meta($user_id, 'alternativ_behandler', sanitize_text_field($_POST['alternativ_behandler']));
    // update doctor's fields 
    // update_user_meta($user_id, 'gadenavn_og_nummer', sanitize_text_field($_POST['gadenavn_og_nummer']));
    // update_user_meta($user_id, 'postnummer', sanitize_text_field($_POST['postnummer']));
    
    }

add_action('additional', 'add_doctorListing' );
    
function add_doctorListing($user_id){
     $listing_postarr = array(
    'post_type' => 'rz_listing',
    'post_title' => sanitize_text_field($_POST['first_name'])." ".sanitize_text_field($_POST['last_name']),
    'post_author' => $user_id,
    'meta_input' => [
        'rz_listing_type'   => '3440',
        'rz_full_name'      => sanitize_text_field($_POST['first_name'])." ".sanitize_text_field($_POST['last_name']),
        'rz_fornavn'        => sanitize_text_field($_POST['first_name']),
        'rz_efternavn'      => sanitize_text_field($_POST['last_name']),
        'rz_nav_pa_clinik'  => sanitize_text_field($_POST['nav_pa_clinik']),
        // 'rz_postnummer'     => sanitize_text_field($_POST['postnummer']),
        'rz_email'          => sanitize_text_field($_POST['email']),
        'rz_telefon'        => sanitize_text_field($_POST['telephone']),
        'rz_referencekode'  => sanitize_text_field($_POST['refkode']),
        ], 
    'post_status' => 'publish',
    );
    
    $my_behandler_id = wp_insert_post( $listing_postarr );
    update_user_meta($user_id, 'behandlerID', $my_behandler_id);

   $loc = $_POST['rz_location'];
    foreach ($loc as $key => $value){
        add_post_meta($my_behandler_id,'rz_location',$value);
     }

    update_field('rz_photo_main', $_POST['rz_photo_main'], $my_behandler_id);
    update_field('rz_gallery', $_POST['rz_photo_main'], $my_behandler_id);


}

