<?php
/*
Template Name: Save Topics
*/$wpdb->query( "DELETE FROM wp_gl_gt_join WHERE rr_del_id = $deliv_id" );

session_start();

if (isset($_POST['assign-topics'])) {
	$delivs = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del", ARRAY_A );
	$deliv_id = $_POST['deliv_id'];
	$topic_cond = $_POST['topic_cond'];
	$topic_list = $_POST['topic_list'];
	
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
	
	$wpdb->query( "DELETE FROM wp_gl_gt_join WHERE gl_group_id = $group_id" );
	
	foreach ($topic_list as $topic){
		$topic_join = array ( 'gl_group_id' => $group_id, 'gl_topic_id' => $topic );
		if ($topic_join != null) { // insert new project in table
			$wpdb->insert( 'wp_gl_gt_join', $topic_join );
		}
	}
	
	unset ($_POST['assign-topics']);
	unset ($_POST['deliv_id']);
	unset ($_POST['topic_cond']);
	unset ($_POST['topic_list']);
	
	header("location: $site_url/assign-topics/");
	exit;
}

if (isset($_POST['edit-topic'])) {
	$topic_cond = $_POST['gl_topic_cond'];
	$gl_topic_id = $_POST['gl_topic_id'];
	$gl_topic_name = $_POST['gl_topic_name'];
	$gl_topic_help = $_POST['help_post_id'];
	$gl_topic_faq = $_POST['faq_post_id'];
	$gl_topic_asc = $_POST['asc_post_id'];
	$gl_topic_examples = $_POST['examples_post_id'];
	
	
	$topic = array ( 'gl_topic_name' => $gl_topic_name, 'gl_topic_help' => $gl_topic_help, 'gl_topic_faq' => $gl_topic_faq,
		'gl_topic_asc' => $gl_topic_asc, 'gl_topic_examples' => $gl_topic_examples );
	if ($topic != null) { 
			$wpdb->update( 
			'wp_gl_topics',
			$topic, 
			array(
				'gl_topic_id' => $gl_topic_id
			),
			array(
				'%s'
			)
		);
	}
	unset ($_POST['edit-topic']);
	
	header("location: $site_url/edit-topics/");
	exit;
}

?>