<?php
global $wpdb;
require( '../../../wp-load.php' );

$element_id = $_GET['element_id'];
$deliv_id = $_GET['deliv_id'];
$group_id = $_GET['group_id'];
$topic_id = $_GET['topic_id']; // same as $group_id
$node_id = $_GET['node_id'];
$status_id = $_GET['status_id'];
$topicArray_id = $_GET['topicArray_id']; //same as $element_id
$nodeArray_id = $_GET['nodeArray_id']; //same as $element_id
$topicData_id = $_GET['topicData_id']; //same as $element_id
$nodeData_id = $_GET['nodeData_id']; //same as $element_id

if ($element_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr WHERE rr_el_id = $element_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['element_id']);
}

if ($topicArray_id !== null){
	if ($status_id == '1'){
		$topicArray = 'rr_topic_array_1';
	} else if ($status_id == '2'){
		$topicArray = 'rr_topic_array_2';
	} else if ($status_id == '3'){
		$topicArray = 'rr_topic_array_3';
	} else if ($status_id == '4'){
		$topicArray = 'rr_topic_array_4';
	}
	$results = $wpdb->get_results( "SELECT $topicArray FROM wp_gl_rr WHERE rr_el_id = $topicArray_id", ARRAY_A );
	$array = $results[0][$topicArray];
	$array = unserialize($array);
	$array = json_encode($array);
	$array = stripslashes($array);
	echo $array;
	unset ($_GET['topicArray_id']);	
}

if ($nodeArray_id !== null){
	if ($status_id == '1'){
		$nodeArray = 'rr_node_array_1';
	} else if ($status_id == '2'){
		$nodeArray = 'rr_node_array_2';
	} else if ($status_id == '3'){
		$nodeArray = 'rr_node_array_3';
	} else if ($status_id == '4'){
		$nodeArray = 'rr_node_array_4';
	}
	$results = $wpdb->get_results( "SELECT $nodeArray FROM wp_gl_rr WHERE rr_el_id = $nodeArray_id", ARRAY_A );
	$array = $results[0][$nodeArray];
	$array = unserialize($array);
	$array = json_encode($array);
	$array = stripslashes($array);
	echo $array;
	unset ($_GET['nodeArray_id']);	
}

if ($deliv_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr_del WHERE rr_del_id = $deliv_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['deliv_id']);
}

if ($group_id !== null){	
	$joins = $wpdb->get_results( "SELECT * FROM wp_gl_gtn_join WHERE gl_group_id = $group_id", ARRAY_A ); // gets the join for the applicable group
	$array = array();
	foreach ($joins as $join){
		if ($join['gl_group_id'] == $group_id){
			$this_topic_id = $join['gl_topic_id'];
			$this_node_id = $join['gl_node_id'];
			$topics = $wpdb->get_results( "SELECT * FROM wp_gl_topics WHERE gl_topic_id = $this_topic_id", ARRAY_A );
			$nodes = $wpdb->get_results( "SELECT * FROM wp_gl_nodes WHERE gl_node_id = $this_node_id", ARRAY_A );
			$this_array = array('topic' => $topics[0], 'node' => $nodes[0]);
			array_push($array, $this_array);
		}
	}
	$array = json_encode($array);
	echo $array;
	unset ($_GET['group_id']);
}

if ($topic_id !== null){
	$joins = $wpdb->get_results( $wpdb->prepare( 
		"
		SELECT 		*
		FROM 		wp_gl_topics
		INNER JOIN 	wp_gl_gt_join 
					ON wp_gl_gt_join.gl_topic_id = wp_gl_topics.gl_topic_id
		WHERE 		gl_group_id = $topic_id
		",
		ARRAY_A 
		) );
	$joins = json_encode($joins);
	echo $joins;
	unset ($_GET['topic_id']);
}

if ($node_id !== null){
	$joins = $wpdb->get_results( $wpdb->prepare( 
		"
		SELECT 		*
		FROM 		wp_gl_nodes
		INNER JOIN 	wp_gl_gtn_join 
					ON wp_gl_gtn_join.gl_node_id = wp_gl_nodes.gl_node_id
		WHERE 		gl_group_id = $node_id
		",
		ARRAY_A 
		) );
	$joins = json_encode($joins);
	echo $joins;
	unset ($_GET['node_id']);
}

if ($nodeData_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr_node_data WHERE rr_el_id = $nodeData_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['nodeData_id']);
}

if ($topicData_id !== null){
	$results = $wpdb->get_results( "SELECT * FROM wp_gl_rr_topic_data WHERE rr_el_id = $topicData_id", ARRAY_A );
	$results = json_encode($results);
	echo $results;
	unset ($_GET['topicData_id']);
}

?>