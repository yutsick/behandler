<?php get_header(); 
$author = get_queried_object();
$listingID = get_user_meta($author->ID, 'behandlerID', true);
?>

<div class="container-fluid bg-grey ov-hidden">
    <div class="container">
         <div class="kama_breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item"><span itemprop="name">Home</span></a>
            </span>
                <span class="kb_sep"> <img src="/wp-content/themes/brikk-child/images/breadcrumbs-arrow.svg" alt="img"> </span>
                <span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a href="/author/<?php echo $author->user_nicename; ?>" itemprop="item"><span itemprop="name"><?php echo $author->display_name; ?></span></a>
                </span>
                <span class="kb_sep"> <img src="/wp-content/themes/brikk-child/images/breadcrumbs-arrow.svg" alt="img"> </span>
                <span class="rz-text-primary">gallery</span>
        </div>
        <h2 class="rz-mt-2 rz-mb-2"><?php esc_html_e( 'Galleri', 'brikk' ); ?></h2>
        <div class="rz-grid">
        
        <?php 
            $image_ID = json_decode(get_post_meta($listingID,'rz_gallery')[0]);
                if ($image_ID){
                    foreach ($image_ID as $imgID){ ?>
                        <?php 
                            $imgUrl = wp_get_attachment_image_url($imgID->id,'medium',true);
                        ?>
					    <div class="rz-col-lg-12 rz-col-3 rz-mb-1">
                            <img src="<?php echo $imgUrl; ?>" alt="" class="rz-w-100 rz-h-100 rz-fit-cover">
                        </div>
                        <?php	
                            } 
                        } else { ?>
                            <div class="rz-ol-lg-12 rz-col-6">
                                <p><?php esc_html_e( 'No gallery present', 'brikk' ); ?></p>
                            </div>
                        <?php }	  
					?>

		</div>
    </div>
</div>
 

<?php get_footer('registration'); ?>