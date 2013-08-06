<?php
/*
Template Name: Full Width Page Rev Rec List
*/
?>
<?php session_start(); ?>
<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="row-fluid post_content">
						
							<div class="span12" style="min-height: 500px">
							
					<?php 
						$user_id = $current_user->ID;
						unset ($_SESSION['switch']);
						unset ($_SESSION['project_id']);
						unset ($_SESSION['project_name']);
						unset ($_SESSION['project_desc']);
						unset ($_SESSION['project_desc_long']);
						unset ($_SESSION['element_id']);
						unset ($_SESSION['return_url']);
						
					?>
						<h3>My Arrangements</h3>
							<div id="debug"></div>
						<a class="btn btn-success" href="<?php echo $site_url; ?>/show-revrec-form/">Create a new arrangement analysis</a>
						<br />
						<br />
					<?php
						$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_user_id = $user_id", ARRAY_A );
						foreach ( $projects as $project ){
							if ($project['gl_user_id'] == $user_id){
								if ($project['gl_proj_php'] == 'rr'){
									if ($project['gl_proj_ctype'] == 'multiple'){
										$proj_href = "$site_url/show-element-list/";
									} else {
										$proj_href = "$site_url/show-contract-details/";
										$return_url = "$site_url/show-revrec-list/";
										$_SESSION['switch'] = 1;
									}
										
								?>
									<div class="name-container">
									<dt> 
									<span>
									<fieldset>
									<h4>Arrangement name: <?php echo stripslashes($project['gl_proj_name']); ?></h4>
									<h5>Arrangement Description: <span><?php echo stripslashes($project['gl_proj_desc']); ?></span></h5>
								
									<div class="button-container">
									<span><form class="action-links" action="<?php echo $proj_href; ?>" method="post">
									<input class="btn btn-mini btn-primary" type="submit" name="submit" value="Analyze Arrangement">
									<input type="hidden" name="project_name" value="<?php echo stripslashes($project['gl_proj_name']); ?>">
									<input type="hidden" name="project_desc" value="<?php echo stripslashes($project['gl_proj_desc']); ?>">
									<input type="hidden" name="project_desc_long" value="<?php echo stripslashes($project['gl_proj_ldesc']); ?>">
									<input type="hidden" name="project_id" value="<?php echo $project['gl_proj_id']; ?>">
									<input type="hidden" name="project_php" value="<?php echo $project['gl_proj_php']; ?>">
									<input type="hidden" name="user_id" value="<?php echo $project['gl_user_id']; ?>">
									<input type="hidden" name="cat_id" value="<?php echo $project['gl_cat_id']; ?>">
									<input type="hidden" name="return_url" value="<?php echo $return_url; ?>">
									
									</form></span>
								
								<?php
									if ($project['gl_user_id'] !== '0') {
								?>
								
									<span id="modify-contract">
									<form class="action-links" action="<?php echo $site_url; ?>/edit-contract/" method="post">
									<input type="hidden" name="project_name" value="<?php echo stripslashes ($project['gl_proj_name']); ?>">
									<input type="hidden" name="project_desc" value="<?php echo stripslashes ($project['gl_proj_desc']); ?>">
									<input type="hidden" name="project_desc_long" value="<?php echo stripslashes ($project['gl_proj_ldesc']); ?>">
									<input type="hidden" name="project_id" value="<?php echo $project['gl_proj_id']; ?>">
									<input type="hidden" name="project_fee" value="<?php echo $project['gl_proj_fee']; ?>">
									<input type="hidden" name="user_id" value="<?php echo $project['gl_user_id']; ?>">
									<input class="btn btn-mini btn-primary" type="submit" name="submit" value="Modify Arrangement Header">
									</form>
									</span>
									
									<span id="delete-contract-container">
									<form class="action-links" action="<?php echo $site_url; ?>/save-rr-project/" method="post">
									<input type="hidden" name="project_id" value="<?php echo $project['gl_proj_id']; ?>">
									<input class="btn btn-mini" id="delete-contract" name="delete" type="submit" name="submit" value="Delete Arrangement">
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
										$('#delete-contract').click(delete_confirm);
										
										function delete_confirm() {
											var msg = confirm('Are you sure you want to delete this project?');
											if (msg == false) {
												return false;
											}
										}
									</script>
									
									<style>
										.name-container {
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
											left: 582px;
											top: -45px;
											
										}

										#save-contract {
											width: 70px;
										}

										#modify-contract {
											width: 50px;
											position: relative;
											left: 122px;
											top: -43px;
										}
										
										#delete-contract-container {
											width: 70px;
											position: relative;
											left: 274px;
											top: -86px;
										}

									</style>
								<?php
								}
							}
						}
						
					?>							
							</div>
							
					
													
						</section> <!-- end article header -->
						
			
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>