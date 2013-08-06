<?php
/*
Template Name: Homepage New Nodes
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

						<section class="row-fluid post_content">
						
									<?php 
										
										$user_id = $current_user->ID;
																				
										
									?>
										
										<form class="form-horizontal" id="node-editor" action="<?php echo $site_url; ?>/edit-nodes/" method="post"> <!-- edit selected project.  variable $_SERVER... is posted -->
											<div class="control-group">
												<label class="control-label" for="topic_cond">Rev rec condition:</label>
												<div class="controls">
													<select id="topic_cond" name="topic_cond">
														<option value="">-----------------</option>
														<option class="topic-cond" value="1">Evidence of an arrangement</option>
														<option class="topic-cond" value="2">Delivery</option>
														<option class="topic-cond" value="3">Fixed or determinable fee</option>
														<option class="topic-cond" value="4">Collectible</option>
													</select>
												</div>
											</div>
											<div class="control-group">
												<label rows="5" class="control-label" for="gl_node_question">Node question:</label>
												<div class="controls">
													<textarea class="input-xlarge" id="gl_node_question" name="gl_node_question"></textarea>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_answer">Node summary:</label>
												<div class="controls">
													<textarea class="input-xlarge" rows="5" id="gl_node_summary" name="gl_node_summary"></textarea>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_answer">Node answer resulting in deferral:</label>
												<div class="controls">
													<select id="gl_node_deferral" name="gl_node_deferral">
														<option value="">---</option>
														<option value="yes">Yes</option>
														<option value="no">No</option>
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_help">HELP post id:</label>
												<div class="controls">
													<input type="text" id="help_post_id" name="help_post_id">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_faq">FAQ post id:</label>
												<div class="controls">
													<input type="text" id="faq_post_id" name="faq_post_id">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_asc">ASC post id:</label>
												<div class="controls">
													<input type="text" id="asc_post_id" name="asc_post_id">
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_examples">EXAMPLES post id:</label>
												<div class="controls">
													<input type="text" id="examples_post_id" name="examples_post_id">
												</div>
											</div>
											<input class="btn btn-primary" type="submit" id="save" name="new-node" value="Save" />
										</form>
								
							</div>
							
							
							<script>
								path = "<?php echo get_template_directory_uri(); ?>/";
								
								$("select").change(function() {
									$("select option:selected").each(function () {
										if ($(this).is('option[class^="topic-cond"]')){
											var topicCondId = $(this).val();
											console.log('topicCondId', topicCondId);
											
											topicResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadNodeData.php', 
												{
													'topic_id': topicCondId,
												}
											));
											
											console.log('topicResults', topicResults);
											
											if (topicResults.length > 1){
												topicKey = [];
												
												for (var key in topicResults){
													if (topicResults[key].gl_topic_id !== ''){
														topicKey.push(topicResults[key]);
													}
												}
												
												topicSorted = topicKey.sort(function(a,b){
													return(a.gl_topic_id - b.gl_topic_id);
												});
											} else {
												topicSorted = topicResults;
											}
											t1 = '';
											for (var i = 0; i < topicSorted.length; i++){ 
												t1 = t1 + '<option class="topic" id="topic-' + topicSorted[i].gl_topic_id + '" value="' + topicSorted[i].gl_topic_id + '">' + topicSorted[i].gl_topic_name + '</option>';					
											}
											console.log('t1', t1);
											t2 = '<select id="topic-list" name="gl_topic_id">' + t1 + '</select>';
											$('#topic-list').replaceWith(t2);
										} else {
											// do nothing
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
				
				<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>