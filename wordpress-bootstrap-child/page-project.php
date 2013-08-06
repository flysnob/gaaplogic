<?php
/*
Template Name: project
*/
?>

<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

<?php
	
	$project_id = $_POST['project_id'];
	$user_id = $_POST['user_id'];
	$project_name = $_POST['project_name'];
	$project_desc = $_POST['project_desc'];
	$project_desc_long = $_POST['project_desc_long'];
	$project_json = $_POST['project_json'];
	$project_php = $_POST['project_php'];
	$cat_id = $_POST['cat_id'];
	
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_cat", ARRAY_A );
	foreach ( $results as $value ){
		if ($value['gl_cat_id'] = $cat_id){
			$cat_table = $value['gl_cat_table'];
		}
	}


	?>
	
	<a class="btn btn-small return hidden" href="<?php echo $site_url; ?>/show-list/">Return to Project List</a><br /><br />
	
	<div id="header"></div> 
	
	<span id="showbreadcrumbs" class="showbreadcrumbs"></span>
	
	<div class="accordion" id="accordion2"> 
		<div id="shownode">
			<div id="wait" style="min-height: 375px; margin-left: auto; margin-left: auto; width: 70%;"><h1>Loading...Please wait</h1></div>
		</div>
	</div>
	<div id="debug0"></div> 
	<div id="debug1"></div> 
	<div id="debug2"></div> 
	<div id="debug3"></div>
	
	<a class="btn btn-small return hidden" href="<?php echo $site_url; ?>/show-list/">Return to Project List</a><br /><br />

	
	</body>
	</html>

	<script>
		title = '<?php echo $project_name; ?>';
		desc = '<?php echo $project_desc; ?>';
		ldesc = '<?php echo $project_desc_long; ?>';
		id = '<?php echo $project_id; ?>';
		name = '<?php echo $project_name; ?>';
		user = '<?php echo $user_id; ?>';
		cat = '<?php echo $cat_id; ?>';
		php = '<?php echo $project_php; ?>';
	</script>
	<script>path = "<?php echo get_template_directory_uri(); ?>/";</script>
	<script src="<?php echo get_template_directory_uri(); ?>/library/js/project.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/library/js/elt.js"></script>

									
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