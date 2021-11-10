<?php 
if ($_GET['rz_plan']){
    $WC_Cart = new WC_Cart();
    $WC_Cart->add_to_cart( $_GET['rz_plan'] );
      wp_safe_redirect( '/checkout/');
    exit();
}
?>
<?php  get_header('registration'); ?>

<div class="container">

    <div class="regis-top rz-mt-2">
            <div class="regis-top-logo">
                <a href="<?php echo  get_home_url();?>">
                    <img src="/wp-content/themes/brikk-child/images/logo-dark.png" alt="img" width="225">
                </a>
            </div>
            <div class="regis-top-link">
                Priser og Fordele
            </div>
    </div>

     <div class="rz-submission-heading">
        <h4 class="rz-plan-title">Vælg din plan</h4>
    </div>
    <div class="">
        <p>Vælg den plan du ønsker. Som ny bruger anbefaler vi, at du vælger Kommissionsplanen. Her betaler du kun for de kunder, som der bookes igennem os, men får alle tilgængelige goder.
        <p>Hvis du er under uddannelse indenfor alternativ behandling, så giver vi dig gratis abonnement indtil afsluttet uddannelse. Kontakt os for at høre nærmere.</p></p>
    </div>

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

?>

<section class="rz-submission-step rz-active" data-id="select-plan">
        <div class="rz-select-plan">
            <div class="rz-plans rz-grid rz-no-select rz-justify-center">
            <?php
                while ( $loop->have_posts() ) : $loop->the_post(); 

                $product = wc_get_product( $post->ID );

                ?>

                <div class="rz-col-3 rz-col-md-12 rz-mb-3 rz-flex ">
                    <form action="" method="GET">
                        <label for="product-<?php echo $post->ID; ?>" >
                            <input type="radio" name="rz_plan" value="<?php echo $post->ID; ?>" class="rz-none" id="product-<?php echo $post->ID; ?>">
                            <div class="rz-plan rz--plan-type-listing_plan rz-flex rz-flex-column rz-justify-space rz-h-100">

                                <div class="rz-heading">

                                    <div class="rz--name select-name rz-mb-3"><?php the_title(); ?></div>

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
                        </label>
                    </form>
                </div>
                <?php endwhile; wp_reset_query(); // Remember to reset ?>
            </div>
        </div>
</section>
</div>
<script>
    (function($){
    $('.test').on('click', function (){
    // document.querySelector
       
        let prod = ($(this).data('product'));
        $('#'+prod).attr('checked', 'checked');
        
    });
    }) (jQuery);
</script>