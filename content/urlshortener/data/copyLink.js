(function($) {

$('.copyLink').click(function(e) {
	e.preventDefault();
	$('#message').hide().empty();
	
	if($('#_hiddenTextToCopy_').length <= 0) {
		$('body').append(
			$('<textarea>').attr({
				id: '_hiddenTextToCopy_'
			}).css({
				position: 'absolute',
				top: '0',
				left: '-9999px'
			})
		);
	}
    var currentFocus = document.activeElement;
	$('#_hiddenTextToCopy_').empty().append($(this).attr('href') ? $(this).attr('href') : $(this).text()).focus();
    $('#_hiddenTextToCopy_')[0].setSelectionRange(0, $('#_hiddenTextToCopy_').val().length);
    
    try {
		succeed = true;
    	document.execCommand('copy');
    } catch(exception) {
        succeed = false;
    }
    $(currentFocus).focus();
	
	if(succeed) {
		$('#message').removeClass().addClass('message message-success').empty().append(
			$('<i>').addClass('fa fa-clipboard fa-fw'),
			' Le lien a été copié !'
		).fadeIn();
	}
	
    return false;
});

})(jQuery);