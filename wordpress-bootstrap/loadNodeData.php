<?php
global $wpdb;
require( '../../../wp-load.php' );

$element_id = $_GET['element_id'];
$deliv_id = $_GET['deliv_id'];
$group_id = $_GET['group_id'];
$topic_cond_id = $_GET['topic_cond_id'];
$node_cond_id = $_GET['node_cond_id'];
$topic_gt_id = $_GET['topic_gt_id'];
$topic_group_id = $_GET['topic_group_id'];
$node_gtn_id = $_GET['node_gtn_id'];
$status_id = $_GET['status_id'];
$join_id = $_GET['join_id'];
$method_id = $_GET['method_id'];

if ($group_id !== null){	
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_groups", ARRAY_A );
	foreach ($results as $result){
		if($result['gl_node_group_id'] == $group_id){
			$group = json_encode($result);
		}
	}
	echo $group;
	unset ($_GET['group_id']);
}

if ($topic_gt_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_gt_join WHERE gl_group_id = $topic_gt_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['topic_gt_id']);
}

if ($node_gtn_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_gtn_join WHERE gl_topic_id = $node_gtn_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['node_gtn_id']);
}

if ($topic_cond_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_groups WHERE gl_topic_cond = $topic_cond_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['topic_group_id']);
}

if ($node_cond_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_nodes WHERE gl_topic_cond = $node_cond_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['node_group_id']);
}

if ($method_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr_meth", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['method_id']);
}

if ($topic_group_id !== null){
	$joins = $wpdb->get_results( $wpdb->prepare( 
		"
		SELECT 		*
		FROM 		wp_gl_gt_join
		INNER JOIN 	wp_gl_topics 
					ON wp_gl_topics.gl_topics_id = wp_gl_gt_join.gl_topic_id
		WHERE 		gl_group_id = $topic_group_id
		",
		ARRAY_A 
		) );
	$joins = json_encode($joins);
	echo $joins;
	unset ($_GET['node_id']);
}

?>