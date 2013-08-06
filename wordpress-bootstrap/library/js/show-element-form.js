(function(){
	if( window.localStorage ){
		if( !localStorage.getItem( 'firstLoad' ) ){
			localStorage[ 'firstLoad' ] = true;
			window.location.reload();
		} else {
			localStorage.removeItem( 'firstLoad' );
		}
	}
})
();

$('document').ready(function(){
	$("#element_form").validate({
		ignore: '.ignore',
	});
})
	
$("select").change(function() {
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'selling_basis_1'){
			$('#vsoe_basis_container').removeClass('hidden');
		}
	
		if ($(this).attr('id') == 'selling_basis_2' || $(this).attr('id') == 'selling_basis_3'){
			$('#vsoe_basis_container').addClass('hidden');
		}
	
		if ($(this).attr('id') == 'sw_element_1'){
			$('#sw_last_container').removeClass('hidden');
			$('#sw_last_container').find('select').removeClass('ignore');
			$('#element_sep_container').addClass('hidden');
		}
	
		if ($(this).attr('id') == 'sw_element_0'){
			$('#sw_last_container').addClass('hidden');
			$('#sw_last_container').find('select').addClass('ignore');
			$('#element_sep_container').removeClass('hidden');
		}
	
		if ($(this).attr('id') == 'contingent_question_1'){
			$('#contingent_amount_container').removeClass('hidden');
			$('#contingent_item_container').removeClass('hidden');
			$('#contingent_desc_container').removeClass('hidden');
			$('#contingent_amount').removeClass('ignore');
		}
	
		if ($(this).attr('id') == 'contingent_question_0'){
			$('#contingent_amount_container').addClass('hidden');
			$('#contingent_item_container').addClass('hidden');
			$('#contingent_desc_container').addClass('hidden');
			$('#contingent_amount').addClass('ignore');
		}
	
		if ($(this).attr('id') == 'ufp_question_1'){
			$('#ufp_disc_amt_container').removeClass('hidden');
			$('#ufp_disc_amt').removeClass('ignore');
			$('#ufp_disc_rate_container').addClass('hidden');
			$('#ufp_disc_rate').addClass('ignore');
		}
	
		if ($(this).attr('id') == 'ufp_question_0'){
			$('#ufp_disc_rate_container').removeClass('hidden');
			$('#ufp_disc_rate').removeClass('ignore');
			$('#ufp_disc_amt_container').addClass('hidden');
			$('#ufp_disc_amt').addClass('ignore');
		}
		
		if ($(this).attr('id') == 'sw_ufp_question_1'){
			$('#sw_ufp_disc_amt_container').removeClass('hidden');
			$('#sw_ufp_disc_amt').removeClass('ignore');
			$('#sw_ufp_disc_rate_container').addClass('hidden');
			$('#sw_ufp_disc_rate').addClass('ignore');
		}
	
		if ($(this).attr('id') == 'sw_ufp_question_0'){
			$('#sw_ufp_disc_rate_container').removeClass('hidden');
			$('#sw_ufp_disc_rate').removeClass('ignore');
			$('#sw_ufp_disc_amt_container').addClass('hidden');
			$('#sw_ufp_disc_amt').addClass('ignore');
		}
	
		if ($(this).attr('class') == 'element_del'){
			delId = $(this).attr('id').slice(12);
			delMethCat = $('#group-' + delId).children('#category').text();
			delDiscCat = $('#group-' + delId).children('#sub_category').text();
			console.log('delId', delId);
			console.log('delMethCat', delMethCat);
			console.log('delDiscCat', delDiscCat);
			if (delMethCat == 1){
				if (delDiscCat == 1){
					console.log('branch 1:1');
					$('#default-container').addClass('hidden');
					$('#default-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#default-container').children().addClass('hidden');
					$('#software-container').addClass('hidden');
					$('#software-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#software-container').children().addClass('hidden');
					$('#sw-sfp-container').addClass('hidden');
					$('#sw-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#sw-ufp-container').addClass('hidden');
					$('#sw-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#other-sfp-container').removeClass('hidden');
					$('#other-sfp-container [class~="default"]').removeClass('ignore').prop('disabled', false);
					$('#other-sfp-container').children('.default_container').removeClass('hidden');
					$('#other-ufp-container').addClass('hidden');
					$('#other-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-ufp-container').children().addClass('hidden');
					$('#meth_cat').val(delMethCat);
					$('#disc_cat').val(delDiscCat);
				} else if (delDiscCat == 2){
					console.log('branch 1:2');
					$('#default-container').addClass('hidden');
					$('#default-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#default-container').children().addClass('hidden');
					$('#software-container').addClass('hidden');
					$('#software-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#software-container').children().addClass('hidden');
					$('#sw-sfp-container').addClass('hidden');
					$('#sw-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#sw-ufp-container').addClass('hidden');
					$('#sw-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#other-sfp-container').addClass('hidden');
					$('#other-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-sfp-container').children().addClass('hidden');
					$('#other-ufp-container').removeClass('hidden');
					$('#other-ufp-container [class~="default"]').removeClass('ignore').prop('disabled', false);
					$('#other-ufp-container').children('.default_container').removeClass('hidden');
					$('#meth_cat').val(delMethCat);
					$('#disc_cat').val(delDiscCat);
				} else {
					console.log('branch 1:0');
					$('#default-container').removeClass('hidden');
					$('#default-container [class~="default"]').removeClass('ignore').prop('disabled', false);
					$('#default-container').children('.default_container').removeClass('hidden');
					$('#software-container').addClass('hidden');
					$('#software-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#software-container').children().addClass('hidden');
					$('#sw-sfp-container').addClass('hidden');
					$('#sw-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#sw-ufp-container').addClass('hidden');
					$('#sw-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-ufp-container').children().addClass('hidden');
					$('#other-sfp-container').addClass('hidden');
					$('#other-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-sfp-container').children().addClass('hidden');
					$('#other-ufp-container').addClass('hidden');
					$('#other-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-ufp-container').children().addClass('hidden');
					$('#meth_cat').val(delMethCat);
					$('#disc_cat').val(delDiscCat);
				}
			} else if (delMethCat == 2){
				if (delDiscCat == 1){
					console.log('branch 2:1');
					$('#default-container').addClass('hidden');
					$('#default-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#default-container').children().addClass('hidden');
					$('#software-container').addClass('hidden');
					$('#software-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#software-container').children().addClass('hidden');
					$('#sw-sfp-container').removeClass('hidden');
					$('#sw-sfp-container [class~="default"]').removeClass('ignore').prop('disabled', false);
					$('#sw-sfp-container').children('.default_container').removeClass('hidden');
					$('#sw-ufp-container').addClass('hidden');
					$('#sw-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-ufp-container').children().addClass('hidden');
					$('#other-sfp-container').addClass('hidden');
					$('#other-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-sfp-container').children().addClass('hidden');
					$('#other-ufp-container').addClass('hidden');
					$('#other-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-ufp-container').children().addClass('hidden');
					$('#meth_cat').val(delMethCat);
					$('#disc_cat').val(delDiscCat);
				} else if (delDiscCat == 2){
					console.log('branch 2:2');
					$('#default-container').addClass('hidden');
					$('#default-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#default-container').children().addClass('hidden');
					$('#software-container').addClass('hidden');
					$('#software-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#software-container').children().addClass('hidden');
					$('#sw-sfp-container').addClass('hidden');
					$('#sw-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#sw-ufp-container').removeClass('hidden');
					$('#sw-ufp-container [class~="default"]').removeClass('ignore').prop('disabled', false);
					$('#sw-ufp-container').children('.default_container').removeClass('hidden');
					$('#other-sfp-container').addClass('hidden');
					$('#other-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-sfp-container').children().addClass('hidden');
					$('#other-ufp-container').addClass('hidden');
					$('#other-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-ufp-container').children().addClass('hidden');
					$('#meth_cat').val(delMethCat);
					$('#disc_cat').val(delDiscCat);
				} else {
					console.log('branch 2:0');
					$('#default-container').addClass('hidden');
					$('#default-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#default-container').children().addClass('hidden');
					$('#software-container').removeClass('hidden');
					$('#software-container [class~="default"]').removeClass('ignore').prop('disabled', false);
					$('#software-container').children('.default_container').removeClass('hidden');
					$('#sw-sfp-container').addClass('hidden');
					$('#sw-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-sfp-container').children().addClass('hidden');
					$('#sw-ufp-container').addClass('hidden');
					$('#sw-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#sw-ufp-container').children().addClass('hidden');
					$('#other-sfp-container').addClass('hidden');
					$('#other-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-sfp-container').children().addClass('hidden');
					$('#other-ufp-container').addClass('hidden');
					$('#other-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
					$('#other-ufp-container').children().addClass('hidden');
					$('#meth_cat').val(delMethCat);
					$('#disc_cat').val(delDiscCat);
				}
			} else {
				console.log('branch not 1 or 2');
				$('#default-container').removeClass('hidden');
				$('#default-container [class~="default"]').removeClass('ignore').prop('disabled', false);
				$('#default-container').children('.default_container').removeClass('hidden');
				$('#software-container').addClass('hidden');
				$('#software-container [class~="default"]').addClass('ignore').prop('disabled', true);
				$('#software-container').children().addClass('hidden');
				$('#sw-sfp-container').addClass('hidden');
				$('#sw-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
				$('#sw-sfp-container').children().addClass('hidden');
				$('#sw-ufp-container').addClass('hidden');
				$('#sw-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
				$('#sw-ufp-container').children().addClass('hidden');
				$('#other-sfp-container').addClass('hidden');
				$('#other-sfp-container [class~="default"]').addClass('ignore').prop('disabled', true);
				$('#other-sfp-container').children().addClass('hidden');
				$('#other-ufp-container').addClass('hidden');
				$('#other-ufp-container [class~="default"]').addClass('ignore').prop('disabled', true);
				$('#other-ufp-container').children().addClass('hidden');
				$('#meth_cat').val(delMethCat);
				$('#disc_cat').val(delDiscCat);
			}
		}
		console.log('delId last', delId);
		console.log('delMethCat last', delMethCat);
		console.log('delDiscCat last', delDiscCat);
	});
})