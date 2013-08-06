<?php
/*
Template Name: Save Method
*/
session_start();

if (isset($_POST['edit-method'])) {	
	$method_id = $_POST['rr_meth_id'];
	$method_name = $_POST['rr_meth_name'];
	$method_desc = $_POST['rr_meth_desc'];
	
	$method = array( "rr_meth_name"=> $method_name, "rr_meth_desc"=> $method_desc );
	$wpdb->update( 'wp_gl_rr_meth', 
		$method, 
		array ("rr_meth_id" => $method_id) 
		);
	
	header("location: $site_url/edit-methods/");
	exit;
}

if (isset($_POST['assign-methods'])) {
	$deliv_id = $_POST['deliv_id'];
	$method_list = $_POST['method_list'];
	
	$wpdb->query( "DELETE FROM wp_gl_del_meth WHERE rr_del_id = $deliv_id" );
	
	foreach ($method_list as $method){
		$del_meth_join = array ( 'rr_del_id' => $deliv_id, 'rr_meth_id' => $method);
		if ($del_meth_join != null) { 
			$wpdb->insert( 'wp_gl_del_meth', $del_meth_join );
		}
	}
	
	unset ($_POST['assign-methods']);
	unset ($_POST['deliv_id']);
	unset ($_POST['method_list']);
	
	header("location: $site_url/assign-methods/");
	exit;
}

?>