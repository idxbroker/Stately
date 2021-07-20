jQuery(function( $ ){

	// Add class based on scroll position
	$(window).scroll(function () {
		if ($(document).scrollTop() > 0 ) {
			$('body').addClass('sticky');
		} else {
			$('body').removeClass('sticky');
		}
	});
});