<?php
/*
Template Name: Homepage Edit Topics
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
										
									?>
										
									<?php
										foreach ($topics as $topic){
									?>
											<form class="form-horizontal" id="node-editor" action="<?php echo $site_url; ?>/save-topic/" method="post"> 
												<div class="control-group">
													<label type="test" class="control-label" for="gl_topic_id">Topic id: <?php echo $topic['gl_topic_id']; ?></label>
													<input type="hidden" id="gl_topic_id" name="gl_topic_id" value="<?php echo $topic['gl_topic_id']; ?>">
												</div>
												<div class="control-group">
													<label rows="5" class="control-label" for="gl_topic_name">Topic name:</label>
													<div class="controls">
														<textarea class="input-xlarge" id="gl_topic_name" name="gl_topic_name"><?php echo $topic['gl_topic_name']; ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="gl_topic_cond">Topic condition ID:</label>
													<div class="controls">
														<input type="text" id="gl_topic_cond" name="gl_topic_cond" value="<?php echo $topic['gl_topic_cond']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="help_post_id">HELP post id:</label>
													<div class="controls">
														<input type="text" id="help_post_id" name="help_post_id" value="<?php echo $topic['gl_topic_help']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="faq_post_id">FAQ post id:</label>
													<div class="controls">
														<input type="text" id="faq_post_id" name="faq_post_id" value="<?php echo $topic['gl_topic_faq']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="asc_post_id">ASC post id:</label>
													<div class="controls">
														<input type="text" id="asc_post_id" name="asc_post_id"value="<?php echo $topic['gl_topic_asc']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="examples_post_id">EXAMPLES post id:</label>
													<div class="controls">
														<input type="text" id="examples_post_id" name="examples_post_id"value="<?php echo $topic['gl_topic_examples']; ?>">
													</div>
												</div>
												<input class="btn btn-primary" type="submit" id="save" name="edit-topic" value="Save" />
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