<?php 
$user = wp_get_current_user();
$user_id = get_current_user_id(); 
 

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
    'post_content' => $_POST['post_content'],
    
    'meta_input' => [
    'rz_listing_type' => '624',
    'rz_doctors-name' => sanitize_text_field($_POST['rz_doctors-name']),
    'rz_doctor-type' => sanitize_text_field($_POST['rz_doctor-type']),
    'rz_price' => sanitize_text_field($_POST['rz_price']),
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

if (!empty($_POST['rz_main_avatar_id'][0])) {
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  $id_attach = '['.json_encode(array('id'=>$_POST['rz_main_avatar_id'][0])).']';
  update_field('rz_avatar', $id_attach, $listingID);

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

/** Create HTML for show certificates */
add_action('show_certificates','update_certs');
function update_certs($cert){
  $user_id = get_current_user_id(); 
   $listingID = get_user_meta($user_id, 'behandlerID', true);

  foreach ($cert as $certif){ 
			foreach($certif as $cert_year=>$cert_name){
       
      $cert_html .= '
				<div class="tab-content_style__presentation-input">
					<div class="tab-content_style__presentation-input-content">
						<div class="tab-content_style__presentation-input-text">
							<span class="tab-content_style__presentation-input-name">'.$cert_name.'</span> <span class="tab-content_style__presentation-input-year">('.$cert_year.')</span>
						</div>

						<div class="tab-content_style__presentation-input-btn-group">
							<button type="button" class="tab-content_style__presentation-input-btn_edit" data-id="edit_certificate"   data-modal="modal_certificate">Edit</button>
							<button type="button" class="tab-content_style__presentation-input-btn_delete" data-id="delete_certificate">Delete</button>
						</div>
					</div>	
				</div>
        <div class="rz-preloader rz-preloader-full">
			    <i class="fas fa-sync"></i>
	    	</div>
        ';
        
			}
		}
    
    update_post_meta($listingID, 'rz_certificates',json_encode($cert));
    echo $cert_html;

   
};

/** Add certificate */
 if (!empty($_POST['ajax_certificate']) )  {
  
 $listingID = get_user_meta($user_id, 'behandlerID', true);
 $course_year = $_POST['rz_course_year'];
 $course_name = $_POST['rz_course_name'];
 

if (get_post_meta($listingID, 'rz_certificates')[0]){
  $cert = json_decode(get_post_meta($listingID, 'rz_certificates')[0],true);
  $cert_add[$course_year] = $course_name;
  array_push($cert,$cert_add);
} else {
  $cert_add[$course_year] = $course_name;
  $cert[] = $cert_add;
};

do_action ('show_certificates', $cert,$listingID);

die();
}

/**Delete certificate */
if (!empty($_POST['ajax_delete_certificate'])) {
    
 $listingID = get_user_meta($user_id, 'behandlerID', true);
 
$cert = json_decode(get_post_meta($listingID, 'rz_certificates')[0],true);
$sert_index_delete = $_POST['rz_course_index'];
unset($cert[$sert_index_delete]);
foreach ($cert as $cr){
  $cert_new[]=$cr;
} 
if (!empty($cert_new)){
  do_action ('show_certificates', $cert_new);
} 

die();
}

/**Edit certificate */
if (!empty($_POST['ajax_edit_certificate']) )  {
    
$listingID = get_user_meta($user_id, 'behandlerID', true);
$course_year = $_POST['rz_course_year'];
$course_name = $_POST['rz_course_name'];
$sert_index_edit = $_POST['rz_course_index'];

$cert = json_decode(get_post_meta($listingID, 'rz_certificates')[0],true);


$key = array_keys($cert[$sert_index_edit]);
$val = array_values($cert[$sert_index_edit]);
$key[0] = $course_year;
$val[0] = $course_name;

$cert[$sert_index_edit] = array_combine($key,$val);

do_action ('show_certificates', $cert);

die();
}

/** Switch certficate */

if(!empty($_POST['ajax_switch_certificate']) )  {

  $switch_cert = $_POST['switch_certificate'];
  $switch_user_certificate = $_POST['switch_user_certificate'];
  $switch_data = $_POST['switch_data'];
  
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID, $switch_cert, $switch_data);
  update_user_meta($user_id, $switch_user_certificate, $switch_data);

  die();
}

/** Student section */
if(!empty($_POST['student_section'])){
  $online_behandling = $_POST['tilbyderduonlinebooking'];
  $du_studerende = $_POST['erdustudende'];
  $skole = $_POST['hvilkenskole'];
  $skole_end = $_POST['hvornarer'];

  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID, 'rz_online_behandling', $online_behandling);
  update_post_meta($listingID, 'rz_du_studerende', $du_studerende);
  update_post_meta($listingID, 'rz_skole', $skole);
  update_post_meta($listingID, 'rz_skole_end', $skole_end);

}

/** Receive notifications */

if(!empty($_POST['ajax_receive_notif']) )  {

  $receive_data = $_POST['receive_data'];
  
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  update_post_meta($listingID, 'rz_receive_notif', $receive_data);


  die();
}

/** Add account gallery */

if (!empty($_POST['gallery_acc'])){
  $listingID = get_user_meta($user_id, 'behandlerID', true);
  $id_current = $_POST['rz_gallery_id_acc'][0];
  $id_new = $_POST['rz_gallery_acc'];
  preg_match("'^.(.*).'",$id_current,$gg);
  preg_match("'^.(.*).'",$id_new,$bb);

 $new_gal = "[".$gg[1].",".$bb[1]."]";

  update_field('rz_gallery', $new_gal, $listingID);
}

/**Listing Modal Content */

if (!empty($_POST['ajax_get_listing'])){
  $post = get_post($_POST['listing_id']);
  $postImgID = json_decode(get_post_meta($post->ID,'rz_gallery')[0])[0]->id;
  $imgUrl = wp_get_attachment_image_url($postImgID,'full',true);
  $listingModalHTML = '<div class="rz-preloader-full rz-absolute">
				<i class="fas fa-sync"></i>
		  </div>
    <a href="#" class="rz-close">
      <i class="fas fa-times"></i>
    </a>
    <div class="h-350 rz-relative">
        <img src="'.$imgUrl.'" alt="" class="rz-w-100 rz-h-100">
        <div class="rz-absolute rz-bottom-0 rz-right-0 rz-mr-1 rz-mb-1"">
          <a href="gallery"><button class="rz-button rz-button-border rz-small rz-bg-white">See alle fotos</button></a>
        </div>
    </div>
    <div class="rz-modal-content">
      <div class="rz-modal-container " id="listing_modal">
        <div class="rz-heading">
          <h4>'.$post->post_title.'</h4>
        </div>
        <div class="">'.
          $post->post_content.'
        </div>
    </div>';
  echo $listingModalHTML;      
}

/** Forward to location */
if( isset( $_POST['location'] ) && $location = $_POST['location'] ){
  wp_safe_redirect( $location);
  exit();
}
?>