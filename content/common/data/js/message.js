$('.page-content .message:not(.remain)').click(function(e) {
	e.preventDefault();
	$(this).fadeOut(function() {
		$(this).remove();
	});
});