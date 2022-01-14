<div class="tab-content_style-cards rz-mb-3">

  <?php   

    $image_ID = json_decode(get_post_meta($listingID,'rz_gallery')[0]);

    if ($image_ID){
      foreach ($image_ID as $imgID){ ?>
        <?php 
          $imgUrl = wp_get_attachment_image_url($imgID->id,'medium',true);
        ?>
        <div class="tab-content_style-cards__item">
          <img src="<?php echo $imgUrl; ?>" alt="" class="rz-w-100">
        </div> 
    <?php	
      }
    }  
  ?>

  <div class="tab-content_style-cards__item">
    <div class=" rz-field " data-multiple="true" data-upload-type="image" data-type="upload" data-storage="request" data-disabled="no" data-heading="Upload gallery" data-id="gallery_acc">
      <div class="rz-upload rz-h-100">
              <!-- button -->
          <label for="rz-upload-rz_gallery_acc" class="">
                  <div class="add-listing rz-h-100">
                      <div class="add-listing-inner">
                          <div class="icon"><img src="<?php echo get_stylesheet_directory_uri();?>/images/camera.png" alt=""></div>
                          <p>Klik for at tilføje foto</p>
                          
                      </div>
                  </div>
          </label>
          <!-- input -->
            <textarea class="rz-upload-input rz-none" type="text" name="rz_gallery_acc" placeholder=""></textarea>
            <input type="hidden" name="rz_gallery_id_acc[]" value='<?php print_r(get_post_meta($listingID,"rz_gallery")[0]); ?>' id="rz_gallery_id_acc">
            <!-- file -->
            <div class="rz-none">
                <input class="rz-upload-file" type="file" id="rz-upload-rz_gallery_acc" multiple="true">
            </div>

            <!-- field info -->
            <div class="rz-field-info rz-relative">
              <span>Maximum upload file size: 50 MB.</span>
              
              <div class="rz-preloader">
                      <i class="fas fa-sync"></i>
              </div>
            </div>
            

            <!-- image preview -->
            <div class="rz-image-preview rz-no-select" id="galleri_acc_photo">
            </div>
            
            <!-- error output -->
            <div class="rz-error-output"></div>

        </div>
      </div>
    </div>
    		
  </div>
  <div class="text-center">
  	<button type="submit" class="rz-button rz-button-accent rz-mt-5" name="" value="<?php esc_attr_e( 'Gem indstillinger', 'woocommerce' ); ?>"><?php esc_html_e( 'Gem indstillinger', 'woocommerce' ); ?></button>
    </div>
</div>