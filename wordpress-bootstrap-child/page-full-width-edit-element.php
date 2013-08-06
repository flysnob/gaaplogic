<?php
/*
Template Name: Full Width Page Edit Element
*/
?>
<?php session_start(); ?>
<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="post_content">
							
						<?php
						
							$element_id = $_POST['element_id'];
							$project_id = $_POST['project_id'];
							$project_name = $_POST['project_name'];
							$return_url = $_POST['return_url'];

							$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr", ARRAY_A );
							$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_proj_id = $project_id", ARRAY_A );
							
							foreach ( $results as $value ){
								if ($value['rr_el_id'] == $element_id){
								
								?>
									
									<form action="<?php echo $site_url; ?>/show-element/" method="post">
										<input type="hidden" name="element_id" value="<?php echo $element_id; ?>">
										<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
										<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
										<input class="btn" type="submit" name="edit" value="Return to Element Details">
									</form>
									
									<h3>Edit Element</h3>
									<h4><?php echo stripslashes($project_name); ?></h4>
									<h5><strong><?php echo stripslashes($value['rr_el_name']); ?></strong></h5>
									<div id="debug"></div>
									<div id="<?php echo $element_id; ?>" class="element-container">
											
										<span>
									
											<form id="form" class="form form-horizontal" action="<?php echo $site_url; ?>/save-element/" method="post">
												<div class="row">
													<div class="span12">
														<div class="row control-group">
															<div class="controls" style="margin-left: auto; margin-left: auto; width: 50%; margin-top: 15px; margin-botton: 0px;">
																<input type="submit" class="btn btn-primary" name="save-edit" value="Save">
																<input type="hidden" name="element_id" id="element_id" value="<?php echo $value['rr_el_id']; ?>">
																<input type="hidden" name="project_id" id="project_id" value="<?php echo $value['gl_proj_id']; ?>">
															</div>
														</div>
													</div>
												</div>
												<br />
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="element_name" style="margin-right: 5px">Element name:   </label>
														<div class="controls">
															<input type="text" class="span6" name="element_name" id="element_name" value="<?php echo stripslashes($value['rr_el_name']); ?>">
															</div>
													</div>
												</div>
												<div class="control_group row" style="margin-bottom: 5px">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="element_desc" style="margin-right: 5px">Element description:   </label>
														<div class="controls">
															<textarea style="overflow: auto;" rows="4" class="span6" name="element_desc" id="element_desc"><?php echo stripslashes($value['rr_el_desc']); ?></textarea>
														</div>
													</div>
												</div>
											<?php
												if (($value['rr_el_meth_cat'] < 2 || $value['rr_el_meth_cat'] > 2) && $value['rr_el_disc_cat'] == 0){
													echo $value['rr_el_meth_cat'];
												?>
													<div id="element_sep_container" class="control_group row">
														<div class="span12">
															<label class="control-label span5 offset1 alert-info" for="element_sep" style="margin-right: 5px">Is this element separable?:  </label>
															<div class="controls">
																<select class="span2" id="element_sep" name="element_sep">
																<?php
																	if ($value['rr_el_sep'] == 'Yes'){
																		echo '<option value="">-----------------</option>';
																		echo '<option value="'.$value['rr_el_sep'].'" selected>'.$value['rr_el_sep'].'</option>'; 
																		echo '<option value="No">No</option>'; 
																	} else if ($value['rr_el_sep'] == 'No'){
																		echo '<option value="">-----------------</option>';
																		echo '<option value="Yes">Yes</option>'; 
																		echo '<option value="'.$value['rr_el_sep'].'" selected>'.$value['rr_el_sep'].'</option>'; 
																	} else {
																		echo '<option value="">-----------------</option>';
																		echo '<option value="Yes">Yes</option>'; 
																		echo '<option value="No">No</option>'; 
																	}
																?>
																</select>
															</div>
														</div>
													</div>
												<?php
												}
											?>
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="sw_element" style="margin-right: 5px">Software element?   </label>
														<div class="controls">
															<select class="span2" id="sw_element" name="sw_element">
															<?php
																if ($value['rr_el_meth_cat'] == 2){
																	echo '<option value="">-----------------</option>';
																	echo '<option id="sw_element_1" value="1" selected>Yes</option>'; 
																	echo '<option id="sw_element_0" value="0">No</option>'; 
																} else {
																	echo '<option value="">-----------------</option>';
																	echo '<option id="sw_element_1" value="1">Yes</option>'; 
																	echo '<option id="sw_element_0" value="0" selected>No</option>'; 
																}
															?>
															</select>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_sw_flag'] == '1'){
												?>  <div id="sw_last_container" class="control_group row"> <?php
												} else {
													?>  <div id="sw_last_container" class="control_group row hidden"> <?php
												}
											?>
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="sw_element" style="margin-right: 5px">Last software deliverable?:  </label>
														<div class="controls">
															<select class="span2" id="sw_last_element" name="sw_last_element">
															<?php
																if ($value['rr_el_last_del'] == '1'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1" selected>Yes</option>'; 
																	echo '<option value="0">No</option>'; 
																} else if ($value['rr_el_last_del'] == '0'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Yes</option>'; 
																	echo '<option value="0" selected>No</option>'; 
																} else {
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Yes</option>'; 
																	echo '<option value="0">No</option>'; 
																}
															?>
															</select>
														</div>
													</div>
												</div>
											<?php
												if ($page_id == 'multiple'){
												?>
													<div id="selling-price-container" class="control_group row">
														<div class="span12">
															<label class="control-label span5 offset1 alert-info" for="selling_price" style="margin-right: 5px">Selling price:  </label>
															<div class="controls">
																<input type="text" class="span3" name="selling_price" id="selling_price" value="<?php echo $value['rr_el_sell_price']; ?>">
															</div>
														</div>
													</div>
												
													<div id="selling-basis-container" class="control_group row">
														<div class="span12">
															<label class="control-label span5 offset1 alert-info" for="sp_basis" style="margin-right: 5px">Basis for determining selling price:  </label>
															<div class="controls">
																<select class="span4" id="sp_basis" name="sp_basis">
																<?php
																	if ($value['rr_el_sp_basis'] == '1'){
																		echo '<option value="">-----------------</option>';
																		echo '<option id="selling_basis_1" value="1" selected>VSOE of fair value</option>'; 
																		echo '<option id="selling_basis_2" value="2">Third party selling price</option>'; 
																		echo '<option id="selling_basis_3" value="3">Management estimate</option>'; 
																	} else if ($value['rr_el_sp_basis'] == '2'){
																		echo '<option value="">-----------------</option>';
																		echo '<option id="selling_basis_1" value="1">VSOE of fair value</option>'; 
																		echo '<option id="selling_basis_2" value="2" selected>Third party selling price</option>'; 
																		echo '<option id="selling_basis_3" value="3">Management estimate</option>'; 
																	} else if ($value['rr_el_sp_basis'] == '3'){
																		echo '<option value="">-----------------</option>';
																		echo '<option id="selling_basis_1" value="1">VSOE of fair value</option>'; 
																		echo '<option id="selling_basis_2" value="2">Third party selling price</option>'; 
																		echo '<option id="selling_basis_3" value="3" selected>Management estimate</option>'; 
																	} else {
																		echo '<option value="">-----------------</option>';
																		echo '<option id="selling_basis_1" value="1">VSOE of fair value</option>'; 
																		echo '<option id="selling_basis_2" value="2">Third party selling price</option>'; 
																		echo '<option id="selling_basis_3" value="3">management estimate</option>'; 
																	}
																?>
																</select>
															</div>
														</div>
													</div>
												<?php
													if ($value['rr_el_sp_basis'] == 1){
														?><div id="vsoe_basis_container" class="control_group row"><?php
													} else {
														?><div id="vsoe_basis_container" class="control_group row hidden"><?php
													}
												?>
													<div class="span12">
															<label class="control-label span5 offset1 alert-info" for="sp_basis" style="margin-right: 5px">Basis for determining VSOE:  </label>
															<div class="controls">
																<select class="span5" id="vsoe_basis" name="vsoe_basis">
																<?php
																	if ($value['rr_el_vsoe_basis'] == '1'){
																		echo '<option value="">-----------------</option>';
																		echo '<option value="1" selected>Price charged for same item sold separately</option>'; 
																		echo '<option value="2">Price established my management</option>'; 
																	} else if ($value['rr_el_vsoe_basis'] == '2'){
																		echo '<option value="">-----------------</option>';
																		echo '<option value="1">Price charged for same item sold separately</option>'; 
																		echo '<option value="2" selected>Price established my management</option>'; 
																	} else {
																		echo '<option value="">-----------------</option>';
																		echo '<option value="1">Price charged for same item sold separately</option>'; 
																		echo '<option value="2">Price established my management</option>'; 
																	}
																?>
																</select>
															</div>
														</div>
													</div>							
												<?php
												}
											?>
												<div id="sp_contingent_container" class="control_group row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="sp_contingent" style="margin-right: 5px">Any portion of selling price contingent?:  </label>
														<div class="controls">
															<select class="span2" id="sp_contingent" name="sp_contingent">
															<?php
																if ($value['rr_el_sp_cont'] > 0){
																	echo '<option value="">-----------------</option>';
																	echo '<option id="contingent_question_1" value="1" selected>Yes</option>'; 
																	echo '<option id="contingent_question_0" value="0">No</option>'; 
																} else if ($value['rr_el_sp_cont'] == 0){
																	echo '<option value="">-----------------</option>';
																	echo '<option id="contingent_question_1" value="1">Yes</option>'; 
																	echo '<option id="contingent_question_0" value="0" selected>No</option>'; 
																}
															?>
															</select>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_amt'] > 0){
												?>	<div id="contingent_amount_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_amount_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_amt" style="margin-right: 5px">Contingent amount (if any):  </label>
														<div class="controls">
															<input type="text" class="span3" name="contingent_amt" id="contingent_amt" value="<?php echo $value['rr_el_sp_cont']; ?>">
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_amt'] > 0){
												?>	<div id="contingent_item_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_item_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_item" style="margin-right: 5px">Nature of the contingency (if any):  </label>
														<div class="controls">
															<select class="span4" id="contingent_item" name="contingent_item">
															<?php
																if ($value['rr_el_cont_item'] == '1'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1" selected>Additional performance conditions</option>'; 
																	echo '<option value="2">Delivery of additional items</option>'; 
																	echo '<option value="3">Other</option>'; 
																} else if ($value['rr_el_cont_item'] == '2'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Additional performance conditions</option>'; 
																	echo '<option value="2" selected>Delivery of additional items</option>'; 
																	echo '<option value="3">Other</option>'; 
																} else if ($value['rr_el_cont_item'] == '3'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Additional performance conditions</option>'; 
																	echo '<option value="2">Delivery of additional items</option>'; 
																	echo '<option value="3" selected>Other</option>'; 
																} else {
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Additional performance conditions</option>'; 
																	echo '<option value="2">Delivery of additional items</option>'; 
																	echo '<option value="3">Other</option>'; 
																}
															?>
															</select>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_amt'] > 0){
												?>	<div id="contingent_desc_container" class="control_group row" style="padding-bottom: 5px"> <?php
												} else {
												?>	<div id="contingent_desc_container" class="control_group row hidden" style="padding-bottom: 5px"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_desc" style="margin-right: 5px">Contingency description (if any):  </label>
														<div class="controls">
															<textarea style="overflow: auto;" rows="4" class="span6" name="contingent_desc" id="contingent_desc"><?php echo stripslashes($value['rr_el_cont_desc']); ?></textarea>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_amt'] > 0){
												?>	<div id="contingent_res_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_res_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_stat" style="margin-right: 5px">Contingency resolved?:  </label>
														<div class="controls">
															<select class="span2" id="contingent_stat" name="contingent_stat">
															<?php
																if ($value['rr_el_cont_stat'] == 'Yes'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1" selected>Yes</option>'; 
																	echo '<option value="0">No</option>'; 
																} else if ($value['rr_el_cont_stat'] == 'No'){
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Yes</option>'; 
																	echo '<option value="0" selected>No</option>'; 
																} else {
																	echo '<option value="">-----------------</option>';
																	echo '<option value="1">Yes</option>'; 
																	echo '<option value="0">No</option>'; 
																}
															?>
															</select>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_amt'] > 0){
												?>	<div id="contingent_resdate_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_resdate_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_date" style="margin-right: 5px">Date contingency resolved (if applicable):  </label>
														<div class="controls">
															<input type="date" class="span3" name="contingent_date" id="contingent_date" value="<?php echo $value['rr_el_cont_date']; ?>">
														</div>
													</div>
												</div>
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="element_notes" style="margin-right: 5px">Notes:  </label>
														<div class="controls">
															<textarea style="overflow: auto;" rows="4" class="span6" name="element_notes" id="element_notes"><?php echo stripslashes($value['rr_el_notes']); ?></textarea>
														</div>
													</div>
												</div>

												<div class="row">
												<div class="span12">
												<div class="row">
												<div class="controls" style="margin-left: auto; margin-left: auto; width: 50%; margin-top: 15px; margin-botton: 0px;">
													<input type="submit" class="btn btn-primary" name="save-edit" value="Save">
													<input type="hidden" name="element_id" id="element_id" value="<?php echo $value['rr_el_id']; ?>">
													<input type="hidden" name="project_id" id="project_id" value="<?php echo $value['gl_proj_id']; ?>">
													<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
												</div>
												</div>
												</div>
												</div>
											
											</form>
											
										</span>
									
										</div>
									</div>
									
									<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/library/js/edit-element.js'></script>
									
									<style>
										.element-container {
											border: 1px solid lightgrey;
											min-height: 350px;
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
								}
							}
						?>							
					
						</section> <!-- end article section -->
			
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>