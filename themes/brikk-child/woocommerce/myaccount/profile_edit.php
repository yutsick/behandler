<?php 
$all_user_meta = array_map(
	function( $a ){
		return $a[0];
	},
	get_user_meta( get_current_user_id() )
);

?>
<div class="rz-form-group rz-field rz-col-12" data-multiple="false" data-upload-type="image" data-type="upload" data-storage="request" data-disabled="no" data-heading="Upload avatar" data-id="avatar">
  <div class="rz-upload">
    <!-- button -->
    <label for="rz-upload-rz_avatar" class="rz-flex">
        <div class="tab-content_style__edit-avatar"> 
          <?php 
          
          $image_ID = json_decode(get_post_meta($listingID,'rz_avatar')[0]);
          $avatarUrl = wp_get_attachment_image_url($image_ID[0]->id,'medium',true);
          ?> 	  
			    <img class="tab-content_style__current-avatar-img" src="<?php echo $avatarUrl; ?>">
		    </div>       
      </label>
            <!-- input -->
            <textarea class="rz-upload-input rz-none" type="text" name="rz_avatar_main" placeholder=""></textarea>
            <input type="hidden" name="rz_main_avatar_id[]" value="" id="rz_main_avatar_id">
            <!-- file -->
            <div class="rz-none">
                <input class="rz-upload-file" type="file" id="rz-upload-rz_avatar" multiple="false">
            </div>

            <!-- field info -->
            <div class="rz-field-info rz-relative">
                <span>Maximum upload file size: 50 MB.</span>
                
                <div class="rz-preloader">
                        <i class="fas fa-sync"></i>
                </div>
            </div>
            

            <!-- image preview -->
            <div class="rz-image-preview rz-no-select" id="avatar_photo">
            </div>
            
            <!-- error output -->
            <div class="rz-error-output"></div>

        </div>
    </div>
   
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_first_name">Fornavn <span class="required">*</span></label>
        <input id="in_first_name" type="text" name="first_name" value="<?php echo $all_user_meta['first_name']; ?>" class="regular-text"/>
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_last_name">Efternavn <span class="required">*</span></label>
        <input id="in_last_name" type="text" name="last_name" value="<?php echo $all_user_meta['last_name']; ?>" class="regular-text"/>
    </p>
    <?php $loc = get_post_meta($listingID,'rz_location')?>
    <div class="rz-form-group rz-field " data-type="map" data-storage="request" data-disabled="no" data-heading="Location" data-id="location">
      <div class="rz-location">
          <div class="rz-grid">
              <div class="rz-form-group rz-col-12 rz-col-md-12 rz-mb-4">
                <div class="form-row">
                    <label for="location" class="rz-block rz-mb-2">Address<span class="required">*</span></label>
                    <input type="text" id="location" class="rz-map-address" name="rz_location[]" value="<?php echo $loc[0]; ?>" placeholder="e.g. Copenhagen">
                  </div>
              </div>
          
              <div class="rz-form-group rz-col-6 rz-col-md-12 rz-mb-4 rz-none">
                  <label class="rz-block rz-mb-2">Latitude</label>
                  <input type="text" value="41.38506389999999" disabled>
                  <input type="hidden" class="rz-map-lat" name="rz_location[]" value="<?php echo $loc[1]; ?>">
              </div>
              <div class="rz-form-group rz-col-6 rz-col-md-12 rz-mb-4 rz-none">
                  <label class="rz-block rz-mb-2">Longitude</label>
                  <input type="text" value="2.1734034999999494" disabled>
                  <input type="hidden" class="rz-map-lng" name="rz_location[]" value="<?php echo $loc[2]; ?>">
              </div>

              <!-- geo information -->
              <div class="rz-none">
                  <input type="text" class="rz-map-country" name="rz_location[]" value="<?php echo $loc[3]; ?>">
                  <input type="text" class="rz-map-city" name="rz_location[]" value="<?php echo $loc[4]; ?>">
                  <input type="text" class="rz-map-city-alt" name="rz_location[]" value="<?php echo $loc[5]; ?>">
              </div>

          </div>
          <div class="rz-map"></div>
      </div>
  </div>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="in_email">E-Mail <span class="required">*</span></label>
        <input id="in_email" type="text" name="email" value="<?php echo $all_user_meta['email']; ?>" class="regular-text"/>
    </p>
    

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="telephone">Telefon</label>
        <input id="telephone" type="text" name="telephone" value="<?php echo $all_user_meta['telephone']; ?>" class="regular-text"/>
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="site_url">Internet side</label>
        <input id="site_url" type="text" name="site_url" value="<?php echo wp_get_current_user()->data->user_url; ?>" class="regular-text"/>
    </p>
  

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_password"><?php esc_html_e( 'Kodeord', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="reg_password2"><?php  _e( 'Kodeord igen*', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" />
    </p>
    
