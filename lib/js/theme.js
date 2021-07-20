jQuery(document).foundation();

jQuery(function( $ ){
	
	// Enable responsive menu icon for mobile
	$('.nav-header-right').addClass('responsive-menu').before('<a href="" class="menu-toggle"><span class="screen-reader-text">Menu</span><i class="fas fa-bars"></i><span class="hide"><span class="screen-reader-text">Close</span><i class="fas fa-times"></i></span></a>');

	$('.menu-toggle').click(function(e){
		e.preventDefault();
		$('.nav-header-right').slideToggle();
		$('.menu-toggle .fa-bars').toggle();
		$('.menu-toggle .hide').toggle();
	});

	$(document).ready(function() {
		// Use matchHeight for off canvas toggle to match header height.
		$('a.off-canvas-toggle').matchHeight({
			property: 'min-height',
	    	target: $('header.site-header .title-area')
	    });

	    // Change default IMPress button text value to add icon.
	    var existing = $('.home .impress-idx-signup-widget button').html();
		$('.home .impress-idx-signup-widget button').html('<i class="fas fa-envelope"></i> '+existing);

	});

	// Add inline CSS for off canvas menu position
	// and for widget content and toggle to align at click position.
	$(document).on('open.fndtn.offcanvas', '[data-offcanvas]', function() {
		var scrolltop = $(document).scrollTop();
		var stickyheight = $('.sticky-header').height();
		$('.off-canvas-menu').css('position', 'fixed');
		$('.off-canvas-menu').css('margin-top', scrolltop );
		$('.off-canvas-toggle').css('margin-top', scrolltop );
		$('.off-canvas.widget-area').css('margin-top', scrolltop );
	});

	$(document).on('close.fndtn.offcanvas', '[data-offcanvas]', function() {
		$('.off-canvas-menu').css('position', 'relative' );
		$('.off-canvas-toggle').css('margin-top', '0' );
	});

	$(window).on('scroll resize', function(e) {
		// Update matchheight on scroll or resize
		$('a.off-canvas-toggle').matchHeight._update();
		// remove inline style if resized to large width
		if(window.innerWidth > 979) {
			$('.nav-header-right').removeAttr('style');
		}
	});

});
