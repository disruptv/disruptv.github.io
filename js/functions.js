jQuery(document).ready(function($) {

	$(document).foundation({
		"magellan-expedition": {
			destination_threshold : 0, // pixels from the top of destination for it to be considered active
		}
	});

  	// Projects viewer AJAX
	$('.project').on('click', function(event){
		event.preventDefault();

		var container = $('#projects');
		var containerWidth = $(container).outerWidth(true);
		var containerHeight = $(container).outerHeight(true);
		var viewer = document.createElement('article');
        
        $(container).wrapInner('<div class="wrapper clearfix"></div>').css('overflow','hidden');
        $('.wrapper').width(containerWidth * 5).wrapInner('<div class="projects clearfix"></div>');
        $('.projects').width(containerWidth);
        $(viewer).attr('id','project').addClass('row').insertAfter('.projects').width(containerWidth);
    	    	
    	viewer = $('#project');
        var project_id = $(this).attr('id').match(/project-(\d+)/)[1];

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
				'action': 'project', 
				'project_id': project_id,
			},
            success: function(response) {
                $(viewer).html(response);
				$('#project-gallery').slick({
					lazyLoad: 'ondemand',
					dots: true,
					infinite: true,
					speed: 500,
					fade: true,
					autoplay: true,
					autoplaySpeed: 5000
				});
                $(container).scrollTo($('#project'), 500);
                $('h1, .back').click(function(event){
	                event.preventDefault();
	                
	                $(container).scrollTo(0, 500, function(){
		                $(viewer).remove();
		                $('.wrapper').replaceWith($('.projects').children());
	                	$(container).removeAttr('style');
	                });
                })
                return false;
            }
        });
	});

	$(window).on('scroll resize',function(){
		var window = $(this);
		var windowHeight = window.height();
		
		$('.project').each(function(){
			parseInt($(this).offset().top, 10) <= window.scrollTop()+windowHeight&&$(this).addClass('in-view');
		});
	}).scroll().resize();
});