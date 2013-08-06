<?php
/*
Template Name: Homepage Show Element Form
*/
?>

<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="post_content">
										
									<?php 
									
										$user_id = $current_user->ID;
										
										if (isset($_SESSION['project_id'])){
											$project_id = $_SESSION['project_id'];
										} else {
											$project_id = $_POST['project_id'];
										}
										
										if (isset($_SESSION['project_name'])){
											$project_name = $_SESSION['project_name'];
										} else {
											$project_name = $_POST['project_name'];
										}
										
										$results = $wpdb->get_results( "SELECT * FROM wp_gl_cat ", ARRAY_A );
										$delivs = $wpdb->get_results($wpdb->prepare( "SELECT * FROM wp_gl_rr_del ORDER BY rr_del_name ASC",	ARRAY_A	));
									?>
										<form class="span2" action="<?php echo $site_url; ?>/show-element-list/" method="post">
											<input type="submit" class="btn btn-small" value="Return to Element List">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
										</form>
										<br />
										<br />
										<h3>Create a new element</h3>
										<h4><?php echo stripslashes($project_name); ?></h4>
										
										<div class="element-container">
											<form class="form-horizontal" id="element_form" action="<?php echo $site_url; ?>/save-element/" method="post" style="margin-top: 25px">
												<div class="control_group row">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="element_name" style="margin-right: 5px">Element name:  </label>
														<div class="controls">
															<input required type="text" class="span6" name="element_name" id="element_name">
														</div>
													</div>
												</div>
												<div class="control_group row" style="margin-bottom: 5px">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="element_desc" style="margin-right: 5px">Element description:  </label>
														<div class="controls">
															<textarea id="description" class="span6" name="element_desc" rows="4"></textarea>
														</div>
													</div>
												</div>
												<div class="control_group row">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="element_del" style="margin-right: 5px">Deliverable type:  </label>
														<div class="controls">
															<select required id="element_del" name="element_del">
																<option value="">Please select</option>
																<?php
																	foreach ($delivs as $deliv){
																	?> 
																		<option class="element_del" id="element_del_<?php echo $deliv->rr_del_id; ?>" value="<?php echo $deliv->rr_del_id; ?>"><?php echo $deliv->rr_del_name; ?></option>
																	<?php
																	}
																?>
															</select>
														</div>
													</div>
												</div>
												<div id="default-container">
													<div class="control_group row hidden" id="specific_allocation_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="spec_alloc" style="margin-right: 5px">Specific allocation:  </label>
															<div class="controls">
																<input type="text" id="spec_alloc" name="spec_alloc" />
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="element_sep_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="element_sep" style="margin-right: 5px">Separable?  </label>
															<div class="controls">
																<select required class="default" id="element_sep" name="element_sep">
																	<option value="">Please Select</option>
																	<option value="Yes">Yes</option>
																	<option value="No">No</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="selling_price_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="selling_price" style="margin-right: 5px">Selling Price:  </label>
															<div class="controls">
																<input required class="default" type="text" id="selling_price" name="selling_price" />
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="selling_basis_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="selling_basis" style="margin-right: 5px">Basis for determining selling price:  </label>
															<div class="controls">
																<select required class="default" id="selling_basis" name="selling_basis">
																	<option id="selling_basis_none" value="None">Please Select</option>
																	<option id="selling_basis_1" value="1">VSOE of fair value</option>
																	<option id="selling_basis_2" value="2">Third-party selling price</option>
																	<option id="selling_basis_3" value="3">Management estimate</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="vsoe_basis_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="vsoe_basis" style="margin-right: 5px">Basis for determining VSOE:  </label>
															<div class="controls">
																<select id="vsoe_basis" name="vsoe_basis">
																	<option value="None">Please Select</option>
																	<option value="1">Price charged for same item sold separately</option>
																	<option value="2">Price established by management</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="contingent_question_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_question" style="margin-right: 5px">Is any portion of the selling price contingent?  </label>
															<div class="controls">
																<select required class="default" id="contingent_question" name="contingent_question">
																	<option value="None">Please Select</option>
																	<option id="contingent_question_1" value="1">Yes</option>
																	<option id="contingent_question_0" value="0">No</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="contingent_amount_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_amount" style="margin-right: 5px">Contingent amount:  </label>
															<div class="controls">
																<input required class="ignore" type="text" id="contingent_amount" name="contingent_amount" />
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="contingent_item_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_item" style="margin-right: 5px">Nature of the contingency?  </label>
															<div class="controls">
																<select id="contingent_item" name="contingent_item">
																	<option value="">Please Select</option>
																	<option value="1">Additional performance conditions</option>
																	<option value="2">Delivery of additional items</option>
																	<option value="3">Other</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="contingent_desc_container" style="margin-bottom: 5px">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_desc" style="margin-right: 5px">Description of the contingency?  </label>
															<div class="controls">
																<textarea id="contingent_desc" class="span6" name="contingent_desc" rows="4"></textarea>
															</div>
														</div>
													</div>
												</div> 
												<!-- end default-container -->
												<div id="software-container" class="hidden">
													<div class="control_group row" id="sw_element_container">
														<div class="span12">
															<div class="controls">
																<input type="hidden" id="sw_element" name="sw_element" value="0"/>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="specific_allocation_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="spec_alloc" style="margin-right: 5px">Specific allocation:  </label>
															<div class="controls">
																<input type="text" id="spec_alloc" name="spec_alloc" />
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="selling_price_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="selling_price" style="margin-right: 5px">Selling Price:  </label>
															<div class="controls">
																<input required class="default" type="text" id="selling_price" name="selling_price" />
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="selling_basis_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="selling_basis" style="margin-right: 5px">Basis for determining selling price:  </label>
															<div class="controls">
																<select required class="default" id="selling_basis" name="selling_basis">
																	<option id="selling_basis_none" value="None">Please Select</option>
																	<option id="selling_basis_1" value="1">VSOE of fair value</option>
																	<option id="selling_basis_2" value="2">Third-party selling price</option>
																	<option id="selling_basis_3" value="3">Management estimate</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="vsoe_basis_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="vsoe_basis" style="margin-right: 5px">Basis for determining VSOE:  </label>
															<div class="controls">
																<select id="vsoe_basis" name="vsoe_basis">
																	<option value="None">Please Select</option>
																	<option value="1">Price charged for same item sold separately</option>
																	<option value="2">Price established by management</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row default_container" id="contingent_question_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_question" style="margin-right: 5px">Is any portion of the selling price contingent?  </label>
															<div class="controls">
																<select required class="default" id="contingent_question" name="contingent_question">
																	<option value="None">Please Select</option>
																	<option id="contingent_question_1" value="1">Yes</option>
																	<option id="contingent_question_0" value="0">No</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="contingent_amount_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_amount" style="margin-right: 5px">Contingent amount:  </label>
															<div class="controls">
																<input required class="ignore" type="text" id="contingent_amount" name="contingent_amount" />
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="contingent_item_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_item" style="margin-right: 5px">Nature of the contingency?  </label>
															<div class="controls">
																<select id="contingent_item" name="contingent_item">
																	<option value="">Please Select</option>
																	<option value="1">Additional performance conditions</option>
																	<option value="2">Delivery of additional items</option>
																	<option value="3">Other</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="contingent_desc_container" style="margin-bottom: 5px">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="contingent_desc" style="margin-right: 5px">Description of the contingency?  </label>
															<div class="controls">
																<textarea id="contingent_desc" class="span6" name="contingent_desc" rows="4"></textarea>
															</div>
														</div>
													</div>
												</div>
													<div class="control_group row hidden default_container" id="sw_last_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sw_last" style="margin-right: 5px">Is this the last software deliverable in the arrangement?  </label>
															<div class="controls">
																<select required class="default ignore" id="sw_last" name="sw_last">
																	<option value="">Please Select</option>
																	<option value="1">Yes</option>
																	<option value="0">No</option>
																</select>
															</div>
														</div>
													</div>
												</div> 
												<!-- end software-container -->
												<div id="sw-sfp-container" class="hidden">
													<div class="control_group row hidden default_container" id="sw_sfp_amt_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sw_sfp_amt" style="margin-right: 5px">Specified future purchase amount:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="sw_sfp_amt" name="sw_sfp_amt" />
															</div>
														</div>
													</div>
													<div class="control_group row hidden default_container" id="sw_sfp_disc_amt_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sw_sfp_disc_amt" style="margin-right: 5px">Specified future purchase discount amount:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="sw_sfp_disc_amt" name="sw_sfp_disc_amt" />
															</div>
														</div>
													</div>
												</div>
												<!-- end sw-sfp-container -->
												<div id="sw-ufp-container" class="hidden">
													<div class="control_group row hidden default_container" id="sw_ufp_question_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sw_ufp_question" style="margin-right: 5px">Is the maximum discount amount on the unspecified future purchase known?  </label>
															<div class="controls">
																<select required class="default ignore" id="sw_ufp_question" name="sw_ufp_question">
																	<option value="">Please Select</option>
																	<option id="sw_ufp_question_1" value="1">Yes</option>
																	<option id="sw_ufp_question_0" value="0">No</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="sw_ufp_disc_amt_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sw_ufp_disc_amt" style="margin-right: 5px">Maximum discount amount on unspecified future purchase:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="sw_ufp_disc_amt" name="sw_ufp_disc_amt" />
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="sw_ufp_disc_rate_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sw_ufp_disc_rate" style="margin-right: 5px">Discount rate on unspecified future purchase:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="sw_ufp_disc_rate" name="sw_ufp_disc_rate" />
															</div>
														</div>
													</div>
												</div>
												<!-- end sw-ufp-container -->
												<div id="other-sfp-container" class="hidden">
													<div class="control_group row hidden default_container"  id="sfp_amt_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sfp_amt" style="margin-right: 5px">Specified future purchase amount:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="sfp_amt" name="sfp_amt" />
															</div>
														</div>
													</div>
													<div class="control_group row hidden default_container" id="sfp_disc_amt_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="sfp_disc_amt" style="margin-right: 5px">Specified future purchase discount amount:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="sfp_disc_amt" name="sfp_disc_amt" />
															</div>
														</div>
													</div>
												</div>
												<!-- end other-sfp-container -->
												<div id="other-ufp-container" class="hidden">
													<div class="control_group row hidden default_container" id="ufp_question_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="ufp_question" style="margin-right: 5px">Is the maximum discount amount on the unspecified future purchase known?  </label>
															<div class="controls">
																<select required class="default ignore" id="ufp_question" name="ufp_question">
																	<option value="">Please Select</option>
																	<option id="ufp_question_1" value="1">Yes</option>
																	<option id="ufp_question_0" value="0">No</option>
																</select>
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="ufp_disc_amt_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="ufp_disc_amt" style="margin-right: 5px">Maximum discount amount on unspecified future purchase:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="ufp_disc_amt" name="ufp_disc_amt" />
															</div>
														</div>
													</div>
													<div class="control_group row hidden" id="ufp_disc_rate_container">
														<div class="span12">
															<label class="alert-info control-label span5 offset1" for="ufp_disc_rate" style="margin-right: 5px">Discount rate on unspecified future purchase:  </label>
															<div class="controls">
																<input required class="default ignore" type="number" id="ufp_disc_rate" name="ufp_disc_rate" />
															</div>
														</div>
													</div>
												</div>
												<!-- end discount-container -->
												
												<div id="disc_button" class="control_group row" style="margin-top: 15px">
													<div class="span12">
														<div class="controls" style="margin-left: auto; margin-left: auto; width: 51%; margin-top: 0px; margin-botton: 15px;">
															<input type="hidden" name="new_element" value="new_element">
															<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id; ?>" />
															<input type="hidden" id="project_name" name="project_name" value="<?php echo $project_name; ?>" />
															<input type="hidden" name="project_php" value="rr">
															<input type="hidden" name="cat_id" value="0">
															<input type="hidden" id="meth_cat" name="meth_cat" value=""/>
															<input type="hidden" id="disc_cat" name="disc_cat" value=""/>
															<input class="btn btn-primary" type="submit" id="save-new" name="save-new" value="Save" />
														</div>
													</div>
												</div>
																					
											</form>
										</div>
										
										<div>
									<?php
										foreach ($delivs as $deliv){
										?>
											<ul class="" id="group-<?php echo $deliv->rr_del_id; ?>" style="">
												<li id="rr_del_id"><?php echo $deliv->rr_del_id; ?></li>
												<li id="category"><?php echo $deliv->rr_meth_asc_id; ?></li>
												<li id="sub_category"><?php echo $deliv->rr_del_disc_cat; ?></li>
											</ul>
										<?php
										}
									?>
										</div>
										
										<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/library/js/show-element-form.js'></script>
										
										<style>
											.element-container {
												border: 1px solid lightgrey;
												min-height: 275px;
												-webkit-border-radius: 4px;
												border-radius: 4px;
												moz-border-radius: 4px;
												margin-bottom: 5px;
											}

											.rr-container {
												border: 1px solid lightgrey;
												-webkit-border-radius: 4px;
												border-radius: 4px;
												moz-border-radius: 4px;
												margin-bottom: 5px;
											}
											
											.button-container {
												height: 25px;
												position: relative;
												width: 260px;
												left: 540px;
												top: -45px;
												
											}

											#save-element {
												width: 70px;
											}

											#modify-element {
												width: 50px;
												position: relative;
												left: 70px;
												top: -43px;
											}
											
											#delete-element {
												width: 70px;
												position: relative;
												left: 192px;
												top: -86px;
											}

										</style>
									<?php
									?>							
					
						</section> <!-- end article section -->
						
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>