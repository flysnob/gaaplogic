<?php
/*
Template Name: Homepage Edit Contract
*/
?>

<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">
					
						<section class="post_content">
							
									<?php	
										$user_id = $_POST['user_id'];
										$project_id = $_POST['project_id'];
										$project_desc = $_POST['project_desc'];
										$project_desc_long = $_POST['project_desc_long'];
										$project_name = $_POST['project_name'];
										$contract_type = $_POST['contract_type'];
										$project_fee = $_POST['project_fee'];
										
									?>
										
										<p><a class="btn" href="<?php echo $site_url; ?>/show-revrec-list/">Return to arrangement list</a>&nbsp;&nbsp;&nbsp; 
										<h3>Modify arrangement header</h3>
										<h4><?php echo stripslashes($project_name); ?></h4>
										
										<div class="element-container">
											<form class="form-horizontal" id="project-header" action="<?php echo $site_url; ?>/save-rr-project/" method="post" style="margin-top: 15px"> 
												<div class="control_group row">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="project_date" style="margin-right: 5px">Arrangement date:  </label>
														<div class="controls">
															<input type="date" id="date" name="project_date" value="<?php echo $project_date; ?>" />
														</div>
													</div>
												</div>
												<div class="control_group row">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="project_name" style="margin-right: 5px">Arrangement name:  </label>
														<div class="controls">
															<input type="text" id="name" name="project_name" value="<?php echo $project_name; ?>" />
														</div>
													</div>
												</div>
												<div class="control_group row" style="margin-bottom: 5px">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="project_desc" style="margin-right: 5px">Arrangement short description:  </label>
														<div class="controls">
															<textarea id="proj_desc" name="project_desc" rows="4"><?php echo $project_desc; ?></textarea>
														</div>
													</div>
												</div>
												<div class="control_group row" style="margin-bottom: 5px">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="project_desc_long" style="margin-right: 5px">Arrangement long description:  </label>
														<div class="controls">
															<textarea id="proj_desc_long" name="project_desc_long" rows="8" class="input-xlarge" placeholder="<?php echo $project_desc_long; ?>" ></textarea>
														</div>
													</div>
												</div>
												<div class="control_group row">
													<div class="span12">
														<label class="alert-info control-label span5 offset1" for="project_fee" style="margin-right: 5px">Arrangement fee:  </label>
														<div class="controls">
															<input type="text" id="fee" name="project_fee" value="<?php echo $project_fee; ?>" />
														</div>
													</div>
												</div>
												<div class="control_group row" style="margin-left: auto; margin-left: auto; width: 80%; margin-top: 15px; margin-botton: 15px;">
													<div class="span12">
														<div class="controls">
															<input class="btn btn-primary" id="modify" name="modify" type="submit" value="Save" />
															<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>" />
															<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id; ?>" />
														</div>
													</div>
												</div>
											</form>
										</div>
										
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