<?php
/*
Template Name: revrec
*/
?>

<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="post_content">

							<?php 
								$element_id = $_POST['element_id'];
								$user_id = $current_user;
								$element_name = $_POST['element_name'];
								$element_desc = $_POST['element_desc'];
								$element_php = $_POST['element_php'];
								$deliv_id = $_POST['deliv_id'];
								$status_id = $_POST['status_id'];
								$return_url = $_POST['return_url'];
								$project_id = $_POST['project_id'];
								$project_name = $_POST['project_name'];
								
								?>
								<div class="return hidden">
									<form action="<?php echo $return_url; ?>" method="post">
										<input type="hidden" name="element_id" value="<?php echo $element_id; ?>">
										<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
										<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
										<input class="btn btn-small" type="submit" name="edit" value="Return to Element">
									</form>
								</div>
								
								<div id="header"></div> 
								
								<span id="showbreadcrumbs" class="showbreadcrumbs"></span>
								
								<div> 
									<div id="shownode">
										<div id="wait" style="min-height: 375px; margin-left: auto; margin-left: auto; width: 70%;"><h1>Loading...Please wait</h1></div>
									</div>
								</div>
								<div id="debug0"></div> 
								<div id="debug1"></div> 
								<div id="debug2"></div> 
								<div id="debug3"></div>
								
								<br />
								<div class="return hidden">
									<form action="<?php echo $return_url; ?>" method="post">
										<input type="hidden" name="element_id" value="<?php echo $element_id; ?>">
										<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
										<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
										<input class="btn btn-small" type="submit" name="edit" value="Return to Element">
									</form>
								</div>
								
								</body>
								</html>
								
								<script>
									title = '<?php echo $element_name; ?>';
									desc = '<?php echo $element_desc; ?>';
									el = '<?php echo $element_id; ?>';
									proj = '<?php echo $project_id; ?>';
									name = '<?php echo $project_name; ?>';
									deliv = '<?php echo $deliv_id; ?>';
									stat = '<?php echo $status_id; ?>';
									user = '<?php echo $current_user->ID; ?>';
									url = '<?php echo $return_url; ?>';
									php = '<?php echo $element_php; ?>';
									
								</script>
								<script src="<?php echo get_template_directory_uri(); ?>/library/js/rr_analysis.js"></script>
								
								<script>path = "<?php echo get_template_directory_uri(); ?>/";</script>
																
							<style>
							.info-container textarea {
								position: absolute;
								width: 385px;
								margin-top: 2px;
								float: left;
							}

							.comment {
								line-height: 16px;
								font-size: 12px;
								position: absolute;
								left: 0px;
								width: 385px;
								height: 121px;
								margin-top: 2px;
								border: 1px solid lightblue;
								-webkit-border-radius: 3px;
								border-radius: 3px;
								overflow: auto;
								padding-bottom: 3px;
								padding-left: 6px;
								padding-right: 6px;
								padding-top: 4px;
							}

							.button-comment {
								position: relative;
								left: 400px;
								top: 2px;
							}

							.accordion {
								overflow-y:auto;
							}

							.question-container button {
								position: absolute;
								top: 375px;
							}

							.header {
								position: fixed;
								height: 100px;
								top: 0px;
								
							}

							.node-container {
								border: 1px solid lightblue;
								margin: 2px;
								min-height: 480;
							}

							.accordion-body {
								
							}

							.accordion-inner {
								
							}

							.question-container {
								position: relative;
								left: 0px;
								top: 10px;
								width: 400px; 
								min-height: 275px;
							}

							.info-container {
								position: relative;
								left: 410px;
								top: -275px;
								width: 520px;
								height: 266px;
								min-height: 275px;
							}

							.summary {
								line-height: 16px;
								font-size: 12px;
								min-height: 60px;
								border: 1px solid lightgrey;
								-webkit-border-radius: 3px;
								border-radius: 3px;
								overflow: auto;
								padding-bottom: 3px;
								padding-left: 6px;
								padding-right: 6px;
								padding-top: 4px;
								
							}

							.conclusion-container{
								position: relative;
								top: 110px;
								height: 141px;
							}

							.conclusion-container p{
								line-height: 16px;
								font-size: 12px;
							}


							</style>
							
						</section> <!-- end article section -->
									
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>