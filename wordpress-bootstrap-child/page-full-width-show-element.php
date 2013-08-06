<?php
/*
Template Name: Full Width Page Show Element
*/
?>
<?php session_start(); ?>
<?php get_header(custom); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="post_content">
							
					<?php

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
						if (isset($_SESSION['element_id'])){
							$element_id = $_SESSION['element_id'];
						} else {
							$element_id = $_POST['element_id'];
						}
						
						$elements = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE rr_el_id = $element_id", ARRAY_A );
						$delivs = $wpdb->get_results($wpdb->prepare( "SELECT * FROM wp_gl_rr_del ORDER BY rr_del_name ASC",	ARRAY_A	));
						$methods = $wpdb->get_results($wpdb->prepare( "SELECT * FROM wp_gl_rr_meth ORDER BY rr_meth_name ASC", ARRAY_A ));
						
						$delmeths = $wpdb->get_results($wpdb->prepare(
							"
							SELECT 		*
							FROM 		wp_gl_del_meth
							INNER JOIN 	wp_gl_rr_meth
										ON wp_gl_rr_meth.rr_meth_id = wp_gl_del_meth.rr_meth_id
							ORDER BY 	rr_meth_name ASC
							", 
							ARRAY_A ));
						
						$topics = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_topics", ARRAY_A );
						$nodes = $wpdb->get_results( "SELECT * FROM wp_gl_rr_nodes", ARRAY_A );
						$topic_resps = $wpdb->get_results( "SELECT * FROM wp_gl_rr_topic_data WHERE rr_el_id = $element_id", ARRAY_A );
						$node_resps = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_data WHERE rr_el_id = $element_id", ARRAY_A );
						$groups = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_groups", ARRAY_A );
						
						foreach ( $elements as $element ){
							if ($element['rr_el_id'] == $element_id){ // select element_id from elements
							?>	<form id="return_button" class="span2" action="<?php echo $site_url; ?>/show-element-list/" method="post">
									<input type="submit" class="btn" value="Return to Element List">
									<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id; ?>">
								</form>
								<br />
								<br />
								
								<h3>Element Details</h3>
								<h4>Arrangement name: <?php echo stripslashes($project_name); ?></h4>
								<h5>Element name: <?php echo stripslashes($element['rr_el_name']); ?></h5>
								
								<div id="debug"></div>

								<div class="hidden" id="element_meta">
									<div id="stop_flag"><?php echo $element['rr_el_stop_flag']; ?></div>
								</div>

							<?php
								foreach( $delivs as $deliv ){
									if ($deliv->rr_del_id == $element['rr_el_del']){
										$rr_del_dt_1 = $deliv->rr_del_st_1;
										$rr_del_dt_2 = $deliv->rr_del_st_2;
										$rr_del_dt_3 = $deliv->rr_del_st_3;
										$rr_del_dt_4 = $deliv->rr_del_st_4;
									}
								}
							?>
								
								<div class="rr-container">
									<div style="margin-bottom: 25px" class="span12">
										<h4 style="text-align: center">Revenue Recognition Summary</h4>
									</div>
									<div style="margin-bottom: 25px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Element deliverable: </p>
											<div id="rrdeliv_a">
												<div class="span5">
												<?php
													foreach( $delivs as $deliv ){
														if ($deliv->rr_del_id == $element['rr_el_del']){
															$rr_deliv_name = $deliv->rr_del_name;
															$rr_deliv_desc = $deliv->rr_del_desc;
														}
													}
												?>
													<p id="element_rr_deliv_name" style="margin-left: 5px"><strong><?php echo $rr_deliv_name; ?></strong><span id="delId" class="hidden"><?php echo $element['rr_el_del']; ?></span></p>
												</div>
												<div class="row span9 offset1">
													<p id="element_rr_deliv_desc"><?php echo $rr_deliv_desc; ?></p>
												</div>
												<span>
													<button style="margin-bottom: 9px" id="edit_rr_deliv" class="btn btn-primary">Change</button>
												</span>
											</div>
											
											<div class="hidden" id="rrdeliv_b">
												<span class="span7">
													<select style="margin-bottom: 9px"  class="input-xlarge" id="rr_el_deliv" name="rr_el_deliv"> <!--select list based on deliverable and rr status-->
												<?php
													
													foreach( $delivs as $deliv ){
														if ($deliv->rr_del_id == $element['rr_el_del']){
															echo '<option value="'.$deliv->rr_del_id.'" selected>'.$deliv->rr_del_name.'</option>'; 
														} else {
															echo '<option value="'.$deliv->rr_del_id.'">'.$deliv->rr_del_name.'</option>'; 
														}
													}
												?>
													</select>
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<button style="margin-bottom: 9px" id="save_deliv_b" class="btn btn-primary">Save</button>
													<button style="margin-bottom: 9px" id="cancel_rr_deliv" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										</div>
									</div>
									<div style="margin-bottom: 25px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Revenue recognition method: </p>
											<div id="rrmeth_a">
												<div class="span5">
												<?php
													
													foreach( $methods as $method ){
														if ($method->rr_meth_id == $element['rr_el_meth']){
															$rr_meth_name = $method->rr_meth_name;
															$rr_meth_desc = $method->rr_meth_desc;
														}
													}
												?>
													<p id="element_rr_meth_name" style="margin-left: 5px"><strong><?php echo stripslashes($rr_meth_name); ?></strong></p>
												</div>
												<div class="row span9 offset1">
													<p id="element_rr_meth_desc"><?php echo stripslashes($rr_meth_desc); ?></p>
												</div>
												<span>
													<button style="margin-bottom: 9px" id="edit_rr_meth" class="btn btn-primary">Change</button>
												</span>
											</div>
											
											<div class="hidden" id="rrmeth_b">
												<span class="span7">
													<select style="margin-bottom: 9px"  class="input-xlarge" id="rr_el_meth" name="rr_el_meth"> <!--select list based on deliverable and rr status-->
												<?php
													foreach( $delmeths as $delmeth ){
														if ($delmeth->rr_del_id == $element['rr_el_del']){
															if ($delmeth->rr_meth_id == $element['rr_el_meth']){
																echo '<option value="'.$delmeth->rr_meth_id.'" selected>'.$delmeth->rr_meth_name.'</option>'; 
															} else {
																echo '<option value="'.$delmeth->rr_meth_id.'">'.$delmeth->rr_meth_name.'</option>'; 
															}
														}
													}	
												?>
													</select>
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<button style="margin-bottom: 9px" id="save_meth_b" class="btn btn-primary">Save</button>
													<button style="margin-bottom: 9px" id="cancel_rr_meth" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										</div>
									</div>									
									<div style="margin-bottom: 25px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Overall revenue recognition conditions status: </p>
											<div id="rro_stat_a">
												<div class="span2" id="rr_status" style="margin-left: 5px"></div>
											</div>
											<div id="rro_stat_a_date">
												<div class="span2" id="rr_status_date"></div>
											</div>
											<div class="hidden" id="rro_stat_b">
												<span class="span7">
													<select style="margin-bottom: 9px"  class="input-medium" id="rro_st_b" name="rro_st_b">
														<option value="Not started">Not started</option>
														<option value="Met">Met</option>
														<option value="Not met">Not met</option>
													</select>
													As of:
													<input class="input-medium" type="date" id="rro_st_date" name="rro_st_date" value="<?php echo $element['rr_el_st_date_2']; ?>">
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<textarea style="margin-bottom: 10px" class="input-xxlarge" rows="5" type="hidden" id="o-override_comment" name="o-override_comment" value=""></textarea>
													<button style="margin-bottom: 9px" id="save-o" name="save-o" class="btn btn-primary save-o">Save</button>
													<button style="margin-bottom: 9px" id="cancel_save_o" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										</div>
									</div>
								</div>
									
								<div class="requirements-container" id="requirements-container">
									<div class="row">
										<div style="margin-bottom: 25px" class="span12">
											<h4 style="text-align: center">Revenue Recognition Conditions</h4>
										</div>
									</div>
									
									<div style="min-height: 50px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Persuasive evidence of an arrangement </p>
										<?php
											if ($element['rr_el_dr_1'] > 0 && $element['rr_el_nr_1'] == 0){
												$rrstat_1 = 'Not met';
											} else if ($element['rr_el_dr_1'] == 0 && $element['rr_el_nr_1'] == 0 && $element['rr_el_rr_1'] > 0){
												$rrstat_1 = 'Met';
											} else {
												$rrstat_1 = 'Incomplete';
											}
											
											if ($element['rr_el_ost_1'] == '' || $element['rr_el_ost_1'] == null){ // if no status override
											?>	<div id="rrtsat_a1"> <?php
											} else {
											?>	<div id="rrtsat_a1" class="hidden"> <?php
											}
											?>
												<p id="element_rr_st_1a" class="span1" style="margin-left: 5px"><strong><?php echo $rrstat_1; ?></strong></p>
												<form class="form-inline span1" action="<?php echo $site_url; ?>/revrec/" method="post">
													<input id="analyze_1" class="btn btn-primary" type="submit" name="edit" value="Analyze">
													<input type="hidden" name="element_name" value="<?php echo $element['rr_el_name']; ?>">
													<input type="hidden" name="element_desc" value="<?php echo $element['rr_el_desc']; ?>">
													<input type="hidden" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="project_id" value="<?php echo $element['gl_proj_id']; ?>">
													<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
													<input id="deliv_id_1" type="hidden" name="deliv_id" value="<?php echo $element['rr_el_del']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id_1" value="1">
													<input type="hidden" name="return_url" value="<?php echo $site_url; ?>/show-element/">
													<input type="hidden" name="element_php" value="rr">
												</form>
												<span class="span5">As of:
												<?php
													if ($element['rr_el_ost_1'] == '' || $element['rr_oel_st_1'] == null){ // if no status override
													?>
														<input class="input-medium" type="date" id="rr_el_dt_1" name="rr_el_dt_1" value="<?php echo $element['rr_el_dt_1']; ?>">
													<?php
													} else {
													?>
														<input class="input-medium" type="date" id="rr_el_dt_1" name="rr_el_dt_1" value="<?php echo $element['rr_el_odt_1']; ?>">
													<?php
													}
												?>
													<input type="hidden" name="element_id" id="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="1">
													<button style="margin-bottom: 9px" id="save_a" class="btn btn-primary save-a">Save Date</button>
													<button style="margin-bottom: 9px" id="override_1" class="btn">Override</button>
												</span>
											</div>
											<div class="hidden" id="rrtsat_b1">
												<span class="span7" style="margin-left: 5px">
													<select style="margin-bottom: 9px"  class="input-medium" id="element_rr_st_1b" name="element_rr_st_1">
														<option value="Not started">Not started</option>
														<option value="Met">Met</option>
														<option value="Not met">Not met</option>
													</select>
														As of:
														<input class="input-medium" type="date" id="rr_el_dt_1" name="rr_el_dt_1" value="<?php echo $element['rr_el_dt_1']; ?>">
														<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
														<input type="hidden" name="status_id" id="rr_status_id" value="1">
													<button style="margin-bottom: 9px" id="save_b1" class="btn btn-primary save-b">Save Override</button>
													<button style="margin-bottom: 9px" id="cancel_save_1" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										<?php
											if ($element['rr_el_ost_1'] == '' || $element['rr_el_ost_1'] == null){ // if no override
											?>	<div id="rrtsat_c1" class="hidden" > <?php
											} else {
											?>	<div id="rrtsat_c1"> <?php
											}
										?>
												<span class="span7" style="margin-left: 5px">
													<div class="span3">
														<span id="element_rr_st_1c" class="ovr_status"><strong><?php echo $element['rr_el_ost_1']; ?></strong></span> <!-- replace with jquery pull of select-->
													</div>
													<div class="span5">
														As of:    
														
														<span class="ovr_date"><strong><?php echo $element['rr_el_odt_1']; ?></strong></span> <!-- replace with jquery pull of date-->
													</div>
													<div class="span4">
														<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
														<input type="hidden" name="status_id" id="rr_status_id" value="1">
														<button style="margin-bottom: 9px" id="cancel_override_1" class="btn btn-primary" type="submit" name="edit">Cancel Override</button>
													</div>
												</span>
											</div>										
										</div>
									</div>
								
									<div style="min-height: 50px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Delivery has occurred or services rendered </p>
										<?php
											if ($element['rr_el_dr_2'] > 0 && $element['rr_el_nr_2'] == 0){
												$rrstat_2 = 'Not met';
											} else if ($element['rr_el_dr_2'] == 0 && $element['rr_el_nr_2'] == 0 && $element['rr_el_rr_2'] > 0){
												$rrstat_2 = 'Met';
											} else {
												$rrstat_2 = 'Incomplete';
											}
											
											if ($element['rr_el_ost_2'] == '' || $element['rr_el_ost_2'] == null){ // if no status override
											?>	<div id="rrtsat_a2"> <?php
											} else {
											?>	<div id="rrtsat_a2" class="hidden"> <?php
											}
										?>
												<p id="element_rr_st_2a" class="span1" style="margin-left: 5px"><strong><?php echo $rrstat_2; ?></strong></p>
												<form class="form-inline span1" action="<?php echo $site_url; ?>/revrec/" method="post">
													<input id="analyze_2" class="btn btn-primary" type="submit" name="edit" value="Analyze">
													<input type="hidden" name="element_name" value="<?php echo $element['rr_el_name']; ?>">
													<input type="hidden" name="element_desc" value="<?php echo $element['rr_el_desc']; ?>">
													<input type="hidden" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="project_id" value="<?php echo $element['gl_proj_id']; ?>">
													<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
													<input id="deliv_id_2" type="hidden" name="deliv_id" value="">
													<input type="hidden" name="status_id" id="rr_status_id_2" value="2">
													<input type="hidden" name="return_url" value="<?php echo $site_url; ?>/show-element/">
													<input type="hidden" name="element_php" value="rr">
												</form>
												<span class="span5">As of:
												<?php
													if ($element['rr_el_ost_2'] == '' || $element['rr_oel_st_2'] == null){ // if no status override
													?>
														<input class="input-medium" type="date" id="rr_el_dt_2" name="rr_el_dt_2" value="<?php echo $element['rr_el_dt_2']; ?>">
													<?php
													} else {
													?>
														<input class="input-medium" type="date" id="rr_el_dt_2" name="rr_el_dt_2" value="<?php echo $element['rr_el_odt_2']; ?>">
													<?php
													}
												?>
													<input type="hidden" name="element_id" id="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="2">
													<button style="margin-bottom: 9px" id="save_a" class="btn btn-primary save-a">Save Date</button>
													<button style="margin-bottom: 9px" id="override_2" class="btn ">Override</button>
												</span>
											</div>
											<div class="hidden" id="rrtsat_b2">
												<span class="span7" style="margin-left: 5px">
													<select style="margin-bottom: 9px"  class="input-medium" id="element_rr_st_2b" name="element_rr_st_2">
														<option value="Not started">Not started</option>
														<option value="Met">Met</option>
														<option value="Not met">Not met</option>
													</select>
													As of:
													<input class="input-medium" type="date" id="rr_el_dt_2" name="rr_el_dt_2" value="<?php echo $element['rr_el_dt_2']; ?>">
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="2">
													<button style="margin-bottom: 9px" id="save_b2" class="btn btn-primary save-b">Save Override</button>
													<button style="margin-bottom: 9px" id="cancel_save_2" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										<?php
											if ($element['rr_el_ost_2'] == '' || $element['rr_el_ost_2'] == null){ // if no override
											?>	<div id="rrtsat_c2" class="hidden" > <?php
											} else {
											?>	<div id="rrtsat_c2"> <?php
											}
										?>
												<span class="span7" style="margin-left: 5px">
													<div class="span3">
													<span id="element_rr_st_2c" class="ovr_status"><strong><?php echo $element['rr_el_ost_2']; ?></strong></span> <!-- replace with jquery pull of select-->
													</div>
													<div class="span5">
													As of:    
													
													<span class="ovr_date"><strong><?php echo $element['rr_el_odt_2']; ?></strong></span> <!-- replace with jquery pull of date-->
													</div>
													<div class="span4">
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="2">
													<button style="margin-bottom: 9px" id="cancel_override_2" class="btn btn-primary" type="submit" name="edit">Cancel Override</button>
													</div>
												</span>
											</div>
										</div>
									</div>
									
									<div style="min-height: 50px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Fixed or determinable fee </p>
										<?php
											if ($element['rr_el_dr_3'] > 0 && $element['rr_el_nr_3'] == 0){
												$rrstat_3 = 'Not met';
											} else if ($element['rr_el_dr_3'] == 0 && $element['rr_el_nr_3'] == 0 && $element['rr_el_rr_3'] > 0){
												$rrstat_3 = 'Met';
											} else {
												$rrstat_3 = 'Incomplete';
											}
											
											if ($element['rr_el_ost_3'] == '' || $element['rr_el_ost_3'] == null){ // if no status override
											?>	<div id="rrtsat_a3"> <?php
											} else {
											?>	<div id="rrtsat_a3" class="hidden"> <?php
											}
											?>
												<p id="element_rr_st_3a" class="span1" style="margin-left: 5px"><strong><?php echo $rrstat_3; ?></strong></p>
												<form class="form-inline span1" action="<?php echo $site_url; ?>/revrec/" method="post">
													<input id="analyze_3" class="btn btn-primary" type="submit" name="edit" value="Analyze">
													<input type="hidden" name="element_name" value="<?php echo $element['rr_el_name']; ?>">
													<input type="hidden" name="element_desc" value="<?php echo $element['rr_el_desc']; ?>">
													<input type="hidden" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="project_id" value="<?php echo $element['gl_proj_id']; ?>">
													<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
													<input id="deliv_id_3" type="hidden" name="deliv_id" value="">
													<input type="hidden" name="status_id" id="rr_status_id_3" value="3">
													<input type="hidden" name="return_url" value="<?php echo $site_url; ?>/show-element/">
													<input type="hidden" name="element_php" value="rr">
												</form>
												<span class="span5">As of:
												<?php
													if ($element['rr_el_ost_3'] == '' || $element['rr_oel_st_3'] == null){ // if no status override
													?>
														<input class="input-medium" type="date" id="rr_el_dt_3" name="rr_el_dt_3" value="<?php echo $element['rr_el_dt_3']; ?>">
													<?php
													} else {
													?>
														<input class="input-medium" type="date" id="rr_el_dt_3" name="rr_el_dt_3" value="<?php echo $element['rr_el_odt_3']; ?>">
													<?php
													}
												?>
													<input type="hidden" name="element_id" id="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="3">
													<button style="margin-bottom: 9px" id="save_a" class="btn btn-primary save-a">Save Date</button>
													<button style="margin-bottom: 9px" id="override_3" class="btn ">Override</button>
												</span>
											</div>
											<div class="hidden" id="rrtsat_b3">
												<span class="span7" style="margin-left: 5px">
													<select style="margin-bottom: 9px"  class="input-medium" id="element_rr_st_3b" name="element_rr_st_3">
														<option value="Not started">Not started</option>
														<option value="Met">Met</option>
														<option value="Not met">Not met</option>
													</select>
													As of:
													<input class="input-medium" type="date" id="rr_el_dt_3" name="rr_el_dt_3" value="<?php echo $element['rr_el_dt_3']; ?>">
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="3">
													<button style="margin-bottom: 9px" id="save_b3" class="btn btn-primary save-b">Save Override</button>
													<button style="margin-bottom: 9px" id="cancel_save_3" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										<?php
											if ($element['rr_el_ost_3'] == '' || $element['rr_el_ost_3'] == null){ // if no override
											?>	<div id="rrtsat_c3" class="hidden" > <?php
											} else {
											?>	<div id="rrtsat_c3"> <?php
											}
										?>
												<span class="span7" style="margin-left: 5px">
													<div class="span3">
														<span id="element_rr_st_3c" class="ovr_status"><strong><?php echo $element['rr_el_ost_3']; ?></strong></span> <!-- replace with jquery pull of select-->
													</div>
													<div class="span5">
														As of:    
														
														<span class="ovr_date"><strong><?php echo $element['rr_el_odt_3']; ?></strong></span> <!-- replace with jquery pull of date-->
													</div>
													<div class="span4">
														<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
														<input type="hidden" name="status_id" id="rr_status_id" value="3">
														<button style="margin-bottom: 9px" id="cancel_override_3" class="btn btn-primary" type="submit" name="edit">Cancel Override</button>
													</div>
												</span>
											</div>											
										</div>
									</div>
									
									<div style="min-height: 50px" class="row">
										<div class="span12">
											<p class="span4 offset1 alert-info">Collectibility reasonably assured </p>
										<?php
											if ($element['rr_el_dr_4'] > 0 && $element['rr_el_nr_4'] == 0){
												$rrstat_4 = 'Not met';
											} else if ($element['rr_el_dr_4'] == 0 && $element['rr_el_nr_4'] == 0 && $element['rr_el_rr_4'] > 0){
												$rrstat_4 = 'Met';
											} else {
												$rrstat_4 = 'Incomplete';
											}
											
											if ($element['rr_el_ost_4'] == '' || $element['rr_el_ost_4'] == null){ // if no status override
											?>	<div id="rrtsat_a4"> <?php
											} else {
											?>	<div id="rrtsat_a4" class="hidden"> <?php
											}
											?>
												<p id="element_rr_st_4a" class="span1" style="margin-left: 5px"><strong><?php echo $rrstat_4; ?></strong></p>
												<form class="form-inline span1" action="<?php echo $site_url; ?>/revrec/" method="post">
													<input id="analyze_4" class="btn btn-primary" type="submit" name="edit" value="Analyze">
													<input type="hidden" name="element_name" value="<?php echo $element['rr_el_name']; ?>">
													<input type="hidden" name="element_desc" value="<?php echo $element['rr_el_desc']; ?>">
													<input type="hidden" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="project_id" value="<?php echo $element['gl_proj_id']; ?>">
													<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
													<input id="deliv_id_4" type="hidden" name="deliv_id" value="">
													<input type="hidden" name="status_id" id="rr_status_id_4" value="4">
													<input type="hidden" name="return_url" value="<?php echo $site_url; ?>/show-element/">
													<input type="hidden" name="element_php" value="rr">
												</form>
												<span class="span5">As of:
												<?php
													if ($element['rr_el_ost_4'] == '' || $element['rr_oel_st_4'] == null){ // if no status override
													?>
														<input class="input-medium" type="date" id="rr_el_dt_4" name="rr_el_dt_4" value="<?php echo $element['rr_el_dt_4']; ?>">
													<?php
													} else {
													?>
														<input class="input-medium" type="date" id="rr_el_dt_4" name="rr_el_dt_4" value="<?php echo $element['rr_el_odt_4']; ?>">
													<?php
													}
												?>
													<input type="hidden" name="element_id" id="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="4">
													<button style="margin-bottom: 9px" id="save_a" class="btn btn-primary save-a">Save Date</button>
													<button style="margin-bottom: 9px" id="override_4" class="btn ">Override</button>
												</span>
											</div>
											<div class="hidden" id="rrtsat_b4" >
												<span class="span7" style="margin-left: 5px">
													<select style="margin-bottom: 9px"  class="input-medium" id="element_rr_st_4b" name="element_rr_st_4">
														<option value="Not started">Not started</option>
														<option value="Met">Met</option>
														<option value="Not met">Not met</option>
													</select>
													As of:
													<input class="input-medium" type="date" id="rr_el_dt_4" name="rr_el_dt_4" value="<?php echo $element['rr_el_dt_4']; ?>">
													<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
													<input type="hidden" name="status_id" id="rr_status_id" value="4">
													<button style="margin-bottom: 9px" id="save_b4" class="btn btn-primary save-b">Save Override</button>
													<button style="margin-bottom: 9px" id="cancel_save_4" class="btn btn-primary" type="submit" name="edit">Cancel</button>
												</span>
											</div>
										<?php
											if ($element['rr_el_ost_4'] == '' || $element['rr_el_ost_4'] == null){ // if no override
											?>	<div id="rrtsat_c4" class="hidden" > <?php
											} else {
											?>	<div id="rrtsat_c4"> <?php
											}
										?>
												<span class="span7" style="margin-left: 5px">
													<div class="span3">
														<span id="element_rr_st_4c" class="ovr_status"><strong><?php echo $element['rr_el_ost_4']; ?></strong></span> <!-- replace with jquery pull of select-->
													</div>
													<div class="span5">
														As of:    
														
														<span class="ovr_date"><strong><?php echo $element['rr_el_odt_4']; ?></strong></span> <!-- replace with jquery pull of date-->
													</div>
													<div class="span4">
														<input type="hidden" id="element_id" name="element_id" value="<?php echo $element['rr_el_id']; ?>">
														<input type="hidden" name="status_id" id="rr_status_id" value="4">
														<button style="margin-bottom: 9px" id="cancel_override_4" class="btn btn-primary" type="submit" name="edit">Cancel Override</button>
													</div>
												</span>
											</div>
										</div>
									</div>
								</div>
								
								<div id="<?php echo $element_id; ?>" class="element-container">
									<div style="margin-bottom: 10px" class="span12">
										<h4 style="text-align: center">Element Information</h4>
									</div>
									<div class="row">
										<div class="span12">
											<div style="margin-left: auto; margin-left: auto; width: 52%; margin-top: 0px;">
												<form class="span2" action="<?php echo $site_url; ?>/edit-element/" method="post">
													<input type="submit" class="btn btn-primary" value="Edit">
													<input type="hidden" name="element_id" value="<?php echo $element_id; ?>">
													<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
													<input type="hidden" name="project_name" value="<?php echo $project_name; ?>">
												</form>
											</div>
										</div>
									</div>
											
									<div id="element_name" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Element name: </p><p class="span6"><?php echo stripslashes($element['rr_el_name']); ?></p>
										</div>
									</div>
									<div id="element_desc" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Element description: </p><p class="span6"><?php echo stripslashes($element['rr_el_desc']); ?></p>
										</div>
									</div>
								<?php
									if (($element['rr_el_meth_cat'] < 2 || $element['rr_el_meth_cat'] > 2) && $element['rr_el_disc_cat'] == 0){
										echo $element['rr_el_meth_cat'];
									?>
										<div id="element_sep" class="row">
											<div class="span12">
												<p class="span5 offset1 alert-info">Is this element separable?: </p><p id="sep_flag" class="span6"><?php echo $element['rr_el_sep']; ?></p>
											</div>
										</div>
									<?php
									}
								?>
								<?php
									if ($element['rr_el_disc_cat'] > 0 && $element['rr_el_disc_cat'] < 3){
										if ($element['rr_el_meth_cat'] == 1){
											if ($element['rr_el_disc_cat'] == 1){
												$disc_type = "Discount on specified future purchase of non-software product(s)";
											} else if ($element['rr_el_disc_cat'] == 2){
												if ($element['rr_el_disc_amt'] > 0){
													$disc_type = "Discount on unspecified future purchase of non-software product(s) with known maximum discount amount";
												} else {
													$disc_type = "Discount on unspecified future purchase of non-software product(s) with unknown maximum discount amount";
												}
											}
										} else if ($element['rr_el_meth_cat'] == 2){
											if ($element['rr_el_disc_cat'] == 1){
												$disc_type = "Discount on specified future purchase of software product(s)";
											} else if ($element['rr_el_disc_cat'] == 2){
												if ($element['rr_el_disc_amt'] > 0){
													$disc_type = "Discount on unspecified future purchase of software product(s) with known maximum discount amount";
												} else {
													$disc_type = "Discount on unspecified future purchase of software product(s) with unknown maximum discount amount and/or no VSOE of fair value";
												}
											}
										}
									?>
										<div id="disc_cat" class="row">
											<div class="span12">
												<p class="span5 offset1 alert-info">Future purchase discount type:</p><p class="span6"><?php echo $disc_type; ?></p>
											</div>
										</div>
									<?php
										if ($element['rr_el_sfp_amt'] > 0){
										?>
											<div id="sfp_amt" class="row">
												<div class="span12">
													<p class="span5 offset1 alert-info">Specified future purchase amount:</p><p class="span6"><?php echo number_format($element['rr_el_sfp_amt'], 2, '.', ','); ?></p>
												</div>
											</div>
										<?php
										}
										if ($element['rr_el_disc_amt'] > 0){
										?>
											<div id="disc_amt" class="row">
												<div class="span12">
													<p class="span5 offset1 alert-info">Future purchase discount maximum amount:</p><p class="span6"><?php echo number_format($element['rr_el_disc_amt'], 2, '.', ','); ?></p>
												</div>
											</div>
										<?php
										}
										if ($element['rr_el_disc_rate'] > 0){
										?>
											<div id="disc_rate" class="row">
												<div class="span12">
													<p class="span5 offset1 alert-info">Future purchase discount rate:</p><p class="span6"><?php echo sprintf("%.2f%%", $element['rr_el_disc_rate'] * 100); ?></p>
												</div>
											</div>
										<?php
										}
									}
									?>
									<div id="element_fee" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Allocated arrangement fee: </p><p class="span6"><?php echo number_format($element['rr_el_amt'], 2, '.', ','); ?></p>
										</div>
									</div>
								<?php
									if ($element['rr_el_sp_basis'] == 1){
										$sp_basis = "VSOE of fair value";
									} else if ($element['rr_el_sp_basis'] == 2){
										$sp_basis = "Third party selling price";
									} else if ($element['rr_el_sp_basis'] == 3){
										$sp_basis = "Management estimate";
									} else {
										$sp_basis = "N/A";
									}
								?>
									<div id="element_sep" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Basis for determining selling price: </p><p id="sp_basis" class="span6"><?php echo $sp_basis; ?></p>
										</div>
									</div>
								<?php
									if ($element['rr_el_sp_basis'] == 1){
										if ($element['rr_el_vsoe_basis'] == 1){
											$vsoe_basis = "Price charged for same item sold separately";
										} else if ($element['rr_el_vsoe_basis'] == 2){
											$vsoe_basis = "Price established by management";
										}
									?>
										<div id="element_sep" class="row">
											<div class="span12">
												<p class="span5 offset1 alert-info">Basis for VSOE of fair value: </p><p id="vsoe_basis" class="span6"><?php echo $vsoe_basis; ?></p>
											</div>
										</div>
									<?php
									}
								?>
									<div id="element_sw_flag" class="row">
										<div class="span12">
										<?php
											if ($element['rr_el_meth_cat'] == 2){
											?>	<p class="span5 offset1 alert-info">Is this a software element? </p><p id="element_sw_flag_yes" class="span6">Yes</p> <?php
											} else {
											?>	<p class="span5 offset1 alert-info">Software element? </p><p id="element_sw_flag_no" class="span6">No</p> <?php
											}
										?>
										</div>
									</div>
									<div id="element_sw_last" class="row">
										<div class="span12">
										<?php
											if ($element['rr_el_sw_flag'] == 1 && $element['rr_el_last_del'] == 1){
											?>	<p class="span5 offset1 alert-info">Last software deliverable?: </p><p class="span6">Yes</p> <?php
											} else if ($element['rr_el_sw_flag'] == 1 || $element['rr_el_last_del'] == 0){
											?>	<p class="span5 offset1 alert-info">Last software deliverable?: </p><p class="span6">No</p> <?php
											}
										?>
										</div>
									</div>
								<?php
									if ($element['rr_el_meth_cat'] == 8 || $element['rr_el_meth_cat'] == 9){
										$sp_label = "Fair value of instrument at inception: ";
									} else if ($element['rr_el_meth_cat'] == 7){
										$sp_label = "Agreement contract amount: ";
									} else if ($element['rr_el_meth_cat'] == 6){
										$sp_label = "Film element fair value: ";
									} else if ($element['rr_el_meth_cat'] == 5){
										$sp_label = "Guarantee fair value: ";
									} else if ($element['rr_el_meth_cat'] == 4){
										$sp_label = "Franchise element selling price: ";
									} else if ($element['rr_el_meth_cat'] == 3){
										$sp_label = "Aggregate minimum lease payments to lessor: ";
									} else if ($element['rr_el_meth_cat'] == 2){
										$sp_label = "Software element selling price: ";
									} else if ($element['rr_el_meth_cat'] == 1){
										$sp_label = "Element selling price: ";
									}
								?>
									<div id="element_cont_amt" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Contingent amount: </p><p id="contingent_amt" class="span6"><?php echo number_format($element['rr_el_sp_cont'], 2, '.', ','); ?></p>
										</div>
									</div>
									<div id="element_cont_type" class="row">
										<div class="span12">
										<?php
											if ($element['rr_el_cont_item'] == 1){
											?>	<p class="span5 offset1 alert-info">Nature of the contingency: </p><p class="span6">Additional performance conditions</p> <?php
											} else if ($element['rr_el_cont_item'] == 2){
											?>	<p class="span5 offset1 alert-info">Nature of the contingency: </p><p class="span6">Delivery of additional items</p> <?php
											} else if ($element['rr_el_cont_item'] == 3){
											?>	<p class="span5 offset1 alert-info">Nature of the contingency: </p><p class="span6">Other</p> <?php
											} else {
											?>	<p class="span5 offset1 alert-info">Nature of the contingency: </p><p class="span6">Not applicable</p> <?php
											}
										?>
										</div>
									</div>
									<div id="element_cont_desc" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Contingency description: </p><p class="span6"><?php echo stripslashes($element['rr_el_cont_desc']); ?></p>
										</div>
									</div>
									<div id="element_cont_res" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Contingency resolved?: </p><p class="span6"><?php echo stripslashes($element['rr_el_cont_status']); ?></p>
										</div>
									</div>
									<div id="element_cont_res_date" class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Date contingency resolved: </p><p class="span6"><?php echo stripslashes($element['rr_el_cont_date']); ?></p>
										</div>
									</div>
								
								
									<!--
									<div id="element_dep" class="row">
									<div class="span12">
								<?php
									/*foreach ( $elements as $dep ){
										if ($dep['rr_el_id'] == $element['rr_el_dep']){
										?>	<p class="span5 offset1 alert-info">Element direct dependency: </p><p id="dep_flag" class="span6"><?php echo $dep['rr_el_name']; ?></p> <?php
										break;
										} else {
										?>	<p class="span5 offset1 alert-info">Element direct dependency: </p><p id="dep_flag" class="span6">None</p> <?php
										}
									}*/
								?>
									</div>
									</div>
									-->
									<div class="row">
										<div class="span12">
											<p class="span5 offset1 alert-info">Notes: </p><p class="span6"><?php echo $element['rr_el_notes']; ?></p>
										</div>
									</div>
								
								</div>
								
								<script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/library/js/show-element.js'></script>
								
								<script>path = "<?php echo get_template_directory_uri(); ?>/";</script>
								
								<style>
									.element-container {
										border: 1px solid lightgrey;
										min-height: 275px;
										-webkit-border-radius: 4px;
										border-radius: 4px;
										moz-border-radius: 4px;
										margin-bottom: 5px;
									}

									.rr-container {
										border: 1px solid lightgrey;
										-webkit-border-radius: 4px;
										border-radius: 4px;
										moz-border-radius: 4px;
										margin-bottom: 5px;
									}
									
									.requirements-container {
										border: 1px solid lightgrey;
										-webkit-border-radius: 4px;
										border-radius: 4px;
										moz-border-radius: 4px;
										margin-bottom: 5px;
									}
									
									.button-container {
										height: 25px;
										position: relative;
										width: 260px;
										left: 540px;
										top: -45px;
										
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
									
									#delete-element {
										width: 70px;
										position: relative;
										left: 192px;
										top: -86px;
									}

								</style>
							<?php
							}
						}

					?>							
					
						</section> <!-- end article section -->
						
				</div> <!-- end #main -->
    
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>