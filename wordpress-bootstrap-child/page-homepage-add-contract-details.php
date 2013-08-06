<?php
/*
Template Name: Homepage Add Contract Details
*/
?>
<?php session_start(); ?>
<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="post_content">
										
									<?php 
					
										$project_id = $_SESSION['project_id'];
										$project_name = $_SESSION['project_name'];
										$project_desc = $_SESSION['project_desc'];
										$project_desc_long = $_SESSION['project_desc_long'];
										$project_fee = $_SESSION['project_fee'];
										$element_id = $_SESSION['element_id'];
		
										$delivs = $wpdb->get_results($wpdb->prepare( "SELECT * FROM wp_gl_rr_del WHERE rr_del_disc_cat = 0 ORDER BY rr_del_name ASC",	ARRAY_A	));
										$results = $wpdb->get_results( "SELECT * FROM wp_gl_cat ", ARRAY_A );
												
									?>
										<form class="span2" action="<?php echo $site_url; ?>/show-revrec-list/" method="post">
											<input type="submit" class="btn btn-small" value="Return to Contract List">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
										</form>
										<br />
										<br />

										<h3>Add details to this arrangement</h3>
										<h4><?php echo $project_id; ?>: <?php echo stripslashes($project_name); ?></h4>
										<div class="element-container">
											<div style="margin-bottom: 10px" class="span12">
												<h4 style="text-align: center">Arrangement Details</h4>
											</div>
											<form class="form-horizontal" id="element_form" action="<?php echo $site_url; ?>/save-rr-project/" method="post"> <!-- edit selected project.  variable $_SERVER... is posted -->
												<input type="hidden" name="new_element" value="new_element">
												<input type="hidden" name="project_php" value="rr">
												<input type="hidden" name="cat_id" value="0">
												<div id="element_name" class="row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" style="margin-right: 5px">Arrangement name:</label>
														<div class="controls">
															<label class="span6"><?php echo stripslashes($project_name); ?></label>
														</div>
													</div>
												</div>
												<div id="element_desc" class="row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" style="margin-right: 5px">Arrangement description:</label>
														<div class="controls">
															<label class="span6"><?php echo stripslashes($project_desc); ?></label>
														</div>
													</div>
												</div>
												<div id="element_desc" class="row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" style="margin-right: 5px">Arrangement fee:</label>
														<div class="controls">
															<label class="span6"><?php echo number_format($project_fee, 2, '.', ','); ?></label>
														</div>
													</div>
												</div>
												
												<div class="control_group row">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="element_del" style="margin-right: 5px">Deliverable type:  </label>
														<div class="controls">
															<select required id="element_del" name="element_del">
																<option value="">Please select</option>
																<?php
																	foreach ($delivs as $deliv){
																		echo '<option id="element_del_'.$deliv->rr_del_id.'" value="'.$deliv->rr_del_id.'">'.$deliv->rr_del_name.'</option>'; 
																	}
																?>
															</select>
														</div>
													</div>
												</div>
												<div class="control_group row" id="sw_element_container">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="sw_element" style="margin-right: 5px">Is this a software arrangement?  </label>
														<div class="controls">
														<select required id="sw_element" name="sw_element">
																<option value="">Please Select</option>
																<option id="sw_element_1" value="1">Yes</option>
																<option id="sw_element_0" value="0">No</option>
															</select>
														</div>
													</div>
												</div>
												<div class="control_group row" id="contingent_question_container">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_question" style="margin-right: 5px">Is any portion of the arrangement amount contingent?  </label>
														<div class="controls">
															<select required id="contingent_question" name="contingent_question">
																<option value="">Please Select</option>
																<option id="contingent_question_1" value="1">Yes</option>
																<option id="contingent_question_0" value="0">No</option>
															</select>
														</div>
													</div>
												</div>
												<div class="control_group row hidden" id="contingent_amount_container">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_amount" style="margin-right: 5px">Contingent amount:  </label>
														<div class="controls">
															<input required class="ignore" type="text" id="contingent_amount" name="contingent_amount" />
														</div>
													</div>
												</div>
												<div class="control_group row hidden" id="contingent_item_container">
													<div class="span12">
														<label class="control-label span5 offset1 alert-info" for="contingent_item" style="margin-right: 5px">Nature of the contingency?  </label>
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
														<label class="control-label span5 offset1 alert-info" for="contingent_desc" style="margin-right: 5px">Description of the contingency?  </label>
														<div class="controls">
															<textarea id="contingent_desc" class="span6" name="contingent_desc" rows="4"></textarea>
														</div>
													</div>
												</div>
												<div class="control_group row" style="margin-top: 15px">
													<div class="span12">
														<div class="controls" style="margin-left: auto; margin-left: auto; width: 51%; margin-top: 0px; margin-botton: 15px;">
															<input class="btn btn-primary" type="submit" name="save-add-details" value="Save" />
															<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
															<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id; ?>" />
															<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
															<input type="hidden" id="element_id" name="element_id" value="<?php echo $element_id; ?>" />
														</div>
													</div>
												</div>

											</form>
										</div>

										<script type='text/javascript'>
										(function(){
											if( window.localStorage ){
												if( !localStorage.getItem( 'firstLoad' ) ){
													localStorage[ 'firstLoad' ] = true;
													window.location.reload();
												} else {
													localStorage.removeItem( 'firstLoad' );
												}
											}
										})
										();
										
										$('document').ready(function(){
											$("#element_form").validate({
												ignore: '.ignore',
											});
										})
											
											$("select").change(function() {
												
												$("select option:selected").each(function () {
													if ($(this).attr('id') == 'contingent_question_1'){
														$('#contingent_amount_container').removeClass('hidden');
														$('#contingent_item_container').removeClass('hidden');
														$('#contingent_desc_container').removeClass('hidden');
														$('#contingent_amount').removeClass('ignore');
													}
												});
												$("select option:selected").each(function () {
													if ($(this).attr('id') == 'contingent_question_0'){
														$('#contingent_amount_container').addClass('hidden');
														$('#contingent_item_container').addClass('hidden');
														$('#contingent_desc_container').addClass('hidden');
														$('#contingent_amount').addClass('ignore');
													}
												});
											})
												
											
													
										</script>
										
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