<?php
/**
 * Starter template for add behandling listing type
 *

 */

defined( 'ABSPATH' ) || exit;

// do_action( 'woocommerce_before_edit_account_form' ); 
	$listingID = get_user_meta(get_current_user_id(), 'behandlerID', true);
?>

<form  style="display: none;" class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
			<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
		</p>
		<div class="clear"></div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
		</p>

		<fieldset>
			<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
			</p>
		</fieldset>
		<div class="clear"></div>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<p>
			<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
			<button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
			<input type="hidden" name="action" value="save_account_details" />
		</p>

		<?php 
		//  do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>
<?php // do_action( 'woocommerce_after_edit_account_form' ); ?>

<section class="breadcrumbs">
	<div class="container">
		<?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(); ?>
	</div>
</section>

<section class="tab-header">
	<div class="container">
		<h1 class="tab-header__title">Tilpasning</h1>
	</div>

	<div class="tab-box tab-box_slider">
		<div>
			<button data-target="#Bookingindstillinger" class="tab-btn active">Bookingindstillinger</button>
		</div>
		<div>
			<button data-target="#Generelle_Indstillinger" class="tab-btn">Generelle Indstillinger</button>
		</div>
		<div>
			<button data-target="#Betalingsindstillinger" class="tab-btn">Betalingsindstillinger</button>
		</div>
		<div>
			<button data-target="#Galleri" class="tab-btn">Galleri</button>
		</div>
	</div>
</section>

<!-- Enter tabs -->
<!-- Tab links -->
<div class="bg-white" style="display: none;">
	<div class="tab">
	<button class="tablinks active" onclick="openCity(event, 'Bookingindstillinger')">Bookingindstillinger</button>
	<button class="tablinks" onclick="openCity(event, 'Generelle_Indstillinger')">Generelle Indstillinger</button>
	<button class="tablinks" onclick="openCity(event, 'Betalingsindstillinger1')">Betalingsindstillinger1</button>
	<button class="tablinks" onclick="openCity(event, 'Galleri')">Galleri</button>
	</div>
</div>
<!-- Tab content -->
<div id="Bookingindstillinger" class="tab-content active">
	<form action="/form_wizard_step/" method="post">
		<input type="hidden" name = "location" value = "/my-account/edit-account/">
		<div class="bg-white rz-p-3 tab-content_style">
			<h3>Tidsplan</h3>
			
			<p>Nedenfor kan du indstille hvilke dage og tidsrum du holder ??bent. Din kalender vil automatisk v??re utilg??ngelig uden for de valgte tidsrum.</p>
			<p>Du kan ogs?? v??lge at g??re din kalender utilg??ngelig for bookinger i toppen ved at klikke p?? h??ngel??sen. Dette vil sp??rre en hel dag.</p>
			<p class="accent">Indstil hvor lang tid i forvejen dine klienter kan booke hos dig</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<a href="" class="rz-button rz-button-regular rz-mb-3" data-modal="modal_listing"><img src="<?php echo get_stylesheet_directory_uri() ;?>/images/ico-calendar.svg"> G?? til kalenderen</a>
					<select name="time" id="" class="regular-text">

							<?php 

							$options = array("Ingen forberedelsestid","15 minutter","30 minutter","1 time","2 time","1 d??gn");
							foreach ($options as $option){?>

									<option value="<?php echo $option; ?>" 
									<?php echo ( esc_attr(get_the_author_meta('time', $user->ID)) == $option) ? "selected" : ""; ?>>
									<?php echo $option; ?></option>

							<?php 
							}
							?>
				</select>
			</p>

			<?php wp_nonce_field(); ?>
															
			<input type="hidden" value="save_time" name="save_time">	
			<button type="submit" class="rz-button rz-button-accent rz-mt-5" name="" value="<?php esc_attr_e( 'Gem indstillinger', 'woocommerce' ); ?>"><?php esc_html_e( 'Gem indstillinger', 'woocommerce' ); ?></button>

		</form>
	</div>
	<div class="bg-white rz-mt-3 rz-p-3 tab-content_style">
		<h3>Tilbud</h3>
		<p>Her kan du redigere, tilf??je eller fjerne typer af behandlings du tilbyder.</p>

		<div class="tab-content_style-cards">
			<?php 

				$args = array(
								'post_type' => 'rz_listing',
								'author' => get_current_user_id(),

								'meta_query' => [ [
									'key'	=>	'rz_listing_type',
									'value'	=>	'624',
								] ],
							
							);
							
				$query = new WP_Query( $args );
				
				// ????????
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$fields = get_post_custom();
					?>
					<div class="tab-content_style-cards__item">
						<div class="list_card">
							<h3>
								<?php the_title(); ?>
							</h3>
								<div class="rz-flex list_card__price">
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

								<div class="list_card__red-line">
									<span>20 % fra mellem</span>
									<span class="list_card__red-line__time">11<sup>15</sup> - 13<sup>45</sup></span>
								</div>

								<div class="list_desc">
									<?php echo mb_strimwidth($fields['post_content'][0],0,40,""); ?>
									<a href="<?php the_permalink(); ?>">l??s mere</a>
								</div>
								<div class="red-text rz-mt-3 rz-text-right" style="display: none;">
									Book nu &rarr;
								</div>
							</div>
						</div>
						<?php
						
						}
						wp_reset_postdata();
					} 
					?> 

					<div class="tab-content_style-cards__item">
						<div class="rz-submission-content label-inside">
							<div class="add-listing" data-modal="modal_listing">
								<div class="add-listing-inner">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri();?>/images/medical.png"></div>
									<p>Tilf??j en ny<br>behandlingsmulighed</p>
								</div>
							</div>

							<?php get_template_part ('form-add-behandling'); ?>

						</div>
					</div>
		</div>			
	</div>
	<div class="bg-white rz-mt-3 rz-p-3 tab-content_style">
		<h3>Specialeomr??de(r)</h3>
		<p>Hvis du specialiserer dig inden for en bestemt behandlingsmetode eller m??lgruppe, kan du skrive det ind her.</p>

		<div class="input-select-chips">
			<input type="text" name="doctor-type" value="<?php echo esc_attr(get_the_author_meta('rz_doctor-type', get_current_user_id())); ?>" class="regular-text icon-search input-select-chips__input" placeholder="Doctor-type*"/> 
						<?php 

							$options = get_terms(array(
								'post_type'	=>	'rz_listing',
								'taxonomy'	=>	'rz_doctor-type',
								'hide_empty' => false,
							));


							$behandlerID = esc_attr(esc_attr(get_the_author_meta('behandlerID', $user->ID)));
							$behandler_listing = get_post($behandlerID);	
							$doctor_types = get_post_meta($behandler_listing->ID,'rz_doctor-type');
							
							foreach ($doctor_types as $doctor_type){
								$term = get_term($doctor_type);
								$doctor_options[] = $term->name;
							}
						
						?>
			<!-- Dropdown speciale -->
				<div id="" class="regular-text input-select-chips__select">
					<?php 

						foreach ($options as $option){
							if ( !in_array($option->name, $doctor_options)) {
							?>

								<span data-value="<?php echo $option->name; ?>"><?php echo $option->name; ?></span>

							<?php 
							}
						}
					?>
				</div>
			<!-- End dropdown  -->

					<div class="input-select-chips__cheeps-box-container cheeps-box-container">
							<?php if (!empty($options)){
								echo  '<div class="cheeps-box">';

								foreach ($options as $option){
									echo ( in_array($option->name, $doctor_options)) ? 
									'<button class="cheeps-box__btn" type="button" data-name="'.$option->name.'">'.$option->name.'</button>' : '';
								}

								echo '</div>';
							}
							?>		
				</div>
		</div>

	</div>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Ydelser og Symptombehandling</h3>
		<p>Her kan du definere hvilke specifikke typer ydelser du tilbyder. Du kan ogs?? skrive hvilke symptomer dine behandlinger kan afhj??lpe.</p>

		<div class="input-select-chips">
			<input type="text" name="symptom" value="<?php echo esc_attr(get_the_author_meta('symptom', get_current_user_id())); ?>" class="regular-text icon-search input-select-chips__input" placeholder="S??g"/>

			<!-- Dropdown speciale -->
			<div id="" class="regular-text input-select-chips__select">
				<span data-value="Sexopatolog">Sexopatolog</span>
				<span data-value="Baton">Baton</span>
				<span data-value="Anton">Anton</span>
				<span data-value="Karton">Karton</span>
				<span data-value="Boston">Boston</span>
			</div>
			<!-- End dropdown  -->
			<div class="input-select-chips__cheeps-box-container cheeps-box-container">

			</div>		
		</div>

			
	</div>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Notifikationer og Bero</h3>
		<?php /* 
		
		not needed

		<p>I dette afsnit kan du ??ndre brugerindstillinger</p>
		<div class="toggle tab-content_style__toggle">
			<label for="send_notif" class="switch">
				Send notifikationer
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="send_notif" id="send_notif" value="<?php echo esc_attr(get_the_author_meta('send_notif', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>
    */?>
		<div class="receive_notif ajaxing rz-position-relative">
			<div class="rz-preloader">
				<i class="fas fa-sync"></i>
		  </div>
			<div class="toggle tab-content_style__toggle">
				<label for="receive_notif" class="switch">
					Modtag notifikationer
					<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="receive_notif" id="receive_notif" value="<?php echo get_post_meta($listingID,'rz_receive_notif')[0]; ?>" class="switch-input regular-text" <?php echo get_post_meta($listingID,'rz_receive_notif')[0] ? 'checked' : '';?>/>
					<span class="slider round"></span>
				</label>
			</div>
			<?php /*
			
			not needed

			<div class="toggle tab-content_style__toggle">
				<label for="hold_profile" class="switch">
					S??t profil i bero
					<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="hold_profile" id="hold_profile" value="1" class="switch-input regular-text"/>
					<span class="slider round"></span>
				</label>
			</div>
			*/?>
		</div>
	</div>
</div>

<div id="Generelle_Indstillinger" class="tab-content">
	<div class="bg-white rz-p-3 tab-content_style">
  		<h3>Om klinikken</h3>
	  	<form action="/form_wizard_step/" method="post">
				<input type="hidden" name = "location" value = "/my-account/edit-account/">

		  	<textarea name="about" class="text-limit" id="" cols="30" rows="30" maxlength="600" value=""><?php  
				
					echo get_post_meta($listingID,'rz_about')[0];?>
				</textarea>
			<p class="text-limit-result"></p>
			<?php wp_nonce_field(); ?>
															 
			<input type="hidden" value="save_about" name="save_about">	
			<button type="submit" class="rz-button rz-button-accent">Gem indstillinger</button>
		</form>
	</div>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Indstillinger</h3>
		<form action="/form_wizard_step/" method="post">

		<?php 
			include 'profile_edit.php';
		?>
		<input type="hidden" name = "location" value = "/my-account/edit-account/">
		<p class="woocommerce-form-row form-row btn-group rz-mt-3">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
			

				
			<button type="reset" class="rz-button rz-button-regular  rz-mr-2">Nulstil</button>					 
			<button type="submit" class="rz-button rz-button-accent">Gem indstillinger</button>
			</p>
		</form>
	</div>

	<!-- Certificates -->
	<?php include('certificate-modal.php'); ?>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
	
		<div class="switch-certificate ajaxing rz-position-relative">
			<div class="rz-preloader">
				<i class="fas fa-sync"></i>
		  </div>
			<h3>Certifikater, kurser og erfaring</h3>
			<div class="toggle tab-content_style__toggle">
				<label for="rab" class="switch">
					Er du RAB Godkendt?
					<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="rz_rab" id="rab" value="<?php echo get_post_meta($listingID,'rz_rab')[0];?>" class="switch-input regular-text" <?php echo get_post_meta($listingID,'rz_rab')[0] ? 'checked' : '';?> data-id="switch_certificate"/>
					<span class="slider round"></span>
				</label>
			</div>
			<div class="toggle tab-content_style__toggle">
				<label for="sygesikring" class="switch">
					Er du medlem af Sygesikring Danmark?
					<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="rz_sygesikring" id="sygesikring" value="<?php echo get_post_meta($listingID,'rz_sygesikring')[0];?>" class="switch-input regular-text" <?php echo get_post_meta($listingID,'rz_sygesikring')[0] ? 'checked' : '';?> data-id="switch_certificate"/>
					<span class="slider round"></span>
				</label>
			</div>
		</div>

		<br>
		<div id="certificate-test" class="rz-position-relative">
				
		<?php $certs = json_decode(get_post_meta($listingID, 'rz_certificates')[0],true);
		if (!empty($certs)){
			foreach ($certs as $cert){ 
				foreach($cert as $cert_year=>$cert_name){?>
					<div class="tab-content_style__presentation-input">
						<div class="tab-content_style__presentation-input-content">
							<div class="tab-content_style__presentation-input-text">
								<span class="tab-content_style__presentation-input-name"><?php echo $cert_name; ?></span> <span class="tab-content_style__presentation-input-year">(<?php echo $cert_year; ?>)</span>
							</div>

							<div class="tab-content_style__presentation-input-btn-group">
								<button type="button" class="tab-content_style__presentation-input-btn_edit" data-id="edit_certificate" data-modal="modal_certificate">Edit</button>
								<button type="button" class="tab-content_style__presentation-input-btn_delete" data-id="delete_certificate" >Delete</button>
							</div>
						</div>	
					</div>
			<?php 
				}
			}
		}
		?>
		<div class="rz-preloader rz-preloader-full">
			<i class="fas fa-sync"></i>
		</div>
		</div>
		<button id="add_certificate" class="rz-button rz-button-accent" data-modal="modal_certificate">Tilf??j nyt certifikat</button>
	</div>

	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Student section</h3>
		<form action="/form_wizard_step/" method="post">
				<input type="hidden" name = "location" value = "/my-account/edit-account/">
				<input type="hidden" name = "student_section" value = "student_section">
			<div class="toggle tab-content_style__toggle">
				<label for="tilbyderduonlinebooking" class="switch">
					Tilbyder du online booking?
					<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="tilbyderduonlinebooking" id="tilbyderduonlinebooking" value="<?php echo get_post_meta($listingID,'rz_online_behandling')[0];?>" class="switch-input regular-text" <?php echo get_post_meta($listingID,'rz_online_behandling')[0] ? 'checked' : '';?>/>
					<span class="slider round"></span>
				</label>
			</div>
			<div class="toggle tab-content_style__toggle">
				<label for="erdustudende" class="switch">
					Er du studerende?
					<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="erdustudende" id="erdustudende" value="<?php echo get_post_meta($listingID,'rz_du_studerende')[0];?>" class="switch-input regular-text" <?php echo get_post_meta($listingID,'rz_du_studerende')[0] ? 'checked' : '';?>/>
					<span class="slider round"></span>
				</label>
			</div>

			<br>
			
			
				<p class="input-box">
					<input type="text" name="hvilkenskole" id="hvilkenskole" value="<?php echo get_post_meta($listingID,'rz_skole')[0];?>" placeholder=" " required>
					<label for="hvilkenskole">Hvilken skole studererer du p???<span style="color: #F55951;">*</span></label>
				</p>

				<p class="input-box">
					<input type="text" name="hvornarer" id="hvornarer" value="<?php echo get_post_meta($listingID,'rz_skole_end')[0];?>" placeholder=" " required>
					<label for="hvornarer">Hvorn??r er din uddannelse f??rdig?<span style="color: #F55951;">*</span></label>
				</p>
		

		<button type="submit" class="rz-button rz-button-accent">Gem indstillinger</button>
		</form>
	</div>

	<div class="delete-profil">
		<a href="#" class="delete-profil-link">Luk profil permanent</a>
	</div>
</div>

	<div id="Betalingsindstillinger" class="tab-content">
		<div class="bg-white rz-p-3 tab-content_style">
			<span>Din nuv??rende profil er</span>
			<h3>Kommissionbaseret betaling</h3>
			<p>Lorem Ipsum er ganske enkelt fyldtekst fra print- og typografiindustrien. Lorem Ipsum har v??ret standard fyldtekst siden 1500-tallet</p>

			<?php 
				$current_plan = get_post_meta($listingID,'rz_subscription_id')[0];
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
			<div class="mulige">
				<div class="mulige__header">
					Mulige profiler
				</div>
				<?php 
						while ( $loop->have_posts() ) : $loop->the_post(); 
						$ID = get_the_ID();
					//	echo gettype($ID);
						//$product = wc_get_product( $post->ID );
					?>

				<div class="mulige__container">
					<div class="mulige__item <?php echo ($current_plan == get_the_ID()) ? 'mulige__item mulige__item_accent' : ''; ?>">
						<div class="mulige__content">
							<div class="mulige__title"><?php the_title(); ;?></div>
							<!-- <form action="" method="get"> -->
								<input type="hidden" value = <?php echo $ID; ?> name="plan_id">
							<a href="#" class="mulige__link send_plan" <?php echo (get_the_ID() != $current_plan) ? 'data-modal="modal_plan-'.$ID.'" data-plan-id='.$ID : ''; ?> type="submit">L??s mere</a>
							
							<!-- </form> -->
						</div>

						<div class="mulige__btn rx-mb-5">
							<a href=<?php echo (get_the_ID() != $current_plan) ? "/wizard_plan" : "#"; ?>>
							<button class="rz-button btn-red-line" data-plan-id="<?php echo $ID; ?>"><?php echo ($current_plan == get_the_ID()) ? 'Nuv??rende profil' : 'Skift til'; ?></button>
							</a>
						</div>
					</div>
					<?php endwhile; wp_reset_query();  ?>
				</div>
			</div>
		</div>
	</div>	
</div>
			<?php require_once('plan-modal.php'); ?>
			<?php 
				/*
			Payment methods and refferal codes. Not needed -->

		<!-- <div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
			<h3>Betalingsmetode</h3>
			<p>Lorem Ipsum er ganske enkelt fyldtekst fra print- og typografiindustrien. Lorem Ipsum har v??ret standard fyldtekst siden 1500-tallet</p>

			<button class="rz-button rz-button-accent">Tilf??j ny metode</button>
		</div>

		<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
			<h3>Tilbudskode</h3>
			<p>Del din referencekode med behandlere der ikke er p?? vores platform endnu. For hver behandler der accepterer din invitation, f??r du ??n m??neds gratis abonnement.</p>
		</div> 
		*/
		?>
	
</div>
<div id="Galleri" class="tab-content">
	<div class="bg-white rz-p-3 tab-content_style">
		<form action="/form_wizard_step/" method="post" class="woocommerce-form woocommerce-form-register register">
			<?php require_once('add-gallery.php'); ?>

			<input type="hidden" value="gallery_acc" name="gallery_acc">	
			<input type="hidden" name = "location" value = "/my-account/edit-account/">

		</form>
		
	</div>
</div>	

<script>
var $avatar_id = document.querySelector('#rz_main_avatar_id');
var el = document.querySelector('#avatar_photo');

const config = {
    childList: true
};
	const callback = function(mutationsList, observer) {
		 
    for (let mutation of mutationsList) {
			
        if (mutation.type === 'childList') {
					
            var $picId = [];
            $images_data = document.querySelectorAll('#avatar_photo>.rz-image-prv-wrapper');
						
            var i;
            for (var i = 0; i < $images_data.length; i++){
                var $id = $images_data[i].getAttribute("data-id");   
                $picId.push( $id);
            }
             $avatar_id.value = $picId; 
        } 
    }
};

const observer = new MutationObserver(callback);
observer.observe(el, config);





</script>