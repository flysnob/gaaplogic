<?php
/*
Template Name: Homepage Show Project Form
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
							<p><a class="btn" href="<?php echo $site_url; ?>/show-list/">Return to Project List</a>&nbsp;&nbsp;&nbsp; <!-- return to list of all projects -->
							<br />
							<br />
							<h3>Create a project</h3>
							
							
							<div class="element-container">
								<form class="form-horizontal" id="project-editor" action="<?php echo $site_url; ?>/save-project/" method="post" style="margin-top: 25px">
									<div class="control_group row">
										<div class="span12">
											<label class="alert-info control-label span5 offset1" for="cat_id" style="margin-right: 5px">Project category:  </label>
											<div class="controls">
												<select name="cat_id" class="span4">
													<option value="">-----------------</option>
												<?php
													foreach( $results as $key => $value ){
														$key = $key + 1;
														echo '<option value="'.$value['gl_cat_id'].'">'.$value['gl_cat_name'].'</option>'; //close your tags!!  //  need to increase key value by one or start array at 1
													}
												?>
												</select>
											</div>
										</div>
									</div>
									<div class="control_group row">
										<div class="span12">
											<label class="alert-info control-label span5 offset1" for="project_name" style="margin-right: 5px">Project name:  </label>
											<div class="controls">
												<input type="text" id="project_name" class="span6" name="project_name" />
											</div>
										</div>
									</div>
									<div class="control_group row" style="margin-bottom: 5px">
										<div class="span12">
											<label class="alert-info control-label span5 offset1" for="project_desc" style="margin-right: 5px">Project description:  </label>
											<div class="controls">
												<textarea id="project_desc" name="project_desc" rows="4" class="span6"></textarea>
											</div>
										</div>
									</div>
									<div class="control_group row">
										<div class="span12">
											<div class="controls" style="margin-left: auto; margin-left: auto; width: 51%; margin-top: 15px; margin-botton: 0px;">
												<input class="btn btn-primary" type="submit" name="save-project" value="Save" />
												<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
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
								
								$('option').click(function(){
									('#hide').removeClass('hidden');
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
							</style>

						</section> <!-- end article section -->
						
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>