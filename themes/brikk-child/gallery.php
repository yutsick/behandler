<?php get_header(); 
$author = get_queried_object();
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
						$gal_img = get_field ('gallery'); 
						if ($gal_img){
							foreach ($gal_img as $gal_image){ ?>
							<div class="rz-col-lg-12 rz-col-3">
								<img src="<?php echo $gal_image; ?>" alt="" class="rz-w-100">
							</div>
						<?php	}
						} else { ?>
						<div class="rz-col-lg-12">
								<p><?php esc_html_e( 'No gallery present', 'brikk' ); ?></p>
						</div>
						<?php }
					?>
		</div>
    </div>
</div>


<?php get_footer('registration'); ?>