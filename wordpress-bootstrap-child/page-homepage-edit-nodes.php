<?php
/*
Template Name: Homepage Edit Nodes
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

						<section class="row-fluid post_content">
									
									<?php 
										
										
										
										$user_id = $current_user->ID;
																				
										$gtn_join = $wpdb->get_results( "SELECT * FROM wp_gl_gtn_join", ARRAY_A );
										$topics = $wpdb->get_results( "SELECT * FROM wp_gl_topics", ARRAY_A );
										$nodes = $wpdb->get_results( "SELECT * FROM wp_gl_nodes", ARRAY_A );
										
										if (isset($_POST['save'])) {	
											$group_id = $_POST['gl_node_group_id'];
											$node_question = $_POST['gl_node_question'];
											$node_summary = $_POST['gl_node_summary'];
											$node_topic_id = $_POST['gl_node_topic_id'];
											$node_deferral = $_POST['gl_node_deferral'];
											$node = array( "gl_node_group_id"=> $group_id, "gl_node_question"=> $node_question, "gl_node_summary"=> $node_summary,
												'gl_node_topic_id' => $node_topic_id, 'gl_node_deferral' => $node_deferral);
											print_r($node);
											
											if ($node != null) { // insert new project in table
												$wpdb->insert( 'wp_gl_rr_nodes', $node );
												$wpdb->print_error();
												$node_id =$wpdb->insert_id;
											}
											unset ($_POST['save']);
										}
										
									
									?>
										
									<?php
										foreach ($nodes as $node){
									?>
											<form class="form-horizontal" id="node-editor" action="<?php echo $site_url; ?>/save-nodes/" method="post"> <!-- edit selected project.  variable $_SERVER... is posted -->
												<div class="control-group">
													<label type="test" class="control-label" for="gl_node_id">Node id: <?php echo $node['gl_node_id']; ?></label>
													<input type="hidden" id="gl_node_id" name="gl_node_id" value="<?php echo $node['gl_node_id']; ?>">
												</div>
												<div class="control-group">
													<label rows="5" class="control-label" for="gl_node_question">Node question:</label>
													<div class="controls">
														<textarea class="input-xlarge" id="gl_node_question" name="gl_node_question"><?php echo $node['gl_node_question']; ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="gl_node_summary">Node summary:</label>
													<div class="controls">
														<textarea class="input-xlarge" rows="5" id="gl_node_summary" name="gl_node_summary"><?php echo $node['gl_node_summary']; ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="gl_node_deferral">Node answer resulting in deferral:</label>
													<div class="controls">
														<select id="gl_node_deferral" name="gl_node_deferral">
													<?php	if ($node['gl_node_deferral'] == 'yes'){
															?>	<option value="">---</option>
																<option value="yes" selected>Yes</option>
																<option value="no">No</option>
															<?php
															} else if ($node['gl_node_deferral'] == 'no'){
															?>	<option value="">---</option>
																<option value="yes" >Yes</option>
																<option value="no" selected>No</option>
															<?php
															} else {
															?>	<option value="">---</option>
																<option value="yes" >Yes</option>
																<option value="no">No</option>
															<?php
															}
														?>
														</select>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="gl_topic_cond">Topic condition ID:</label>
													<div class="controls">
														<input type="text" id="gl_topic_cond" name="gl_topic_cond" value="<?php echo $node['gl_topic_cond']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="help_post_id">HELP post id:</label>
													<div class="controls">
														<input type="text" id="help_post_id" name="help_post_id" value="<?php echo $node['gl_node_help']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="faq_post_id">FAQ post id:</label>
													<div class="controls">
														<input type="text" id="faq_post_id" name="faq_post_id" value="<?php echo $node['gl_node_faq']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="asc_post_id">ASC post id:</label>
													<div class="controls">
														<input type="text" id="asc_post_id" name="asc_post_id"value="<?php echo $node['gl_node_asc']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="examples_post_id">EXAMPLES post id:</label>
													<div class="controls">
														<input type="text" id="examples_post_id" name="examples_post_id"value="<?php echo $node['gl_node_examples']; ?>">
													</div>
												</div>
												<input class="btn btn-primary" type="submit" id="save" name="edit-node" value="Save" />
											</form>
									<?php
										}
									?>
								
							</div>
							
							<script>
								path = "<?php echo get_template_directory_uri(); ?>/";
								
								$("select").change(function() {
									$("select option:selected").each(function () {
										if ($(this).is('option[class^="topic"]')){
											var groupId = $(this).val();
											console.log('groupId', groupId);
											topicResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadData.php', 
												{
													'topic_id': groupId,
												}
											));
											
											console.log('topicResults', topicResults);
											
											if (topicResults.length > 1){
												topicKey = [];
												
												for (var key in topicResults){
													if (topicResults[key].gl_node_topic_id !== ''){
														topicKey.push(topicResults[key]);
													}
												}
												
												topicSorted = topicKey.sort(function(a,b){
													return(a.gl_node_topic_id - b.gl_node_topic_id);
												});
											} else {
												topicSorted = topicResults;
											}
											t1 = '';
											for (var i = 0; i < topicSorted.length; i++){ 
												t1 = t1 + '<option class="topic" id="topic-' + topicSorted[i].gl_node_topic_id + '" value="' + topicSorted[i].gl_node_topic_id + '">' + topicSorted[i].gl_node_topic_name + '</option>';					
											}
											console.log('t1', t1);
											t2 = '<select id="topic-list" name="gl_node_topic_id">' + t1 + '</select>';
											$('#topic-list').replaceWith(t2);
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
											}
										});
									   return result;
									}
								});
							</script>
							
							<?php get_sidebar('sidebar2'); // sidebar 2 ?>
													
						</section> <!-- end article header -->
						
				</div> <!-- end #main -->
				
				<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>