<?php
/*
Template Name: Homepage Show List
*/
?>

<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="row-fluid post_content">
						
							<div class="span12" style="min-height: 500px">
						
									<?php 
									
										$user_id = $current_user->ID;
										
									?>
										
										<h1>My Projects</h1>
											<div id="debug"></div>
										<a class="btn btn-success" href="<?php echo $site_url; ?>/show-project-form/">Create a new project &raquo;</a>
										<br />
										<br />
							
									<?php
										$table = 'wp_gl_proj';
										$results = $wpdb->get_results( "SELECT * FROM wp_gl_proj", ARRAY_A );
										foreach ( $results as $value ){
											if ($value['gl_user_id'] == $current_user->ID && $value['gl_proj_php'] !== 'rr'){
												$json = $value['gl_proj_json'];
												$json = unserialize ( $json );
												$json = str_replace( "\\\"", "&quot;", $json );
												$json = str_replace( "\'", "&#39;", $json );
														
											?>
												<div class="name-container">
												<dt> 
												<span>
												<fieldset>
												<h4>Project name: <?php echo stripslashes($value['gl_proj_name']); ?></h4>
												<h5>Project Description: <span><?php echo stripslashes($value['gl_proj_desc']); ?></span></h5>
											
												<div class="button-container">
												<span>
													<form class="action-links" action="<?php echo $site_url; ?>/project/" method="post">
														<input class="btn btn-primary btn-mini" type="submit" name="submit" value="Edit Project">
														<input type="hidden" name="project_name" value="<?php echo stripslashes($value['gl_proj_name']); ?>">
														<input type="hidden" name="project_desc" value="<?php echo stripslashes($value['gl_proj_desc']); ?>">
														<input type="hidden" name="project_desc_long" value="<?php echo stripslashes($value['gl_proj_ldesc']); ?>">
														<input type="hidden" name="project_id" value="<?php echo $value['gl_proj_id']; ?>">
														<input type="hidden" name="project_php" value="<?php echo $value['gl_proj_php']; ?>">
														<input type="hidden" name="user_id" value="<?php echo $value['gl_user_id']; ?>">
														<input type="hidden" name="cat_id" value="<?php echo $value['gl_cat_id']; ?>">
													</form>
												</span>
											
											<?php
												if ($value['gl_user_id'] !== '0') {
												?>
												
													<span id="modify-project">
													<form class="action-links" action="<?php echo $site_url; ?>/edit-project/" method="post">
													<input type="hidden" name="project_name" value="<?php echo stripslashes ($value['gl_proj_name']); ?>">
													<input type="hidden" name="project_desc" value="<?php echo stripslashes ($value['gl_proj_desc']); ?>">
													<input type="hidden" name="project_desc_long" value="<?php echo stripslashes ($value['gl_proj_ldesc']); ?>">
													<input type="hidden" name="project_id" value="<?php echo $value['gl_proj_id']; ?>">
													<input type="hidden" name="user_id" value="<?php echo $value['gl_user_id']; ?>">
													<input class="btn btn-primary btn-mini" type="submit" name="submit" value="Modify Project Header">
													</form>
													</span>
													
													<span id="delete-project-container">
													<form class="action-links" action="<?php echo $site_url; ?>/save-project/" method="post">
													<input type="hidden" name="project_name" value="<?php echo $value['gl_proj_name']; ?>">
													<input type="hidden" name="project_desc" value="<?php echo $value['gl_proj_desc']; ?>">
													<input type="hidden" name="project_desc_long" value="<?php echo $value['gl_proj_ldesc']; ?>">
													<input type="hidden" name="project_id" value="<?php echo $value['gl_proj_id']; ?>">
													<input type="hidden" name="user_id" value="<?php echo $value['gl_user_id']; ?>">
													<input class="btn btn-mini" id="delete-project" type="submit" name="delete-project" value="Delete Project">
													</form>
													</span>
												
												<?php
												}
											?>	
											
												</div>

												</fieldset></span>

												</dt>
												</div>
												<script>
													$('#delete-project').click(delete_confirm);
												
													function delete_confirm() {
														var msg = confirm('Are you sure you want to delete this project?');
														if (msg == false) {
															return false;
														}
													}
												</script>
												
												<style>
													.name-container {
														width: 960px;
														border: 1px solid lightgrey;
														height: 75px;
														-webkit-border-radius: 4px;
														border-radius: 4px;
														moz-border-radius: 4px;
														margin-bottom: 5px;
													}

													.button-container {
														height: 25px;
														position: relative;
														width: 260px;
														left: 685px;
														top: -45px;
														
													}

													#save-project {
														width: 70px;
													}

													#modify-project {
														width: 50px;
														position: relative;
														left: 70px;
														top: -43px;
													}
													
													#delete-project-container {
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
								
							</div>
							
					
													
						</section> <!-- end article header -->
						
			
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>