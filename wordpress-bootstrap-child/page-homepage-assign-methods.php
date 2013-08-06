<?php
/*
Template Name: Homepage Assign Methods
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

						<section class="row-fluid post_content">
															
									<?php 
										
										$user_id = $current_user->ID;
																				
										$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
										
										$groups = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_groups", ARRAY_A );
										$topics = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_topics", ARRAY_A );
										$nodes = $wpdb->get_results( "SELECT * FROM wp_gl_rr_nodes", ARRAY_A );
										
										if (isset($_POST['assign-methods'])) {	
											
										}
									?>
										<a href="<?php echo P_EDITOR_URL; ?>">&laquo; Return to list</a>&nbsp;&nbsp;&nbsp; <!-- return to list of all projects -->
										
										<form class="form-horizontal" id="node-editor" action="<?php echo $site_url; ?>/save-method/" method="post"> <!-- edit selected project.  variable $_SERVER... is posted -->
											<div class="control-group">
												<label class="control-label" for="deliv_id">Deliverable:</label>
												<div class="controls">
													<select id="deliv_id" name="deliv_id">
														<option value="">-----------------</option>
														<?php
															foreach ($delivs as $deliv){
															?>	
																<option class="deliv" value="<?php echo $deliv['rr_del_id']; ?>"><?php echo $deliv['rr_del_name']; ?></option>
															<?php
															}
														?>
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_meth_id">Methods:</label>
												<div class="controls span6">
													<span id="method-list">
													</span>
												</div>
											</div>
											<input class="btn btn-primary" type="submit" id="save" name="assign-methods" value="Save" />
										</form>
							</div>
							
							<script>
								path = "<?php echo get_template_directory_uri(); ?>/";
								
								$("select").change(function() {
									$("select option:selected").each(function () {
										
										if ($(this).hasClass('deliv')){
											delivId = $(this).val();
											console.log('delivId', delivId);
											
											methodResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadData.php', 
												{
													'method_id': '1',
												}
											));
											console.log('methodResults', methodResults);
											if (methodResults.length > 1){
												methodKey = [];
												
												for (var key in methodResults){
													if (methodResults[key].rr_meth_id !== ''){
														methodKey.push(methodResults[key]);
													}
												}
												
												methodSorted = methodKey.sort(function(a,b){
													return(a.rr_meth_id - b.rr_meth_id);
												});
											} else {
												methodSorted = methodResults;
											}
											
											t1 = '';
											for (var i = 0; i < methodSorted.length; i++){ 
												t1 = t1 + '<label class="checkbox"><input type="checkbox" class="method" id="method-' + methodSorted[i].rr_meth_id + '" name="method_list[]" value="' + methodSorted[i].rr_meth_id + '">' + methodSorted[i].rr_meth_name + '</label>';
											}
											console.log('t1', t1);
											$('#method-list').html(t1);
											
											joinResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadData.php', 
												{
													'join_id': delivId,
												}
											));
											
											//loop over checkboxes and indicate already assigned
											for (var key in joinResults){
												if (joinResults.hasOwnProperty(key)){
													$('.method').each(function(){
														var mid = $(this).attr('id').slice(7);
														console.log('mid', mid);
														if (mid == joinResults[key].rr_meth_id){
															$(this).parent().addClass('alert-info');
															$(this).prop('checked', true);
															//this.disabled = true;
														}
													})
												}
											}
										
										}
									});
								});
								
								jQuery.extend({
									getValues: function(url, dataParams) {
										var result = null;
										$.ajax({
											url: url,
											type: 'get',
											data: dataParams,
											async: false,
											success: function(data) {
												result = data;
												alert(result);
											}
										});
									   return result;
									}
								});
							</script>
							
						<?php get_sidebar('sidebar2'); // sidebar 2 ?>
													
						</section> <!-- end article header -->
						
				</div> <!-- end #main -->
				
				<?php //get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>