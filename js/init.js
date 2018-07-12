/*
Aaron Salley Design Initialization.js

***********************************************
***********************************************
***********************************************
********************************   ************
******************************* *  ************
*****************************  **  ************
***************************   ***  ************
*************************   *****  ************
*********************       *****  ************
******************  **  ******  *  ************
****************  **  *********    ************
***************  *  *************  ************
***************   ***************  ************
***************  ****************  ************
*************    ****************  ************
***********  ***  **************   ************
*********  *******  **********  *  ************
*******  ***********         ****  ************
***********************************************
***********************************************
***********************************************
***********************************************
***********************************************

*/
(function($){
	
	//Prepackaged WordPress functions
	( function() {
			var body    = $( 'body' ),
			_window = $( window );
	
		// Enable menu toggle for small screens.
		( function() {
			var nav = $( '#site-navigation' ), button, menu;
			if ( ! nav ) {
				return;
			}
	
			button = nav.find( '.menu-toggle' );
			if ( ! button ) {
				return;
			}
	
			// Hide button if menu is missing or empty.
			menu = nav.find( '.nav-menu' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}
	
			$( '.menu-toggle' ).on( 'click.design', function() {
				nav.toggleClass( 'toggled-on' );
			} );
		} )();
	
		// Arrange footer widgets vertically.
		if ( $.isFunction( $.fn.masonry ) ) {
			$( '.footer-sidebar' ).masonry( {
				itemSelector: '.widget',
				columnWidth: function( containerWidth ) {
					return containerWidth / 4;
				},
				gutterWidth: 0,
				isResizable: true,
				isRTL: $( 'body' ).is( '.rtl' )
			} );
		}
	
		// Initialize Featured Content slider.
		_window.load( function() {
			if ( body.is( '.slider' ) ) {
				$( '.featured-content' ).featuredslider( {
					selector: '.featured-content-inner > article',
					controlsContainer: '.featured-content'
				} );
			}
		} );
	});
	
	//Show background before site header.
	$('.home .site-header').css({'margin-top': $(window).height() - $('.site-header').height()})

	//Sets position of leader text.
	$('#leader').css({'top': ($(window).height() - $('.site-header').height() - $('#leader').height())/2 });

	//Affixes site navigation to the top of the screen once scrolled past.
	$('.site-navigation').height( $('.nav-menu').height());
	
	$('.nav-menu').affix({
		offset: { top: $('.nav-menu').offset().top }
	});
	
	//Includes entire height of post content area when setting the site of the container.
	if( $('.entry-content').height() < $('.entry-meta').height() ){
		$('.content-wrapper').css({'min-height': $('.entry-meta').height()});
	};

	//Set up masonry on project grids.
		var $container = $('.masonry');
		// initialize
		$container.masonry({
		  columnWidth: 200,
		  itemSelector: '.brick'
		});
	
	//Show background after site footer.
	$('.site-footer').css({'margin-bottom': $(window).height() - $('.site-footer').outerHeight()-$('.nav-menu').height()})
	
	// Scroll in both directions
	$.localScroll.defaults.axis = 'xy';
	
	// Scroll initially if there's a hash (#something) in the url 
	$.localScroll.hash({
		queue:false,
		duration:1500
	});
	
	$.localScroll({
		queue:false,
		duration:1000,
		hash:false,
		onBefore:function( e, anchor, $target ){
		},
		onAfter:function( anchor, settings ){
		}
	});

})(jQuery);