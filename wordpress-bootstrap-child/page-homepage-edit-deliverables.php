<?php
/*
Template Name: Homepage Edit Deliverables
*/
?>

<?php get_header(); ?>
			
			<div id="content" class="clearfix row-fluid">
			
				<div id="main" class="span12 clearfix" role="main">

						<section class="row-fluid post_content">
						
							<div class="span8">
									
									<?php 
										
										$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
										
									?>
										
									<?php
										foreach ($delivs as $deliv){
									?>
											<form class="form-horizontal" id="node-editor" action="/save-deliv/" method="post">
												<div class="control-group">
													<label class="control-label" for="rr_del_id">Deliverable id: <?php echo $deliv['rr_del_id']; ?></label>
													<input type="hidden" name="rr_del_id" value="<?php echo $deliv['rr_del_id']; ?>">
												</div>
												<div class="control-group">
													<label rows="5" class="control-label" for="rr_del_name">Deliverable name:</label>
													<div class="controls">
														<textarea class="input-xlarge" id="rr_del_name" name="rr_del_name"><?php echo stripslashes($deliv['rr_del_name']); ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="rr_del_desc">Deliverable description:</label>
													<div class="controls">
														<textarea class="input-xlarge" rows="5" id="rr_del_desc" name="rr_del_desc"><?php echo stripslashes($deliv['rr_del_desc']); ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="rr_del_disc_cat">Discount category:</label>
													<div class="controls">
														<textarea class="input-xlarge" rows="5" id="rr_del_disc_cat" name="rr_del_disc_cat"><?php echo stripslashes($deliv['rr_del_disc_cat']); ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="rr_del_desc">Condition 1 id:</label>
													<div class="controls">
														<input class="input-mini" type="text" id="gl_node_group_id_1" name="gl_node_group_id_1" value="<?php echo $deliv['gl_node_group_id_1']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="rr_del_desc">Condition 2 id:</label>
													<div class="controls">
														<input class="input-mini" type="text" id="gl_node_group_id_2" name="gl_node_group_id_2" value="<?php echo $deliv['gl_node_group_id_2']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="rr_del_desc">Condition 3 id:</label>
													<div class="controls">
														<input class="input-mini" type="text" id="gl_node_group_id_3" name="gl_node_group_id_3" value="<?php echo $deliv['gl_node_group_id_3']; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label" for="rr_del_desc">Condition 4 id:</label>
													<div class="controls">
														<input class="input-mini" type="text" id="gl_node_group_id_4" name="gl_node_group_id_4" value="<?php echo $deliv['gl_node_group_id_4']; ?>">
													</div>
												</div>
												
												<input class="btn btn-primary" type="submit" id="save" name="edit-deliv" value="Save" />
											</form>
									<?php
										}
									?>
								
							</div>
							
							<?php get_sidebar('sidebar2'); // sidebar 2 ?>
													
						</section> <!-- end article header -->
						
				</div> <!-- end #main -->
				
				<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>