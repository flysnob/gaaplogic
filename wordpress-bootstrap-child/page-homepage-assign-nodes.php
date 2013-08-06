<?php
/*
Template Name: Homepage Assign Nodes
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

						<section class="row-fluid post_content">
						
									
									<?php 
										
										$user_id = $current_user->ID;
																				
										$topics = $wpdb->get_results( "SELECT * FROM wp_gl_topics", ARRAY_A );
										$nodes = $wpdb->get_results( "SELECT * FROM wp_gl_nodes", ARRAY_A );
										
										if (isset($_POST['assign-topics'])) {	
											
										}
									?>
										<a href="<?php echo P_EDITOR_URL; ?>">&laquo; Return to list</a>&nbsp;&nbsp;&nbsp; <!-- return to list of all projects -->
										
										<form class="form-horizontal" id="node-editor" action="<?php echo $site_url; ?>/save-nodes/" method="post">
											<div class="control-group">
												<label class="control-label" for="cond">Rev rec condition:</label>
												<div class="controls">
													<select id="cond" name="cond">
														<option value="">-----------------</option>
														<option class="cond" value="1">Evidence of an arrangement</option>
														<option class="cond" value="2">Delivery</option>
														<option class="cond" value="3">Fixed or determinable fee</option>
														<option class="cond" value="4">Collectible</option>
													</select>
												</div>
											</div>
											<div class="control-group hidden" id="1-container">
												<label class="control-label" for="topic">Topics:</label>
												<div class="controls">
													<select id="topic_id" name="topic_id">
														<option value="">-----------------</option>
														<?php
															foreach ($topics as $topic){
																if ($topic['gl_topic_cond'] == 1){
																?>	
																	<option class="topic" value="<?php echo $topic['gl_topic_id']; ?>"><?php echo $topic['gl_topic_name']; ?></option>
																<?php
																}
															}
														?>
													</select>
												</div>
											</div>
											<div class="control-group hidden" id="2-container">
												<label class="control-label" for="topic">Topics:</label>
												<div class="controls">
													<select id="topic_id" name="topic_id">
														<option value="">-----------------</option>
														<?php
															foreach ($topics as $topic){
																if ($topic['gl_topic_cond'] == 2){
																?>	
																	<option class="topic" value="<?php echo $topic['gl_topic_id']; ?>"><?php echo $topic['gl_topic_name']; ?></option>
																<?php
																}
															}
														?>
													</select>
												</div>
											</div>
											<div class="control-group hidden" id="3-container">
												<label class="control-label" for="topic">Topics:</label>
												<div class="controls">
													<select id="topic_id" name="topic_id">
														<option value="">-----------------</option>
														<?php
															foreach ($topics as $topic){
																if ($topic['gl_topic_cond'] == 3){
																?>	
																	<option class="topic" value="<?php echo $topic['gl_topic_id']; ?>"><?php echo $topic['gl_topic_name']; ?></option>
																<?php
																}
															}
														?>
													</select>
												</div>
											</div>
											<div class="control-group hidden" id="4-container">
												<label class="control-label" for="topic">Topics:</label>
												<div class="controls">
													<select id="topic_id" name="topic_id">
														<option value="">-----------------</option>
														<?php
															foreach ($topics as $topic){
																if ($topic['gl_topic_cond'] == 4){
																?>	
																	<option class="topic" value="<?php echo $topic['gl_topic_id']; ?>"><?php echo $topic['gl_topic_name']; ?></option>
																<?php
																}
															}
														?>
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="gl_node_topic">Nodes:</label>
												<div class="controls span6">
													<span id="node-list">
													</span>
												</div>
											</div>
											<input class="btn btn-primary" type="submit" id="save" name="assign-nodes" value="Save" />
										</form>
										
									
							</div>
							
							<script>
								path = "<?php echo get_template_directory_uri(); ?>/";
								
								$("select").change(function() {
									$("select option:selected").each(function () {
										if ($(this).is('option[class="cond"]')){
											topicCondId = $(this).val();
											if (topicCondId == 1){
												$('#1-container').removeClass('hidden');
												$('#2-container').addClass('hidden');
												$('#3-container').addClass('hidden');
												$('#4-container').addClass('hidden');
											} else if (topicCondId == 2){
												$('#2-container').removeClass('hidden');
												$('#1-container').addClass('hidden');
												$('#3-container').addClass('hidden');
												$('#4-container').addClass('hidden');
											} else if (topicCondId == 3){
												$('#3-container').removeClass('hidden');
												$('#1-container').addClass('hidden');
												$('#2-container').addClass('hidden');
												$('#4-container').addClass('hidden');
											} else if (topicCondId == 4){
												$('#4-container').removeClass('hidden');
												$('#1-container').addClass('hidden');
												$('#2-container').addClass('hidden');
												$('#3-container').addClass('hidden');
											}
										}
										
										if ($(this).is('option[class="topic"]')){
											topicId = $(this).val();
											console.log('topicId', topicId);
											
											nodeResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadNodeData.php', 
												{
													'node_cond_id': topicCondId,
												}
											));
											
											
											
											nodeGtnResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadNodeData.php', 
												{
													'node_gtn_id': topicId,
												}
											));
											
											console.log('nodeResults', nodeResults);
											console.log('nodeGtnResults', nodeGtnResults);
											
											if (nodeResults.length > 1){
												nodeKey = [];
												
												for (var key in nodeResults){
													if (nodeResults[key].gl_node_id !== ''){
														nodeKey.push(nodeResults[key]);
													}
												}
												
												nodeSorted = nodeKey.sort(function(a,b){
													return(a.gl_node_id - b.gl_node_id);
												});
											} else {
												nodeSorted = nodeResults;
											}
											
											console.log('nodeSorted', nodeSorted);
											
											t1 = '';
											for (var i = 0; i < nodeSorted.length; i++){ 
												t1 = t1 + '<label class="checkbox"><input type="checkbox" class="node" id="node-' + nodeSorted[i].gl_node_id + '" name="node_list[]" value="' + nodeSorted[i].gl_node_id + '">' + nodeSorted[i].gl_node_question + '</label>';
											}
											console.log('t1', t1);
											$('#node-list').html(t1);
											
											//loop over checkboxes and indicate already assigned
											for (var key in nodeGtnResults){
												if (nodeGtnResults.hasOwnProperty(key)){
													$('.node').each(function(){
														var nid = $(this).val();
														console.log('nid', nid);
														if (nid == nodeGtnResults[key].gl_node_id){
															$(this).parent().addClass('alert-info');
															this.disabled = true;
														}
													})
												}
											}
											console.log('node-con pass');
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
												//alert(result);
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