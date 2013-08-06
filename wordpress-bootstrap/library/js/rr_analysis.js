$('document').ready(function(){
    
	// load element array data from database
	elementResults = $.parseJSON($.getValues( //all data for the element
		path + 'loadData.php', 
		{
			'element_id': el,
		}
	));
	
	delivResults = $.parseJSON($.getValues( // deliverable name, description and node groups
		path + 'loadData.php', 
		{
			'deliv_id': deliv,
		}
	));
	
	if (stat == '1'){ // determine the right group id
		group = delivResults[0].gl_node_group_id_1;
	} else if (stat == '2'){
		group = delivResults[0].gl_node_group_id_2;
	} else if (stat == '3'){
		group = delivResults[0].gl_node_group_id_3;
	} else if (stat == '4'){
		group = delivResults[0].gl_node_group_id_4;
	}
	
	topicResults = $.parseJSON($.getValues( // topic id's, names and descriptions and sort them
		path + 'loadData.php', 
		{
			'topic_id': group,
		}
	));
	
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
	
	nodeResults = $.parseJSON($.getValues( // node id's, questions, deferral, wp references and sort them
		path + 'loadData.php', 
		{
			'node_id': stat,
		}
	));
	
	nodeObj = [];
	
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
	
	nodeDataResults = {};
	nodeDataResults = $.parseJSON($.getValues( // node data
		path + 'loadData.php', 
		{
			'nodeData_id': el,
		}
	));
	
	topicDataResults = {};
	topicDataResults = $.parseJSON($.getValues( // topic data
		path + 'loadData.php', 
		{
			'topicData_id': el,
		}
	));
	
	if (topicDataResults.length > 1){
		topicDataKey = [];
		
		for (var key in topicDataResults){
			if (topicDataResults[key].gl_node_topic_data_id !== ''){
				topicDataKey.push(topicDataResults[key]);
			}
		}
		
		topicDataSorted = topicDataKey.sort(function(a,b){
			return(a.gl_node_topic_data_id - b.gl_node_topic_data_id);
		}); 
	} else {
		topicDataSorted = topicDataResults;
	}
	
	// set header
	//var hb = '<!-- Button to trigger modal --><a class="btn btn-small" data-toggle="modal" href="#reportModal">Generate Report</a>'
	var rModal = '<!-- Report Modal -->' + 
		'<div id="reportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">' +
		'<div id="reportModalContent"><div class="modal-header"><h3>' + title + '</h3><h4>' + desc + '</h4></div>' +
        '<div class="modal-body"><h4><strong>Project description: </strong></strong></h4><span id="rep"></span></div></div>' +
        '<div class="modal-footer"><button class="btn btn-small" onclick="printModal()">Print</button><button class="btn btn-small" data-dismiss="modal">Close</button></div></div>';
	var iModal = '<!-- Info Modal -->' + 
		'<div id="infoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">' +
		'<div id="infoModalContent">' +
		'<div class="modal-body"><span id="info"></span></div></div>' +
		'<div class="modal-footer"><button class="btn btn-small" data-dismiss="modal">Close</button></div></div>';
	var dModal = '<!-- Defer Modal -->' + 
		'<div id="deferModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deferModalLabel" aria-hidden="true">' +
		'<div id="deferModalContent">' +
		'<div class="modal-body"><span id="defer"></span></div></div>' +
		'<div class="modal-footer"><button class="btn btn-small" data-dismiss="modal">Close</button></div></div>';
	var ht = '<span><h4>Arrangement:' + name + '</h4></span><span><h5>Element:' + title + '</h5></span>';
	var catStat = '<div class="hidden" id="catstat" style="margin-top: 15px"></div>'
	var h = '<div class=glheader>' + ht + '</div>' + catStat + rModal + iModal + dModal;//+ hb + catStat + rModal + iModal;
	document.getElementById("header").innerHTML=h;
	
	$('li[id^="def"]').live('click',function(){
		var nid = $(this).attr('id').slice(3);
		var d1 = $(this).parent().siblings('span').text();
		$("#defer").html(d1);
	})
	
	for (var i = 0; i < topicSorted.length; i++){ // get a topic
		if (topicSorted[i].gl_topic_id !== null){
			// generate the topic header
			var t0 = $('#shownode').html();
			var t1 = parseInt(topicSorted[i].gl_topic_id);
			var t2 = topicSorted[i].gl_topic_name;
			var t3 = '';
			var t4 = t0 + '<div style="margin-top: 25px"><div class="alert-info"><button class="btn btn-mini toggle" id="t' + t1 + '">Disable</button>' +
				'<div style="position: relative; left: 65px; top: -22px;">' + 
				'<ul class="unstyled">' + 
				'<li>' + t2 + '</li>' + 
				'<div class="pull-right" style="position: relative; top: -1px; right: 65px;">'
			if (topicSorted[i].gl_topic_help > 1){
				var t5 = '<li id="' + topicSorted[i].gl_topic_help + '" class="info btn btn-mini" data-toggle="modal" href="#infoModal">Help</li>';
			} else {
				var t5 = '';
			}
			if (topicSorted[i].gl_topic_faq > 1){
				var t6 = '<li id="' + topicSorted[i].gl_topic_faq + '" class="info btn btn-mini" data-toggle="modal" href="#infoModal">FAQ</li>';
			} else {
				var t6 = '';
			}
			if (topicSorted[i].gl_topic_asc > 1){
				var t7 = '<li id="' + topicSorted[i].gl_topic_asc + '" class="info btn btn-mini" data-toggle="modal" href="#infoModal">ASC</li>';
			} else {
				var t7 = '';
			}
			if (topicSorted[i].gl_topic_examples >1){
				var t8 = '<li id="' + topicSorted[i].gl_topic_examples + '" class="info btn btn-mini" data-toggle="modal" href="#infoModal">Examples</li>';
			} else {
				var t8 = '';
			}
			var t9 = '</div></ul></div></div><div id="tcontainer-' + t1 + '" style="margin-left: 50px; margin-right: 50px;"></div></div>';
			var t10 = t4 + t5 + t6 + t7 + t8 + t9;
			$('#shownode').html(t10);
			for (var j = 0; j < nodeSorted.length; j++){ // get a node
				if (nodeSorted[j].gl_topic_id !== null){
					// if the node's topic_id equals the topic's topic_id, then generate the node
					if (nodeSorted[j].gl_topic_id == topicSorted[i].gl_topic_id){ 
						console.log('nodeSorted[j].gl_topic_id', nodeSorted[j].gl_topic_id);
						console.log('topicSorted[i].gl_topic_id', topicSorted[i].gl_topic_id);
						var q0 = $('#tcontainer-' + t1).html();
						var q1 = parseInt(nodeSorted[j].gl_node_id);
						var q2 = nodeSorted[j].gl_node_question;
						var q3 = nodeSorted[j].gl_node_deferral;
						var q4 = nodeSorted[j].gl_node_summary;
						var q5 = parseInt(nodeSorted[j].gl_node_id);
						var q6 = '<div id="q' + q1 + '"><ul class="unstyled"><li id="tq' + q1 + '">' + q2 + '</li>';
						var q7 = '<li class="btn btn-mini" id="node-yes' + q1 + '">Yes</li><li class="btn btn-mini" id="node-no' + q1 + '">No</li>' +
							'<li class="btn btn-mini" id="node-na' + q1 + '">NA</li>' + 
							'<div class="pull-right">' + 
							'<li class="btn btn-mini btn-danger hidden" id="def' + q1 + '" data-toggle="modal" href="#deferModal">Defer</li>' + 
							'</div>' + 
							'<span class="hidden">' + nodeResults[j].gl_node_summary + '</span></ul></div>';
						var q8 = q0 + q6 + q7;
						$('#tcontainer-' + t1).html(q8);
					}
				}
			}
		}
	}
	
	enabled = '';
	disabled = '';
	total_resp = '';
	no_resp = '';
	rec_resp = '';
	def_resp = '';
	
	// loop over topics and show saved data
	for (var key in topicDataResults){
		if (topicDataResults.hasOwnProperty(key)){
			$('.toggle').each(function(){
				var tid = $(this).attr('id').slice(1);
				if (tid == topicDataResults[key].gl_node_topic_id){
					if (topicDataResults[key].gl_node_topic_value == '0'){
						$(this).parent().siblings('div[id^="tcontainer"]').toggle(300);
						$(this).text('Enable');
						$(this).parent('div').removeClass('alert-info');
						$(this).parent('div').addClass('alert-error');
						disabled++;
					} else {
						$(this).text('Disable');
						$(this).parent('div').addClass('alert-info');
						$(this).parent('div').removeClass('alert-error');
						enabled++;
					}
				}
			})
		}
	}
	
	// loop over nodes and show saved data
	for (var key in nodeDataResults){
		if (nodeDataResults.hasOwnProperty(key)){
			$('li[id^="tq"]').each(function(){
				var nid = $(this).attr('id').slice(2);
				if (nid == nodeDataResults[key].gl_node_id){
					$(this).addClass('resp');
					if (nodeDataResults[key].gl_node_data_value == '0'){
						$(this).siblings('li[id^="node-no"]').addClass('selected').addClass("btn-inverse");
						for (var i = 0; i < nodeSorted.length; i++){ // get a node
							if (nodeSorted[i].gl_node_id == nodeDataResults[key].gl_node_id){
								if (nodeSorted[i].gl_node_deferral == 'no'){
									$(this).parent().parent('div[id^="q"]').addClass('alert-error');
									$(this).siblings('div').children('li[id^="def"]').removeClass('hidden');
								} else {
									$(this).parent().parent('div[id^="q"]').removeClass('alert-error');
									$(this).siblings('div').children('li[id^="def"]').addClass('hidden');
								}
								break;
							}
						}
					} else if (nodeDataResults[key].gl_node_data_value == '1'){
						$(this).siblings('li[id^="node-yes"]').addClass('selected').addClass("btn-inverse");
						for (var i = 0; i < nodeSorted.length; i++){ // get a node
							if (nodeSorted[i].gl_node_id == nodeDataResults[key].gl_node_id){
								if (nodeSorted[i].gl_node_deferral == 'yes'){
									$(this).parent().parent('div[id^="q"]').addClass('alert-error');
									$(this).siblings('div').children('li[id^="def"]').removeClass('hidden');
								} else {
									$(this).parent().parent('div[id^="q"]').removeClass('alert-error');
									$(this).siblings('div').children('li[id^="def"]').addClass('hidden');
								}
								break;
							}
						}
					} else if (nodeDataResults[key].gl_node_data_value == '2'){
						$(this).siblings('li[id^="node-na"]').addClass('selected').addClass("btn-inverse");
						$(this).addClass('na');
						for (var i = 0; i < nodeSorted.length; i++){ // get a node
						}
					}
				}
			})
		}
		total_quest = $('button:contains("Disable")').parent().siblings().find('li[id^="tq"]').length;
		def_resp = $('button:contains("Disable")').parent().siblings().find('div.alert-error').length;
		na_resp = $('button:contains("Disable")').parent().siblings().find('li.na[id^="tq"]').length;
		total_resp = $('button:contains("Disable")').parent().siblings().find('li.resp[id^="tq"]').length; 
		rec_resp = total_resp - def_resp - na_resp;
		no_resp = total_quest - total_resp
		catStat = '<p>Total number of questions enabled: ' + total_quest + '</p><p>Total number of questions answered: ' + total_resp + '</p><p>Total number of questions resulting in deferral: ' + def_resp + '</p><p>Total number of NA responses: ' + na_resp + '</p>'
		$('#catstat').html(catStat);
	}
	
	$('#wait').addClass('hidden');
	$('.return').removeClass('hidden');
	
	// toggle node visibility, update database, push topic value to array
	$('.toggle').live('click', function(){
		var topicId = $(this).attr('id').slice(1);
		$(this).parent().siblings('div[id^="tcontainer"]').toggle(300);
		if ($(this).text() == 'Disable'){
			$(this).text('Enable');
			$(this).parent('div').removeClass('alert-info');
			$(this).parent('div').addClass('alert-error');
			defCount = $(this).parent().siblings().find('li[id^="def"]:visible').length; //count the visible "Defer" buttons
			topicDefStat = '0';
			topicVal = '0';
		} else {
			$(this).text('Disable');
			$(this).parent('div').addClass('alert-info');
			$(this).parent('div').removeClass('alert-error');
			defCount = $(this).parent().siblings().find('li[id^="def"]:visible').length; //count the visible "Defer" buttons
			topicDefStat = '1';
			topicVal = '1';
		}
		if (topicDataResults.length > 0){
			for (var i = 0; i < topicDataResults.length; i++){
				if (topicDataResults[i].gl_node_topic_id == topicId){
					topicDataId = topicDataResults[i].gl_node_topic_data_id;
					break
				} else {
					topicDataId = '';
				}
			}
		} else {
			topicDataId = '';
		}
		if (topicDataId !== null && topicDataId !== ''){
			topicUpdateResults = $.saveValues( //all data for the element
				path + 'update_topic_data.php', 
				{
					'project_id': 	proj,
					'element_id': 	el,
					'deliv_id': 	deliv,
					'group_id': 	group,
					'status_id': 	stat,
					'topic_id': 	topicId,
					'topicData_id': topicDataId,
					'topicDefStat':	topicDefStat,
					'topic_value': 	topicVal
				}
			)
			for (var j = 0; j < topicDataResults.length; j++){
				if (topicDataResults[j].gl_node_topic_id == topicId){
					topicDataResults[j] = {
						gl_node_topic_data_id:		topicDataId,
						gl_node_topic_id: 			topicId,
						gl_proj_id: 				proj,
						rr_el_id: 					el,
						rr_del_id: 					deliv,
						gl_node_group_id: 			group,
						gl_el_status_id: 			stat,
						gl_node_topic_def_status:	topicDefStat,
						gl_node_topic_value:		topicVal
					};
				}
			}
		} else {
			newTopicDataId = $.saveValues( //all data for the element
				path + 'update_topic_data.php', 
				{
					'project_id': 	proj,
					'element_id': 	el,
					'deliv_id': 	deliv,
					'group_id': 	group,
					'status_id': 	stat,
					'topic_id': 	topicId,
					'topicData_id': 'new',
					'topicDefStat':	topicDefStat,
					'topic_value': 	topicVal
				}
			)
			topicDataResults.push({
				gl_node_topic_data_id:		newTopicDataId,
				gl_node_topic_id: 			topicId,
				gl_proj_id: 				proj,
				rr_el_id: 					el,
				rr_del_id: 					deliv,
				gl_node_group_id: 			group,
				gl_el_status_id: 			stat,
				gl_node_topic_def_status:	topicDefStat,
				gl_node_topic_value:		topicVal
			});
		}
		total_quest = $('button:contains("Disable")').parent().siblings().find('li[id^="tq"]').length;
		def_resp = $('button:contains("Disable")').parent().siblings().find('div.alert-error').length;
		na_resp = $('button:contains("Disable")').parent().siblings().find('li.na[id^="tq"]').length;
		total_resp = $('button:contains("Disable")').parent().siblings().find('li.resp[id^="tq"]').length; 
		rec_resp = total_resp - def_resp - na_resp;
		no_resp = total_quest - total_resp
		catStat = '<p>Total number of questions enabled: ' + total_quest + '</p><p>Total number of questions answered: ' + total_resp + '</p><p>Total number of questions resulting in deferral: ' + def_resp + '</p><p>Total number of NA responses: ' + na_resp + '</p>'
		$('#catstat').html(catStat);
		if (def_resp > 0 && no_resp == 0){
			elStat = 'Not Met';
		} else if (def_resp == 0 && no_resp == 0 && rec_resp > 0){
			elStat = 'Met';
		} else {
			elStat = 'Incomplete';
		}
		catStatUpdateResults = $.saveValues( //all data for the element
			path + 'json_rr_update.php', 
			{
				'def_element_id': 	el,
				'status_id':		stat,
				'total_quest': 		total_quest,
				'def_resp': 		def_resp,
				'no_resp':	 		no_resp,
				'na_resp':	 		na_resp,
				'total_resp': 		total_resp,
				'rec_resp':			rec_resp,
				'status_calc':		elStat
			}
		)
	})
	
	// toggle yes/no <li>'s, update database, push node value to array
	$('li[id^="node"]').live('click',function(){
		// the node's id
		var nodeId = $(this).siblings('li[id^="tq"]').attr('id').slice(2);
		
		// show the selected answer as selected
		$(this).addClass('selected').addClass("btn-inverse").siblings('.btn').removeClass('selected').removeClass("btn-inverse"); 
		$(this).siblings('li[id^="tq"]').addClass("resp");
		
		if ($(this).text() == 'No'){
			nodeVal = '0';
			$(this).siblings('li[id^="tq"]').removeClass('na');
			for (var i = 0; i < nodeSorted.length; i++){ // get a node
				if (nodeSorted[i].gl_node_deferral == 'no'){
					$(this).parent().parent('div[id^="q"]').addClass('alert-error');
					$(this).siblings('div').children('li[id^="def"]').removeClass('hidden');
					var nodeDefStat = '1';
				} else {
					$(this).parent().parent('div[id^="q"]').removeClass('alert-error');
					$(this).siblings('div').children('li[id^="def"]').addClass('hidden');
					var nodeDefStat = '0';
					
				}
				break;
			}
		} else if ($(this).text() == 'Yes'){
			nodeVal = '1';
			$(this).siblings('li[id^="tq"]').removeClass('na');
			for (var i = 0; i < nodeSorted.length; i++){ // get a node
				if (nodeSorted[i].gl_node_deferral == 'yes'){
					$(this).parent().parent('div[id^="q"]').addClass('alert-error');
					$(this).siblings('div').children('li[id^="def"]').removeClass('hidden');
					var nodeDefStat = '1';
				} else {
					$(this).parent().parent('div[id^="q"]').removeClass('alert-error');
					$(this).siblings('div').children('li[id^="def"]').addClass('hidden');
					var nodeDefStat = '0';
				}
				break;
			}
		} else if ($(this).text() == 'NA'){
			nodeVal = '2';
			$(this).siblings('li[id^="tq"]').addClass('na');
			$(this).parent().parent('div[id^="q"]').removeClass('alert-error');
			$(this).siblings('div').children('li[id^="def"]').addClass('hidden');
			var nodeDefStat = '0';
		}
		if (nodeDataResults.length > 0){
			for (var i = 0; i < nodeDataResults.length; i++){
				if (nodeDataResults[i].gl_node_id == nodeId){
					nodeDataId = nodeDataResults[i].gl_node_data_id;
					break
				} else {
					nodeDataId = '';
				}
			}
		} else {
			nodeDataId = '';
		}
		if (nodeDataId !== null && nodeDataId !== ''){
			nodeUpdateResults = $.saveValues( //all data for the element
				path + 'update_node_data.php', 
				{
					'project_id': 	proj,
					'element_id': 	el,
					'deliv_id': 	deliv,
					'group_id': 	group,
					'status_id': 	stat,
					'node_id': 		nodeId,
					'nodeData_id': 	nodeDataId,
					'nodeDefStat':	nodeDefStat,
					'node_value': 	nodeVal
				}
			)
			for (var j = 0; j < nodeDataResults.length; j++){
				if (nodeDataResults[j].gl_node_id == nodeId){
					nodeDataResults[j] = {
						gl_node_data_id:	nodeDataId,
						gl_node_id: 		nodeId,
						gl_proj_id: 		proj,
						rr_el_id: 			el,
						rr_del_id: 			deliv,
						gl_node_group_id: 	group,
						gl_el_status_id: 	stat,
						gl_node_def_status:	nodeDefStat,
						gl_node_value:		nodeVal
					};
				}
			}
		} else {
			newnodeDataId = $.saveValues( //all data for the element
				path + 'update_node_data.php', 
				{
					'project_id': 	proj,
					'element_id': 	el,
					'deliv_id': 	deliv,
					'group_id': 	group,
					'status_id': 	stat,
					'node_id': 		nodeId,
					'nodeData_id': 'new',
					'nodeDefStat':	nodeDefStat,
					'node_value': 	nodeVal
				}
			)
			nodeDataResults.push({
				gl_node_data_id:	newnodeDataId,
				gl_node_id: 		nodeId,
				gl_proj_id: 		proj,
				rr_el_id: 			el,
				rr_del_id: 			deliv,
				gl_node_group_id: 	group,
				gl_el_status_id: 	stat,
				gl_node_def_status:	nodeDefStat,
				gl_node_value:		nodeVal
			});
		}
		
		//loop over nodes and count response types
		
		total_quest = $('button:contains("Disable")').parent().siblings().find('li[id^="tq"]').length;
		def_resp = $('button:contains("Disable")').parent().siblings().find('div.alert-error').length;
		na_resp = $('button:contains("Disable")').parent().siblings().find('li.na[id^="tq"]').length;
		total_resp = $('button:contains("Disable")').parent().siblings().find('li.resp[id^="tq"]').length; 
		rec_resp = total_resp - def_resp - na_resp;
		no_resp = total_quest - total_resp
		catStat = '<p>Total number of questions enabled: ' + total_quest + '</p><p>Total number of questions answered: ' + total_resp + '</p><p>Total number of questions resulting in deferral: ' + def_resp + '</p><p>Total number of NA responses: ' + na_resp + '</p>'
		$('#catstat').html(catStat);
		if (def_resp > 0 && no_resp == 0){
			elStat = 'Not Met';
		} else if (def_resp == 0 && no_resp == 0 && rec_resp > 0){
			elStat = 'Met';
		} else {
			elStat = 'Incomplete';
		}
		catStatUpdateResults = $.saveValues( //all data for the element
			path + 'json_rr_update.php', 
			{
				'def_element_id': 	el,
				'status_id':		stat,
				'total_quest': 		total_quest,
				'def_resp': 		def_resp,
				'no_resp':	 		no_resp,
				'na_resp':	 		na_resp,
				'total_resp': 		total_resp,
				'rec_resp':			rec_resp,
				'status_calc':		elStat
			}
		)
		
	})
	
	// load node info from wordpress gl_posts on info button click
	$('.info').live('click',function(){
		postId = $(this).attr('id');
		$.ajax({
			type : "POST",
			url : path + "ajax_post.php",
			data : { 'postid' : postId }, 
			context: this,
			success: function(post){
				$("#info").html(post);
			}
		})
	})
})
		
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

jQuery.extend({
	saveValues: function(url, dataParams) {
		var result = null;
		$.ajax({
			url: url,
			type: 'post',
			data: dataParams,
			datatype: 'json',
			async: false,
			success: function(data) {
				result = data;
				//alert(result);
			}
		});
	   return result;
	}
});