<?php
/*
Template Name: Homepage Assign Topics
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span8 clearfix" role="main">

						<section class="row-fluid post_content">
															
									<?php 
										
										$user_id = $current_user->ID;
																				
										$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del ORDER BY rr_del_name ASC", ARRAY_A );
										
										$groups = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_groups", ARRAY_A );
										$topics = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_topics", ARRAY_A );
										$nodes = $wpdb->get_results( "SELECT * FROM wp_gl_rr_nodes", ARRAY_A );
										
										if (isset($_POST['assign-topics'])) {	
											
										}
									?>
										<a href="<?php echo P_EDITOR_URL; ?>">&laquo; Return to list</a>&nbsp;&nbsp;&nbsp; <!-- return to list of all projects -->
										
										<form class="form-horizontal" id="node-editor" action="<?php echo $site_url; ?>/save-topic/" method="post"> <!-- edit selected project.  variable $_SERVER... is posted -->
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
												<label class="control-label" for="gl_node_topic">Topics:</label>
												<div class="controls span6">
													<span id="topic-list">
													</span>
												</div>
											</div>
											<input class="btn btn-primary" type="submit" id="save" name="assign-topics" value="Save" />
										</form>
										
									<?php
										foreach ($delivs as $deliv){
										?>
											<ul class="hidden" id="group-<?php echo $deliv['rr_del_id']; ?>" style="">
												<li id="stat1"><?php echo $deliv['gl_node_group_id_1']; ?></li>
												<li id="stat2"><?php echo $deliv['gl_node_group_id_2']; ?></li>
												<li id="stat3"><?php echo $deliv['gl_node_group_id_3']; ?></li>
												<li id="stat4"><?php echo $deliv['gl_node_group_id_4']; ?></li>
											</ul>
										<?php
										}
									?>
							</div>
							
							<script>
								path = "<?php echo get_template_directory_uri(); ?>/";
								
								$("select").change(function() {
									$("select option:selected").each(function () {
										if ($(this).hasClass('deliv')){
											groupId = $(this).val();
											console.log('groupId', groupId);
											console.log('deliv pass')
										}
										
										if ($(this).hasClass('topic-cond')){
											topicCondId = $(this).val();
											console.log('topicCondId', topicCondId);
											
											topicResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadNodeData.php', 
												{
													'topic_id': topicCondId,
												}
											));
											
											if (topicCondId == 1){
												console.log('1');
												console.log(groupId);
												gtId = $('#group-' + groupId).children('#stat1').text();
											} else if (topicCondId == 2){
												console.log('2');
												gtId = $('#group-' + groupId).children('#stat2').text();
											} else if (topicCondId == 3){
												console.log('3');
												gtId = $('#group-' + groupId).children('#stat3').text();
											} else if (topicCondId == 4){
												console.log('4');
												gtId = $('#group-' + groupId).children('#stat4').text();
											}
											
											console.log('gtId', gtId);
											topicGtResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
												path + 'loadNodeData.php', 
												{
													'topic_gt_id': gtId,
												}
											));
											
											console.log('topicResults', topicResults);
											console.log('topicGtResults', topicGtResults);
											
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
												t1 = t1 + '<label class="checkbox"><input type="checkbox" class="topic" id="topic-' + topicSorted[i].gl_topic_id + '" name="topic_list[]" value="' + topicSorted[i].gl_topic_id + '">' + topicSorted[i].gl_topic_name + '</label>';
											}
											console.log('t1', t1);
											$('#topic-list').html(t1);
											
											//loop over checkboxes and indicate already assigned
											for (var key in topicGtResults){
												if (topicGtResults.hasOwnProperty(key)){
													$('.topic').each(function(){
														var tid = $(this).attr('id').slice(6);
														console.log('tid', tid);
														if (tid == topicGtResults[key].gl_topic_id){
															$(this).parent().addClass('alert-info');
															$(this).prop('checked', true);
														}
													})
												}
											}
											console.log('topic-con pass')
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