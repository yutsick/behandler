<span class="rz-overlay"></span>


<?php 



$args = array( 
					'post_type' => 'product',
					'product_tag' => "plan",
					'post_status' => 'publish',
					// 'columns' => 4,
					'orderby' => "id",
					'order' => 'ASC',
					//'visibility' => 'visible',
			);
$loop = new WP_Query( $args );


  while ( $loop->have_posts() ) : $loop->the_post(); 
  $ID = get_the_ID();
  $product = wc_get_product( $ID );

  ?> 
                
  <div class="rz-modal rz-modal-ready rz-modal_plan" data-id="modal_plan-<?php echo $ID; ?>">
    <a href="#" class="rz-close">
      <i class="fas fa-times"></i>
    </a>
    <div class="rz-modal-heading rz--border rz-modal-title-bg">
      <h4 class="">Abonnementsbaseret</h4>
    </div>
    <div class="rz-modal-content">
      <div class="rz-modal-append">
        <div class="rz-modal-container " id="modal_plan">
          <!-- START MODAL CONTENT -->
          <div class="rz-col-3 rz-col-md-12 rz-mb-3 rz-flex ">
            
            <form action="/wizard_plan/" method="GET">
              <input type="hidden" name="rz_plan" value="<?php echo $ID; ?>" id="product-<?php echo $ID; ?>">
              <div class="rz-plan rz--plan-type-listing_plan rz-flex rz-flex-column rz-justify-space rz-h-100">
                <div class="rz-heading">
                 
                  <div class="rz--desc select-desc"><?php the_excerpt(); ?></div>
                </div>
                <div class="">
                  <div class="rz-price ">
                      <p>
                          <span class="woocommerce-Price-amount amount">
                              <bdi>
                                  <span class="woocommerce-Price-currencySymbol">DKK</span>
                                  &nbsp; 
                                  <?php echo $product -> get_price(); ?>
                              </bdi>
                          </span>
                      </p>
                  </div>
                  <span class="rz-content text-bold">
                    <div class="price__info_make">
                        <?php the_content(); ?>
                    </div>
                  </span>
                  <div class="rz-action">
                    <input  type="submit" class="test rz-button rz-button-accent select-plan" value="Vælg denne plan" data-product="product-<?php echo $post->ID; ?>"> 
                  </div>
                </div>
              </div>
            </form>
          </div>
          
        </div>
        <!-- END MODAl CONTENT -->
      </div>
    </div>
  </div>

<?php endwhile; wp_reset_query(); // Remember to reset ?>