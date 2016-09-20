(function(){
	// Save current page
	if(typeof sns.query_vars !== 'undefined'){
		_current_page = sns.query_vars.paged;
	}else{
		_current_page = -1;
	}
	if(_current_page == 0) _current_page = 1;
	// Flag to check if an ajax is executing
	_ajax_loading = false;
	
	function snssimen_do_ajax($blog_layout){
		if( jQuery('#navigation-ajax').length > 0 ){
			jQuery('#navigation-ajax').live('click', function(e){
				e.preventDefault();
				if( _current_page > -1 && !_ajax_loading){
					item_template = jQuery(this).attr('data-template');
					
					data = {
							action: 'load_more',
							page: _current_page,
							template: item_template,
							snssimen_blog_layout: $blog_layout,
							vars: sns.query_vars,
					};
					
					content_div = jQuery(this).attr('data-target');
					
					_ajax_loading = true;
					jQuery.ajax({
						type: 'POST',
						url: sns.ajaxurl,
						cache: false,
						data: data,
						success: function(data, textStatus, XMLHttpRequest){
							if(data !=''){
								// Do something fancy before appending data
								jQuery('#navigation-ajax').removeClass('snsnav-active');
								// Then append data
								
								// blog masonry
								if(jQuery('.sns-grid-masonry').length > 0){
									var newItems = jQuery(data).appendTo(content_div);
									jQuery(content_div).masonry('appended', newItems);
									
									var ImagesLoaded = imagesLoaded( document.querySelector(content_div)  );
									ImagesLoaded.on( 'done', function(instance){
										jQuery('.sns-grid-masonry').masonry({
											// options
											itemSelector: '.sns-grid-item',
										});
									});
								}else{
									jQuery(content_div).append(data);
								}
								
								// increase current page
								_current_page = _current_page + 1;
								// Hide button load more if no posts
								if( jQuery('#sns-load-more-no-posts').length > 0 ){
									jQuery('.navigation-ajax').hide();
								}
							}else{
								_current_page = -1;
								// Do something else when there is no more results
								jQuery('.navigation-ajax').hide();
							}
							
							_ajax_loading = false;
						},
						error: function(MLHttpRequest, textStatus, errorThrown){
							alert(errorThrown);
							_ajax_loading = false;
						}
					});
				}
			});
		}
	}
	
	jQuery(document).ready(function($){
		var $snssimen_blog_layout = $('input[name="hidden_snssimen_blog_layout"]').val();
		$('#navigation-ajax').click(function(){
			// Do something before loading
			$(this).addClass('snsnav-active');
			snssimen_do_ajax($snssimen_blog_layout);
		});
	});
	
})();