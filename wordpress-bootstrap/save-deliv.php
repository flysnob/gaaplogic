<?php
/*
Template Name: Save Deliv
*/
session_start();

if (isset($_POST['edit-deliv'])) {	
	$deliv_id = $_POST['rr_del_id'];
	$deliv_name = $_POST['rr_del_name'];
	$deliv_desc = $_POST['rr_del_desc'];
	$deliv_group_1 = $_POST['gl_node_group_id_1'];
	$deliv_group_2 = $_POST['gl_node_group_id_2'];
	$deliv_group_3 = $_POST['gl_node_group_id_3'];
	$deliv_group_4 = $_POST['gl_node_group_id_4'];
	
	$deliv = array( "rr_del_name"=> $deliv_name, "rr_del_desc"=> $deliv_desc, "gl_node_group_id_1"=> $deliv_group_1, "gl_node_group_id_2"=> $deliv_group_2,
		"gl_node_group_id_3"=> $deliv_group_3, "gl_node_group_id_4"=> $deliv_group_4);
	$wpdb->update( 'wp_gl_rr_del', 
		$deliv, 
		array ("rr_del_id" => $deliv_id) 
		);
	
	header("location: $site_url/edit-delivs/");
	exit;
}

?>