<?php 
$user = wp_get_current_user();
$user_id = get_current_user_id(); 
//echo $_POST['rz_course_year'].':'.$_POST['rz_course_name'];
// print_r($_POST);
/*Second wizard step*/

if ($_POST['step'] == 'first'){
  
    update_user_meta($user_id, 'time', sanitize_text_field($_POST['time']));
    update_user_meta($user_id, 'rab', sanitize_text_field($_POST['rab']));
    update_user_meta($user_id, 'sygesikring', sanitize_text_field($_POST['sygesikring']));
    update_user_meta($user_id, 'online_behandling', sanitize_text_field($_POST['online_behandling']));
    update_user_meta($user_id, 'alternativ_behandler', sanitize_text_field($_POST['alternativ_behandler']));
}


/*Second wizard step*/

if ($_POST['step'] == 'second'){
  $post_id = 'user_'.$current_user->ID;
  $id_attach = explode(",", $_POST['rz_gallery_id'][0]);
  update_field('gallery', $id_attach, $post_id);

}


/* Add listing*/

if(!empty ($_POST['recurring_availability'])){
    $rec_str = '["';
    foreach ($_POST['recurring_availability'] as $rec){
        $rec_str .= $rec.'","';
    }
    $rec_str .= '"]';
}

if (!empty($_POST['add_post'])) {
    
    $rz_time_availability = '[{"template":{"id":"period","name":"Period","heading":"name","heading_text":"Custom Period"},"fields":{"name":"Custom Period","key":"custom-period","start_time":"'.$_POST["start_time"].'","end_time":"'.$_POST["end_time"].'","duration":"'.$_POST["duration"].'","custom_duration_length":"","custom_duration_entity":"60","interval":"'.$_POST["interval"].'","custom_interval_length":"","custom_interval_entity":"60","recurring":"1","start":"","end":"","recurring_availability":'.$rec_str.',"price":"","price_weekend":"","limit":""}}]';
    $rz_price_seasonal = '[{"template":{"id":"period","name":"Period","heading":"start","heading_text":"Discount"},"fields":{"start":"'.$_POST["start_discount"].'","end":"'.$_POST["end_discount"].'","price":"'.$_POST["price_discount"].'","price_weekend":""}}]';

    $listing_postarr = array(
    'post_type' => 'rz_listing',
    'post_title' => sanitize_text_field($_POST['rz_doctors-name']),
    
    'meta_input' => [
    'rz_listing_type' => '624',
    'rz_doctors-name' => sanitize_text_field($_POST['rz_doctors-name']),
    'rz_doctor-type' => sanitize_text_field($_POST['rz_doctor-type']),
    'rz_price' => sanitize_text_field($_POST['rz_price']),
    'post_content' => sanitize_text_field($_POST['post_content']),
    'rz_instant' => '1',
    ], 
    'post_status' => 'publish',
    );

    $my_post_id = wp_insert_post( $listing_postarr );

    update_post_meta ($my_post_id, 'rz_time_availability',$rz_time_availability);
    update_post_meta ($my_post_id, 'rz_price_seasonal',$rz_price_seasonal);
    update_field('rz_gallery', $_POST['rz_gallery'], $my_post_id);
}
global $register;
$register = true;




/** Edit account */

if (!empty($_POST['save_time'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_time',sanitize_text_field($_POST['time']));
  update_user_meta($user_id, 'time', sanitize_text_field($_POST['time']));
}

if (!empty($_POST['save_about'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_about',sanitize_text_field($_POST['about']));

}

if (!empty($_POST['rz_main_photo_id'][0])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  $id_attach = '['.json_encode(array('id'=>$_POST['rz_main_photo_id'][0])).']';
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_avatar',$id_attach);

}

if (!empty($_POST['first_name'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_fornavn',sanitize_text_field($_POST['first_name']));
  update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
}

if (!empty($_POST['last_name'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_efternavn',sanitize_text_field($_POST['last_name']));
  update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
}

// location

if (!empty($_POST['rz_location'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  delete_post_meta( $listingID, 'rz_location');
   $loc = $_POST['rz_location'];
    foreach ($loc as $key => $value){
        add_post_meta($listingID,'rz_location',$value);
     }
}
// end location

if (!empty($_POST['email'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_email',sanitize_text_field($_POST['email']));
  update_user_meta($user_id, 'email', sanitize_text_field($_POST['email']));
}

if (!empty($_POST['telephone'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID,'rz_telephone',sanitize_text_field($_POST['telephone']));
  update_user_meta($user_id, 'telephone', sanitize_text_field($_POST['telephone']));
}

if (!empty($_POST['site_url'])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);

  update_post_meta($listingID,'rz_site_url',$_POST['site_url']);
  $user->data->user_url = $_POST['site_url'];
  wp_update_user($user);
}

if( !empty( $_POST['password']) && ($_POST['password'] == $_POST['password2'])){
  $new_pass = trim( wp_unslash( $_POST['password'] ) );
  wp_set_password ($new_pass,$user_id);
}

/** Add certificate */
if (!empty($_POST['ajax_certificate'])) {
echo $_POST['rz_course_year'].':'.$_POST['rz_course_name'];
//die;
}


if( isset( $_POST['location'] ) && $location = $_POST['location'] ){
  wp_safe_redirect( $location);
  exit();
}
?>