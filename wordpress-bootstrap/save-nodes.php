<?php
/*
Template Name: Save Nodes
*/

session_start();
cache_control(0);

if (isset($_POST['new-node'])) {
	$topic_cond = $_POST['gl_topic_cond'];
	$gl_node_question = $_POST['gl_node_question'];
	$gl_node_summary = $_POST['gl_node_summary'];
	$gl_node_deferral = $_POST['gl_node_deferral'];
	$gl_node_help = $_POST['gl_node_help'];
	$gl_node_faq = $_POST['gl_node_faq'];
	$gl_node_asc = $_POST['gl_node_asc'];
	$gl_node_examples = $_POST['gl_node_examples'];
	$node = array ( 'gl_node_question' => $gl_node_question, 'gl_node_summary' => $gl_node_summary, 'gl_node_deferral' => $gl_node_deferral, 
		'gl_node_help' => $gl_node_help, 'gl_node_faq' => $gl_node_faq, 'gl_node_asc' => $gl_node_asc, 'gl_node_examples' => $gl_node_examples,
		'gl_topic_cond' => $topic_cond );
	if ($node != null) {
		$wpdb->insert( 'wp_gl_nodes', $node );
	}
	unset ($_POST['new-node']);
	
	header("location: $site_url/edit-nodes/");
	exit;
}

if (isset($_POST['edit-node'])) {
	$topic_cond = $_POST['gl_topic_cond'];
	$gl_node_id = $_POST['gl_node_id'];
	$gl_node_question = $_POST['gl_node_question'];
	$gl_node_summary = $_POST['gl_node_summary'];
	$gl_node_deferral = $_POST['gl_node_deferral'];
	$gl_node_help = $_POST['help_post_id'];
	$gl_node_faq = $_POST['faq_post_id'];
	$gl_node_asc = $_POST['asc_post_id'];
	$gl_node_examples = $_POST['examples_post_id'];
	
	
	$node = array ( 'gl_node_question' => $gl_node_question, 'gl_node_summary' => $gl_node_summary, 'gl_node_deferral' => $gl_node_deferral, 
		'gl_node_help' => $gl_node_help, 'gl_node_faq' => $gl_node_faq, 'gl_node_asc' => $gl_node_asc, 'gl_node_examples' => $gl_node_examples );
	if ($node != null) { 
			$wpdb->update( 
			'wp_gl_nodes',
			$node, 
			array(
				'gl_node_id' => $gl_node_id
			),
			array(
				'%s'
			)
		);
	}
	unset ($_POST['edit-node']);
	
	header("location: $site_url/edit-nodes/");
	exit;
}

if (isset($_POST['assign-nodes'])) {
	$topic_cond = $_POST['topic_cond'];
	$topic_id = $_POST['topic_id'];
	
	foreach ($delivs as $deliv){
		if ($deliv['rr_del_id'] == $deliv_id){
			if ($topic_cond == 1){
				$group_id = $deliv['gl_node_group_id_1'];
			} else if ($topic_cond == 2){
				$group_id = $deliv['gl_node_group_id_2'];
			} else if ($topic_cond == 3){
				$group_id = $deliv['gl_node_group_id_3'];
			} else if ($topic_cond == 4){
				$group_id = $deliv['gl_node_group_id_4'];
			}
		}
	}
	
	$node_list = $_POST['node_list'];
		
	foreach ($node_list as $node){
		$node_join = array ( 'gl_topic_id' => $topic_id, 'gl_node_id' => $node );
		if ($node_join != null) { // insert new project in table
			$wpdb->insert( 'wp_gl_gtn_join', $node_join );
		}
	}
	
	unset ($_POST['assign-nodes']);
	unset ($_POST['topic_cond']);
	unset ($_POST['node_list']);
	
	header("location: $site_url/assign-nodes/");
	exit;
}

?>