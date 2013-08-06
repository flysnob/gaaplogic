<?php
global $wpdb;
require( '../../../wp-load.php' );

$deliv_meth_id = $_GET['deliv_meth_id'];
$deliv_id = $_GET['deliv_id'];
$meth_id = $_GET['meth_id'];

	
if ($deliv_id !== null) {
	$deliv_delivs = array();
	$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
	foreach ($delivs as $key => $deliv){
		if ($deliv['rr_del_id'] == $deliv_id){
			$array = array('rr_del_id' => $deliv['rr_del_id'], 'rr_del_name' => $deliv['rr_del_name'],
				'rr_del_desc' => $deliv['rr_del_desc']);
			array_push($deliv_delivs, $array);
		}
	}
	$deliv_delivs = json_encode($deliv_delivs);
	print_r ($deliv_delivs);
}
	
if ($deliv_meth_id !== null) {
	$deliv_meths = array();
	$results = $wpdb->get_results($wpdb->prepare(
		"
		SELECT 		*
		FROM 		wp_gl_del_meth
		INNER JOIN 	wp_gl_rr_meth
					ON wp_gl_rr_meth.rr_meth_id = wp_gl_del_meth.rr_meth_id
		ORDER BY 	rr_meth_name ASC
		", 
		ARRAY_A ));
	foreach ($results as $result){
		if ($result->rr_del_id == $deliv_meth_id){
			$array = array('rr_del_id' => $result->rr_del_id, 'rr_meth_id' => $result->rr_meth_id, 'rr_meth_name' => $result->rr_meth_name,
				'rr_meth_desc' => $result->rr_del_desc);
			array_push($deliv_meths, $array);
		}
	}
	$deliv_meths = json_encode($deliv_meths);
	print_r ($deliv_meths);
}

if ($meth_id !== null) {
	$meth_meths = array();
	$methods = $wpdb->get_results( "SELECT * FROM wp_gl_rr_meth", ARRAY_A );
	foreach ($methods as $method){
		if ($method['rr_meth_id'] == $meth_id){
			$array = array('rr_meth_id' => $method['rr_meth_id'], 'rr_meth_name' => $method['rr_meth_name'],
				'rr_meth_desc' => $method['rr_meth_desc']);
			array_push($meth_meths, $array);
		}
	}
	$meth_meths = json_encode($meth_meths);
	print_r ($meth_meths);
}
											
?>