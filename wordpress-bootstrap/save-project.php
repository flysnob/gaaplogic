<?php
/*
Template Name: Save Project
*/

session_start();

if (isset($_POST['save-project'])) {
	$project_name = $_POST['project_name'];
	$project_desc = $_POST['project_desc'];
	$cat_id = $_POST['cat_id'];
	$user_id = $current_user->ID;
	$cats = $wpdb->get_results( "SELECT * FROM wp_gl_cat WHERE gl_cat_id = $cat_id", ARRAY_A );

	foreach ($cats as $cat){
		$project = array( "gl_user_id" => $user_id, "gl_cat_id" => $cat_id, "gl_proj_name" => $project_name, "gl_proj_desc"=> $project_desc,
			"gl_proj_php"=> $cat['gl_cat_php'], "gl_cat_start_node"=> $cat['gl_cat_start_node']);
	}
	$wpdb->insert( 'wp_gl_proj', $project );
	
	unset ($_POST['save-project']);
	
	header("location: $site_url/show-list/");
	exit;
}

if (isset($_POST['delete-project'])) {	
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$wpdb->query("DELETE FROM wp_gl_proj WHERE gl_proj_id = $project_id ");
	
	unset ($_POST['delete-project']);
	
	header("location: $site_url/show-list/");
	exit;
}

if (isset($_POST['modify-project'])) {
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$project_desc = $_POST['project_desc'];
	$project_desc_long = $_POST['project_desc_long'];
	$wpdb->update( 'wp_gl_proj', array ("gl_proj_name" => $project_name, "gl_proj_desc" => $project_desc, "gl_proj_ldesc" => $project_desc_long), array ("gl_proj_id" => $project_id) );
	
	unset ($_POST['modify-project']);
	
	header("location: $site_url/show-list/");
	exit;
}

?>