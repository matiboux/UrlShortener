/** This library requires jQuery */

/** Confirm Click */
function confirmClick($this, e) {
	if($this.attr('confirm') != 'true') {
		e = e || null;
		if(e !== null) e.preventDefault();
		$this.attr('confirm', true);
		
		$this.removeClass('btn-danger');
		$this.addClass('btn-warning');
		if($this.find('span').length > 0) {
			$this.attr('data-content', $this.find('span').html());
			$this.find('span').html('Confirm?');
		} else {
			$this.attr('data-content', $this.html());
			$this.html('Confirm?');
		}
		return false;
	} else {
		$this.attr('confirm', false);
		$this.removeClass('btn-warning');
		$this.addClass('btn-danger');
		if($this.find('span').length > 0) $this.find('span').html($this.attr('data-content'));
		else $this.html($this.attr('data-content'));
		return true;
	}
}

$(function() {

	/** Selectors */
	$('.selector').click(function() {
		$(this).toggleClass('checked');
		
		if($(this).hasClass('checked')) {
			$(this).find('i').removeClass('far fa-square');
			$(this).find('i').addClass('fas fa-check-square');
		}
		else {
			$(this).find('i').removeClass('fas fa-check-square');
			$(this).find('i').addClass('far fa-square');
		}
	});
	
	$('.selectAll').click(function(e) {
		e.preventDefault();
		$('.selector').addClass('checked');
		$('.selector').each(function() {
			$(this).find('i').removeClass('far fa-square');
			$(this).find('i').addClass('fas fa-check-square');
		});
		return false;
	});
	$('.unselectAll').click(function(e) {
		e.preventDefault();
		$('.selector').removeClass('checked');
		$('.selector').each(function() {
			$(this).find('i').removeClass('fas fa-check-square');
			$(this).find('i').addClass('far fa-square');
		});
		return false;
	});
	
	$('.delete').click(function(e) { confirmClick($(this), e); });
	$('.deleteSelected').click(function(e) {
		e.preventDefault();
		
		var selectArray = [];
		$('.selector.checked').parent().each(function() {
			selectArray.push($(this).attr('id'));
		});
		
		if(selectArray.length > 0 && confirmClick($(this))) {
			var url = $(this).attr('href') + encodeURIComponent(JSON.stringify(selectArray));
			window.location = url;
		}
	});

});