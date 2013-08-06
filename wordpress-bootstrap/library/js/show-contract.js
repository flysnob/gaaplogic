$('document').ready(function(){
	$('#analyze_1').live('click', function(){
		deliv_id_1 = $('#delId').text();
		$(this).siblings('#deliv_id_1').val(deliv_id_1);
	});

	$('#analyze_2').live('click', function(){
		deliv_id_2 = $('#delId').text();
		$(this).siblings('#deliv_id_2').val(deliv_id_2);
	});
	
	$('#analyze_3').live('click', function(){
		deliv_id_3 = $('#delId').text();
		$(this).siblings('#deliv_id_3').val(deliv_id_3);
	});

	$('#analyze_4').live('click', function(){
		deliv_id_4 = $('#delId').text();
		$(this).siblings('#deliv_id_4').val(deliv_id_4);
	});
	
	(function() {
		Date.prototype.toYMD = Date_toYMD;
		function Date_toYMD() {
			var year, month, day;
			year = String(this.getFullYear());
			month = String(this.getMonth() + 1);
			if (month.length == 1) {
				month = "0" + month;
			}
			day = String(this.getDate());
			if (day.length == 1) {
				day = "0" + day;
			}
			return year + "-" + month + "-" + day;
		}
	})();
	
	if ($('#return_button').attr('action') == '<?php echo $site_url; ?>/show-revrec-list/'){
		$('#element_sep').addClass('hidden');
		$('#element_sw_last').addClass('hidden');
	}
	
	if ($('#element_sw_flag_no')){
		$('#element_sw_last').addClass('hidden');
	}
	
	if ($('#contingent_amt').text() == 0){
		$('#element_cont_amt').addClass('hidden');
		$('#element_cont_type').addClass('hidden');
		$('#element_cont_desc').addClass('hidden');
		$('#element_cont_res').addClass('hidden');
		$('#element_cont_res_date').addClass('hidden');
	}

	$('#cancel_rr_meth').click(function(){
		$('#rrmeth_b').addClass('hidden');
		$('#rrmeth_a').removeClass('hidden');
	})
	
	$('#cancel_rr_deliv').click(function(){
		$('#rrdeliv_b').addClass('hidden');
		$('#rrdeliv_a').removeClass('hidden');
	})
	
	$('#override_1').click(function(){
		$('#rrtsat_a1').addClass('hidden');
		$('#rrtsat_b1').removeClass('hidden');
	})
	$('#cancel_save_1').click(function(){
		$('#rrtsat_b1').addClass('hidden');
		$('#rrtsat_a1').removeClass('hidden');
	})
	
	$('#cancel_override_1').click(function(){
		$('#rrtsat_c1').addClass('hidden');
		$('#rrtsat_a1').removeClass('hidden');
		statusId = $(this).siblings('#rr_status_id').val();
		elementId = $(this).siblings('#element_id').val();
		projectId = $('#project_id').val();
		var data = { 'status_odate' : '', 'status_id' : statusId, 'status_ovr' : '', 'element_id' : elementId, 'project_id' : projectId };
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		overall_status();
	})
	
	$('#override_2').click(function(){
		$('#rrtsat_a2').addClass('hidden');
		$('#rrtsat_b2').removeClass('hidden');
	})
	
	$('#cancel_save_2').click(function(){
		$('#rrtsat_b2').addClass('hidden');
		$('#rrtsat_a2').removeClass('hidden');
	})
	
	$('#cancel_override_2').click(function(){
		var url = path + 'json_rr_update.php';
		var resetData = { 'project_id' : projectId, 'meth_cat_id' : '2' }
		$.saveData(url, resetData);
		$('#rrtsat_c2').addClass('hidden');
		$('#rrtsat_a2').removeClass('hidden');
		statusId = $(this).siblings('#rr_status_id').val();
		elementId = $(this).siblings('#element_id').val();
		projectId = $('#project_id').val();
		if (statusId == '2'){
			var data = { 'status_odate' : '', 'status_id' : statusId, 'status_ovr' : '', 'element_id' : elementId, 'element_oaus' : '', 'project_id' : projectId };
		} else {
			var data = { 'status_odate' : '', 'status_id' : statusId, 'status_ovr' : '', 'element_id' : elementId, 'project_id' : projectId };
		}
		$.saveData(url, data);
		overall_status();
	})
	
	$('#override_3').click(function(){
		$('#rrtsat_a3').addClass('hidden');
		$('#rrtsat_b3').removeClass('hidden');
	})
	
	$('#cancel_save_3').click(function(){
		$('#rrtsat_b3').addClass('hidden');
		$('#rrtsat_a3').removeClass('hidden');
	})
	
	$('#cancel_override_3').click(function(){
		$('#rrtsat_c3').addClass('hidden');
		$('#rrtsat_a3').removeClass('hidden');
		statusId = $(this).siblings('#rr_status_id').val();
		elementId = $(this).siblings('#element_id').val();
		projectId = $('#project_id').val();
		var data = { 'status_odate' : '', 'status_id' : statusId, 'status_ovr' : '', 'element_id' : elementId, 'project_id' : projectId };
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		overall_status();
	})
	
	$('#override_4').click(function(){
		$('#rrtsat_a4').addClass('hidden');
		$('#rrtsat_b4').removeClass('hidden');
	})
	
	$('#cancel_save_4').click(function(){
		$('#rrtsat_b4').addClass('hidden');
		$('#rrtsat_a4').removeClass('hidden');
	})
	
	$('#cancel_override_4').click(function(){
		$('#rrtsat_c4').addClass('hidden');
		$('#rrtsat_a4').removeClass('hidden');
		statusId = $(this).siblings('#rr_status_id').val();
		elementId = $(this).siblings('#element_id').val();
		projectId = $('#project_id').val();
		var data = { 'status_odate' : '', 'status_id' : statusId, 'status_ovr' : '', 'element_id' : elementId, 'project_id' : projectId };
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		overall_status();
	})
	
	$('#save_meth_b').click(function(){
		rrMethId = $(this).siblings('select').val();
		rrMethName = $("#rr_el_meth option:selected").text();  
		elementId = $('#element_id').val();
		projectId = $('#project_id').val();
		var data = { 'method_id' : rrMethId, 'element_id' : elementId, 'project_id' : projectId };
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		rrMethHtml = '<strong>' + rrMethName + '</strong>'
		$('#element_rr_meth_name').html(rrMethHtml);
		var url = path + 'json_rr_upload.php';
		var data = { 'meth_id' : rrMethId };
		methResults = $.parseJSON($.getData(url, data));
		methDesc = '';
		for (var i = 0; i < methResults.length; i++){
			if (methResults[i].rr_meth_id == rrMethId){
				methDesc = methDesc + methResults[i].rr_meth_desc;
			}
		}
		
		$('#element_rr_meth_desc').html(methDesc);
		$('#rrmeth_b').addClass('hidden');
		$('#rrmeth_a').removeClass('hidden');
		overall_status();
	})
	
	$('.save-a').click(function(){
		rrStDate = $(this).siblings('input[type="date"]').val();
		statusId = $(this).siblings('#rr_status_id').val();
		elementId = $(this).siblings('#element_id').val();
		projectId = $('#project_id').val();
		if (statusId == '2'){ 													// if this is the delivery condition	
			var url = path + 'json_rr_update.php';
			var resetData = { 'project_id' : projectId, 'meth_cat_id' : '2' }
			$.saveData(url, resetData);
			sep_flag = $('#sep_flag').text();
			dep_flag = $('#dep_flag').text();
			var today = new Date();
			if (new Date(rrStDate) <= today && rrStDate !== ''){				// if delivery has occurred
				if (sep_flag == 'Yes'){											// if the element is separable
					if (dep_flag == 'None' || dep_flag == '' || dep_flag == null){									// if there is no dependency
						aus = 1;
					} else {
						aus = 2;
					}
				} else {
					if (dep_flag == 'None'){
						aus = 3;
					} else {
						aus = 4;
					}
				}
			} else {
				if (sep_flag == 'Yes'){
					if (dep_flag == 'None'){
						aus = 5;
					} else {
						aus = 6;
					}
				} else {
					if (dep_flag == 'None'){
						aus = 7;
					} else {
						aus = 8;
					}
				}
			}
		} else {
			aus = '';
		}
		if (aus !== ''){
			var data = { 'status_date' : rrStDate, 'status_id' : statusId, 'element_id' : elementId, 'element_aus' : aus, 'project_id' : projectId };
		} else {
			var data = { 'status_date' : rrStDate, 'status_id' : statusId, 'element_id' : elementId, 'project_id' : projectId };
		}
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		overall_status();
	})
	
	$('.save-b').click(function(){ // save override info
		rrOStat = $(this).siblings('select').val();
		rrStODate = $(this).siblings('input[type="date"]').val();
		statusId = $(this).siblings('#rr_status_id').val();
		elementId = $(this).siblings('#element_id').val();			
		projectId = $('#project_id').val();
		if (statusId == '2'){
			var url = path + 'json_rr_update.php';
			var resetData = { 'project_id' : projectId, 'meth_cat_id' : '2' }
			$.saveData(url, resetData);
			sep_flag = $('#sep_flag').text();
			dep_flag = $('#dep_flag').text();
			var today = new Date();
			if (new Date(rrStODate) <= today && rrStODate !== ''){
				if (sep_flag == 'Yes'){
					if (dep_flag == 'None'){
						oaus = 1;
					} else {
						oaus = 2;
					}
				} else {
					if (dep_flag == 'None'){
						oaus = 3;
					} else {
						oaus = 4;
					}
				}
			} else {
				if (sep_flag == 'Yes'){
					if (dep_flag == 'None'){
						oaus = 5;
					} else {
						oaus = 6;
					}
				} else {
					if (dep_flag == 'None'){
						oaus = 7;
					} else {
						oaus = 8;
					}
				}
			}
		} else {
			oaus = '';
		}
		if (oaus !== ''){
			var data = { 'status_odate' : rrStODate, 'status_id' : statusId, 'status_ovr' : rrOStat, 'element_id' : elementId, 'element_oaus' : oaus, 'project_id' : projectId };
		} else {
			var data = { 'status_odate' : rrStODate, 'status_id' : statusId, 'status_ovr' : rrOStat, 'element_id' : elementId, 'project_id' : projectId };
		}
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		rrOStatHtml = '<p class="span1"><strong>' + rrOStat + '</strong>';
		rrODateHtml = '<strong>' + rrStODate+ '</strong>';
		$(this).parent().parent().siblings('div[id^="rrtsat_c"]').find('.ovr_status').html(rrOStatHtml);
		$(this).parent().parent().siblings('div[id^="rrtsat_c"]').find('.ovr_date').html(rrODateHtml);
		$(this).parent().parent().siblings('div[id^="rrtsat_c"]').removeClass('hidden');
		$(this).parent().parent('div[id^="rrtsat_b"]').addClass('hidden');
		overall_status();
	})
	
	$('#edit_rr_deliv').click(function(){
		$('#rrdeliv_a').addClass('hidden');
		$('#rrdeliv_b').removeClass('hidden');
	})
	
	$('#save_deliv_b').click(function(){
		r = false;
		if ($('#element_rr_deliv_name').text() !== ''){
			r = confirm('Changing the element deliverable will delete all data for the current revenue recognition method. Do you want to continue?');
		} else {
			r = true;
		}
		if (r == true){
			rrDelivId = $(this).siblings('select').val();
			rrDelivName = $("#rr_el_deliv option:selected").text();  
			elementId = $('#element_id').val();
			projectId = $('#project_id').val();
			var data = { 'deliv_id' : rrDelivId, 'element_id' : elementId, 'del_method_id' : '', 'project_id' : projectId };
			var url = path + 'json_rr_update.php';
			$.saveData(url, data);
			var url = path + 'json_rr_upload.php';
			var data = { 'deliv_id' : rrDelivId };
			delivResults = $.parseJSON($.getData(url, data));
			for (var i = 0; i < delivResults.length; i++){
				if (delivResults[i].rr_del_id == rrDelivId){
					delName = '<strong>' + delivResults[i].rr_del_name + '</strong><span id="delId" class="hidden">' + rrDelivId + '</span>'; 
					delDesc = delivResults[i].rr_del_desc; 
					$('#element_rr_deliv_name').html(delName);
					$('#element_rr_deliv_desc').html(delDesc);
				}
			}
			
			
			var data = { 'deliv_meth_id' : rrDelivId };
			methResults = $.parseJSON($.getData(url, data));
			meth = '';
			for (var j = 0; j < methResults.length; j++){
				if (methResults[j].rr_del_id == rrDelivId){
					meth = meth + '<option value="' + methResults[j].rr_meth_id + '">' + methResults[j].rr_meth_name + '</option>'; 
					$('#rr_el_meth').html(meth);
				}
			}
			$('#rrdeliv_b').addClass('hidden');
			$('#rrdeliv_a').removeClass('hidden');
			$('#element_rr_meth_name').html('<strong>Please update</strong>');
			$('#element_rr_meth_desc').html('');
		}
		overall_status();
	})
	
	$('#edit_rr_meth').click(function(){
		$('#rrmeth_a').addClass('hidden');
		$('#rrmeth_b').removeClass('hidden');
	})
	
	$('rr_status').change(function(){
		elementId = $('#element_id').val();
		elementStatus = $('#rr_status').children('strong').text();
		projectId = $('#project_id').val();
		var data = { 'element_status' : elementStatus, 'element_id' : elementId, 'project_id' : projectId };
		var url = path + 'json_rr_update.php';
		$.saveData(url, data);
		overall_status();
	})
	
	jQuery.extend({
		saveData: function(url, data) {
			//var result = null;
			$.ajax({
				url: url,
				type: 'POST',
				context: this,
				data: data,
				//async: false,
				success: function(result) {
					//alert(result);
				}
			});
		   //return result;
		}
	});
	
	jQuery.extend({
		getData: function(url, data) {
			var result;
			$.ajax({
				url: url,
				type: 'GET',
				async: false,
				context: this,
				data: data,
				datatype: 'json',
				//async: false,
				success: function(data) {
					//alert(data);
					result = data
				}
			});
		   return result;
		}
	});
	overall_status();
})

function overall_status(){
	// evaluate the status of each requirement
	if ($('#rrtsat_a1').attr('class') == 'hidden'){
		r1Text = $('#element_rr_st_1c').text();
		r1Date = $('#rrtsat_c1').find('.ovr_date').text();
		r1DateValue = Date.parse(r1Date);
	} else {
		r1Text = $('#element_rr_st_1a').text();
		r1Date = $('#rr_el_dt_1').val();
		r1DateValue = Date.parse(r1Date);
	}
	if ($('#rrtsat_a2').attr('class') == 'hidden'){
		r2Text = $('#element_rr_st_2c').text();
		r2Date = $('#rrtsat_c2').find('.ovr_date').text();
		r2DateValue = Date.parse(r2Date);
	} else {
		r2Text = $('#element_rr_st_2a').text();
		r2Date = $('#rr_el_dt_2').val();
		r2DateValue = Date.parse(r2Date);
	}
	if ($('#rrtsat_a3').attr('class') == 'hidden'){
		r3Text = $('#element_rr_st_3c').text();
		r3Date = $('#rrtsat_c3').find('.ovr_date').text();
		r3DateValue = Date.parse(r3Date);
	} else {
		r3Text = $('#element_rr_st_3a').text();
		r3Date = $('#rr_el_dt_3').val();
		r3DateValue = Date.parse(r3Date);
	}
	if ($('#rrtsat_a4').attr('class') == 'hidden'){
		r4Text = $('#element_rr_st_4c').text();
		r4Date = $('#rrtsat_c4').find('.ovr_date').text();
		r4DateValue = Date.parse(r4Date);
	} else {
		r4Text = $('#element_rr_st_4a').text();
		r4Date = $('#rr_el_dt_4').val();
		r4DateValue = Date.parse(r4Date);
	}
	
	if (r1Text == "Incomplete"){
		rrStatus = 'Incomplete';
		rrStatusDate = '';
	} else if (r2Text == "Incomplete"){
		rrStatus = 'Incomplete';
		rrStatusDate = '';
	} else if (r3Text == "Incomplete"){
		rrStatus = 'Incomplete';
		rrStatusDate = '';
	} else if (r4Text == "Incomplete"){
		rrStatus = 'Incomplete';
		rrStatusDate = '';
	} else {
		if (r1Text !== "Met"){
			r1Status = 0;
		} else {
			r1Status = 1;
		}
		if (r2Text !== "Met"){
			r2Status = 0;
		} else {
			r2Status = 1;
		}
		if (r3Text !== "Met"){
			r3Status = 0;
		} else {
			r3Status = 1;
		}
		if (r4Text !== "Met"){
			r4Status = 0;
		} else {
			r4Status = 1;
		}
		
		if (r1Status + r2Status + r3Status + r4Status < 4){
			rrStatus = 'Not Met';
			rrStatusDate = '';
		} else {
			rrStatus = 'Met';
			if (r1DateValue > 0 && r2DateValue > 0 && r3DateValue > 0 && r4DateValue > 0){
				var rrStatusValue = Math.max(r1DateValue, r2DateValue, r3DateValue, r4DateValue) + 86400000;
				var rrStatusDateValue = new Date(rrStatusValue);
				var rrStatusDate = rrStatusDateValue.toYMD();
			} else {
				var rrStatusDate = '0000-00-00';
			}
		}
	}
	
	$('#rr_status').html('<strong>' + rrStatus + '</strong>');
	if (rrStatusDate == ''){
		rrStatusDateHtml = '';
	} else {
		rrStatusDateHtml = 'As of: <strong>' + rrStatusDate + '</strong>';
	}
	$('#rr_status_date').html(rrStatusDateHtml);
	elementId = $('.element-container').attr('id');
	projectId = $('#project_id').val();
	var data = { 'overall_status' : rrStatus, 'overall_status_date' : rrStatusDate, 'element_id' : elementId, 'project_id' : projectId };
	var url = path + 'json_rr_update.php';
	$.saveData(url, data);
}
