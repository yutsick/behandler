<?php 
								global $wp;
							
							?>
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
													<input type="hidden" name="location" value="<?php 	echo home_url( $wp->request ); ?>" />
													<div class="rz-grid">
													<div class="rz-form-group rz-field rz-col-12 rz-relative rz-field-ready" data-type="text" data-storage="request" data-disabled="no" data-heading="Navn på behandlingen*" data-id="doctors-name">
														<input type="text" name="rz_doctors-name" id="rz_doctors-name" value="" class="" placeholder=" "/>
														<label for="rz_doctors-name" class="">
														Navn på behandlingen*
														<i class="rz-required"></i>
														</label>
													</div>

													<div class="rz-form-group rz-field rz-col-12" data-multiple="true" data-upload-type="image" data-type="upload" data-storage="request" data-disabled="no" data-heading="Upload gallery" data-id="gallery">
														<div class="rz-upload">
															<!-- button -->
															<label for="rz-upload-rz_gallery" class="rz-flex">
																	<div class="add-listing">
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
															<div class="rz-field-info">
																<span>Maximum upload file size: 50 MB.</span>
																<span>Drag to reorder.</span>
															</div>
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
													
													<?php /** Tilbud kampagne. Please uncomment to process 
													 * 
													 
														*		<div class="toggle rz-w-100 tab-content_style__toggle rz-col-12 rz-none">
														*			<label for="tilbudkampagne" class="switch">
														*				Tilbud/Kampagne
														*				<input onclick="$(this).attr('value', this.checked ? 1 : 0);showPromo()" type="checkbox" name="tilbudkampagne" id="tilbudkampagne" value="<?php echo esc_attr(get_the_author_meta('tilbudkampagne', $user->ID)); ?>" class="switch-input regular-text"/>
														*				<span class="slider round"></span>
														*			</label>
														*		</div>
														*/
													?>

													<div class="rz-repeater rz-repeater-collect rz-none rz-col-12" id="promotion">

															<textarea type="text" class="rz-repeater-value rz-none" name="rz_price_seasonal"></textarea>

															<div class="rz-repeater-content rz-grid">
																<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-relative rz-mt-2" data-type="text" data-storage="field" data-disabled="no" data-heading="Start Date" data-id="start">


																	<input type="text" name="start_discount" id="start_discount" class="" placeholder=" ">
																	<label for="start_discount" class="">
																		Startdato (DD/MM)
																		<i class="rz-required"></i>
																	</label>
																</div>
																<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-relative" data-type="text" data-storage="field" data-disabled="no" data-heading="End Date" data-id="end">
																	<input type="text" name="end_discount" id="end_discount2" class="" placeholder=" ">
																	<label for="end_discount2" class="">
																		Udløbsdato DD/MM
																		<i class="rz-required"></i>
																	</label>
																</div>
																<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-relative" data-type="text" data-storage="field" data-disabled="no" data-heading="End Date" data-id="end">
																	<input type="text" name="end_discount" id="end_discount" class="" placeholder=" ">
																	<label for="end_discount" class="">
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

														<div class="rz-field rz-col-12 rz-relative" data-type="text" data-storage="request" data-disabled="no" data-heading="Specialeområde(r)*" data-id="doctor-type">
															<input type="text" name="rz_doctor-type" id="rz_doctor-type" value=""  class="" placeholder=" ">
															<label for="rz_doctor-type" class="">
																Specialeområde(r)*
																<i class="rz-required"></i>
															</label>
														</div>

														<div class="rz-field rz-col-12 rz-relative rz-field-ready rz-mt-2" data-type="textarea" data-storage="request" data-disabled="no" data-heading="Beskrivelse af behandlingen*" data-id="post_content">
															<textarea id="post_content2" maxlength="150" type="text" name="post_content" class="text-limit-150" placeholder=" "></textarea>
															<label for="post_content2" class="">
															Beskrivelse af behandlingen*
															<i class="rz-required"></i>
															</label>
															<p class="text-limit-result">392/600</p>
															
														</div>
													</div>

													<div class="rz-grid">
														<div class="rz-form-group rz-field rz-col-12 rz-none" data-type="checkbox" data-storage="request" data-disabled="no" data-heading="Allow instant booking" data-id="instant">
															<input type='hidden' name="rz_instant" value="1">
														</div>
														<div class="rz-field rz-col-12" data-type="repeater" data-storage="request" data-disabled="no" data-heading="Add Availability" data-id="time_availability">
															<div class="rz-heading">
															Add Availability
															</div>


															<div class="rz-repeater  rz-repeater-collect ">

																<textarea type="text" class="rz-repeater-value rz-none" name="rz_time_availability"></textarea>

																<input type="hidden" class="rz-repeater-schema" value="{&quot;period&quot;:{&quot;name&quot;:&quot;Period&quot;,&quot;heading&quot;:&quot;name&quot;,&quot;fields&quot;:{&quot;name&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;name&quot;:&quot;Name&quot;,&quot;value&quot;:&quot;Custom Period&quot;,&quot;col&quot;:6},&quot;key&quot;:{&quot;type&quot;:&quot;key&quot;,&quot;name&quot;:&quot;Unique ID&quot;,&quot;value&quot;:&quot;custom-period&quot;,&quot;defined&quot;:false,&quot;col&quot;:6},&quot;start_time&quot;:{&quot;type&quot;:&quot;select&quot;,&quot;name&quot;:&quot;Start Time&quot;,&quot;options&quot;:{&quot;0&quot;:&quot;12:01 am&quot;,&quot;3600&quot;:&quot;1:00 am&quot;,&quot;7200&quot;:&quot;2:00 am&quot;,&quot;10800&quot;:&quot;3:00 am&quot;,&quot;14400&quot;:&quot;4:00 am&quot;,&quot;18000&quot;:&quot;5:00 am&quot;,&quot;21600&quot;:&quot;6:00 am&quot;,&quot;25200&quot;:&quot;7:00 am&quot;,&quot;28800&quot;:&quot;8:00 am&quot;,&quot;32400&quot;:&quot;9:00 am&quot;,&quot;36000&quot;:&quot;10:00 am&quot;,&quot;39600&quot;:&quot;11:00 am&quot;,&quot;43200&quot;:&quot;12:00 pm&quot;,&quot;46800&quot;:&quot;1:00 pm&quot;,&quot;50400&quot;:&quot;2:00 pm&quot;,&quot;54000&quot;:&quot;3:00 pm&quot;,&quot;57600&quot;:&quot;4:00 pm&quot;,&quot;61200&quot;:&quot;5:00 pm&quot;,&quot;64800&quot;:&quot;6:00 pm&quot;,&quot;68400&quot;:&quot;7:00 pm&quot;,&quot;72000&quot;:&quot;8:00 pm&quot;,&quot;75600&quot;:&quot;9:00 pm&quot;,&quot;79200&quot;:&quot;10:00 pm&quot;,&quot;82800&quot;:&quot;11:00 pm&quot;,&quot;86400&quot;:&quot;12:00 am&quot;},&quot;value&quot;:28800,&quot;allow_empty&quot;:false,&quot;col&quot;:6},&quot;end_time&quot;:{&quot;type&quot;:&quot;select&quot;,&quot;name&quot;:&quot;End Time&quot;,&quot;options&quot;:{&quot;0&quot;:&quot;12:01 am&quot;,&quot;3600&quot;:&quot;1:00 am&quot;,&quot;7200&quot;:&quot;2:00 am&quot;,&quot;10800&quot;:&quot;3:00 am&quot;,&quot;14400&quot;:&quot;4:00 am&quot;,&quot;18000&quot;:&quot;5:00 am&quot;,&quot;21600&quot;:&quot;6:00 am&quot;,&quot;25200&quot;:&quot;7:00 am&quot;,&quot;28800&quot;:&quot;8:00 am&quot;,&quot;32400&quot;:&quot;9:00 am&quot;,&quot;36000&quot;:&quot;10:00 am&quot;,&quot;39600&quot;:&quot;11:00 am&quot;,&quot;43200&quot;:&quot;12:00 pm&quot;,&quot;46800&quot;:&quot;1:00 pm&quot;,&quot;50400&quot;:&quot;2:00 pm&quot;,&quot;54000&quot;:&quot;3:00 pm&quot;,&quot;57600&quot;:&quot;4:00 pm&quot;,&quot;61200&quot;:&quot;5:00 pm&quot;,&quot;64800&quot;:&quot;6:00 pm&quot;,&quot;68400&quot;:&quot;7:00 pm&quot;,&quot;72000&quot;:&quot;8:00 pm&quot;,&quot;75600&quot;:&quot;9:00 pm&quot;,&quot;79200&quot;:&quot;10:00 pm&quot;,&quot;82800&quot;:&quot;11:00 pm&quot;,&quot;86400&quot;:&quot;12:00 am&quot;},&quot;value&quot;:64800,&quot;allow_empty&quot;:false,&quot;col&quot;:6},&quot;duration&quot;:{&quot;type&quot;:&quot;select&quot;,&quot;name&quot;:&quot;Appointment Duration&quot;,&quot;options&quot;:{&quot;1800&quot;:&quot;30m&quot;,&quot;2700&quot;:&quot;45m&quot;,&quot;3600&quot;:&quot;60m&quot;,&quot;5400&quot;:&quot;90m&quot;,&quot;7200&quot;:&quot;120m&quot;,&quot;custom&quot;:&quot;Custom&quot;},&quot;value&quot;:&quot;60m&quot;,&quot;allow_empty&quot;:false,&quot;style&quot;:&quot;v2&quot;},&quot;custom_duration_length&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;name&quot;:&quot;Custom Appointment Duration Lenght&quot;,&quot;dependency&quot;:{&quot;id&quot;:&quot;duration&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;},&quot;col&quot;:6},&quot;custom_duration_entity&quot;:{&quot;type&quot;:&quot;select&quot;,&quot;name&quot;:&quot;Custom Appointment Duration Entity&quot;,&quot;options&quot;:{&quot;60&quot;:&quot;Minutes&quot;,&quot;3600&quot;:&quot;Hours&quot;,&quot;86400&quot;:&quot;Days&quot;},&quot;value&quot;:&quot;m&quot;,&quot;allow_empty&quot;:false,&quot;dependency&quot;:{&quot;id&quot;:&quot;duration&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;},&quot;col&quot;:6},&quot;interval&quot;:{&quot;type&quot;:&quot;select&quot;,&quot;name&quot;:&quot;Time Between Appointment&quot;,&quot;options&quot;:{&quot;none&quot;:&quot;None&quot;,&quot;300&quot;:&quot;5m&quot;,&quot;600&quot;:&quot;10m&quot;,&quot;custom&quot;:&quot;Custom&quot;},&quot;value&quot;:&quot;none&quot;,&quot;allow_empty&quot;:false,&quot;style&quot;:&quot;v2&quot;},&quot;custom_interval_length&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;name&quot;:&quot;Custom Time Between Appointment Lenght&quot;,&quot;dependency&quot;:{&quot;id&quot;:&quot;interval&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;},&quot;col&quot;:6},&quot;custom_interval_entity&quot;:{&quot;type&quot;:&quot;select&quot;,&quot;name&quot;:&quot;Custom Time Between Appointment Entity&quot;,&quot;options&quot;:{&quot;60&quot;:&quot;Minutes&quot;,&quot;3600&quot;:&quot;Hours&quot;,&quot;86400&quot;:&quot;Days&quot;},&quot;value&quot;:&quot;m&quot;,&quot;allow_empty&quot;:false,&quot;dependency&quot;:{&quot;id&quot;:&quot;interval&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;},&quot;col&quot;:6},&quot;recurring&quot;:{&quot;type&quot;:&quot;checkbox&quot;,&quot;name&quot;:&quot;Recurring Period&quot;},&quot;start&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;name&quot;:&quot;Start Date&quot;,&quot;placeholder&quot;:&quot;YYYY-MM-DD&quot;,&quot;col&quot;:6,&quot;dependency&quot;:{&quot;id&quot;:&quot;recurring&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:false}},&quot;end&quot;:{&quot;type&quot;:&quot;text&quot;,&quot;name&quot;:&quot;End Date&quot;,&quot;placeholder&quot;:&quot;YYYY-MM-DD&quot;,&quot;col&quot;:6,&quot;dependency&quot;:{&quot;id&quot;:&quot;recurring&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:false}},&quot;recurring_availability&quot;:{&quot;type&quot;:&quot;checklist&quot;,&quot;name&quot;:&quot;Repeat Availability&quot;,&quot;options&quot;:{&quot;1&quot;:&quot;Monday&quot;,&quot;2&quot;:&quot;Tuesday&quot;,&quot;3&quot;:&quot;Wednesday&quot;,&quot;4&quot;:&quot;Thursday&quot;,&quot;5&quot;:&quot;Friday&quot;,&quot;6&quot;:&quot;Saturday&quot;,&quot;7&quot;:&quot;Sunday&quot;},&quot;dependency&quot;:{&quot;id&quot;:&quot;recurring&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:true}},&quot;price&quot;:{&quot;type&quot;:&quot;number&quot;,&quot;name&quot;:&quot;Custom Price&quot;,&quot;description&quot;:&quot;Leave empty if you want to use the base price&quot;,&quot;min&quot;:0,&quot;step&quot;:0.01,&quot;col&quot;:6},&quot;price_weekend&quot;:{&quot;type&quot;:&quot;number&quot;,&quot;name&quot;:&quot;Custom Weekend Price&quot;,&quot;description&quot;:&quot;Leave empty if you want to use the base weekend price&quot;,&quot;min&quot;:0,&quot;step&quot;:0.01,&quot;col&quot;:6},&quot;limit&quot;:{&quot;type&quot;:&quot;number&quot;,&quot;name&quot;:&quot;Limit Guests&quot;,&quot;description&quot;:&quot;Number only. Leave empty for unlimited.&quot;,&quot;min&quot;:0,&quot;step&quot;:1}}}}">

																<div class="rz-repeater-content rz-grid">
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none" data-type="text" data-storage="field" data-disabled="no" data-heading="Name" data-id="name">
																		<div class="rz-heading">
																			Name
																		</div>

																		<input type="text" name="name" value="Custom Period" placeholder="" class="" form="&quot;fake-form-readonly&quot;">
																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none" data-type="key" data-storage="field" data-disabled="no" data-heading="Unique ID" data-id="key">
																		<div class="rz-heading">
																			Unique ID
																		</div>

																		<div class="rz-input-group rz-input-group-custom">
																			<div class="rz-flex">
																				<input type="text" value="custom-period" placeholder="">

																			</div>
																		</div>


																		<input type="hidden" name="key" value="custom-period" form="&quot;fake-form-readonly&quot;">
																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready" data-type="select" data-storage="field" data-disabled="no" data-heading="Start Time" data-id="start_time">

																		<div class="rz-select rz-select-single rz-relative">
																			<select name="start_time" class="" id="start_time">
																				<option value="0">12:01 am</option>
																				<option value="3600">1:00 am</option>
																				<option value="7200">2:00 am</option>
																				<option value="10800">3:00 am</option>
																				<option value="14400">4:00 am</option>
																				<option value="18000">5:00 am</option>
																				<option value="21600">6:00 am</option>
																				<option value="25200">7:00 am</option>
																				<option value="28800" selected>8:00 am</option>
																				<option value="32400">9:00 am</option>
																				<option value="36000">10:00 am</option>
																				<option value="39600">11:00 am</option>
																				<option value="43200">12:00 pm</option>
																				<option value="46800">1:00 pm</option>
																				<option value="50400">2:00 pm</option>
																				<option value="54000">3:00 pm</option>
																				<option value="57600">4:00 pm</option>
																				<option value="61200">5:00 pm</option>
																				<option value="64800">6:00 pm</option>
																				<option value="68400">7:00 pm</option>
																				<option value="72000">8:00 pm</option>
																				<option value="75600">9:00 pm</option>
																				<option value="79200">10:00 pm</option>
																				<option value="82800">11:00 pm</option>
																				<option value="86400">12:00 am</option>
																			</select>
																			<label for="start_time" class="">
																				Start Time
																			</label>
																		</div>

																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12  rz-field-ready" data-type="select" data-storage="field" data-disabled="no" data-heading="End Time" data-id="end_time">
																		
																		

																		<div class="rz-select rz-select-single rz-relative">
																			<select name="end_time" id="end_time"  class="">
																				<option value="0">12:01 am</option>
																				<option value="3600">1:00 am</option>
																				<option value="7200">2:00 am</option>
																				<option value="10800">3:00 am</option>
																				<option value="14400">4:00 am</option>
																				<option value="18000">5:00 am</option>
																				<option value="21600">6:00 am</option>
																				<option value="25200">7:00 am</option>
																				<option value="28800">8:00 am</option>
																				<option value="32400">9:00 am</option>
																				<option value="36000">10:00 am</option>
																				<option value="39600">11:00 am</option>
																				<option value="43200">12:00 pm</option>
																				<option value="46800">1:00 pm</option>
																				<option value="50400">2:00 pm</option>
																				<option value="54000">3:00 pm</option>
																				<option value="57600">4:00 pm</option>
																				<option value="61200">5:00 pm</option>
																				<option value="64800" selected>6:00 pm</option>
																				<option value="68400">7:00 pm</option>
																				<option value="72000">8:00 pm</option>
																				<option value="75600">9:00 pm</option>
																				<option value="79200">10:00 pm</option>
																				<option value="82800">11:00 pm</option>
																				<option value="86400">12:00 am</option>
																			</select>
																			<label for="end_time" class="">
																				End Time
																			</label>
																		</div>

																	</div>
																	<div class="rz-form-group rz-field rz-col-12 rz-field-ready" data-type="select" data-storage="field" data-disabled="no" data-heading="Appointment Duration" data-id="duration">
																		
																		<div class="rz-select rz-select-single rz-relative">
																			<select name="duration" id="duration" class="">
																				<option value="1800" selected>30m</option>
																				<option value="2700" >45m</option>
																				<option value="3600">60m</option>
																				<option value="5400">90m</option>
																				<option value="7200">120m</option>
																				<!--<option value="custom">Custom</option>-->
																			</select>
																			<label for="duration" class="">
																				Appointment Duration
																			</label>
																		</div>

																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none rz-no-pointer rz-relative" data-dependency="{&quot;id&quot;:&quot;duration&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;}" data-type="text" data-storage="field" data-disabled="no" data-heading="Custom Appointment Duration Lenght" data-id="custom_duration_length">
																		<input type="text" name="custom_duration_length" id="custom_duration_length" value="" placeholder=" " class="">
																		<label for="custom_duration_length" class="">
																				Custom Appointment Duration Lenght
																		</label>
																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none rz-no-pointer" data-dependency="{&quot;id&quot;:&quot;duration&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;}" data-type="select" data-storage="field" data-disabled="no" data-heading="Custom Appointment Duration Entity" data-id="custom_duration_entity">
																
																		<div class="rz-select rz-select-single rz-relative">
																			<select name="custom_duration_entity" id="custom_duration_entity"  class="">
																				<option value="60">Minutes</option>
																				<option value="3600">Hours</option>
																				<option value="86400">Days</option>
																			</select>
																			<label for="custom_duration_entity" class="">
																				Custom Appointment Duration Entity
																			</label>
																		</div>
																		

																	</div>
																	<div class="rz-form-group rz-field rz-col-12 rz-field-ready" data-type="select" data-storage="field" data-disabled="no" data-heading="Time Between Appointment" data-id="interval">
																		<div class="rz-select rz-select-single rz-relative">
																			<select name="interval" id="interval" class="">
																				<option value="300">5m</option>
																				<option value="600">10m</option>
																				<option value="none" selected="">None</option>
																				<!--<option value="custom">Custom</option>-->
																			</select>
																			<label for="interval" class="">
																				Time Between Appointment
																			</label>
																		</div>

																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none rz-no-pointer rz-relative" data-dependency="{&quot;id&quot;:&quot;interval&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;}" data-type="text" data-storage="field" data-disabled="no" data-heading="Custom Time Between Appointment Lenght" data-id="custom_interval_length">

																		<input type="text" name="custom_interval_length" id="custom_interval_length" value="" placeholder=" " class="" >
																		<label for="custom_interval_length" class="">
																				Custom Time Between Appointment Lenght
																		</label>
																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none rz-no-pointer" data-dependency="{&quot;id&quot;:&quot;interval&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:&quot;custom&quot;}" data-type="select" data-storage="field" data-disabled="no" data-heading="Custom Time Between Appointment Entity" data-id="custom_interval_entity">
																		
																		<div class="rz-select rz-select-single rz-relative">
																			<select name="custom_interval_entity" id="custom_interval_entity"  class="">
																				<option value="60">Minutes</option>
																				<option value="3600">Hours</option>
																				<option value="86400">Days</option>
																			</select>
																			<label for="custom_interval_entity" class="">
																				Custom Time Between Appointment Entity
																			</label>
																		</div>

																	</div>
																	<div class="rz-form-group rz-field rz-col-12 rz-field-ready rz-none" data-type="checkbox" data-storage="field" data-disabled="no" data-heading="Recurring Period" data-id="recurring">
																		<div class="rz-heading">
																			Recurring Period
																		</div>

																		<label class="rz-checkbox rz-no-select">
																			<input type="checkbox" value="1" checked>
																			<span class="rz-transition"></span>
																			<em>Yes</em>
																		</label>

																		<input type="hidden" name="recurring" value="1">
																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none rz-no-pointer" data-dependency="{&quot;id&quot;:&quot;recurring&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:false}" data-type="text" data-storage="field" data-disabled="no" data-heading="Start Date" data-id="start">
																		<div class="rz-heading">
																			Start Date
																		</div>

																		<input type="text" name="start" value="" placeholder="YYYY-MM-DD" class="" >
																	</div>
																	<div class="rz-form-group rz-field rz-col-6 rz-col-sm-12 rz-field-ready rz-none rz-no-pointer" data-dependency="{&quot;id&quot;:&quot;recurring&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:false}" data-type="text" data-storage="field" data-disabled="no" data-heading="End Date" data-id="end">
																		<div class="rz-heading">
																			End Date
																		</div>

																		<input type="text" name="end" value="" placeholder="YYYY-MM-DD" class="" >
																	</div>
																	<div class="rz-field rz-col-12 rz-field-ready" data-dependency="{&quot;id&quot;:&quot;recurring&quot;,&quot;compare&quot;:&quot;=&quot;,&quot;value&quot;:true}" data-type="checklist" data-storage="field" data-disabled="no" data-heading="Repeat Availability" data-id="recurring_availability">
																		<div class="rz-heading">
																			Repeat Availability
																		</div>

																		<div class="rz-checklist">
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="1">
																				<span class="rz-transition"></span>
																				<em>Monday</em>
																			</label>
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="2">
																				<span class="rz-transition"></span>
																				<em>Tuesday</em>
																			</label>
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="3">
																				<span class="rz-transition"></span>
																				<em>Wednesday</em>
																			</label>
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="4">
																				<span class="rz-transition"></span>
																				<em>Thursday</em>
																			</label>
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="5">
																				<span class="rz-transition"></span>
																				<em>Friday</em>
																			</label>
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="6">
																				<span class="rz-transition"></span>
																				<em>Saturday</em>
																			</label>
																			<label class="rz-checkbox rz-no-select">
																				<input type="checkbox" name="recurring_availability[]" value="7">
																				<span class="rz-transition"></span>
																				<em>Sunday</em>
																			</label>
																		</div>

																		<input name="recurring_availability[]" type="hidden" value="" disabled="">
																	</div>
																
																</div>
																
															</div>

														</div>
														<div class="rz-modal-footer rz--top-border btn-group">
															<a href="#" class="rz-close rz-modal-button rz-mr-2 btn btn-line-dark"><span>Annuler</span></a>

															<input type="submit" value="Gem" class="rz-modal-button btn btn-accent"/>
														</div>

													</div>
												</section>
											</form>
										<!-- END MODAl CONTENT -->
										</div>
										
									</div>
								</div>
							</div>