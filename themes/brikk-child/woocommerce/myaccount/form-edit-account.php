<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
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

		<?php//  do_action( 'woocommerce_edit_account_form_end' ); ?>

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
			
			<p>Nedenfor kan du indstille hvilke dage og tidsrum du holder åbent. Din kalender vil automatisk være utilgængelig uden for de valgte tidsrum.</p>
			<p>Du kan også vælge at gøre din kalender utilgængelig for bookinger i toppen ved at klikke på hængelåsen. Dette vil spærre en hel dag.</p>
			<p class="accent">Indstil hvor lang tid i forvejen dine klienter kan booke hos dig</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<a href="" class="rz-button rz-button-regular rz-mb-3" data-modal="modal_listing"><img src="<?php echo get_stylesheet_directory_uri() ;?>/images/ico-calendar.svg"> Gå til kalenderen</a>
					<select name="time" id="" class="regular-text">

							<?php 

							$options = array("Ingen forberedelsestid","15 minutter","30 minutter","1 time","2 time","1 døgn");
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
		<p>Her kan du redigere, tilføje eller fjerne typer af behandlings du tilbyder.</p>

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
				
				// Цикл
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
									<a href="<?php the_permalink(); ?>">læs mere</a>
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
									<p>Tilføj en ny<br>behandlingsmulighed</p>
								</div>
							</div>

							<span class="rz-overlay"></span>
							<div class="rz-modal rz-modal-ready" data-id="modal_listing" data-signup="pass">
								<a href="#" class="rz-close">
									<i class="fas fa-times"></i>
								</a>
								<div class="rz-modal-heading rz--border rz-modal-title-bg">
									<h4 class="">Tilføj ny behandlingstype</h4>
								</div>
								<div class="rz-modal-content">
									<div class="rz-modal-append">
										<div class="rz-modal-container">
										<!-- START MODAL CONTENT -->
											<form method="post" action="/form_wizard_step/">
												<section class="rz-submission-step rz-active" data-id="fields" data-group="0">
													<input type="hidden" name="add_post" value="add_post" />
													<input type="hidden" name="location" value="/" />
													<div class="rz-grid">
													<div class="rz-form-group rz-field rz-col-12 rz-relative rz-field-ready" data-type="text" data-storage="request" data-disabled="no" data-heading="Navn på behandlingen*" data-id="doctors-name">
														<input type="text" name="rz_doctors-name" value="" class="" placeholder=" "/>
														<label class="">
														Navn på behandlingen*
														<i class="rz-required"></i>
														</label>
													</div>
													<div class="rz-form-group form-group form-group_space-between rz-col-12">
														<div class="">
															<label>
																Pris per time
																<i class="rz-required"></i>
															</label>
														</div>

														<div class="rz-number-type-number form-group_input-min-number" data-type="number">
															<input type="number" name="rz_price" min="0" step="0.01" placeholder="0" data-format="<strong>%s</strong>"/>
														</div>
													</div>
													
													<div class="toggle rz-w-100 tab-content_style__toggle rz-col-12">
														<label for="tilbudkampagne" class="switch">
															Tilbud/Kampagne
															<input onclick="$(this).attr('value', this.checked ? 1 : 0);showPromo()" type="checkbox" name="tilbudkampagne" id="tilbudkampagne" value="<?php echo esc_attr(get_the_author_meta('tilbudkampagne', $user->ID)); ?>" class="switch-input regular-text"/>
															<span class="slider round"></span>
														</label>
													</div>

													<div class="rz-repeater rz-repeater-collect rz-none rz-col-12" id="promotion">

															<textarea type="text" class="rz-repeater-value rz-none" name="rz_price_seasonal"></textarea>

															<div class="rz-repeater-content rz-grid">
																<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-relative rz-mt-2" data-type="text" data-storage="field" data-disabled="no" data-heading="Start Date" data-id="start">


																	<input type="text" name="start_discount" class="" placeholder=" ">
																	<label class="">
																		Startdato (DD/MM)
																		<i class="rz-required"></i>
																	</label>
																</div>
																<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-relative" data-type="text" data-storage="field" data-disabled="no" data-heading="End Date" data-id="end">
																	<input type="text" name="end_discount" class="" placeholder=" ">
																	<label class="">
																		Udløbsdato DD/MM
																		<i class="rz-required"></i>
																	</label>
																</div>
																<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-relative" data-type="text" data-storage="field" data-disabled="no" data-heading="End Date" data-id="end">
																	<input type="text" name="end_discount" class="" placeholder=" ">
																	<label class="">
																		Tidsrum (lad denne være blank for heldagstilbud)
																		<i class="rz-required"></i>
																	</label>
																</div>
																<div class="rz-form-group form-group form-group_space-between rz-col-12" data-input-type="number" data-type="number" data-storage="field" data-disabled="no" data-heading="Base Price" data-id="price">
																	<div class="">
																		<label class="">
																			Tilbudspris
																			<i class="rz-required"></i>
																		</label>
																	</div>

																	<div class="rz-number-type-number form-group_input-min-number" data-type="number">

																		<input type="number" name="price_discount" placeholder="0" min="0" step="0.01" data-format="<strong>%s</strong>">

																	</div>
																</div>
																
															</div>
														</div>

														<div class="rz-form-group rz-field rz-col-12 rz-relative rz-field-ready rz-mt-2" data-type="textarea" data-storage="request" data-disabled="no" data-heading="Beskrivelse af behandlingen*" data-id="post_content">
															<textarea maxlength="150" type="text" name="post_content" class="text-limit-150"></textarea>
															<label class="">
															Beskrivelse af behandlingen*
															<i class="rz-required"></i>
															</label>
															<p class="text-limit-result">392/600</p>
															
														</div>
													</div>
												</section>
											</form>
										<!-- END MODAl CONTENT -->
										</div>
										<div class="rz-modal-footer rz--top-border btn-group">
											<a href="#" class="rz-close rz-modal-button rz-mr-2 btn btn-line-dark"><span>Annuler</span></a>

											<input type="submit" value="Gem" class="rz-modal-button btn btn-accent"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</div>			
	</div>
	<div class="bg-white rz-mt-3 rz-p-3 tab-content_style">
		<h3>Specialeområde(r)</h3>
		<p>Hvis du specialiserer dig inden for en bestemt behandlingsmetode eller målgruppe, kan du skrive det ind her.</p>
		 <!-- <input type="text" name="doctor-type" value="<?php echo esc_attr(get_the_author_meta('rz_doctor-type', get_current_user_id())); ?>" class="regular-text icon-search" placeholder="Doctor-type*"/>  -->
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
				
        <td>
            <select name="doctor-type" id="" class="regular-text" multiple>
                <?php 

                foreach ($options as $option){?>
                     <option value="<?php echo $option->name; ?>" 
                     <?php echo ( in_array($option->name, $doctor_options)) ? "selected" : ""; ?>>
                     <?php echo $option->name; ?></option>

                 <?php 
                 }
                ?>
            </select>
        </td>
			<!-- End dropdown  -->

		<div class="cheeps-box-container">
			<div class="cheeps-box">
				<button class="cheeps-box__btn" type="button" data-name="Androlog">Androlog</button>	<button class="cheeps-box__btn" type="button" data-name="Sexopatolog">Sexopatolog</button>		
				<button class="cheeps-box__btn" type="button" data-name="Androlog">Androlog</button>	<button class="cheeps-box__btn" type="button" data-name="Sexopatolog">Sexopatolog</button>		
				<button class="cheeps-box__btn" type="button" data-name="Sexolog">Sexolog</button>	<button class="cheeps-box__btn" type="button" data-name="Sexopatolog">Sexopatolog</button>		
				<button class="cheeps-box__btn" type="button" data-name="Sexolog">Sexolog</button>

				<button class="cheeps-box__btn_clear" type="clear">Ryd Alt</button>
			</div>
		</div>
	</div>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Ydelser og Symptombehandling</h3>
		<p>Her kan du definere hvilke specifikke typer ydelser du tilbyder. Du kan også skrive hvilke symptomer dine behandlinger kan afhjælpe.</p>
		<input type="text" name="symptom" value="<?php echo esc_attr(get_the_author_meta('symptom', get_current_user_id())); ?>" class="regular-text icon-search" placeholder="Søg"/>
		<div class="cheeps-box-container">
			<div class="cheeps-box">
				<button class="cheeps-box__btn" type="button" data-name="Stress">Stress</button>	<button class="cheeps-box__btn" type="button" data-name="Nakkesmerter">Nakkesmerter</button>		
				<button class="cheeps-box__btn" type="button" data-name="Uro i kroppen">Uro i kroppen</button>	<button class="cheeps-box__btn" type="button" data-name="Sexopatolog">Sexopatolog</button>		
				<button class="cheeps-box__btn" type="button" data-name="Livssyn">Livssyn</button>	

				<button class="cheeps-box__btn_clear" type="clear">Ryd Alt</button>
			</div>
		</div>			
	</div>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Notifikationer og Bero</h3>
		<p>I dette afsnit kan du ændre brugerindstillinger</p>
		<div class="toggle tab-content_style__toggle">
			<label for="send_notif" class="switch">
				Send notifikationer
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="send_notif" id="send_notif" value="<?php echo esc_attr(get_the_author_meta('send_notif', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>
		<div class="toggle tab-content_style__toggle">
			<label for="receive_notif" class="switch">
				Modtag notifikationer
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="receive_notif" id="receive_notif" value="<?php echo esc_attr(get_the_author_meta('receive_notif', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>
		<div class="toggle tab-content_style__toggle">
			<label for="hold_profile" class="switch">
				Sæt profil i bero
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="hold_profile" id="hold_profile" value="1" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
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
		<h3>Certifikater, kurser og erfaring</h3>
		
		<div class="toggle tab-content_style__toggle">
			<label for="erdurabgodkendt" class="switch">
				Er du RAB Godkendt?
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="erdurabgodkendt" id="erdurabgodkendt" value="<?php echo esc_attr(get_the_author_meta('erdurabgodkendt', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>
		<div class="toggle tab-content_style__toggle">
			<label for="erdumedlemafsygesikringdanmark" class="switch">
				Er du medlem af Sygesikring Danmark?
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="erdumedlemafsygesikringdanmark" id="erdumedlemafsygesikringdanmark" value="<?php echo esc_attr(get_the_author_meta('erdumedlemafsygesikringdanmark', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>

		<br>
		
		<div class="tab-content_style__presentation-input">
			<div class="tab-content_style__presentation-input-content">
				<div class="tab-content_style__presentation-input-text">
					<span class="tab-content_style__presentation-input-name">Den Danske Akupunktørskole</span> <span class="tab-content_style__presentation-input-year">(2001)</span>
				</div>

				<div class="tab-content_style__presentation-input-btn-group">
					<button type="button" class="tab-content_style__presentation-input-btn_edit">Edit</button>
					<button type="button" class="tab-content_style__presentation-input-btn_delete">Delete</button>
				</div>
			</div>	
		</div>
		<?php $cert = get_post_meta($listingID, 'rz_certificates');
		print_r( json_decode($cert[0]));
		?>
		 <div id="certificate-test"></div>
		<button class="rz-button rz-button-accent" data-modal="modal_certificate">Tilføj nyt certifikat</button>
	</div>

	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Student section</h3>
		
		<div class="toggle tab-content_style__toggle">
			<label for="tilbyderduonlinebooking" class="switch">
				Tilbyder du online booking?
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="tilbyderduonlinebooking" id="tilbyderduonlinebooking" value="<?php echo esc_attr(get_the_author_meta('tilbyderduonlinebooking', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>
		<div class="toggle tab-content_style__toggle">
			<label for="erdustudende" class="switch">
				Er du studerende?
				<input onclick="$(this).attr('value', this.checked ? 1 : 0)" type="checkbox" name="erdustudende" id="erdustudende" value="<?php echo esc_attr(get_the_author_meta('erdustudende', $user->ID)); ?>" class="switch-input regular-text"/>
				<span class="slider round"></span>
			</label>
		</div>

		<br>
		
		<form action="">
			<p class="input-box">
				<input type="text" id="hvilkenskole" value="" require>
				<label for="hvilkenskole">Hvilken skole studererer du på?<span style="color: #F55951;">*</span></label>
			</p>

			<p class="input-box">
				<input type="text" id="hvilkenskole" value="" require>
				<label for="hvilkenskole">Hvornår er din uddannelse færdig?<span style="color: #F55951;">*</span></label>
			</p>
		</form>

		<button class="rz-button rz-button-accent">Tilføj nyt certifikat</button>
	</div>

	<div class="delete-profil">
		<a href="#" class="delete-profil-link">Luk profil permanent</a>
	</div>
</div>

<div id="Betalingsindstillinger" class="tab-content">
	<div class="bg-white rz-p-3 tab-content_style">
		<span>Din nuværende profil er</span>
		<h3>Kommissionbaseret betaling</h3>
		<p>Lorem Ipsum er ganske enkelt fyldtekst fra print- og typografiindustrien. Lorem Ipsum har været standard fyldtekst siden 1500-tallet</p>

		<div class="mulige">
			<div class="mulige__header">
				Mulige profiler
			</div>
			<div class="mulige__item mulige__item_accent">
				<div class="mulige__content">
					<div class="mulige__title">Kommissionsbaseret</div>
					<a href="#" class="mulige__link">Læs mere</a>
				</div>

				<div class="mulige__btn">
					<button class="rz-button btn-red-line">Nuværende profil</button>
				</div>
			</div>
			<div class="mulige__container">
				<div class="mulige__item">
					<div class="mulige__content">
						<div class="mulige__title">Abonnementsbaseret</div>
						<a href="#" class="mulige__link">Læs mere</a>
					</div>

					<div class="mulige__btn">
						<button class="rz-button btn-red-line">Skift til</button>
					</div>
				</div>
				<div class="mulige__item">
					<div class="mulige__content">
						<div class="mulige__title">Gratis</div>
						<a href="#" class="mulige__link">Læs mere</a>
					</div>

					<div class="mulige__btn">
						<button class="rz-button btn-red-line">Skift til</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Betalingsmetode</h3>
		<p>Lorem Ipsum er ganske enkelt fyldtekst fra print- og typografiindustrien. Lorem Ipsum har været standard fyldtekst siden 1500-tallet</p>

		<button class="rz-button rz-button-accent">Tilføj ny metode</button>
	</div>

	<div class="bg-white rz-p-3 rz-mt-3 tab-content_style">
		<h3>Tilbudskode</h3>
		<p>Del din referencekode med behandlere der ikke er på vores platform endnu. For hver behandler der accepterer din invitation, får du én måneds gratis abonnement.</p>

		
	</div>
</div>

<div id="Galleri" class="tab-content">
<div class="bg-white rz-p-3 tab-content_style">
		<h3>Galleri</h3>

		<div class="tab-content_style-cards rz-mb-3">
			<div class="tab-content_style-cards__item">
				<?php include (get_stylesheet_directory().'/page-add-listing.php'); ?>
			</div>
			<div class="tab-content_style-cards__item">
				<?php include (get_stylesheet_directory().'/page-add-listing.php'); ?>
			</div>
			<div class="tab-content_style-cards__item">
				<?php include (get_stylesheet_directory().'/page-add-listing.php'); ?>
			</div>
			<div class="tab-content_style-cards__item">
				<?php include (get_stylesheet_directory().'/page-add-listing.php'); ?>
			</div>
			<div class="tab-content_style-cards__item">
				<?php include (get_stylesheet_directory().'/page-add-listing.php'); ?>
			</div>			
		</div>
	</div>
</div>
<script>
var $gal_id = document.querySelector('#rz_main_photo_id');
var el = document.querySelector('#main_photo');

const config = {
    childList: true
};
	const callback = function(mutationsList, observer) {
    for (let mutation of mutationsList) {
			
        if (mutation.type === 'childList') {
					
            var $picId = [];
            $images_data = document.querySelectorAll('#main_photo>.rz-image-prv-wrapper');
						
            var i;
            for (var i = 0; i < $images_data.length; i++){
                var $id = $images_data[i].getAttribute("data-id");   
                $picId.push( $id);
            }
             $gal_id.value = $picId; 
        } 
    }
};

const observer = new MutationObserver(callback);
observer.observe(el, config);
</script>