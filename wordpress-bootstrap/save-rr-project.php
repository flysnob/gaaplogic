<?php
/*
Template Name: Save RR Project
*/

session_start();

if (isset($_POST['save-single'])) {
	$cat_id = $_POST['cat_id'];
	$user_id = $_POST['user_id'];
	$project_date = $_POST['project_date'];
	$project_name = $_POST['project_name'];
	$project_desc = $_POST['project_desc'];
	$project_desc_long = $_POST['project_desc_long'];
	$project_php = $_POST['project_php'];
	$contract_type = $_POST['contract_type'];
	$revrec_type = $_POST['revrec_type'];
	$project_fee = $_POST['project_fee'];
	$forward_url = $_POST['forward_url'];
	
	$project = array( "gl_user_id"=> $current_user->ID, "gl_cat_id"=> $cat_id, "gl_proj_date"=> $project_date, "gl_proj_name"=> $project_name,
		"gl_proj_desc"=> $project_desc, "gl_proj_ldesc"=> $project_desc_long, "gl_proj_php"=> $project_php, "gl_proj_fee"=> $project_fee, 
		"gl_proj_ctype"=> $contract_type);
		
	if ($project != null) { // insert new project in table
		$wpdb->insert( wp_gl_proj, $project );
	}
	
	$project_id =$wpdb->insert_id;
	
	$element = array( "gl_proj_id"=> $project_id, "rr_el_name"=> $project_name, "rr_el_desc"=> $project_desc, "rr_el_amt"=> $project_fee);
		
	if ($element != null) { // insert new project in table
		$wpdb->insert( wp_gl_rr, $element );		
		$wpdb->print_error();
		$element_id =$wpdb->insert_id;
	}
	
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	$_SESSION['project_desc'] = $project_desc;
	$_SESSION['project_desc_long'] = $project_desc_long;
	$_SESSION['project_fee'] = $project_fee;
	$_SESSION['element_id'] = $element_id;
	
	unset ($_POST['save-single']);
	
	header("location: $site_url/add-contract-details/");
	
	exit;
}

if (isset($_POST['save-multiple'])) {
	$cat_id = $_POST['cat_id'];
	$user_id = $_POST['user_id'];
	$project_date = $_POST['project_date'];
	$project_name = $_POST['project_name'];
	$project_desc = $_POST['project_desc'];
	$project_desc_long = $_POST['project_desc_long'];
	$project_php = $_POST['project_php'];
	$contract_type = $_POST['contract_type'];
	$revrec_type = $_POST['revrec_type'];
	$project_fee = $_POST['project_fee'];
	$forward_url = $_POST['forward_url'];
	
	$project = array( "gl_user_id"=> $current_user->ID, "gl_cat_id"=> $cat_id, "gl_proj_date"=> $project_date, "gl_proj_name"=> $project_name,
		"gl_proj_desc"=> $project_desc, "gl_proj_ldesc"=> $project_desc_long, "gl_proj_php"=> $project_php, "gl_proj_fee"=> $project_fee, 
		"gl_proj_ctype"=> $contract_type);
		
	if ($project != null) { // insert new project in table
		$wpdb->insert( wp_gl_proj, $project );
	}
	
	$project_id =$wpdb->insert_id;
		
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_comb_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_hv_all_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_fm_all_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_all_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_ls_all_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_fr_all_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_all_vsoe_flag', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_comb_date', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_comb_meth', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_vsoe_flag', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_undeliv_vsoe_flag', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_undeliv_pcs_flag', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_undeliv_serv_flag', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_undeliv_vsoe_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_last_del_meth', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_last_del_flag', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_comb_stat', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sfp_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_ufp_disc_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_ufp_disc_rate', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sfswp_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_ufswp_disc_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_ufswp_disc_rate', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_swsu_alloc_amt', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_fp_disc_rate_calc', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_swfp_disc_rate_calc', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_latest_deliv_date', 'gl_proj_meta_value' => '' ));
	$wpdb->insert( 'wp_gl_projmeta', array ( "gl_proj_id" => $project_id, 'gl_proj_meta_key' => '_proj_sw_latest_deliv_meth', 'gl_proj_meta_value' => '' ));
	
	unset ($_POST['save-multiple']);
	
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	
	header("location: $site_url/show-element-list/");
	
	exit;
}

if (isset($_POST['save-add-details'])) {
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$element_id = $_POST['element_id'];
	$element_del = $_POST['element_del'];
	$sw_element = $_POST['sw_element'];
	$delivery_amount = $_POST['delivery_amount'];
	$contingent_amount = $_POST['contingent_amount'];
	$contingent_item = $_POST['contingent_item'];
	$contingent_desc = $_POST['contingent_desc'];
	
	$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
	
	foreach ($delivs as $deliv){
		if ($deliv['rr_del_id'] == $element_del){
			$method_cat = $deliv['rr_meth_asc_id'];
		}
	}
	
	$element = array( "rr_el_del"=> $element_del, "rr_el_sw_flag"=> $sw_element, "rr_el_del_amt"=> $delivery_amount, 
		"rr_el_sp_cont"=> $contingent_amount, "rr_el_cont_item"=> $contingent_item, "rr_el_cont_desc"=> $contingent_desc, "rr_el_meth_cat"=> $method_cat );
	
	if ($element != null) { 
		$wpdb->update( 'wp_gl_rr', $element, array ("rr_el_id" => $element_id) );
		$wpdb->print_error();
	}
	
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	$_SESSION['element_id'] = $element_id;
	$_SESSION['return_url'] = '<?php echo get_template_directory_uri(); ?>/show-revrec-list/';
	
	header("location: $site_url/show-contract-details/");
	
	exit;
}

if (isset($_POST['save-edit'])) {
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$element_id = $_POST['element_id'];
	$page_id = $_POST['page_id'];
	$element_name = $_POST['element_name'];
	$element_desc = $_POST['element_desc'];
	$sw_element = $_POST['sw_element'];
	$contract_price = $_POST['contract_price'];
	$delivery_amount = $_POST['delivery_amount'];
	$sp_contingent = $_POST['sp_contingent'];
	$contingent_amount = $_POST['contingent_amount'];
	$contingent_item = $_POST['contingent_item'];
	$contingent_desc = $_POST['contingent_desc'];
	$contingent_stat = $_POST['contingent_stat'];
	$contingent_date = $_POST['contingent_date'];
	$element_sep = null;
	$element_notes = $_POST['element_notes'];
	
	$element_data = array ("rr_el_name" => $element_name, "rr_el_desc" => $element_desc, "rr_el_sw_flag" => $sw_element, "rr_el_amt" => $contract_price, 
		"rr_el_del_amt" => $delivery_amount, "rr_el_cont_amt" => $contingent_amount, "rr_el_cont_item" => $contingent_item, 
		"rr_el_cont_desc" => $contingent_desc, "rr_el_cont_stat" => $contingent_stat, "rr_el_cont_date" => $contingent_date, "rr_el_notes" => $element_notes);
	
	$wpdb->update( 'wp_gl_rr', 
		$element_data, 
		array ("rr_el_id" => $element_id) );
	
	unset ($_POST['save']);
	
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	$_SESSION['element_id'] = $element_id;
	$_SESSION['page_id'] = $page_id;
	
	header("location: $site_url/show-contract-details/");
	
	exit;
}

if (isset($_POST['modify'])) {
	$project_id = $_POST['project_id'];
	$project_date = $_POST['project_date'];
	$project_name = $_POST['project_name'];
	$project_desc = $_POST['project_desc'];
	$project_desc_long = $_POST['project_desc_long'];
	$project_fee = $_POST['project_fee'];
	
	$wpdb->update( 'wp_gl_proj', array ("gl_proj_name" => $project_name, "gl_proj_date" => $project_date, "gl_proj_desc" => $project_desc, 
		"gl_proj_ldesc" => $project_desc_long, "gl_proj_fee" => $project_fee), array ("gl_proj_id" => $project_id) );
	
	unset ($_POST['modify']);
	
	header("location: $site_url/show-revrec-list/");
	
	exit;
}

if (isset($_POST['set-date'])) {
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$project_asof_date = $_POST['project_asof_date'];
	
	$wpdb->update( 'wp_gl_proj', array ("gl_proj_asof_date" => $project_asof_date), array ("gl_proj_id" => $project_id) );
	
	unset ($_POST['set-date']);
	
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	$_SESSION['project_asof_date'] = $project_asof_date;
	
	header("location: $site_url/show-element-list/");
	
	exit;
}

if (isset($_POST['delete'])) {	
	$project_id = $_POST['project_id'];
	$wpdb->query("DELETE FROM wp_gl_proj WHERE gl_proj_id = '$project_id' ");
	
	unset ($_POST['delete']);
	
	header("location: $site_url/show-revrec-list/");
	
	exit;
}

?>