<?php get_header(); ?>

<div class="about__main author">
    <div class="container color-w">
        <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(); ?>
    </div>
    <div class="container">
        <div class="about__main_info">
             <?php if (get_field('about_us_head')): ?>
                <div class="about__main_info-head">
                     <h1><?php the_field('about_us_head'); ?></h1>
                </div>
            <?php endif; ?>
            <?php if (get_field('about_us_slag')): ?>
                <div class="about__main_info-text">
                    <?php the_field('about_us_slag'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Get Behandler info -->

<?php

						global $wpdb;

						$author = get_queried_object();
						$user = new \Routiz\Inc\Src\User( $author->ID );
						$user_avatar = $user->get_avatar();
						$user_cover = $user->get_cover();
						$title = $author->display_name;

						$listings_per_page = 6;
						$current_page = isset( $_GET['onpage'] ) ? (int) $_GET['onpage'] : 1;
						if( $current_page < 1 ) {
							$current_page = 1;
						}
            
						$listingID = get_user_meta($author->ID, 'behandlerID', true);

						$listing_types = new \WP_Query([
							'post_status' => 'publish',
							'post_type' => 'rz_listing_type',
							'posts_per_page' => -1,
						]);

						$args = [
							'post_status' => 'publish',
							'post_type' => 'rz_listing',
							'author' => $author->ID,
							'posts_per_page' => $listings_per_page,
							'offset' => ( $current_page - 1 ) * $listings_per_page,
						];

						// set listing type by query string
						if( isset( $_GET['type'] ) ) {
							$listing_type = new \Routiz\Inc\Src\Listing_Type\Listing_Type( $_GET['type'] );
							if( $listing_type->id ) {
								$args['meta_query'] = [
									[
										'key' => 'rz_listing_type',
										'value' => $listing_type->id,
										'compare' => '=',
									]
								];
							}
						}

						// set listing type by first
						if( ! isset( $args['meta_query'] ) ) {
							if( $listing_types->found_posts > 0 ) {
								$args['meta_query'] = [
									[
										'key' => 'rz_listing_type',
										'value' => $listing_types->posts[0]->ID,
										'compare' => '=',
									]
								];
							}
						}

						$listings = new \WP_Query( $args );

						$author_posts = $wpdb->get_results(
							$wpdb->prepare("
									SELECT ID
									FROM $wpdb->posts
									WHERE post_status = 'publish'
									AND post_type = 'rz_listing'
									AND post_author = %d
								",
								$author->ID
							)
						);

						$comment_rating = '-';
						$rating_count = 0;

						$author_post_ids = [];
						foreach( $author_posts as $author_post ) {
							
							$author_post_ids[] = $author_post->ID;
						}

						if( $author_post_ids ) {

							$comments = $wpdb->get_row("
								SELECT *, m.meta_value as review_rating_average, SUM( m.meta_value ) as rating_sum, SUM( CASE WHEN m.meta_value THEN 1 ELSE 0 END ) as rating_count
								FROM {$wpdb->comments} c
									LEFT JOIN {$wpdb->prefix}commentmeta m ON m.comment_id = c.comment_ID AND m.meta_key = 'rz_rating_average'
								WHERE comment_post_ID IN ( " . implode( ',', $author_post_ids ) . " )
								AND comment_type = 'rz-review'
								AND comment_approved = 1
								AND comment_parent = 0
							");

							$rating_count = $comments->rating_count;

							if( $comments->rating_sum and $comments->rating_count ) {
								$comment_rating = number_format( $comments->rating_sum / $comments->rating_count, 2 );
							}

						}


					?>
<div class="container-fluid bg-grey">
	<div class="container">
		<div class="rz-grid rz-align-start">
			<div class="rz-col-lg-12 rz-col-4 bg-white">
				<div class="brk--inner">
					<div class="author-avatar brk--cover-avatar">

						<?php 
						$image_ID = json_decode(get_post_meta($listingID,'rz_avatar')[0]);
						$avatarUrl = wp_get_attachment_image_url($image_ID[0]->id,'medium',true);

						if( $avatarUrl ): ?>
							<img class="tab-content_style__current-avatar-img" src="<?php echo $avatarUrl; ?>">
						<?php else: ?>
							<i class="brk--avatar fas fa-user-alt"></i>
						<?php endif; ?>

					</div>
				</div>
				<div class="author-title">
					<h3><?php echo ($title); ?></h3>
				</div>
				<div class="rz-grid rz-mt-4">
					<div class="rz-col-6">
						<div><?php esc_html_e( 'Antal anmeldelser', 'brikk' ); ?></div>
						<div class="red-text author-big-text">1 211</div>
					</div>
					<div class="rz-col-6">
						<div><?php esc_html_e( 'Bedømmelse', 'brikk' ); ?></div>
						<div class="red-text author-big-text">4.7</div>
					</div>
				</div>
				<div class="author-data rz-mt-4">
					<div class="author-data-item rz-flex rz-align-center">
						<img class="icon rz-mr-1" src="<?php echo get_stylesheet_directory_uri();?>/images/ico-place.svg" alt="">
						<span class="icon-text"><?php echo get_post_meta($listingID,'rz_location__geo_city_alt')[0]; ?></span>
					</div>

					<div class="author-data-item rz-mt-1 rz-flex rz-align-center">
						<img class="icon rz-mr-1" src="<?php echo get_stylesheet_directory_uri();?>/images/ico-globo.svg" alt="">
						<span class="icon-text"><a href="<?php echo get_post_meta($listingID,'rz_site_url')[0]; ?>"><?php echo get_post_meta($listingID,'rz_site_url')[0]; ?></a></span>
					</div>
					<div class="author-data-item rz-mt-1 rz-flex rz-align-center">
						<img class="icon rz-mr-1" src="<?php echo get_stylesheet_directory_uri();?>/images/ico-phone.svg" alt="">
						<span class="icon-text"><?php echo get_post_meta($listingID,'rz_telephone')[0]; ?></span>
					</div>
				</div>

				<h3 class="rz-mt-4"><?php esc_html_e( 'Om klinikken', 'brikk' ); ?></h3>
				<div class="author-about-klinik">
					<?php echo get_post_meta($listingID,'rz_about')[0];?>
				</div>
				
				<h3 class=rz-mt-4><?php esc_html_e( 'Specialer', 'brikk' ); ?></h3>
				<?php 
					$behandler_listing = get_post($listingID);	
					$doctor_types = get_post_meta($behandler_listing->ID,'rz_doctor-type');
						
				?>
				<ul>
					<?php 
						foreach ($doctor_types as $special){
							echo '<li>'.get_term($special)->name.'</li>';
						}?>
				</ul>

				<h3 class="rz-mt-4"><?php esc_html_e( 'Certifikater, uddannelse og forsikring', 'brikk' ); ?></h3>
				<ul>
					<?php $certs = json_decode(get_post_meta($listingID, 'rz_certificates')[0],true);
						if (!empty($certs)){
							foreach ($certs as $cert){ 
								foreach($cert as $cert_year=>$cert_name){?>
									
												<li><?php echo $cert_name; ?><span class="tab-content_style__presentation-input-year"> (<?php echo $cert_year; ?>)</span></li>

							<?php 
								}
							} 
						} else {
							echo ('<span class="no_cert"> No certifikate</span>');
						}
						?>
				</ul>

				<div class="kontakt rz-mt-3">
					<button class="rz-button rz-button-accent rz-modal-button rz-payment w-100">Kontakt</button>
				</div>
			</div>

			<div class="rz-col-lg-12 rz-col-8">
				<div class="rz-grid rz-justify-space rz-align-center">
					<div class="rz-col-lg-12 rz-col-2">
						<h2 class="rz-mt-1">
							<?php esc_html_e( 'Galleri', 'brikk' ); ?>
						</h2>
					</div>
					<div class="rz-col-lg-12 rz-col-3 rz-text-right">
						<a href="gallery"><button class="rz-button rz-button-border rz-small ">See alle fotos</button></a>
					</div>
				</div>

				<div class="author-page rz-mb-3" id="author-page">
					<?php 
						$image_ID = json_decode(get_post_meta($listingID,'rz_gallery')[0]);
						  if ($image_ID){
								foreach ($image_ID as $imgID){ ?>
									<?php 
										$imgUrl = wp_get_attachment_image_url($imgID->id,'medium',true);
									?>
									<li class="rz-listing-item rz-p-1 <?php Rz()->listing_class(); ?>">
										<img src="<?php echo $imgUrl; ?>" alt="" class="rz-h-100 rz-w-100">
								</li>
							<?php	
								} 
							} else { ?>
								<div class="rz-ol-lg-12 rz-col-6">
									<p><?php esc_html_e( 'No gallery present', 'brikk' ); ?></p>
								</div>
							<?php }	  
					?>
				</div>

				<div class="bg-white rz-p-20" id="author-page-listing">
					<h2 class="rz-mt-3">
						<?php esc_html_e( 'Behandlinger', 'brikk' ); ?>
					</h2>
					<div class="rz-grid rz-align-start">
						<?php 
							
								
							$args = array(
								'post_type' => 'rz_listing',
								'author' => $author->ID,

								'meta_query' => [ [
									'key'	=>	'rz_listing_type',
									'value'	=>	'624',
								] ],
							
							);
							$query = new WP_Query( $args );
							
							// Цикл
							if ( $query->have_posts() ) {
								while ( $query->have_posts() ) {
									$query->the_post();
									$fields = get_post_custom();
									
								?>
								<div class="rz-col-4 rz-col-sm-12 rz-mb-3">
									<div class="list_card">
										<h3>
											<?php the_title(); ?>
										</h3>
											<div class="rz-flex ">
												<div class="price">
													Kr <?php 
													echo $fields['rz_price'][0];
													?>
												</div>
												<span class=delimiter>|</span>
												<div class="time">
													<?php 
													$tt = json_decode($fields['rz_time_availability'][0]);
													echo ($tt[0]->{'fields'}->{'duration'}/60).' min';
													?> 
												</div>
											</div>
											<div class="list_desc rz-mt-3">
												<?php echo mb_strimwidth($fields['post_content'][0],0,40,""); ?>
												<a href="#" data-modal="listing_modal" data-listing-id="<?php echo get_the_ID();?>">læs mere</a>
											</div>
											<div class="red-text rz-mt-3 rz-text-right">
												Book nu &rarr;
											</div>
										</div>
									</div>
									<?php
									
									}
									wp_reset_postdata();
								} 
								get_template_part('listing-modal');
							?>
					</div>
				</div>

				<?php /*
				not needed

				<div class="bg-white rz-p-20 rz-mt-2 rz-mb-2">
					<h2 class="rz-mt-3">
						<?php esc_html_e( 'Anmeldelser', 'brikk' ); ?> <span class="color-grey"> (114)</span>
					</h2>
					<div class="list_card">
						<div class="rz-grid rz-mb-2">
							<div class="rz-col-1">
								<i class="brk--avatar fas fa-user-alt"></i>
							</div>
							<div class="rz-col">
								<div class="coment-title">Bill Doe</div>
								<div class="coment-date color-grey">15 Jul 2020</div>
							</div>
						</div>
						<h3>Akupunktur</h3>
						<p>Rasmus er en kompetent og dygtig behandler. Han gjorde sit bedste for at forstå 
							ikke kun hvilke problemer jeg havde, men også hvorfor jeg havde dem, så vi kom 
							i dybden med udfordringerne.</p>
					</div>
				</div>
				*/
				?>
			</div>
		</div>
	</div>
</div>
<!-- end -->
<?php get_footer('registration'); ?>


