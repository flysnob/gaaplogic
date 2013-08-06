<?php
/*
Template Name: Homepage Show Revrec Form
*/
?>

<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">
					
						<section class="post_content">
									
						<?php
							$user_id = $current_user->ID;
							$results = $wpdb->get_results( "SELECT * FROM wp_gl_cat ", ARRAY_A );
						?>
							<p><a class="btn" href="<?php echo $site_url; ?>/show-revrec-list/">Return to Arrangement List</a>&nbsp;&nbsp;&nbsp; 
							<br />
							<br />
							
							<div class="element-container">
							<form class="form-horizontal" style="margin-top: 25px" id="project-editor" action="<?php echo $site_url; ?>/save-rr-project/" method="post"> 
								
								<div class="control_group row">
									<div class="span12">
										<label class="alert-info control-label span5 offset1" for="contract_type" style="margin-right: 5px">Arrangement type:  </label>
										<div class="controls">
											<select required class="span5" name="contract_type">
												<option value="">Please Select</option>
												<option id="single" value="single">Single Deliverable Arrangement</option>
												<option id="multiple" value="multiple">Multiple Deliverables Arrangement</option>
											</select>
										</div>
									</div>
								</div>
								<div class="control_group row">
									<div class="span12">
										<label class="alert-info control-label span5 offset1" for="project_name" style="margin-right: 5px">Arrangement date:  </label>
										<div class="controls">
											<input required class="input" type="date" id="project_date" name="project_date" />
										</div>
									</div>
								</div>
								<div class="control_group row">
									<div class="span12">
										<label class="alert-info control-label span5 offset1" for="project_name" style="margin-right: 5px">Arrangement name:  </label>
										<div class="controls">
											<input required class="span6" type="text" id="project_name" name="project_name" />
										</div>
									</div>
								</div>
								<div class="control_group row" style="margin-bottom: 5px">
									<div class="span12">
										<label class="alert-info control-label span5 offset1" for="project_desc" style="margin-right: 5px">Arrangement description:  </label>
										<div class="controls">
											<textarea class="span6" id="description" name="project_desc" rows="4" class="input-xlarge"></textarea>
										</div>
									</div>
								</div>
								<div class="control_group row">
									<div class="span12">
										<label class="alert-info control-label span5 offset1" for="project_fee" style="margin-right: 5px">Arrangement fee:  </label>
										<div class="controls">
											<input required type="number" id="project_fee" name="project_fee" />
										</div>
									</div>
								</div>
								<div class="control_group row" style="margin-top: 15px">
									<div class="span12">
										<div class="controls" style="margin-left: auto; margin-left: auto; width: 51%; margin-top: 0px; margin-botton: 15px;">
											<input type="hidden" name="project_php" value="rr">
											<input type="hidden" name="cat_id" value="0">
											<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
											<input id="submit" class="btn btn-primary" type="submit" name="save-single" value="Save" />
										</div>
									</div>
								</div>
								
							</form>
							</div>

							<script>
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
									ignore: '.ignore'
								})
							})
							</script>

							<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/library/js/new-contract.js'></script>
							
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
							
						</section> <!-- end article section -->
									
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>