jQuery(document).ready(function($) {
	$(document).foundation();
	
	function deviceSizeClass() {
		if ( Foundation.MediaQuery.current == 'small' ) {
			$('html').addClass('mobile');
			$('html').removeClass('tablet');
			$('html').removeClass('desktop');
		} else if (Foundation.MediaQuery.current == 'medium') {
			$('html').addClass('tablet');
			$('html').removeClass('mobile');
			$('html').removeClass('desktop');
		} else {
			$('html').addClass('desktop');			
			$('html').removeClass('mobile');
			$('html').removeClass('tablet');
		}		
	}
	deviceSizeClass();
	
	$('.portfolio-items').mixItUp({
		selectors: {
			target: '.portfolio-item'
		}
	});
	$('.filter').on( 'click', function(){
		$('.portfolio-items').mixItUp( 'filter', '.work_platform-'+$(this).attr( 'id' ) );
	})
	
	$( '.portfolio-item' ).hover( function() {
		$(this).toggleClass( 'active' ).siblings( '.portfolio-item' ).toggleClass( 'inactive' );
	})
	
	if( $('html').hasClass( 'mobile' )){
		$('.wp-post-image').insertAfter($('h3'))
	}
	
	$(window).on( 'scroll changed.zf.mediaquery', function(event, newSize, oldSize){
		var window = $(this);
		var windowHeight = window.height();
		
		$('.portfolio-item').each(function(){
			parseInt($(this).offset().top, 10) <= window.scrollTop()+windowHeight&&$(this).addClass('in-view');
		});
		
		deviceSizeClass();
	}).scroll().resize();	
});