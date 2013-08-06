<?php
global $wpdb;
require( '../../../wp-load.php' );

$json = $_POST['json']; 
$element_id = $_POST['element_id'];
$project_id = $_POST['project_id'];
$status_id = $_POST['status_id'];
$method_id = $_POST['method_id'];
$status_date = $_POST['status_date'];
$status_odate = $_POST['status_odate'];
$status_ovr = $_POST['status_ovr'];
$status_calc = $_POST['status_calc'];
$element_oaus = $_POST['element_oaus'];
$element_aus = $_POST['element_aus'];
$element_wipe = $_POST['element_wipe'];
$deliv_id = $_POST['deliv_id'];
$del_method_id = $_POST['del_method_id'];
$def_element_id = $_POST['def_element_id'];
$total_quest = $_POST['total_quest'];
$def_resp = $_POST['def_resp'];
$no_resp = $_POST['no_resp'];
$na_resp = $_POST['na_resp'];
$total_resp = $_POST['total_resp'];
$rec_resp = $_POST['rec_resp'];
$element_status = $_POST['element_status'];
$overall_status = $_POST['overall_status'];
$overall_status_date = $_POST['overall_status_date'];
$meth_cat_id = $_POST['meth_cat_id'];

if ($json !== null) {
	$json = serialize( $json ); // this saves to mysql // base64_encode(serialize($multidimensional_array))
}


$table = 'wp_gl_rr';


if ($status_id !== null){
	if ($status_id == '1'){
		$dt = 'rr_el_dt_1';
		$st = 'rr_el_st_1';
		$odt = 'rr_el_odt_1';
		$ost = 'rr_el_ost_1';
		$tq = 'rr_el_tq_1';
		$tr = 'rr_el_tr_1';
		$nr = 'rr_el_nr_1';
		$dr = 'rr_el_dr_1';
		$rr = 'rr_el_rr_1';
		$na = 'rr_el_na_1';
	} else if ($status_id == '2'){
		$dt = 'rr_el_dt_2';
		$st = 'rr_el_st_2';
		$odt = 'rr_el_odt_2';
		$ost = 'rr_el_ost_2';
		$tq = 'rr_el_tq_2';
		$tr = 'rr_el_tr_2';
		$nr = 'rr_el_nr_2';
		$dr = 'rr_el_dr_2';
		$rr = 'rr_el_rr_2';
		$na = 'rr_el_na_2';
	} else if ($status_id == '3'){
		$dt = 'rr_el_dt_3';
		$st = 'rr_el_st_3';
		$odt = 'rr_el_odt_3';
		$ost = 'rr_el_ost_3';
		$tq = 'rr_el_tq_3';
		$tr = 'rr_el_tr_3';
		$nr = 'rr_el_nr_3';
		$dr = 'rr_el_dr_3';
		$rr = 'rr_el_rr_3';
		$na = 'rr_el_na_3';
	} else if ($status_id == '4'){
		$dt = 'rr_el_dt_4';
		$st = 'rr_el_st_4';
		$odt = 'rr_el_odt_4';
		$ost = 'rr_el_ost_4';
		$tq = 'rr_el_tq_4';
		$tr = 'rr_el_tr_4';
		$nr = 'rr_el_nr_4';
		$dr = 'rr_el_dr_4';
		$rr = 'rr_el_rr_4';
		$na = 'rr_el_na_4';
	} else {
		echo "Status error";
	}
}		
	
if ($json !== null) {
	$wpdb->update( 
		$table,
		array(
		$dt => $json
		), 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
	);
	//update_el_status($element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	echo '$json: ';
	echo $json;
}

if ($method_id !== null) {
	$wpdb->update( 
		$table,
		array(
		'rr_el_meth' => $method_id
		), 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
	);
	//update_el_status($element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	echo '$method_id: ';
	echo $method_id;
}

/*if ($status_calc !== null) {
	$data = array($st => $status_calc);
	$wpdb->update( 
		$table,
		$data, 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
		);
	echo '$st: ';
	echo $st;
	echo ' : ';
	echo '$status_calc: ';
	echo $status_calc;
	$wpdb->show_errors();
	$wpdb->print_error();
	$wpdb->hide_errors();
}*/

if ($status_date !== null) { // update calc'd status date (and delivery status if status 2)
	if ($element_aus !== null){
		$data = array($dt => $status_date, 'rr_el_austat' => $element_aus);
	} else {
		$data = array($dt => $status_date);
	}
	$wpdb->update( 
		$table,
		$data, 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
	);
	//update_el_status($element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	echo '$dt: ';
	echo $dt;
	echo ' : ';
	echo '$status_date: ';
	echo $status_date;
}

if ($status_ovr !== null) {
	if ($element_oaus !== null){
		$data = array($ost => $status_ovr, $odt => $status_odate, 'rr_el_oaustat' => $element_oaus);
	} else {
		$data = array($ost => $status_ovr, $odt => $status_odate);
	}
	$wpdb->update( 
		$table,
		$data, 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
	);
	//update_el_status($element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	echo '$ost: ';
	echo $ost;
	echo ' : ';
	echo '$status_ovr: ';
	echo $status_ovr;
	echo '$odt: ';
	echo $odt;
	echo ' : ';
	echo '$status_odate: ';
	echo $status_odate;
	$wpdb->show_errors();
	$wpdb->print_error();
	$wpdb->hide_errors();
}

if ($deliv_id !== null) {
	$wpdb->update( 
		$table,
		array(
		rr_el_del => $deliv_id,
		rr_el_meth => $del_method_id,
		'rr_el_ost_1' => '',
		'rr_el_odt_1' => '',
		'rr_el_st_1' => '',
		'rr_el_dt_1' => '',
		'rr_el_ost_2' => '',
		'rr_el_odt_2' => '',
		'rr_el_st_2' => '',
		'rr_el_dt_2' => '',
		'rr_el_ost_3' => '',
		'rr_el_odt_3' => '',
		'rr_el_st_3' => '',
		'rr_el_dt_3' => '',
		'rr_el_ost_4' => '',
		'rr_el_odt_4' => '',
		'rr_el_st_4' => '',
		'rr_el_dt_4' => ''
		), 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
	);
	//update_el_status($element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	$wpdb->show_errors();
	$wpdb->print_error();
	$wpdb->hide_errors();
}

if ($def_element_id !== null) {
	$wpdb->update( 
		$table,
		array(
		$tq => $total_quest,
		$tr => $total_resp,
		$nr => $no_resp,
		$dr => $def_resp,
		$rr => $rec_resp,
		$na => $na_resp,
		$st => $status_calc
		), 
		array(
		'rr_el_id' => $def_element_id
		),
		array(
		'%s'
		)
	);
	echo $def_element_id;
	//update_el_status($def_element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	$wpdb->show_errors();
	$wpdb->print_error();
	$wpdb->hide_errors();
}

if ($overall_status !== null) {
	$wpdb->update( 
		$table,
		array(
		'rr_el_cond_status' => $overall_status,
		'rr_el_cond_date' => $overall_status_date,
		), 
		array(
		'rr_el_id' => $element_id
		),
		array(
		'%s'
		)
	);
	//update_el_status($element_id);
	update_comb_projmeta($project_id);
	update_sw_projmeta($project_id);
	update_sw_revrec($project_id, $project_metas);
	update_sw_status($element_id);
	echo '$json: ';
	echo $json;
}

if ($meth_cat_id !== null) {
	$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	foreach ($elements as $element){
		if ($element['rr_el_meth_cat'] == '2'){ // filter for sofware
			$wpdb->update( 
				$table,
				array(
				'rr_el_stop_flag' => '',
				'rr_el_meth_calc' => '',
				), 
				array(
				'rr_el_id' => $element['rr_el_id']
				),
				array(
				'%s'
				)
			);
		}
	}
	$elements = $wpdb->get_results( "SELECT rr_el_id, rr_el_stop_flag, rr_el_meth_calc FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	print_r($elements);
	
	foreach ($project_metas as $project_meta){	
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_all_vsoe_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_vsoe_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_vsoe_amt'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_pcs_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_undeliv_serv_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_last_del_meth'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_last_del_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_latest_deliv_date'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
		if ($project_meta['gl_proj_meta_key'] == '_proj_sw_latest_deliv_meth'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => 0), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
	}
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	print_r($project_metas);
}
											
?>