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
						<?php if( $user_avatar ): ?>
							<img src="<?php echo esc_url( $user_avatar ); ?>">
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
						<div><?php esc_html_e( 'Bed??mmelse', 'brikk' ); ?></div>
						<div class="red-text author-big-text">4.7</div>
					</div>
				</div>
				<div class="author-data rz-mt-4">
					<div class="author-data-item rz-flex rz-align-center">
						<img class="icon rz-mr-1" src="<?php echo get_stylesheet_directory_uri();?>/images/ico-place.svg" alt="">
						<span class="icon-text"><?php echo esc_attr(get_the_author_meta('gadenavn_og_nummer', $author->ID)); ?></span>
					</div>
					<div class="author-data-item rz-mt-1 rz-flex rz-align-center">
						<img class="icon rz-mr-1" src="<?php echo get_stylesheet_directory_uri();?>/images/ico-globo.svg" alt="">
						<span class="icon-text"><a href=""><?php echo esc_attr(get_the_author_meta('email', $author->ID)); ?></a></span>
					</div>
					<div class="author-data-item rz-mt-1 rz-flex rz-align-center">
						<img class="icon rz-mr-1" src="<?php echo get_stylesheet_directory_uri();?>/images/ico-phone.svg" alt="">
						<span class="icon-text"><?php echo esc_attr(get_the_author_meta('telephone', $author->ID)); ?></span>
					</div>
				</div>

				<h3 class="rz-mt-4"><?php esc_html_e( 'Om klinikken', 'brikk' ); ?></h3>
				<div class="author-about-klinik">
					Lorem ipsum dolor sit amet consectetur adipisicing elit. 
					Iste tempora ex excepturi similique nostrum quia ut asperiores id, 
					odit natus ipsam! Quaerat nostrum dolor minima sit laudantium 
					reiciendis tempora quae neque, illum enim fugiat praesentium 
					reprehenderit quis consequatur velit ipsum. Numquam suscipit labore quo. 
					Maiores nihil rerum temporibus unde facere.
				</div>
				
				<h3 class=rz-mt-4><?php esc_html_e( 'Specialer', 'brikk' ); ?></h3>
				<ul>
					<li>Lorem ipsum</li>
					<li>Lorem ipsum</li>
					<li>Lorem ipsum</li>
				</ul>

				<h3 class="rz-mt-4"><?php esc_html_e( 'Certifikater, uddannelse og forsikring', 'brikk' ); ?></h3>
				<ul>
					<li>Den Danske Akupunkt??rskole <span>(2001)</span></li>
					<li>RAB Godkendt <span>(2014)</span></li>
					<li>Er du Medlem af Sygesikring Danmark  <span>(2018)</span></li>
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
						<button class="rz-button rz-button-border rz-small ">See alle fotos</button>
					</div>
				</div>
				<div class="rz-grid">
					<?php 
						$gal_img = get_field ('gallery'); 
						if ($gal_img){
							foreach ($gal_img as $gal_image){ ?>
							<div class="rz-ol-lg-12 rz-col-6">
								<img src="<?php echo $gal_image; ?>" alt="" class="rz-w-100">
							</div>
						<?php	}
						} else { ?>
						<div class="rz-ol-lg-12 rz-col-6">
								<p><?php esc_html_e( 'No gallery present', 'brikk' ); ?></p>
						</div>
						<?php }
					?>
				</div>
				<div class="bg-white rz-p-20">
					<h2 class="rz-mt-3">
						<?php esc_html_e( 'Behandlinger', 'brikk' ); ?>
					</h2>
					<div class="rz-grid rz-align-start">
						<?php 
							
								
							$args = array(
								'post_type' => 'rz_listing',
								'author' => $title,
							);
							$query = new WP_Query( $args );
							
							// ????????
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
												<a href="<?php the_permalink(); ?>">l??s mere</a>
											</div>
											<div class="red-text rz-mt-3 rz-text-right">
												Book nu &rarr;
											</div>
										</div>
									</div>
									<?php
									
									}
								} 

							?>
					</div>
				</div>
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
						<p>Rasmus er en kompetent og dygtig behandler. Han gjorde sit bedste for at forst?? 
							ikke kun hvilke problemer jeg havde, men ogs?? hvorfor jeg havde dem, s?? vi kom 
							i dybden med udfordringerne.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end -->
<?php get_footer('registration'); ?>


<div class="brk-container">

	<?php get_template_part('templates/title'); ?>

	<div class="brk-row">
		<main class="brk-main">
			<div class="brk-content">

				<?php if( function_exists('routiz') ): ?>

					

					<?php if( ! ( isset( $_GET['onpage'] ) and (int) $_GET['onpage'] > 1 ) and ! isset( $_GET['type'] ) ): ?>
		                <div class="brk-author-cover">
		                    <div class="brk--cover<?php if( $user_cover ) { echo ' brk--has-cover'; } if( $user_avatar ) { echo ' brk--has-avatar'; } ?>" style="<?php if( $user_cover ) { echo sprintf( 'background-image: url(\'%s\');', $user_cover ); } ?>">
		                        <div class="brk--inner">
		                            <div class="brk--cover-avatar">
		                                <?php if( $user_avatar ): ?>
		                                    <img src="<?php echo esc_url( $user_avatar ); ?>">
		                                <?php else: ?>
		                                    <i class="brk--avatar fas fa-user-alt"></i>
		                                <?php endif; ?>
		                            </div>
		                            <h5 class="brk--name">
										<?php if( get_user_meta( $author->ID, 'rz_verified', true ) ): ?>
								            <i class="rz--verified fas fa-check-circle"></i>
								        <?php endif; ?>
										<?php echo esc_html( $author->display_name ); ?>
									</h5>
		                            <p class="brk--bio"><?php echo wp_trim_words( esc_html( get_the_author_meta( 'description', $author->ID ) ), 50, ' ...' ); ?></p>
		                        </div>
		                    </div>
		                </div>

		                <div class="rz-dashboard">
		                    <div class="rz-grid rz-dashboard-row">
		                        <div class="rz-col-4 rz-col-lg-12">
		                            <div class="rz--box rz--colored rz--has-icon">
		                                <i class="material-icon-location_onplaceroom"></i>
		                                <h3 class="rz--title"><?php esc_html_e( 'Total listings', 'brikk' ); ?></h3>
		                                <span class="rz--num"><?php echo (int) $user->get_num_listings(); ?></span>
		                            </div>
		                        </div>
		                        <div class="rz-col-4 rz-col-lg-12">
		                            <div class="rz--box rz--colored rz--has-icon">
		                                <i class="material-icon-stargrade"></i>
		                                <h3 class="rz--title"><?php echo sprintf( esc_html__( 'Rating from %s reviews', 'brikk' ), $rating_count ); ?></h3>
		                                <span class="rz--num"><?php echo esc_html( $comment_rating ); ?></span>
		                            </div>
		                        </div>
		                        <div class="rz-col-4 rz-col-lg-12">
		                            <div class="rz--box rz--colored rz--highlight rz--has-icon">
		                                <i class="material-icon-timer"></i>
		                                <h3 class="rz--title"><?php esc_html_e( 'Response rate', 'brikk' ); ?></h3>
		                                <span class="rz--num"><?php esc_html_e( 'Fast', 'brikk' ); ?></span>
		                            </div>
		                        </div>
		                    </div>
		                </div>
					<?php endif; ?>

					<div class="brk-grid brk-align-center brk-mt-4 brk-mb-4">
						<div class="brk-col">
							<h4 class="brk-author-title">
								<?php esc_html_e( 'Author\'s listings', 'brikk' ); ?>
							</h4>
						</div>
						<?php if( $listing_types->found_posts > 1 ): ?>
							<div class="brk-col-4 brk-col-md-12">
								<div class="rz-form-group brk-select-listing-type">
									<div class="rz-select rz-select-single">
										<select data-action="author-listing-types">
											<?php foreach( $listing_types->posts as $listing_type ): ?>
												<?php $slug = Rz()->get_meta( 'rz_slug', $listing_type->ID ); ?>
												<?php $name = Rz()->get_meta( 'rz_name_plural', $listing_type->ID ); ?>
												<option value="<?php echo esc_html( $slug ); ?>"<?php if( isset( $_GET['type'] ) and $_GET['type'] == $slug ) { echo ' selected="selected"'; } ?>>
													<?php echo esc_html( $name ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>

	                <?php if( $listings->have_posts() ): ?>

	                    <ul class="rz-listings" data-cols="3">
	                        <?php while( $listings->have_posts() ): $listings->the_post(); ?>
	                            <li class="rz-listing-item <?php Rz()->listing_class(); ?>">
									<?php Rz()->the_template('routiz/explore/listing/listing'); ?>
								</li>
	                        <?php endwhile; wp_reset_postdata(); ?>
	                    </ul>

	                    <div class="brk-paging">
	                        <?php

	                            echo Rz()->pagination([
	                                'base' => add_query_arg( [ 'onpage' => '%#%' ], get_author_posts_url( $author->ID ) ),
	                                'format' => '?onpage=%#%',
	                                'current' => $current_page,
	                                'total' => $listings->max_num_pages,
	                            ]);

	                        ?>
	                    </div>

	                    <?php

	                        $from = ( $current_page - 1 ) * $listings_per_page + 1;
	                        $to = $from + $listings_per_page - 1;

	                    ?>

	                    <div class="rz-summary rz-text-center">
	                        <p>
	                            <?php echo sprintf(
	                                esc_html__( '%s - %s of %s listings. ', 'brikk' ),
	                                $from,
	                                $to > $listings->found_posts ? $listings->found_posts : $to,
	                                $listings->found_posts
	                            ); ?>
	                        </p>
	                    </div>

	                <?php else: ?>

	                    <p><?php esc_html_e( 'No results were found', 'brikk' ); ?></p>

	                <?php endif; ?>

				<?php else: ?>

					<?php if( have_posts() ): ?>
						<div class="brk-msnry">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'templates/article-msnry' ); ?>
							<?php endwhile; ?>
						</div>
						<div class="brk-paging">
							<?php echo Brk()->pagination(); ?>
						</div>
					<?php else: ?>
						<?php get_template_part( 'templates/content-none' ); ?>
					<?php endif; ?>

				<?php endif; ?>

			</div>
		</main>
	</div>
</div>

<?php get_footer();
