$("select").change(function() {
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'single'){
			forwardUrl = '<input class="btn btn-primary" type="submit" name="save-single" value="Save" />'
			$('#submit').replaceWith(forwardUrl);
		}
	});
	$("select option:selected").each(function () {
		if ($(this).attr('id') == 'multiple'){
			forwardUrl = '<input class="btn btn-primary" type="submit" name="save-multiple" value="Save" />'
			$('#submit').replaceWith(forwardUrl);
		}
	});
	
})