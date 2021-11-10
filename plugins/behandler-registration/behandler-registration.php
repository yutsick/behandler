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
        


        <tr>
            <th><label for="facebook_profile">Gadenavn og nummer</label></th>
            <td><input type="text" name="gadenavn_og_nummer" value="<?php echo esc_attr(get_the_author_meta('gadenavn_og_nummer', $user->ID)); ?>" class="regular-text"/></td>
        </tr>

        <tr>
            <th><label for="twitter_profile">Postnummer</label></th>
            <td><input type="text" name="postnummer" value="<?php echo esc_attr(get_the_author_meta('postnummer', $user->ID)); ?>" class="regular-text"/></td>
        </tr>

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
            <th><label for="rab">Er du medlem af Sygesikring Danmark?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="sygesikring" value="<?php echo esc_attr(get_the_author_meta('sygesikring', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
        <tr>
            <th><label for="rab">Tilbyder do online behandling?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="online_behandling" value="<?php echo esc_attr(get_the_author_meta('online_behandling', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
        <tr>
            <th><label for="rab">Er du ved at uddanne dig til alternativ behandler?</label></th>
            <td><input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="alternativ_behandler" value="<?php echo esc_attr(get_the_author_meta('alternativ_behandler', $user->ID)); ?>" class="regular-text andre-checkbox"/></td>
        </tr>
    </table>
    <!-- Script for make chrckboxes checked-->
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
        <td><input type="text" name="time" value="<?php echo esc_attr(get_the_author_meta('time', $user->ID)); ?>" class="regular-text"/></td>
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

//add_action('personal_options_update', '____action_function_name' );
//add_action('edit_user_profile_update', '____action_function_name' );
add_action('user_register', 'save_extra_social_links');
add_action('personal_options_update', 'save_extra_social_links');
add_action('edit_user_profile_update', 'save_extra_social_links');
add_action('user_register', 'test' );

function test($user_id){
    if ((!is_user_logged_in() && $_POST['client'] == 'business')){
        wp_set_auth_cookie( $user_id );
        $user_test = $user_id;
       
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
    update_user_meta($user_id, 'gadenavn_og_nummer', sanitize_text_field($_POST['gadenavn_og_nummer']));
    update_user_meta($user_id, 'postnummer', sanitize_text_field($_POST['postnummer']));

    }
    


