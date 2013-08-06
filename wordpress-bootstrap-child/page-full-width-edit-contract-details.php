<?php
/*
Template Name: Full Width Page Edit Contract Details
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
									<form action="<?php echo $site_url; ?>/show-contract-details/" method="post">
										<input type="hidden" name="element_id" value="<?php echo $element_id; ?>">
										<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
										<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
										<input type="hidden" name="page_id" id="page_id" value="single">
										<input type="hidden" name="return_url" value="<?php echo $site_url; ?>/show-revrec-list/">
										<input class="btn" type="submit" name="edit" value="Return to Arrangement Details">
									</form>
									
									<h3>Edit Arrangement Details</h3>
									<h4><?php echo stripslashes($value['rr_el_name']); ?></h4>
									<div id="debug"></div>
									<div id="page_id" class="<?php echo $project['gl_proj_ctype']; ?> container">
										
										<span>
									
											<form id="form" class="form form-horizontal" action="<?php echo $site_url; ?>/save-rr-project/" method="post">
												<div class="row">
													<div class="span12">
														<div class="row control-group">
															<div class="controls" style="margin-left: auto; margin-left: auto; width: 59%; margin-top: 0px; margin-botton: 15px;">
																<input type="submit" class="btn btn-primary" name="save-edit" value="Save">
																<input type="hidden" name="element_id" id="element_id" value="<?php echo $value['rr_el_id']; ?>">
																<input type="hidden" name="project_id" id="project_id" value="<?php echo $value['gl_proj_id']; ?>">
																<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>">
																<input type="hidden" name="return_url" value="<?php echo $return_url; ?>">
															</div>
														</div>
													</div>
												</div>
												<br />
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="element_name" style="margin-right: 5px">Arrangement name:  </label>
														<div class="controls">
															<input type="text" class="span6" name="element_name" id="element_name" value="<?php echo stripslashes($value['rr_el_name']); ?>">
															</div>
													</div>
												</div>
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="element_desc" style="margin-right: 5px">Arrangement description:  </label>
														<div class="controls">
															<input type="text" class="span6" name="element_desc" id="element_desc" value="<?php echo stripslashes($value['rr_el_desc']); ?>">
														</div>
													</div>
												</div>
												<div id="contract-price-container" class="control_group row">
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="selling_price" style="margin-right: 5px">Arrangement price:  </label>
														<div class="controls">
															<input type="text" class="span3" name="contract_price" id="contract_price" value="<?php echo $value['rr_el_amt']; ?>">
														</div>
													</div>
												</div>
												<div id="sp_contingent_container" class="control_group row">
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="sp_contingent" style="margin-right: 5px">Any portion of arrangement fee contingent?:  </label>
														<div class="controls">
															<select class="span2" id="sp_contingent" name="sp_contingent">
															<?php
																if ($value['rr_el_sp_cont'] > 0){
																	echo '<option value="">-----------------</option>';
																	echo '<option id="contingent_question_1" value="1" selected>Yes</option>'; 
																	echo '<option id="contingent_question_0" value="0">No</option>'; 
																} else if ($value['rr_el_sp_cont'] == 0){{
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
												if ($value['rr_el_sp_cont'] > 0){
												?>	<div id="contingent_amount_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_amount_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="contingent_amt" style="margin-right: 5px">Contingent amount (if any):  </label>
														<div class="controls">
															<input type="text" class="span3" name="contingent_amt" id="contingent_amt" value="<?php echo $value['rr_el_cont_amt']; ?>">
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_sp_cont'] > 0){
												?>	<div id="contingent_item_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_item_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="contingency_item" style="margin-right: 5px">Nature of the contingency (if any):  </label>
														<div class="controls">
															<select class="span4" id="contingency_item" name="contingency_item">
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
												if ($value['rr_el_cont_item'] == 1){
												?>	<div id="contingent_desc_container" class="control_group row" style="padding-bottom: 5px"> <?php
												} else {
												?>	<div id="contingent_desc_container" class="control_group row hidden" style="padding-bottom: 5px"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="contingency_desc" style="margin-right: 5px">Contingency description (if any):  </label>
														<div class="controls">
															<textarea style="overflow: auto;" rows="4" class="span6" name="contingency_desc" id="contingency_desc"><?php echo $value['rr_el_cont_desc']; ?></textarea>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_item'] == 1){
												?>	<div id="contingent_res_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_res_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="contingency_stat" style="margin-right: 5px">Contingency resolved?:  </label>
														<div class="controls">
															<select class="span2" id="contingency_stat" name="contingency_stat">
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
																	echo '<option value="0" selected>No</option>'; 
																}
															?>
															</select>
														</div>
													</div>
												</div>
											<?php
												if ($value['rr_el_cont_item'] == 1){
												?>	<div id="contingent_resdate_container" class="control_group row"> <?php
												} else {
												?>	<div id="contingent_resdate_container" class="control_group row hidden"> <?php	
												}
											?>
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="contingency_date" style="margin-right: 5px">Date contingency resolved (if applicable):  </label>
														<div class="controls">
															<input type="date" class="span3" name="contingency_date" id="contingency_date" value="<?php echo $value['rr_el_cont_date']; ?>">
														</div>
													</div>
												</div>
												<!--
												<div class="row">
												<div class="span12">
													<label class="control-label span4 offset2 alert-info" for="element_dep">Direct dependency:  </label>
													<select class="span6" id="element_dep" name="element_dep">
													<option value="None">None Selected</option>
												-->
														<?php
														/*	foreach( $results as $dep ){
																if ($dep['rr_el_id'] !== $value['rr_el_id'] && $dep['gl_proj_id'] == $value['gl_proj_id']){
																	if ($value['rr_el_dep'] == $dep['rr_el_id']){
																		echo '<option value="'.$dep['rr_el_id'].'" selected>'.$dep['rr_el_name'].'</option>';
																	} else {
																		echo '<option value="'.$dep['rr_el_id'].'">'.$dep['rr_el_name'].'</option>';
																	}
																}
															}*/
														?>
												<!--
													</select>
												</div>
												</div>
												-->
												
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span4 offset1 alert-info" for="element_notes" style="margin-right: 5px">Notes:  </label>
														<div class="controls">
															<textarea style="overflow: auto;" rows="4" class="span6" name="element_notes" id="element_notes"><?php echo $value['rr_el_notes']; ?></textarea>
														</div>
													</div>
												</div>

												<div class="row">
												<div class="span12">
												<div class="row">
												<div class="controls" style="margin-left: auto; margin-left: auto; width: 58%; margin-top: 15px; margin-botton: 0px;">
													<input type="submit" class="btn btn-primary" name="save-edit" value="Save">
													<input type="hidden" name="element_id" id="element_id" value="<?php echo $value['rr_el_id']; ?>">
													<input type="hidden" name="project_id" id="project_id" value="<?php echo $value['gl_proj_id']; ?>">
													<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>">
													<input type="hidden" name="return_url" value="<?php echo $return_url; ?>">
												</div>
												</div>
												</div>
												</div>
											
											</form>
											
										</span>
								
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
						}
						
						?>							
					
						</section> <!-- end article section -->
						
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>