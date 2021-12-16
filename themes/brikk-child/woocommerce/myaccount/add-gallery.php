<div class="tab-content_style-cards rz-mb-3">

  <?php   

    $image_ID = json_decode(get_post_meta($listingID,'rz_gallery')[0]);
    //$avatarUrl = wp_get_attachment_image_url($image_ID[0]->id,'medium',true);
    //	$gal_img[] = get_post_meta($listingID,'rz_gallery')[0];

      //var_dump($gal_img);
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
    <div class=" rz-field rz-h-150" data-multiple="true" data-upload-type="image" data-type="upload" data-storage="request" data-disabled="no" data-heading="Upload gallery" data-id="gallery">
      <div class="rz-upload rz-h-100">
              <!-- button -->
          <label for="rz-upload-rz_gallery" class="">
                  <div class="add-listing rz-h-100">
                      <div class="add-listing-inner">
                          <div class="icon"><img src="<?php echo get_stylesheet_directory_uri();?>/images/camera.png" alt=""></div>
                          <p>Klik for at tilføje foto</p>
                          
                      </div>
                  </div>
          </label>
          <!-- input -->
          <textarea class="rz-upload-input rz-none" type="text" name="rz_gallery" placeholder=""></textarea>


          <!-- file -->
          <div class="rz-none">
              <input class="rz-upload-file" type="file" id="rz-upload-rz_gallery" multiple="true">
          </div>

          <!-- field info -->
          
          <div class="rz-preloader">
                  <i class="fas fa-sync"></i>
          </div>

          <!-- image preview -->
          <div class="rz-image-preview rz-no-select">
          </div>

          <!-- error output -->
          <div class="rz-error-output"></div>

        </div>
      </div>
    </div>
  </div>
</div>