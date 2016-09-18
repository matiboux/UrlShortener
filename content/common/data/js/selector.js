(function($) {

$('.selector').click(function() {
	$(this).toggleClass('checked');
	
	if($(this).hasClass('checked')) {
		$(this).find('.fa').removeClass('fa-square-o');
		$(this).find('.fa').addClass('fa-check-square');
	}
	else {
		$(this).find('.fa').removeClass('fa-check-square');
		$(this).find('.fa').addClass('fa-square-o');
	}
});
$('.selectAll').click(function(e) {
	e.preventDefault();
	$('.selector').addClass('checked');
	$('.selector').each(function() {
		if($(this).hasClass('checked')) {
			$(this).find('.fa').removeClass('fa-square-o');
			$(this).find('.fa').addClass('fa-check-square');
		}
		else {
			$(this).find('.fa').removeClass('fa-check-square');
			$(this).find('.fa').addClass('fa-square-o');
		}
	});
	return false;
});
$('.unselectAll').click(function(e) {
	e.preventDefault();
	$('.selector').removeClass('checked');
	$('.selector').each(function() {
		if($(this).hasClass('checked')) {
			$(this).find('.fa').removeClass('fa-square-o');
			$(this).find('.fa').addClass('fa-check-square');
		}
		else {
			$(this).find('.fa').removeClass('fa-check-square');
			$(this).find('.fa').addClass('fa-square-o');
		}
	});
	return false;
});
$('.deleteSelected').click(function(e) {
	e.preventDefault();
	$('#script-message').hide();
	
	var selectArray = [];
	$('.selector.checked').parent().each(function() {
		selectArray.push($(this).attr('id'));
	});
	
	if(selectArray.length > 0) window.location = $(this).attr('href') + encodeURIComponent(JSON.stringify(selectArray));
	else {
		$('#script-message').removeClass().addClass('message message-danger').empty().append(
			$('<p>').append('Select something first')
		).fadeIn();
	}
	
	return false;
});

})(jQuery);