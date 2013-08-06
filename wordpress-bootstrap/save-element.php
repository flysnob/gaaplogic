<?php
/*
Template Name: Save Element
*/
session_start();

if (isset($_POST['save-new'])) {	
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$element_name = $_POST['element_name'];
	$element_desc = $_POST['element_desc'];
	$element_del = $_POST['element_del'];
	$element_sep = $_POST['element_sep'];
	$selling_price = $_POST['selling_price'];
	$selling_basis = $_POST['selling_basis'];
	$vsoe_basis = $_POST['vsoe_basis'];
	$sw_element = $_POST['sw_element'];
	$sw_last = $_POST['sw_last'];
	$delivery_amount = $_POST['delivery_amount'];
	$contingent_amount = $_POST['contingent_amount'];
	$contingent_item = $_POST['contingent_item'];
	$contingent_desc = $_POST['contingent_desc'];
	$contingent_stat = $_POST['contingent_stat'];
	$contingent_date = $_POST['contingent_date'];
	$spec_alloc = $_POST['spec_alloc'];
	$disc_cat = $_POST['disc_cat'];
	$meth_cat = $_POST['meth_cat'];
	$sfp_amt = $_POST['sfp_amt'];
	$sfp_disc_amt = $_POST['sfp_disc_amt'];
	$ufp_disc_amt = $_POST['ufp_disc_amt'];
	$ufp_disc_rate = $_POST['ufp_disc_rate'];
	$sw_sfp_amt = $_POST['sw_sfp_amt'];
	$sw_sfp_disc_amt = $_POST['sw_sfp_disc_amt'];
	$sw_ufp_disc_amt = $_POST['sw_ufp_disc_amt'];
	$sw_ufp_disc_rate = $_POST['sw_ufp_disc_rate'];
	
	$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
	
	foreach ($delivs as $deliv){
		if ($deliv['rr_del_id'] == $element_del){
			$method_cat = $deliv['rr_meth_asc_id'];
		}
	}
	
	if ($meth_cat == 1){
		if ($disc_cat == 1){
			$disc_amt = $sfp_disc_amt;
			$disc_rate = 0;
		} else if ($disc_cat == 2){
			$disc_amt = $ufp_disc_amt;
			$disc_rate = $ufp_disc_rate;
		}
	} else if ($meth_cat == 2){
		if ($disc_cat == 1){
			$sfp_amt = $sw_sfp_amt;
			$disc_amt = $sw_sfp_disc_amt;
			$disc_rate = 0;
		} else if ($disc_cat == 2){
			$disc_amt = $sw_ufp_disc_amt;
			$disc_rate = $sw_ufp_disc_rate;
		}
	}
	
	$element = array( "gl_proj_id"=> $project_id, "rr_el_name"=> $element_name, "rr_el_desc"=> $element_desc, "rr_el_del"=> $element_del, 
		"rr_el_sep"=> $element_sep,	"rr_el_sell_price"=> $selling_price, "rr_el_sp_basis"=> $selling_basis, "rr_el_vsoe_avail"=> $vsoe_avail, 
		"rr_el_vsoe_basis"=> $vsoe_basis, "rr_el_sw_flag"=> $sw_element, "rr_el_last_del"=> $sw_last, "rr_el_del_amt"=> $delivery_amount, 
		"rr_el_sp_cont"=> $contingent_amount, "rr_el_cont_item"=> $contingent_item, "rr_el_cont_desc"=> $contingent_desc, 
		"rr_el_cont_stat" => $contingent_stat, "rr_el_cont_date" => $contingent_date, "rr_el_spec_amt"=> $spec_alloc, "rr_el_meth_cat"=> $method_cat,
		"rr_el_sfp_amt"=> $sfp_amt, "rr_el_disc_amt"=> $disc_amt, "rr_el_disc_rate"=> $disc_rate, "rr_el_disc_cat"=> $disc_cat);
	
	if ($element != null) {
		$wpdb->insert( wp_gl_rr, $element );
		$wpdb->print_error();
		$element_id =$wpdb->insert_id;
		
		$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
		
		foreach ($results as $value){
			if ($value['rr_el_meth_cat'] == '2'){ // filter for sofware
				$wpdb->update( 
					'wp_gl_rr',
					array(
					'rr_el_stop_flag' => '',
					'rr_el_meth_calc' => '',
					), 
					array(
					'rr_el_id' => $value['rr_el_id']
					),
					array(
					'%s'
					)
				);
			}
		}
		
		$sp_accum_array = update_sp_accum($project_id);
		
		$cat_alloc_array = update_cat_alloc($project_id, $sp_accum_array);
		
		$elements_array = update_allocation($project_id, $cat_alloc_array, $sp_accum_array);
		
		foreach ($elements_array as $el){
			$wpdb->update( 
				'wp_gl_rr', 
				array ("rr_el_amt" => $el['element_allocation'], "rr_el_cont_amt" => $el['element_contingent']), 
				array ("rr_el_id" => $el['element_id']) 
			);
		}
		$comb_allocation = update_combined_allocation($project_id);
		
		//  Category accumulations are no longer needed. Delete here and in functions.php
		/*$hv_allocation = update_hv_allocation($project_id);
		$fm_allocation = update_fm_allocation($project_id);
		$sw_allocation = update_sw_allocation($project_id);
		$ls_allocation = update_ls_allocation($project_id);
		$fr_allocation = update_fr_allocation($project_id);*/
		
		$sw_vsoe = update_sw_vsoe($project_id);
		
		$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
		
		foreach ($project_metas as $project_meta_1){
			if ($project_meta_1['gl_proj_meta_key'] == '_proj_fp_disc_rate_calc'){
				foreach ($project_metas as $project_meta_2){
					if ($project_meta_2['gl_proj_meta_key'] == '_proj_fp_disc_rate'){
						$fp_disc_rate = $project_meta_2['gl_proj_meta_value'];
					}
					if ($project_meta_2['gl_proj_meta_key'] == '_proj_fp_disc_amt'){
						$fp_disc_amt = $project_meta_2['gl_proj_meta_value'];
					}
				}
				$fp_disc_rate_calc = ($cat_alloc_array['other'] - $fp_disc_amt) *  $fp_disc_rate;
				$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $fp_disc_rate_calc), array ("gl_proj_meta_id" => $project_meta_1['gl_proj_meta_id']) );
			}
			if ($project_meta_1['gl_proj_meta_key'] == '_proj_swfp_disc_rate_calc'){
				foreach ($project_metas as $project_meta_3){
					if ($project_meta_3['gl_proj_meta_key'] == '_proj_swfp_disc_rate'){
						$swfp_disc_rate = $project_meta_3['gl_proj_meta_value'];
					}
					if ($project_meta_3['gl_proj_meta_key'] == '_proj_swfp_disc_amt'){
						$swfp_disc_amt = $project_meta_3['gl_proj_meta_value'];
					}
				}
				echo "cat_alloc_array['sw']: ".$cat_alloc_array['sw'];
				echo "cat_alloc_array['swsu']: ".$cat_alloc_array['swsu'];
				echo "swfp_disc_amt: ".$swfp_disc_amt;
				$swfp_disc_rate_calc = ($cat_alloc_array['sw'] - $cat_alloc_array['swsu'] - $swfp_disc_amt) *  $swfp_disc_rate;
				$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $swfp_disc_rate_calc), array ("gl_proj_meta_id" => $project_meta_1['gl_proj_meta_id']) );
			}
			
			if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_all_vsoe_flag'){
				$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $sw_vsoe), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
			}
		}
		
		update_sw_projmeta($project_id);
		
		update_sw_revrec($project_id);
		
		update_comb_projmeta($project_id);
	}
	
	unset ($_POST['save-new']);
	
	$_SESSION['_proj_comb_amt'] = $comb_allocation;
	$_SESSION['elements_array'] = $elements_array;
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	
	header("location: $site_url/show-element-form/");
	exit;
}

if (isset($_POST['save-edit'])) {
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$element_id = $_POST['element_id'];
	$element_name = $_POST['element_name'];
	$element_desc = $_POST['element_desc'];
	$sw_element = $_POST['sw_element'];
	$sw_last_element = $_POST['sw_last_element'];
	$selling_price = $_POST['selling_price'];
	$spec_alloc = $_POST['spec_alloc'];
	$sp_basis = $_POST['sp_basis'];
	$vsoe_basis = $_POST['vsoe_basis'];
	$delivery_amount = $_POST['delivery_amount'];
	$sp_contingent = $_POST['sp_contingent'];
	$contingent_amount = $_POST['contingent_amt'];
	$contingent_item = $_POST['contingent_item'];
	$contingent_desc = $_POST['contingent_desc'];
	$contingent_stat = $_POST['contingent_stat'];
	$contingent_date = $_POST['contingent_date'];
	$element_sep = $_POST['element_sep'];
	$element_notes = $_POST['element_notes'];
	$sfp_amt = $_POST['sfp_amt'];
	$sfp_disc_amt = $_POST['sfp_disc_amt'];
	
	$element_data = array ("rr_el_name" => $element_name, "rr_el_desc" => $element_desc, "rr_el_sw_flag" => $sw_element, 
		"rr_el_last_del" => $sw_last_element, "rr_el_sell_price" => $selling_price, "rr_el_spec_amt" => $spec_alloc,
		"rr_el_sp_basis" => $sp_basis,"rr_el_vsoe_basis" => $vsoe_basis, "rr_el_del_amt" => $delivery_amount, "rr_el_sp_cont" => $contingent_amount,	
		"rr_el_cont_item" => $contingent_item, "rr_el_cont_desc" => $contingent_desc, "rr_el_cont_stat" => $contingent_stat, 
		"rr_el_cont_date" => $contingent_date, "rr_el_sep" => $element_sep, "rr_el_notes" => $element_notes, "rr_el_sfp_amt"=> $sfp_amt,
		"rr_el_disc_amt"=> $sfp_disc_amt);
	
	$wpdb->update( 'wp_gl_rr', 
		$element_data, 
		array ("rr_el_id" => $element_id) );
	
	$sp_accum_array = update_sp_accum($project_id);
	
	$cat_alloc_array = update_cat_alloc($project_id, $sp_accum_array);
	
	$elements_array = update_allocation($project_id, $cat_alloc_array, $sp_accum_array);
	
	foreach ($elements_array as $el){
		$wpdb->update( 
			'wp_gl_rr', 
			array ("rr_el_amt" => $el['element_allocation'], "rr_el_cont_amt" => $el['element_contingent']), 
			array ("rr_el_id" => $el['element_id']) 
		);
	}
	
	$comb_allocation = update_combined_allocation($project_id);
	
	//  Category accumulations are no longer needed. Delete here and in functions.php
	/*$hv_allocation = update_hv_allocation($project_id);
	$fm_allocation = update_fm_allocation($project_id);
	$sw_allocation = update_sw_allocation($project_id);
	$ls_allocation = update_ls_allocation($project_id);
	$fr_allocation = update_fr_allocation($project_id);*/
	
	$sw_vsoe = update_sw_vsoe($project_id);
	
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	
	foreach ($project_metas as $project_meta_1){
		if ($project_meta_1['gl_proj_meta_key'] == '_proj_fp_disc_rate_calc'){
			foreach ($projects_meta as $project_meta_2){
				if ($project_meta_2['gl_proj_meta_key'] == '_proj_fp_disc_rate'){
					$fp_disc_rate = $project_meta_2['gl_proj_meta_value'];
				}
				if ($project_meta_2['gl_proj_meta_key'] == '_proj_fp_disc_amt'){
					$fp_disc_amt = $project_meta_2['gl_proj_meta_value'];
				}
			}
			$fp_disc_rate_calc = ($cat_alloc_array['other'] - $fp_disc_amt) *  $fp_disc_rate;
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $fp_disc_rate_calc), array ("gl_proj_meta_id" => $project_meta_1['gl_proj_meta_id']) );
		}
		if ($project_meta_1['gl_proj_meta_key'] == '_proj_swfp_disc_rate_calc'){
			foreach ($project_metas as $project_meta_3){
				if ($project_meta_3['gl_proj_meta_key'] == '_proj_swfp_disc_rate'){
					$swfp_disc_rate = $project_meta_3['gl_proj_meta_value'];
				}
				if ($project_meta_3['gl_proj_meta_key'] == '_proj_swfp_disc_amt'){
					$swfp_disc_amt = $project_meta_3['gl_proj_meta_value'];
				}
			}
			echo "cat_alloc_array['sw']: ".$cat_alloc_array['sw'];
			echo "cat_alloc_array['swsu']: ".$cat_alloc_array['swsu'];
			echo "swfp_disc_amt: ".$swfp_disc_amt;
			$swfp_disc_rate_calc = ($cat_alloc_array['sw'] - $cat_alloc_array['swsu'] - $swfp_disc_amt) *  $swfp_disc_rate;
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $swfp_disc_rate_calc), array ("gl_proj_meta_id" => $project_meta_1['gl_proj_meta_id']) );
		}

		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_all_vsoe_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $sw_vsoe), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
	}
	
	update_sw_projmeta($project_id);
	
	update_sw_revrec($project_id);
	
	update_comb_projmeta($project_id);
	
	unset ($_POST['save-edit']);
	
	$_SESSION['_proj_comb_amt'] = $comb_allocation;
	$_SESSION['elements_array'] = $elements_array;
	$_SESSION['element_id'] = $element_id;
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	
	header("location: $site_url/show-element/");
	exit;
}

if (isset($_POST['delete'])) {
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$element_id = $_POST['element_id'];
	$wpdb->query("DELETE FROM wp_gl_rr WHERE rr_el_id = '$element_id' ");

	$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
	
	foreach ($results as $value){
		if ($value['rr_el_meth_cat'] == '2'){ // filter for software
			$wpdb->update( 
				'wp_gl_rr',
				array(
				'rr_el_stop_flag' => '',
				'rr_el_meth_calc' => '',
				), 
				array(
				'rr_el_id' => $value['rr_el_id']
				),
				array(
				'%s'
				)
			);
		}
	}
	
	$sp_accum_array = update_sp_accum($project_id);
	$cat_alloc_array = update_cat_alloc($project_id, $sp_accum_array);
	$elements_array = update_allocation($project_id, $cat_alloc_array, $sp_accum_array);
	
	foreach ($elements_array as $el){
		$wpdb->update( 
			'wp_gl_rr', 
			array ("rr_el_amt" => $el['element_allocation'], "rr_el_cont_amt" => $el['element_contingent']), 
			array ("rr_el_id" => $el['element_id']) 
		);
	}
	
	$comb_allocation = update_combined_allocation($project_id);
	
	//  Category accumulations are no longer needed. Delete here and in functions.php
	/*$hv_allocation = update_hv_allocation($project_id);
	$fm_allocation = update_fm_allocation($project_id);
	$sw_allocation = update_sw_allocation($project_id);
	$ls_allocation = update_ls_allocation($project_id);
	$fr_allocation = update_fr_allocation($project_id);*/
	
	$sw_vsoe = update_sw_vsoe($project_id);
	
	$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
	
	foreach ($project_metas as $project_meta_1){
		if ($project_meta_1['gl_proj_meta_key'] == '_proj_fp_disc_rate_calc'){
			foreach ($projects_meta as $project_meta_2){
				if ($project_meta_2['gl_proj_meta_key'] == '_proj_fp_disc_rate'){
					$fp_disc_rate = $project_meta_2['gl_proj_meta_value'];
				}
				if ($project_meta_2['gl_proj_meta_key'] == '_proj_fp_disc_amt'){
					$fp_disc_amt = $project_meta_2['gl_proj_meta_value'];
				}
			}
			$fp_disc_rate_calc = ($cat_alloc_array['other'] - $fp_disc_amt) *  $fp_disc_rate;
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $fp_disc_rate_calc), array ("gl_proj_meta_id" => $project_meta_1['gl_proj_meta_id']) );
		}
		if ($project_meta_1['gl_proj_meta_key'] == '_proj_swfp_disc_rate_calc'){
			foreach ($project_metas as $project_meta_3){
				if ($project_meta_3['gl_proj_meta_key'] == '_proj_swfp_disc_rate'){
					$swfp_disc_rate = $project_meta_3['gl_proj_meta_value'];
				}
				if ($project_meta_3['gl_proj_meta_key'] == '_proj_swfp_disc_amt'){
					$swfp_disc_amt = $project_meta_3['gl_proj_meta_value'];
				}
			}
			echo "cat_alloc_array['sw']: ".$cat_alloc_array['sw'];
			echo "cat_alloc_array['swsu']: ".$cat_alloc_array['swsu'];
			echo "swfp_disc_amt: ".$swfp_disc_amt;
			$swfp_disc_rate_calc = ($cat_alloc_array['sw'] - $cat_alloc_array['swsu'] - $swfp_disc_amt) *  $swfp_disc_rate;
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $swfp_disc_rate_calc), array ("gl_proj_meta_id" => $project_meta_1['gl_proj_meta_id']) );
		}

		if ($project_meta['gl_proj_id'] == $project_id && $project_meta['gl_proj_meta_key'] == '_proj_sw_all_vsoe_flag'){
			$wpdb->update( 'wp_gl_projmeta', array ("gl_proj_meta_value" => $sw_vsoe), array ("gl_proj_meta_id" => $project_meta['gl_proj_meta_id']) );
		}
	}
	
	update_sw_projmeta($project_id);
	
	update_sw_revrec($project_id);
	
	update_comb_projmeta($project_id);
	
	unset ($_POST['delete']);
	
	$_SESSION['project_id'] = $project_id;
	$_SESSION['project_name'] = $project_name;
	
	header("location: $site_url/show-element-list/");
	exit;
}

?>