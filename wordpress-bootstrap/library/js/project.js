$('document').ready(function(){
	
	// load nodes from json file
	nodeResults = $.getValues(path + 'assets/nodes.json', '');
		
	// load project data (answers, targets and comments) from database
	dbResults = $.parseJSON($.getData(path + 'load_json.php'));
	console.log('dbResults', dbResults);
	dbKey = [];
	for (var key in dbResults){
		if (dbResults[key].seq !== ''){
			dbKey.push(dbResults[key]);
		}
	}
	dbSorted = dbKey.sort(function(a,b){
		return(a.seq - b.seq);
	});  // sort the array in numeric order by embedded seq
	console.log('dbSorted.seq', dbSorted);
	
	for (i = 0; i < dbSorted.length; i++) {
		console.log('dbSorted.nid', dbSorted[i].nid);
	}
		
	// set header
	var hb = '<!-- Button to trigger modal --><a class="btn btn-small" data-toggle="modal" href="#reportModal">Generate Report</a>'
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
	var ht = '<span class="lead"><strong>' + title + '</strong></span>';
	var h = '<div class=glheader>' + ht + '</div>' + hb + rModal + iModal;
	document.getElementById("header").innerHTML=h;
	
	$('li').css('cursor', 'pointer');
	//$('.accordion').tinyscrollbar();
	
	// clear info content on info button click
	$('#clear').live('click',function(){
		$(this).siblings('#info-content').text('');
	})
	
	// toggle node visibility
	$('.crumb').live('click',function(){
		var node = $(this).attr('id');
		$("#d" + node).toggle('slide', 'slow');
	})
	
	// activate tooltip
	$('.tooltipped').tooltip('left');
	
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
	
	$('#clear').live('click',function(){
		$(this).siblings('#info-content').text('');
	})
	
	// setup the intial node
	// if there is data in the database (i.e., project edit) then load it along with the target node of the last answered node
	// if thre is no data in the database (i.e., new project) load the first node only
	if (dbResults === null){
		count = 0; 
		sequence = 0;
		dbResults = {};
		startNode();
	} else {
		initialNode();
	}
	
	$('#wait').addClass('hidden');
	$('.return').removeClass('hidden');
	
	// do lots of stuff when a node answer is selected including: update the database via ajax call, drop ancestor nodes of a predocessor node answer changes,
	// update the database for same event (except comments which are always retained), evaluate the responses if the target node is a test node,
	// and generate the target node
	$('li').live('click',function(){
		
		// the node's id
		var nodeId = $(this).parent().attr('id');
		var nodeNum = parseInt(nodeId);
		console.log('this node id', nodeNum);
		
		// the target node id
		var target = parseInt($(this).attr('id'));
		console.log('target node id', target);
		
		// if user comment for this node have not been saved, then offer to save them
		if ($.trim($("#ta" + nodeNum).val()) !== '') { 
			var conf = window.confirm("Do you want to save your comments?");
			if (conf == true){
				saveComment(count, nodeNum);
			}
		}
        
		// show the selected answer as selected
		$(this).addClass('selected').addClass("btn-inverse").siblings().removeClass('selected').removeClass("btn-inverse"); 
		
		// hide all previous nodes
		$('.accordion-body').removeClass('in').height(0);
		$('div[id^="d"]').hide();
				
		// update dbSorted with the selected answer and its target
		var qaTar = $(this).attr('id');
		var qaAns = $(this).text(); 
		if ( $("#pc" + nodeNum).text() !== ''){
			var qaCom = $("#pc" + nodeNum).text(); 
		} else {
			var qaCom = '';
		}
		var parid = $(this).parent().parent().parent().parent().parent().attr('id');
		var parnum = parseInt(parid.slice(1,3)); 
		var lastid = $('#shownode').children('div:last').attr('id');
		var lastnum = parseInt(lastid.slice(1,3)); 
		if (parnum < lastnum){ // no backstep so far
			sequence = parnum; // reset sequence on parent reset
		}
		dbResults[nodeNum] = {
				seq: sequence,
				nid: nodeNum,
				ans: qaAns,
				tar: qaTar,
				com: qaCom
		};
		console.log('dbResults element updated', dbResults[nodeNum]);
		
		// delete child nodes after parent question change and vacate dbResults values (answer and target only...not comments) affected
		var parid = $(this).parent().parent().parent().parent().parent().attr('id');
		var parnum = parseInt(parid.slice(1,3)); 
		$('#shownode > div').each(function() { 
			var divid = $(this).attr('id'); 
			var divnum = parseInt(divid.slice(1,3));
			var thisnodeNum = $(this).find('span').attr('id');
			if (divnum > parnum){
				$(this).remove();
				if (dbResults[thisnodeNum] === undefined ){
					// do nothing
				} else {
					dbResults[thisnodeNum].seq = '';
					dbResults[thisnodeNum].ans = '';
					dbResults[thisnodeNum].tar = '';
				}
			}
		})
		sequence = sequence + 1; // continue on reset sequence
		console.log('parent node', parnum);
		console.log('next node sequence', sequence);
		
		// increment the node counter for next node
		count = count + 1;
		console.log('count for next node', count);
		
		// send updated dbResults to the database
		if (user != 0){
			jsonData = JSON.stringify(dbResults);
			$.ajax({
				type : "POST",
				url : path + "json_update.php",
				data : { 'json' : jsonData, 'project_id' : id }, 
				datatype : 'json',
				success: function(json){
				}
			});
		}
		
		// generate the target node
		evaluateNode(target, nodeNum);
		console.log('<------------------------->')
    })
})
	
function startNode(){ // build first node of a new decision tree
	for (i = 0; i < nodeResults.length; i++){
		if (nodeResults[i].node_id == cat){
			console.log('start node id', nodeResults[i].node_id);
			var q0 = parseInt(nodeResults[i].node_id);
			var q1 = nodeResults[i].node_question;
			var q3 = '<div class="summary">' + nodeResults[i].node_summary + '</div>';
			if (nodeResults[i].node_c1 !== ''){
				var q2 = '<div id="d' + count + '" class="node-container"><div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q0 + '"><span id=' + q0 + '><p id=p' + count + '>' + q0 + ': ' + q1 + '</p></span></a></div><div id="collapse' + q0 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q3 + '<div class="question-container">'; 
			} else {
				var q2 = '<div id="d' + count + '" class="node-container"><div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q0 + '"><span id=' + q0 + '><p id=p' + count + '>' + q0 + ': ' + q1 + '</p></span></a></div><div id="collapse' + q0 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q3 + '<div class="question-container">'; 
			}
			if (nodeResults[i].node_r1 !== ''){
				var a1 = nodeResults[i].node_r1;
				var t1 = nodeResults[i].node_t1;
				var resp1 = '<ul id="' + q0 + '" style="margin-left: 0px"><li class="btn btn-small" id="' + t1 + '">' + a1 + '</li>';
			} else {
				var resp1 = '';
			}
			if (nodeResults[i].node_r2 !== ''){
				var a2 = nodeResults[i].node_r2;
				var t2 = nodeResults[i].node_t2;
				var resp2 = '<li class="btn btn-small" id="' + t2 + '">' + a2 + '</li>';
			} else {
				var resp2 = '';
			}
			if (nodeResults[i].node_r3 !== ''){
				var a3 = nodeResults[i].node_r3;
				var t3 = nodeResults[i].node_t3;
				var resp3 = '<li class="btn btn-small" id="' + t3 + '">' + a3 + '</li></ul>';
			} else {
				var resp3 = '</ul>';
			}
			var ta1 = '<br /><span id="s' + q0 + '"><textarea id="ta' + q0 + '" rows="6" class="input-xlarge" placeholder="Comments"></textarea>'; // ml add to capture textarea
			var b1 =  '<button id="sB' + q0 + '" onclick="saveComment(' + sequence +', ' + q0 + ')" class="button-comment btn btn-small">Save Comment</button></span>';
			var c1 = '<div id="cc' + q0 + '" class="conclusion-container alert alert-success hidden"><h4>Intermediate Conclusion</h4>'; 
			var c2 = '<p class="hidden" id="yes-' + q0 + '">' + nodeResults[i].node_c1 + '</p>'; // load c1 as hidden
			var c3 = '<p class="hidden" id="no-' + q0 + '">' + nodeResults[i].node_c2 + '</p>'; // load c2 as hidden
			var c4 = c1 + c2 + c3 + '</div>'; // build decision container
			if (nodeResults[i].node_help !== ''){
				var i1 = '<a id="' + nodeResults[i].node_help + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Help</a>';
			} else { 
				var i1 = '';
			}
			if (nodeResults[i].node_faq !== ''){
				var i2 = '<a id="' + nodeResults[i].node_faq + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">FAQ</a>';
			} else { 
				var i2 = '';
			}
			if (nodeResults[i].node_asc !== ''){
				var i3 = '<a id="' + nodeResults[i].node_asc + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">ASC</a>';
			} else { 
				var i3 = '';
			}
			if (nodeResults[i].node_examples !== ''){
				var i4 = '<a id="' + nodeResults[i].node_examples + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Examples</a>';
			} else { 
				var i4 = '';
			}
			var r1 = q2 + resp1 + resp2 + resp3 + '</div>' + 
				'<div class="info-container">' +
				'<div>' + i1 + i2 + i3 + i4 +
				ta1 + b1 + c4 + 
				'</div></div></div></div></div>';
			$('#shownode').html(r1); // load the revised decision tree
			n = q0; // need?
			dbResults[q0] = {
				seq: sequence,
				nid: q0,
				ans: '',
				tar: '',
				com: ''
			};
			break;
		}
	}
}

function initialNode(){ //generates initial nodes from saved data
	// if <td> node number matches i, build div node
	// check li's for match with data.ans make that li class selected
	// add to var rSaved then
	rSaved = '';
	count = 0;
	console.log('dbSorted.length', dbSorted.length)
	for (var i = 0; i < dbSorted.length; i++){
		sequence = dbSorted[i].seq;
		console.log('i : sequence:', i, sequence);
		if (dbSorted[i].nid !== ''){
			for (var j = 0; j < nodeResults.length; j++){
				if (nodeResults[j].node_id == dbSorted[i].nid){
					if (dbSorted[i].ans !== ''){
						console.log('parse nodeId', parseInt(nodeResults[j].node_id))
						var q0 = parseInt(nodeResults[j].node_id);
						var n = q0;
						var q1 = nodeResults[j].node_question;
						var q3 = '<div class="summary">' + nodeResults[j].node_summary + '</div>';
						if (nodeResults[j].node_type == 'r'){
							var q2 = '<div id="d' + count + '" class="node-container"><div id="ah' + q0 + '" class="accordion-heading alert-info"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q0 + '"><span id=' + q0 + '><p id=p' + count + '>' + q0 + ': ' + q1 + '</p></span></a></div><div id="collapse' + q0 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q3 + '<div class="question-container">';
						} else if (nodeResults[j].node_c1 !== ''){
							var q2 = '<div id="d' + count + '" class="node-container"><div id="ah' + q0 + '" class="accordion-heading alert-success"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q0 + '"><span id=' + q0 + '><p id=p' + count + '>' + q0 + ': ' + q1 + '</p></span></a></div><div id="collapse' + q0 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q3 + '<div class="question-container">'; 
						} else {
							var q2 = '<div id="d' + count + '" class="node-container"><div id="ah' + q0 + '" class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q0 + '"><span id=' + q0 + '><p id=p' + count + '>' + q0 + ': ' + q1 + '</p></span></a></div><div id="collapse' + q0 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q3 + '<div class="question-container">'; 
						}
						if (nodeResults[j].node_r1 !== ''){
							var a1 = nodeResults[j].node_r1;
							var t1 = nodeResults[j].node_t1;
							var resp1 = '<ul id="' + q0 + '" style="margin-left: 0px"><li class="btn btn-small" id="' + t1 + '">' + a1 + '</li>';
						} else {
							var resp1 = '';
						}
						if (nodeResults[j].node_r2 !== ''){
							var a2 = nodeResults[j].node_r2;
							var t2 = nodeResults[j].node_t2;
							var resp2 = '<li class="btn btn-small" id="' + t2 + '">' + a2 + '</li>';
						} else {
							var resp2 = '';
						}
						if (nodeResults[j].node_r3 !== ''){
							var a3 = nodeResults[j].node_r3;
							var t3 = nodeResults[j].node_t3;
							var resp3 = '<li class="btn btn-small" id="' + t3 + '">' + a3 + '</li></ul>';
						} else {
							var resp3 = '</ul>';
						}
						if (dbSorted[i].com !== '') { // insert comment and make this a <p>
							var ta1 =  '<br /><span id="s' + q0 + '"><p class="comment" id="pc' + q0 + '">' + dbSorted[i].com + '</p>'; 
							var b1 =  '<button id="eB' + q0 + '" onclick="editComment(' + sequence +', ' + q0 + ')" class="button-comment btn btn-small">Edit Comment</button></span>';
						} else { // else provide textarea
							var ta1 = '<br /><span id="s' + q0 + '"><textarea id="ta' + q0 + '" rows="6" class="input-xlarge" placeholder="Comments"></textarea>'; // ml add to capture textarea
							var b1 =  '<button id="sB' + q0 + '" onclick="saveComment(' + sequence +', ' + q0 + ')" class="button-comment btn btn-small">Save Comment</button></span>';
						}
						if (nodeResults[j].node_help !== ''){
							var i1 = '<a id="' + nodeResults[j].node_help + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Help</a>';
						} else { 
							var i1 = '';
						}
						if (nodeResults[j].node_faq !== ''){
							var i2 = '<a id="' + nodeResults[j].node_faq + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">FAQ</a>';
						} else { 
							var i2 = '';
						}
						if (nodeResults[j].node_asc !== ''){
							var i3 = '<a id="' + nodeResults[j].node_asc + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">ASC</a>';
						} else { 
							var i3 = '';
						}
						if (nodeResults[j].node_examples !== ''){
							var i4 = '<a id="' + nodeResults[j].node_examples + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Examples</a>';
						} else { 
							var i4 = '';
						}
						var r1 = q2 + resp1 + resp2 + resp3 + '</div>' + 
							'<div class="info-container">' +
							'<div>' + i1 + i2 + i3 + i4 +
							ta1 + b1;
						console.log('conclusion node c1', nodeResults[j].node_c1);
						if (nodeResults[j].node_c1 !== ''){ // if there's a conclusion in this node, show it
							c1 = '<div id="cc' + q0 + '" class="conclusion-container alert alert-success"><h4>Intermediate Conclusion</h4>';
							if ( dbSorted[i].ans == nodeResults[j].node_r1 ){ // answer is r1, show conclusion1
								c2 = '<p id="c' + q0 + '">' + nodeResults[j].node_c1 + '</p>';
							} else {
								c2 = '<p id="c' + q0 + '">' + nodeResults[j].node_c2 + '</p>';
							}
							var c3 = c1 + c2 + '</div>';
							rSaved = rSaved + r1 + c3 + '</div></div></div></div></div>';
						} else {
							rSaved = rSaved + r1 + '</div></div></div></div></div>';
						}
						count = count + 1;
					}
					break;
				}
			}
		}
	}
	$('#shownode').html(rSaved);
	$('.accordion-body').removeClass('in').height(0);
	$('div[id^="d"]').hide();
	
	// make selected <li>'s class 'selected'
	for (var key in dbSorted){
		if (dbSorted.hasOwnProperty(key)){
			$('#shownode li').each(function(){
				var qnum = $(this).attr('id');
				if (qnum == dbSorted[key].tar){
					$(this).addClass("selected").addClass("btn-inverse");
				}
			})
		}
	}
	
	// show target node of last selection  
	// show node of last <li> with class 'selected' // unless it's a test node, so show evaluation of last node
	for (var k = 0; k < nodeResults.length; k++){
		var target = parseInt($('#shownode').children('div:last').find('li.selected').attr('id'));
		console.log('iNode target', parseInt($('#shownode').children('div:last').find('li.selected').attr('id')));
		var nodeNum = parseInt($('#shownode').children('div:last').find('ul').attr('id'));
		console.log('iNode last node', parseInt($('#shownode').children('div:last').find('ul').attr('id')));
		if (nodeResults[k] !== undefined && nodeResults[k].node_id == target){
			sequence = sequence + 1;
			if (nodeResults[k].node_question == ''){ // test for test node
				console.log('test node nodeNum', nodeNum);
				testNode(target, nodeNum);
			} else if (nodeResults[k].node_id !== undefined){
				var parAns = $('#collapse' + nodeNum).find('.selected').text();
			
				// Unhide conclusion container if conclusion is not empty
				
				if ($('#yes-' + nodeNum).text() !== ''){
					$('#ah' + nodeNum).addClass('alert-success');
					$('#cc' + nodeNum).removeClass('hidden');
				}
				if ($('#no-' + nodeNum).text() !== ''){
					$('#ah' + nodeNum).addClass('alert-success');
					$('#cc' + nodeNum).removeClass('hidden');
				}
				
				// Unhide conclusion
				if ($('#yes-' + nodeNum).hasClass() == 'hidden' && $('#no-' + nodeNum).hasClass() == 'hidden'){
					if (parAns == 'Yes'){
						$('#yes-' + nodeNum).removeClass('hidden');
						$('#no-' + nodeNum).addClass('hidden');
					} else if (parAns == 'No'){
						$('#no-' + nodeNum).removeClass('hidden');
						$('#yes-' + nodeNum).addClass('hidden');
					}
				}
				
				// generate target node
				var q4 = nodeResults[k].node_id;
				var q5 = nodeResults[k].node_question;
				var q7 = '<div class="summary">' + nodeResults[k].node_summary + '</div>';
				if (nodeResults[k].node_type !== 'r'){
					var q6 = '<div id="d' + count + '" class="node-container"><div id="ah' + q4 + '" class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q4 + '"><span id=' + q4 + '><p>' + q4 + ': ' + q5 + '</p></span></a></div><div id="collapse' + q4 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q7 + '<div class="question-container">';
					if (nodeResults[k].node_r1 !== ''){
						var a4 = nodeResults[k].node_r1;
						var t4 = nodeResults[k].node_t1;
						var resp4 = '<ul id="' + q4 + '" style="margin-left: 0px"><li class="btn btn-small" id="' + t4 + '">' + a4 + '</li>';
					} else {
						var resp4 = '';
					}
					if (nodeResults[k].node_r2 !== ''){
						var a5 = nodeResults[k].node_r2;
						var t5 = nodeResults[k].node_t2;
						var resp5 = '<li class="btn btn-small" id="' + t5 + '">' + a5 + '</li>';
					} else {
						var resp5 = '';
					}
					if (nodeResults[k].node_r3 !== ''){
						var a6 = nodeResults[k].node_r3;
						var t6 = nodeResults[k].node_t3;
						var resp6 = '<li class="btn btn-small" id="' + t6 + '">' + a6 + '</li></ul>';
					} else {
						var resp6 = '</ul>';
					}
				} else {
					var q6 = '<div id="d' + count + '" class="node-container"><div id="ah' + q4 + '" class="accordion-heading alert-info"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q4 + '"><span id=' + q4 + '><p>' + q4 + ': ' + q5 + '</p></span></a></div><div id="collapse' + q4 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q7 + '<div class="question-container">';
					if (nodeResults[k].node_next !== ''){
						var next1 = nodeResults[k].node_next;
						var href1 = nodeResults[k].node_href;
						var resp4 = '<button id="next' + q4 + '"class="btn btn-small" href="' + href1 + '">' + next1 + '</button>';
					} else {
						var resp4 = '';
					}
					var resp5 = '';
					var resp6 = '';
				}
				var q8 = $('#shownode').html();
				if (nodeResults[k].node_type !== 'r'){
					if (dbResults[q4] === undefined || dbResults[q4].com == ''){
						var ta2 =  '<br /><span id="s' + q4 + '"><textarea id="ta' + q4 + '" rows="6" class="input-xlarge" placeholder="Comments"></textarea>'; // ml add to capture textarea
						var b2 =  '<button id="sB' + q4 + '" onclick="saveComment(' + sequence +', ' + q4 + ')" class="button-comment  btn btn-small">Save Comment</button></span>';
					} else { // insert comment and make this a <p>
						var ta2 =  '<br /><span id="s' + q4 + '"><p class="comment" id="pc' + q4 + '">' + dbResults[q4].com + '</p>'; 
						var b2 =  '<button id="eB' + q4 + '" onclick="editComment(' + sequence +', ' + q4 + ')" class="button-comment  btn btn-small">Edit Comment</button></span>';
					}
				} else {
					var ta2 = '';
					var b2 = '';
				}
				var c1 = '<div id="cc' + q4 + '" class="conclusion-container alert alert-success hidden"><h4>Intermediate Conclusion</h4>';
				var c2 = '<p class="hidden" id="yes-' + q4 + '">' + nodeResults[k].node_c1 + '</p>';
				var c3 = '<p class="hidden" id="no-' + q4 + '">' + nodeResults[k].node_c2 + '</p>';
				var c4 = c1 + c2 + c3 + '</div>';
				if (nodeResults[k].node_type !== 'r'){
					if (nodeResults[k].node_help !== ''){
						var i5 = '<a id="' + nodeResults[k].node_help + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Help</a>';
					} else { 
						var i5 = '';
					}
					if (nodeResults[k].node_faq !== ''){
						var i6 = '<a id="' + nodeResults[k].node_faq + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">FAQ</a>';
					} else { 
						var i6 = '';
					}
					if (nodeResults[k].node_asc !== ''){
						var i7 = '<a id="' + nodeResults[k].node_asc + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">ASC</a>';
					} else { 
						var i7 = '';
					}
					if (nodeResults[k].node_examples !== ''){
						var i8 = '<a id="' + nodeResults[k].node_examples + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Examples</a>';
					} else { 
						var i8 = '';
					}
					var r = q8 + q6 + resp4 + resp5 + resp6 + '</div>' + 
						'<div class="info-container">' +
						'<div>' + i5 + i6 + i7 + i8 +
						ta2 + b2 + c4 + '</div></div></div></div></div>';
				} else {
					var r = q8 + q6 + '</div></div></div></div>';
				}
				$('#shownode').html(r);
				window.scrollBy(0,000); ;
				console.log('iNode q4:', q4);
				dbResults[q4] = {
					seq: sequence,
					nid: q4,
					ans: '',
					tar: '',
					com: ''
				};
				console.log('iNode dbResults: ', dbResults);
			}
			break;
		}
	}
	bc = '<span style="color:#0088cc;"><a style="text-decoration:none" class="tooltipped" href="#" data-toggle="tooltip" data-placement="left" title="Click buttons to hide or show nodes. Green indicates intermediate conclusion node. Blue indicates a final accounting recommendation node.">Toggle node visibility >></a></span><span id="node-vis"></span>';
	$('#shownode').children().each(function(){
		var nid = $(this).children('.accordion-heading').children('.accordion-toggle').children('span').attr('id');
		var nnum = parseInt(nid);
		var ncountid = $(this).attr('id');
		var ncnum = parseInt(ncountid.slice(1,3));
		if ($(this).children('.accordion-heading').hasClass('alert-success').toString() == 'true'){
			crumbClass = 'btn-success';
		} else if ($(this).children('.accordion-heading').hasClass('alert-info').toString() == 'true'){
			crumbClass = 'btn-info';
		} else {
			crumbClass = '';
		}
		if ($(this).css('display') == 'none'){
			bc = bc + '<button id="' + ncnum + '" class="btn btn-mini crumb active ' + crumbClass + '" data-toggle="button">'+ nnum + '</button>';	
		} else {
			bc = bc + '<button id="' + ncnum + '" class="btn btn-mini crumb '  + crumbClass + '" data-toggle="button">'+ nnum + '</button>';
		}
	})
	$('#showbreadcrumbs').html(bc);
	console.log('iNode dbResults to report(): ', dbResults);
	genReport(dbResults);
}
	
function evaluateNode(target, nodeNum){ // evaluate the user response then build the target node
	console.log('dbResults before evaluateNode', dbResults);
	for (var i = 0; i < nodeResults.length; i++){
		if (nodeResults[i] !== undefined && nodeResults[i].node_id == target){
			if (nodeResults[i].node_question == ''){ // if the last selected target is a test node, then test it
				testNode(target, nodeNum);
			} else if (nodeResults[i].node_id !== undefined){
				var parAns = $('#collapse' + nodeNum).find('.selected').text();
				console.log('nodeNum for conclusion test', nodeNum);
				console.log('parAns for conclusion test', parAns);
				// Unhide conclusion container if conclusion is not empty
				if ($('#yes-' + nodeNum).text() !== ''){
					$('#ah' + nodeNum).addClass('alert-success');
					$('#cc' + nodeNum).removeClass('hidden');
				}
				if ($('#no-' + nodeNum).text() !== ''){
					$('#ah' + nodeNum).addClass('alert-success');
					$('#cc' + nodeNum).removeClass('hidden');
				}
				
				console.log('yes class', $('#yes-' + nodeNum).attr('class'));
				console.log('no class', $('#no-' + nodeNum).attr('class'));
				// Unhide conclusion // overrides testNode setting!
				if ($('#no-' + nodeNum).attr('class') == 'hidden') {
					document.getElementById("debug0").innerHTML='yes';
				}
				if ($('#no-' + nodeNum).attr('class') == 'hidden') {
					document.getElementById("debug1").innerHTML='no';
				}
				if ($('#yes-' + nodeNum).attr('class') == 'hidden' && $('#no-' + nodeNum).attr('class') == 'hidden'){
					document.getElementById("debug2").innerHTML='pass';
					if (parAns == 'Yes'){
						$('#yes-' + nodeNum).removeClass('hidden');
						$('#no-' + nodeNum).addClass('hidden');
						document.getElementById("debug3").innerHTML='yes';
						console.log('yes class after yes', $('#yes-' + nodeNum).attr('class'));
						console.log('no class after yes', $('#no-' + nodeNum).attr('class'));
					} else if (parAns == 'No'){
						$('#no-' + nodeNum).removeClass('hidden');
						$('#yes-' + nodeNum).addClass('hidden');
						document.getElementById("debug3").innerHTML='no';
						console.log('yes class after no', $('#yes-' + nodeNum).attr('class'));
						console.log('no class after no', $('#no-' + nodeNum).attr('class'));
						
					}
				}
				
				// generate target node
				var q4 = nodeResults[i].node_id;
				var q5 = nodeResults[i].node_question;
				switch (target){
					case 514:
						softwarerevrec();
						var q7 = '<span id="swrr"></span>';
					default:
						var q7 = '<div class="summary">' + nodeResults[i].node_summary + '</div>';
				}
				if (nodeResults[i].node_type !== 'r'){
					var q6 = '<div id="d' + count + '" class="node-container"><div id="ah' + q4 + '" class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q4 + '"><span id=' + q4 + '><p>' + q4 + ': ' + q5 + '</p></span></a></div><div id="collapse' + q4 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q7 + '<div class="question-container">';
					if (nodeResults[i].node_r1 !== ''){
						var a4 = nodeResults[i].node_r1;
						var t4 = nodeResults[i].node_t1;
						var resp4 = '<ul id="' + q4 + '" style="margin-left: 0px"><li class="btn btn-small" id="' + t4 + '">' + a4 + '</li>';
					} else {
						var resp4 = '';
					}
					if (nodeResults[i].node_r2 !== ''){
						var a5 = nodeResults[i].node_r2;
						var t5 = nodeResults[i].node_t2;
						var resp5 = '<li class="btn btn-small" id="' + t5 + '">' + a5 + '</li>';
					} else {
						var resp5 = '';
					}
					if (nodeResults[i].node_r3 !== ''){
						var a6 = nodeResults[i].node_r3;
						var t6 = nodeResults[i].node_t3;
						var resp6 = '<li class="btn btn-small" id="' + t6 + '">' + a6 + '</li></ul>';
					} else {
						var resp6 = '</ul>';
					}
				} else {
					var q6 = '<div id="d' + count + '" class="node-container"><div id="ah' + q4 + '" class="accordion-heading alert-info"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse' + q4 + '"><span id=' + q4 + '><p>' + q4 + ': ' + q5 + '</p></span></a></div><div id="collapse' + q4 + '" class="accordion-body collapse in"><div class="accordion-inner" style="height:395px">' + q7 + '<div class="question-container">';
					if (nodeResults[i].node_next !== ''){
						var next1 = nodeResults[i].node_next;
						var href1 = nodeResults[i].node_href;
						var resp4 = '<button id="next' + q4 + '"class="btn btn-small" href="' + href1 + '">' + next1 + '</button>';
					} else {
						var resp4 = '';
					}
					var resp5 = '';
					var resp6 = '';
				}
				var q8 = $('#shownode').html();
				if (nodeResults[i].node_type !== 'r'){
					if (dbResults[q4] === undefined || dbResults[q4].com == ''){
						var ta2 =  '<br /><span id="s' + q4 + '"><textarea id="ta' + q4 + '" rows="6" class="input-xlarge" placeholder="Comments"></textarea>'; // ml add to capture textarea
						var b2 =  '<button id="sB' + q4 + '" onclick="saveComment(' + sequence +', ' + q4 + ')" class="button-comment  btn btn-small">Save Comment</button></span>';
					} else { // insert comment and make this a <p>
						var ta2 =  '<br /><span id="s' + q4 + '"><p class="comment" id="pc' + q4 + '">' + dbResults[q4].com + '</p><br />'; 
						var b2 =  '<button id="eB' + q4 + '" onclick="editComment(' + sequence +', ' + q4 + ')" class="button-comment  btn btn-small">Edit Comment</button></span>';
					}
				} else {
					var ta2 = '';
					var b2 = '';
				}
				var c1 = '<div id="cc' + q4 + '" class="conclusion-container alert alert-success hidden"><h4>Intermediate Conclusion</h4>'; 
				var c2 = '<p class="hidden" id="yes-' + q4 + '">' + nodeResults[i].node_c1 + '</p>'; // load c1 as hidden
				var c3 = '<p class="hidden" id="no-' + q4 + '">' + nodeResults[i].node_c2 + '</p>'; // load c2 as hidden
				var c4 = c1 + c2 + c3 + '</div>'; // build decision container
				console.log(c4);
				if (nodeResults[i].node_type !== 'r'){
					if (nodeResults[i].node_help !== ''){
						var i5 = '<a id="' + nodeResults[i].node_help + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Help</a>';
					} else { 
						var i5 = '';
					}
					if (nodeResults[i].node_faq !== ''){
						var i6 = '<a id="' + nodeResults[i].node_faq + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">FAQ</a>';
					} else { 
						var i6 = '';
					}
					if (nodeResults[i].node_asc !== ''){
						var i7 = '<a id="' + nodeResults[i].node_asc + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">ASC</a>';
					} else { 
						var i7 = '';
					}
					if (nodeResults[i].node_examples !== ''){
						var i8 = '<a id="' + nodeResults[i].node_examples + '" class="btn btn-small btn-info info" data-toggle="modal" href="#infoModal">Examples</a>';
					} else { 
						var i8 = '';
					}
					var r = q8 + q6 + resp4 + resp5 + resp6 + '</div>' + 
						'<div class="info-container">' +
						'<div>' + i5 + i6 + i7 + i8 +
						ta2 + b2 + c4 + '</div></div></div></div></div>';
				} else {
					var r = q8 + q6 + '</div></div></div></div>';
				}
				$('#shownode').html(r);
				window.scrollBy(0,000); ;
				console.log('eNode q4:', q4);
				dbResults[q4] = {
					seq: sequence,
					nid: q4,
					ans: '',
					tar: '',
					com: ''
				};
				console.log('eNode dbResults: ', dbResults);
			}
			break;
		}		
	}
	// popup
	bc = '<span style="color:#0088cc;"><a style="text-decoration:none" class="tooltipped" href="#" data-toggle="tooltip" data-placement="left" title="Click buttons to hide or show nodes. Green indicates intermediate conclusion node. Blue indicates a final accounting recommendation node.">Toggle node visibility >></a></span><span id="node-vis"></span>';
	
	// loop over all nodes and generate visibility toggle buttons
	$('#shownode').children().each(function(){
		var nid = $(this).children('.accordion-heading').children('.accordion-toggle').children('span').attr('id');
		var nnum = parseInt(nid);
		var ncountid = $(this).attr('id');
		var ncnum = parseInt(ncountid.slice(1,3));
		if ($(this).children('.accordion-heading').hasClass('alert-success').toString() == 'true'){
			crumbClass = 'btn-success';
		} else if ($(this).children('.accordion-heading').hasClass('alert-info').toString() == 'true'){
			crumbClass = 'btn-info';
		} else {
			crumbClass = '';
		}
		if ($(this).css('display') == 'none'){
			bc = bc + '<button id="' + ncnum + '" class="btn btn-mini crumb active ' + crumbClass + '" data-toggle="button">'+ nnum + '</button>';	
		} else {
			bc = bc + '<button id="' + ncnum + '" class="btn btn-mini crumb '  + crumbClass + '" data-toggle="button">'+ nnum + '</button>';
		}
	})
	$('#showbreadcrumbs').html(bc);
	console.log('eNode dbResults to report(): ', dbResults);
	genReport(dbResults);
}
	
function saveComment( sequence, z ){ 
	console.log(z);
	var selectedTA = $("#ta" + z);
	if ( selectedTA.length > 0 ) {
		selectedTAValue = selectedTA.val();
	}
	dbResults[z].com = selectedTAValue;
	console.log(dbResults[z].com);
	jsonData = JSON.stringify(dbResults);
	// send updated dbResults to the database
	if (user != 0){
		jsonData = JSON.stringify(dbResults);
		$.ajax({
			type : "POST",
			url : path + "json_update.php",
			data : { 'json' : jsonData, 'project_id' : id }, 	
			datatype : 'json',
			success: function(json){
			}
		});
	}
	var t3 =  '<span id="s' + z + '"><p class="comment" id="pc' + z + '">' + selectedTAValue + '</p>'; 
	var b3 =  '<button id="eB' + z + '" onclick="editComment(' + sequence +', ' + z + ')" class="button-comment  btn btn-small">Edit Comment</button></span>';
	var r4 = t3 + b3;
	$("#s" + z).replaceWith(r4); 
	genReport(dbResults);
}

function editComment( sequence, z ){
	var selectedP = $("#pc" + z).text(); 
	if ( selectedP.length >= 0 ) {
		selectedPValue = selectedP;
	}
	var t4 =  '<span id="s' + z + '"><textarea id="ta' + z + '" rows="6" class="input-xlarge">' + selectedPValue + '</textarea>'; 
	var b4 =  '<button id="uB' + z + '" onclick="updateComment(' + sequence + ', ' + z + ')" class="button-comment btn btn-small">Save Comment</button><span>';
	var r5 = t4 + b4;
	$("#s" + z).replaceWith(r5);
}

function updateComment( sequence, z ){ 
	var selectedTA = $("#ta" + z);
	if ( selectedTA.length > 0 ) {
		selectedTAValue = selectedTA.val();
	}
	dbResults[z].com = selectedTAValue;
	jsonData = JSON.stringify(dbResults);
	// send updated dbResults to the database
	if (user != 0){
		jsonData = JSON.stringify(dbResults);
		$.ajax({
			type : "POST",
			url : path + "json_update.php",
			data : { 'json' : jsonData, 'project_id' : id }, 
			datatype : 'json',
			success: function(json){
			}
		});
	}
	var t3 =  '<span id="s' + z + '"><p class="comment" id="pc' + z + '">' + selectedTAValue + '</p>'; 
	var b3 =  '<button id="eB' + z + '" onclick="editComment(' + sequence +', ' + z + ')" class="button-comment  btn btn-small">Edit Comment</button></span>';
	var r4 = t3 + b3;
	$("#s" + z).replaceWith(r4);
	genReport(dbResults);
}

jQuery.extend({
	getValues: function(url, dataParams) {
		var result = null;
		$.ajax({
			url: url,
			type: 'get',
			dataType: 'json',
			data: dataParams,
			async: false,
			success: function(data) {
				result = data;
			}
		});
	   return result;
	}
});

jQuery.extend({
	getData: function(url) {
		var result = null;
		$.ajax({
			url: url,
			type: 'get',
			data: {
				'project_id': id,
				'user_id': user
			},
			async: false,
			success: function(data) {
				result = data;
			}
		});
	   return result;
	}
});

function genReport(db){
	var report = '';
	var dbReportKey = [];
	console.log('report db', db);
	for (var key in db){
		if (db[key].seq !== ''){
			dbReportKey.push(db[key]);
		}
	}
	var dbReport = dbReportKey.sort(function(a,b){
		return(a.seq - b.seq);
	});  // sort the array in numeric order by embedded seq
	for (var i in dbReport){
		for (var j = 0; j < nodeResults.length; j++){
			if (dbReport[i].nid == nodeResults[j].node_id){
				console.log('dbReport[i].nid', dbReport[i].nid);
				console.log('nodeResults[j].node_id', nodeResults[j].node_id);
				if (nodeResults[j].node_type !== 'r'){
					if (dbReport[i].com == ''){
						var comment = 'none';
					} else {
						var comment = dbReport[i].com;
					}
					report = report + '<div>' +
						'<h5><strong>Question (node id#' + nodeResults[j].node_id + '): </strong>' + nodeResults[j].node_question + '</h5>' + 
						'<ul><li><strong>Question summary: </strong>' + nodeResults[j].node_summary + '</li>' + 
						'<li><strong>Response: </strong>' + dbReport[i].ans + '</li>' + 
						'<li><strong>Comments: </strong>' + comment + '</li></ul></div>';
				} else {
						report = report + '<div>' +
							'<div style="border: solid lightblue 1px; padding: 5px;"><h4><strong>Accounting recommendation (' + nodeResults[j].node_id + '): </strong>' + nodeResults[j].node_question + '</h4>' + 
							'<h5><strong>Recommendation summary: </strong>' + nodeResults[j].node_summary + '</h5></div>' + 
							'<br /></div>';
				}
			}
		}
	}
	
	report = report + '<div><strong>gaaplogic.com</strong></div><div>&#169; GAAP Logic</div></div>';
	$("#rep").html(report);
}

function printModal(){
	if (user !== '0'){
		var DocumentContainer = document.getElementById('modalContent');
		var WindowObject = window.open("", "PrintWindow",
		"width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
		WindowObject.document.writeln(DocumentContainer.innerHTML);
		WindowObject.document.close();
		WindowObject.focus();
		WindowObject.print();
		WindowObject.close();
	} else {
		alert('You must be logged in to print a report.');
	}
}

function softwareRevRec(){
	sw1 = '<div class="summary">This will be the software revenue recognition conclusion</div>';
	$("#swrr").replaceWith(sw1);
}