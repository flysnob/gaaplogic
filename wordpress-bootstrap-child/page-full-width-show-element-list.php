<?php
/*
Template Name: Full Width Page Show Element List
*/
session_start();
?>

<?php get_header(wide); ?>
			
<?php 
	
$user_id = $_POST['user_id'];

if (isset($_SESSION['project_id'])){
	$project_id = $_SESSION['project_id'];
} else {
	$project_id = $_POST['project_id'];
}

if (isset($_SESSION['project_name'])){
	$project_name = $_SESSION['project_name'];
} else {
	$project_name = $_POST['project_name'];
}

$project_desc = $_POST['project_desc'];
$project_desc_long = $_POST['project_desc_long'];
$project_json = $_POST['project_json'];
$project_php = $_POST['project_php'];
$cat_id = $_POST['cat_id'];

unset ($_SESSION['element_id']);

$projects = $wpdb->get_results( "SELECT * FROM wp_gl_proj WHERE gl_proj_id = $project_id", ARRAY_A );
$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE gl_proj_id = $project_id", ARRAY_A );
$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
$methods = $wpdb->get_results( "SELECT * FROM wp_gl_rr_meth", ARRAY_A );
$project_metas = $wpdb->get_results( "SELECT * FROM wp_gl_projmeta WHERE gl_proj_id = $project_id", ARRAY_A );
$stats = $wpdb->get_results( "SELECT * FROM wp_gl_rr_stat", ARRAY_A );

foreach ($project_metas as $project_meta){
	$key = $project_meta['gl_proj_meta_key'];
	switch ($key){
		case '_proj_fp_disc_amt':
			$fp_disc_amt = $project_meta['gl_proj_meta_value'];
			break;
		case '_proj_fp_disc_rate':
			$fp_disc_rate = $project_meta['gl_proj_meta_value'];
			break;
		case '_proj_fp_disc_rate_calc':
			$fp_disc_rate_calc = $project_meta['gl_proj_meta_value'];
			break;
		case '_proj_swfp_disc_amt':
			$swfp_disc_amt = $project_meta['gl_proj_meta_value'];
			break;
		case '_proj_swfp_disc_rate':
			$swfp_disc_rate = $project_meta['gl_proj_meta_value'];
			break;
		case '_proj_swfp_disc_rate_calc':
			$swfp_disc_rate_calc = $project_meta['gl_proj_meta_value'];
			break;
		case '_proj_comb_date':
			$comb_met_date = $project_meta['gl_proj_meta_value'];
			break;
		default:
			break;
	}
}

?>
	<p><a class="btn btn-small" href="<?php echo $site_url; ?>/show-revrec-list/">Return to Arrangement List</a>&nbsp;&nbsp;&nbsp; <!-- return to list of all projects -->
	<h3>Arrangement Elements</h3>
	<h4><?php echo stripslashes($project_name); ?></h4>
		<div id="debug"></div>
	
	<form action="<?php echo $site_url; ?>/show-element-form/" method="post">
		<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
		<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
		<input class="btn btn-success" type="submit" name="edit" value="Add an arrangement element">
	</form>
	
	<br />
<?php
		
	foreach ( $elements as $element ){
		$i = 0;
		if ($element['gl_proj_id']){
			$i++;
		}
	}
	
	if ($i > 0){ // Are there any elements?
	
		foreach ($projects as $project){
			if ($project['gl_proj_id'] == $project_id){
				if ($project['gl_proj_asof_date'] == null || $project['gl_proj_asof_date'] == '' || $project['gl_proj_asof_date'] == 0){
					$as_of_date = date("Y-m-d");
				} else {
					$as_of_date = $project['gl_proj_asof_date'];
				}
				$project_date = $project['gl_proj_date'];
				$project_name = $project['gl_proj_name'];
			}
		}
	?>
		<form class="form-horizontal" action="<?php echo $site_url; ?>/save-rr-project/" method="post">
			<input class="input-medium" type="date" id="project_asof_date" name="project_asof_date" value="<?php echo $as_of_date; ?>">
			<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
			<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
			<input class="btn btn-success" type="submit" name="set-date" value="Save 'as of' date">
		</form>
	<?php

		if ($project_date > $as_of_date){
		?>	<h4>The arrangement effective date is after the selected 'as of' date. Please varify that the arrangement date is correct or select a different 'as of' date.</h4> <?php
		} else {
		?>
			<!-- Set up table header -->
			<div class="name-container">
				<h5 style="margin-left: 7px"><strong>Accounting Units Summary</strong></h5>
				<table class="table">
					<thead>
						<tr>
							<th>Element name</th>
							<th>Deliverable type</th>
							<th>Separable (or VSOE)?</th>
							<th>Selling price</th>
							<th>Delivery date</th>
							<th>Element revenue recognition method</th>
							<th>Element rev rec conditions status</th>
							<th>Contingent amount</th>
							<th>Date contingency resolved</th>
							<th>Non-contingent amount</th>
							<th style="text-align: right">Element allocable amount</th>
							<th></th>
						</tr>
					</thead>
				<tbody>
				<?php
				
					// Start financial instruments carried at fair value
					
					$title_8 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 8){
							$title_8++;
						}
					}
					
					if ($title_8 > 0){
					?>
						<tr>
							<td colspan="12">Financial instruments carried at fair value</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 8){
								$fv_c_total = $fv_c_total + $element['rr_el_cont_amt'];
								$fv_total = $fv_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$fv_n_total = $fv_total - $fv_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total - financial instruments carried at fair value</td>
							<td style="text-align: right"><?php echo number_format($fv_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($fv_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($fv_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End financial instruments carried at fair value
					
					// Start financial instruments carried at historic value
					
					$title_9 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 9){
							$title_9++;
						}
					}
					
					if ($title_9 > 0){
					?>
						<tr>
							<td colspan="12">Financial instruments not carried at fair value</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 9){
								$hv_c_total = $hv_c_total + $element['rr_el_cont_amt'];
								$hv_total = $hv_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$hv_n_total = $hv_total - $hv_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total - financial instruments not carried at fair value</td>
							<td style="text-align: right"><?php echo number_format($hv_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($hv_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($hv_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End financial instruments carried at historic value
					
					// Start extended maintenance agreements
					
					$title_7 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 7){
							$title_7++;
						}
					}
					
					if ($title_7 > 0){
					?>
						<tr>
							<td colspan="12">Extended maintenance and warranty agreements</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 7){
								$em_c_total = $em_c_total + $element['rr_el_cont_amt'];
								$em_total = $em_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$em_n_total = $em_total - $em_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total - extended maintenance and warranty agreements</td>
							<td style="text-align: right"><?php echo number_format($em_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($em_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($em_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End extended maintenance agreements
					
					// Start guarantees
					
					$title_5 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 5){
							$title_5++;
						}
					}
					
					if ($title_5 > 0){
					?>
						<tr>
							<td colspan="12">Guarantees</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 5){
								$gu_c_total = $gu_c_total + $element['rr_el_cont_amt'];
								$gu_total = $gu_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$gu_n_total = $gu_total - $gu_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total - guarantees</td>
							<td style="text-align: right"><?php echo number_format($gu_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($gu_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($gu_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End guarantees
					
					// Start films
					
					$title_6 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 6){
							$title_6++;
						}
					}
					
					if ($title_6 > 0){
					?>
						<tr>
							<td colspan="12">Film and film products</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 6){
								$fm_c_total = $fm_c_total + $element['rr_el_cont_amt'];
								$fm_total = $fm_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$fm_n_total = $fm_total - $fm_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total - film and film products</td>
							<td style="text-align: right"><?php echo number_format($fm_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($fm_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($fm_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End films
					
					// Start software
					
					$title_2 = 0;
				
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 2){
							$title_2++;
						}
					}
				
					if ($title_2 > 0){
					?>
						<tr>
							<td colspan="12">Software</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 2){
								$sw_c_total = $sw_c_total + $element['rr_el_cont_amt'];
								$sw_total = $sw_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$sw_n_total = $sw_total - $sw_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total software</td>
							<td style="text-align: right"><?php echo number_format($sw_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($sw_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($sw_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End software
					
					// Start leases
					
					$title_3 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 3){
							$title_3++;
						}
					}
				
					if ($title_3 > 0){
					?>
						<tr>
							<td colspan="12">Leases</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 3){
								$ls_c_total = $ls_c_total + $element['rr_el_cont_amt'];
								$ls_total = $ls_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$ls_n_total = $ls_total - $ls_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total leases</td>
							<td style="text-align: right"><?php echo number_format($ls_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($ls_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($ls_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End leases
					
					// Start franchises
					
					$title_4 = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 4){
							$title_4++;
						}
					}
				
					if ($title_4 > 0){
					?>
						<tr>
							<td colspan="12">Franchise</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 4){
								$fr_c_total = $fr_c_total + $element['rr_el_cont_amt'];
								$fr_total = $fr_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$fr_n_total = $fr_total - $fr_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total franchise</td>
							<td style="text-align: right"><?php echo number_format($fr_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($fr_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($fr_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}

					// End franchises
					
					// Start delivered separables
					
					$title_1a = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] == 'Yes' && $element['rr_el_cond_date'] > 0 && $element['rr_el_cond_date'] <= $as_of_date){
							$title_1a++;
						}
					}
				
					if ($title_1a > 0){
					?>
						<tr>
							<td colspan="12">Delivered Separable Elements</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] == 'Yes' && $element['rr_el_cond_date'] > 0 && $element['rr_el_cond_date'] <= $as_of_date){
								$ds_c_total = $ds_c_total + $element['rr_el_cont_amt'];
								$ds_total = $ds_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$ds_n_total = $ds_total - $ds_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total delivered separable elements</td>
							<td style="text-align: right"><?php echo number_format($ds_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($ds_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($ds_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End delivered separables
					
					// Start undelivered separables
					
					$title_1b = 0;
					
					foreach ( $elements as $element ){
						if (($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] == 'Yes' && $element['rr_el_cond_date'] == 0) || ($element['rr_el_meth_cat'] == 1 && $element['rr_el_cond_date'] > $as_of_date)){
							$title_1b++;
						}
					}
				
					if ($title_1b > 0){
					?>
						<tr>
							<td colspan="12">Undelivered Separable Elements</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if (($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] == 'Yes' && $element['rr_el_cond_date'] == 0) || ($element['rr_el_meth_cat'] == 1 && $element['rr_el_cond_date'] > $as_of_date)){
								$us_c_total = $us_c_total + $element['rr_el_cont_amt'];
								$us_total = $us_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$us_n_total = $us_total - $us_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total undelivered separable elements</td>
							<td style="text-align: right"><?php echo number_format($us_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($us_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($us_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End delivered separables
					
					// Start non-separables
					
					$title_1c = 0;
					
					foreach ( $elements as $element ){
						if ($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] !== 'Yes'){
							$title_1c++;
						}
					}
				
					if ($title_1c > 0){
					?>
						<tr>
							<td colspan="12">Non-separable combined elements</td>
						</tr>
					<?php
						foreach ( $elements as $element ){
							if ($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] !== 'Yes'){
								$u_c_total = $u_c_total + $element['rr_el_cont_amt'];
								$u_total = $u_total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$u_n_total = $u_total - $u_c_total;
								
								$c_total = $c_total + $element['rr_el_cont_amt'];
								$total = $total + $element['rr_el_amt'] + $element['rr_el_spec_amt'];
								$n_total = $total - $c_total;
								
								render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date);
							}
						}

					?>
						<tr>
							<td colspan="7">Total non-separables combined elements</td>
							<td style="text-align: right"><?php echo number_format($u_c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($u_n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($u_total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
					}
					
					// End non-separables
					
					?>
						<tr>
							<td colspan="7">Total</td>
							<td style="text-align: right"><?php echo number_format($c_total, 2, '.', ','); ?></td>
							<td></td>
							<td style="text-align: right"><?php echo number_format($n_total, 2, '.', ','); ?></td>
							<td style="text-align: right"><?php echo number_format($total, 2, '.', ','); ?></td>
							<td></td>
						</tr>
					<?php
				}
			} else {
			?>
				<h4>Please add some elements to this arrangement!</h4>
			<?php
			}

			?>

			</tbody>
		</table>
	</div>

	<script>
		$('#delete-element').click(delete_confirm);
		
		function delete_confirm() {
			var msg = confirm('Deleting this element will reset the revenue recognition method analysis for certain elements. Are you sure you want to delete this element?');
			if (msg == false) {
				return false;
			}
		}
	</script>
	
	<style>
		.name-container {
			border: 1px solid lightgrey;
			min-height: 181px;
			-webkit-border-radius: 4px;
			border-radius: 4px;
			moz-border-radius: 4px;
			margin-bottom: 1px;
		}
		
		.table th {
			font-size: 12px; 
			line-height: 16px;
		}
		
		.table td {
			font-size: 12px; 
			line-height: 16px;
		}

		.button-container {
			height: 21px;
			position: relative;
			width: 260px;
			left: 690px;
			top: -91px;
			
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
		
		#delete-element-container {
			width: 70px;
			position: relative;
			left: 192px;
			top: -86px;
		}

	</style>

<?php

function render_element($element, $elements, $delivs, $methods, $project_metas, $stats, $project_id, $site_url, $as_of_date){
	// calculations
	$edel = 'None selected'; 																		// start deliverable type
	foreach ( $delivs as $deliv ){
		if ($element['rr_el_del'] == $deliv['rr_del_id']){
			$edel = stripslashes($deliv['rr_del_name']);
			break;
		}
	} 																								// deliverable type
	foreach ( $elements as $dep ){ 																	// start delivery dependency
		if ($element['rr_el_dep'] == 'None' || $element['rr_el_dep'] == null){			
			$edep = 'None';
			break;
		} else if ($element['rr_el_dep'] == $dep['rr_el_id']){
			$edep = stripslashes($dep['rr_el_name']);
			break;
		}
	} 																								//end delivery type
	if ($element['rr_el_meth_cat'] == 2){
		if ($element['rr_el_sp_basis'] == 1){
			$esep = 'VSOE';
		} else {
			$esep = 'No VSOE';
		}
	} else {
		$esep = $element['rr_el_sep'];
	}
	$deldate = 'None'; 																				// start deliverable date
	if ($element['rr_el_odt_2'] > 0){			
		$deldate = $element['rr_el_odt_2'];
	} else if ($element['rr_el_dt_2'] > 0){			
		$deldate = $element['rr_el_dt_2'];
	} 																								//end deliverable date
	if ($element['rr_el_meth_cat'] == 1 && $element['rr_el_sep'] !== 'Yes'){
		$el_meth = update_comb_revrec_meth($element, $methods, $project_metas, $stats, $project_id);
		$rev_rec_meth = $el_meth['status_desc'].$el_meth['status_date'];
		$el_status = update_comb_cond_status($element, $project_metas, $stats, $project_id);
		$cond_status = $el_status['status_desc'].$el_status['status_date'];
	} else if ($element['rr_el_meth_cat'] == 2){
		$el_meth = array('rr_stat_id' => '', 'status_desc' => '', 'status_date' => $element['rr_el_meth_calc']);
		$rev_rec_meth = $el_meth['status_desc'].$el_meth['status_date'];
		$el_status = update_sw_status($element, $stats);
		$cond_status = $el_status['status_desc'].$el_status['status_date'];
	} else {
		$el_meth = update_sepdel_revrec_meth($element, $methods, $stats);
		$rev_rec_meth = $el_meth['status_desc'].$el_meth['status_date'];
		$el_status = update_sepdel_cond_status($element, $stats);
		$cond_status = $el_status['status_desc'].$el_status['status_date'];
	}
	$contingent_date = update_cont_date($element);
	$noncontingent = $element['rr_el_amt'] + $element['rr_el_spec_amt'] - $element['rr_el_cont_amt'];
	$total_amt = $element['rr_el_amt'] + $element['rr_el_spec_amt'];
	if ($deldate == 'None' || $el_status['rr_stat_id'] == 2 || ($el_status['rr_stat_id'] >= 4 && $el_status['rr_stat_id'] <= 6) || $el_meth['rr_stat_id'] == 10){
		$alert = 'error';
	} else if (($contingent_date !== 'N/A' && $contingent_date > $as_of_date) || ($contingent_date == 0 && $element['rr_el_cont_amt'] > 0) || $deldate > $as_of_date){
		$alert = 'alert';
	} else if ($el_meth['rr_stat_id'] == 12 || $el_meth['rr_stat_id'] == 7 || $el_status['rr_stat_id'] == 3){
		$alert = 'info';
	} else {
		$alert = 'success';
	}
	?>
		<tr class="<?php echo $alert; ?>">
			<td><?php echo stripslashes($element['rr_el_name']); ?></td>
			<td><?php echo stripslashes($edel); ?></td>
			<td><?php echo $esep; ?></td>
			<td style="text-align: right"><?php echo number_format($element['rr_el_sell_price'], 2, '.', ','); ?></td>
			<td><?php echo $deldate; ?></td>
			<td><?php echo stripslashes($rev_rec_meth); ?></td>
			<td><?php echo stripslashes($cond_status); ?></td>
			<td style="text-align: right"><?php echo number_format($element['rr_el_cont_amt'], 2, '.', ','); ?></td>
			<td style="text-align: right"><?php echo $contingent_date; ?></td>
			<td style="text-align: right"><?php echo number_format($noncontingent, 2, '.', ','); ?></td>
			<td style="text-align: right"><?php echo number_format($total_amt, 2, '.', ','); ?></td>
			<td>
				<span>
					<form class="action-links" action="<?php echo $site_url; ?>/show-element/" method="post" style="margin-bottom: 0px">
					<input class="btn btn-small btn-primary" type="submit" name="submit" value="Element Details">
					<input type="hidden" name="element_name" value="<?php echo stripslashes($element['rr_el_name']); ?>">
					<input type="hidden" name="element_desc" value="<?php echo stripslashes($element['rr_el_desc']); ?>">
					<input type="hidden" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
					<input type="hidden" name="element_php" value="<?php echo $element['rr_el_php']; ?>">
					<input type="hidden" name="cat_id" value="<?php echo $element['gl_cat_id']; ?>">
					<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
					<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
					<input type="hidden" name="return_url" value="<?php echo $site_url; ?>/show-element-list/">
					</form>
				</span>
				<span>
					<form class="action-links" action="<?php echo $site_url; ?>/save-element/" method="post" style="margin-top: 1px; margin-bottom: 0px">
					<input class="btn btn-small delete" type="submit" name="delete" id="delete-element" value="Delete Element ">
					<input type="hidden" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
					<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
					<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
					</form>
				</span>
			</td>
		</tr>
	<?php
}

?>

<?php get_footer(); ?>