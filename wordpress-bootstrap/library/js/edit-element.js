$("select").change(function() {
	// loop over div's and hide based on page type
	if ($('#page_id').hasClass('multiple')){
		$('#contract_price_container').addClass('hidden');
	} else {
		$('#sw_last_container').addClass('hidden');
		$('#selling_price_container').addClass('hidden');
		$('#selling_basis_container').addClass('hidden');
		$('#element_sep_container').addClass('hidden');
		$('#spec_alloc_container').addClass('hidden');
	}
	
	// loop over div's and hide based on content
	if ($('#page_id').hasClass('multiple')){
		// $('#spec_alloc_container').addClass('hidden');
	} else {
		$('#sw_last_container').addClass('hidden');
		$('#selling_price_container').addClass('hidden');
		$('#selling_basis_container').addClass('hidden');
		$('#element_sep_container').addClass('hidden');
	}
	
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'selling_basis_1'){
			$('#vsoe_basis_container').removeClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'selling_basis_2' || $(this).attr('id') == 'selling_basis_3'){
			$('#vsoe_basis_container').addClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'sw_element_1' && $('#page_id').attr('id') == 'multiple'){
			$('#sw_last_container').removeClass('hidden');
			$('#element_sep_container').addClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'sw_element_1' && $('#page_id').attr('id') == 'multiple'){
			$('#sw_last_container').addClass('hidden');
			$('#element_sep_container').removeClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'contingent_question_1'){
			$('#contingent_amount_container').removeClass('hidden');
			$('#contingent_item_container').removeClass('hidden');
			$('#contingent_desc_container').removeClass('hidden');
			$('#contingent_res_container').removeClass('hidden');
			$('#contingent_resdate_container').removeClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'contingent_question_0'){
			$('#contingent_amount_container').addClass('hidden');
			$('#contingent_item_container').addClass('hidden');
			$('#contingent_desc_container').addClass('hidden');
			$('#contingent_res_container').addClass('hidden');
			$('#contingent_resdate_container').addClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'element_del_2'){
			$('#specific_allocation_container').removeClass('hidden');
			$('#selling_price_container').addClass('hidden');
			$('#contingent_desc_container').addClass('hidden');
			$('#contingent_question_container').addClass('hidden');
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'element_del_1' || $(this).attr('id') == 'element_del_3' || $(this).attr('id') == 'element_del_4' || $(this).attr('id') == 'element_del_5' || $(this).attr('id') == 'element_del_0'){
			$('#specific_allocation_container').addClass('hidden');
			$('#selling_price_container').removeClass('hidden');
			$('#contingent_question_container').removeClass('hidden');
		}
	});
})