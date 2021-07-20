jQuery(function( $ ){

	// On scroll set content margin bottom to height of footer
	// and set footer to fixed.
	$(window).on('scroll resize', function(e) {
		var footerheight = $('footer.site-footer').height();
		$('.site-inner').css('margin-bottom', footerheight);
		$('footer.site-footer').css('width', '100%');
		$('footer.site-footer').css('position', 'fixed');
		$('footer.site-footer').css('z-index', '1');
		$('footer.site-footer').css('bottom', '0');
		
	});

});