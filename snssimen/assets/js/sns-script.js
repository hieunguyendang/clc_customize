(function ($) {
	"use strict";
	$(document).ready(function($){
		var $win = $(window);
		// Sticky Menu for homepage 4
		$win.scroll(function(){
			if( $('#sticky-navigation-holder').length>0 ){
				var $doc 		= document.documentElement;
				var $top_offset = (window.pageYOffset || $doc.scrollTop) - ($doc.clientTop || 0);
				var $wpadminbar = $("#wpadminbar").height();
				if($win.width() < 600){
					$wpadminbar = 0;
				}
				if( $top_offset > $('#sns_header').offset().top + 50 ){
					$('#sticky-navigation-holder').addClass('scrolled');
					$('#sns_header > .container').appendTo($('#sticky-navigation-holder'));
					$('#sticky-navigation-holder').css({'top': $wpadminbar });
					
				}else{
					$('#sticky-navigation-holder').removeClass('scrolled');
					$('#sticky-navigation-holder').css('top',-50);
					$('#sticky-navigation-holder > .container').appendTo($('#sns_header'));
				}
			}
		});
		
		// lazyload for woo product
		if( $('body').hasClass('use_lazyload') ){
			$('.product_list, .sns-products-list').each(function(){
				if( $(this).length > 0 ){
					$(this).find('img.lazy').lazyload();
				}
			})
		}

		// handle-preload
		$('.handle-preload').removeClass('handle-preload');
		// Set color, border-color for social icon
		$('.connect-us [data-color]').hover(function(){
			$(this).css({
				'color':$(this).attr('data-color'), 
				'border-color':$(this).attr('data-color')
			});
		},function(){
			$(this).css({
				'color':'',
				'border-color':''
			})
		});
		// Count to
		$('.counter-value').each(function(){
			$(this).waypoint(function() {
	        	var element = $(this).find(' > span');
		    	element.countTo({
		    		from: element.data('from'), 
		    		to: element.data('to'),
		    		efreshInterval: element.data('interval'),
		    		speed: element.data('speed')
		    	});
	        },{
			triggerOnce : true ,
			     offset : '100%'
	    	});
		});
		// Sticky menu
		var $is_header2 = false;
		if($('body').hasClass('sns_header_layout_2')){
			$is_header2 = true;
		}
		
		if($('#sns_menu').length && $('body').hasClass('use_stickmenu') && $is_header2 == false){
		    var headerOrgOffset = $('#sns_menu').offset().top;
		    $(window).scroll(function() {
		        var currentScroll = $(this).scrollTop();
		        if(currentScroll > headerOrgOffset) {
		        	$('#sns_menu').addClass('keep-menu');
		        } else {
		        	$('#sns_menu').removeClass('keep-menu');
		        }
		    });
		}
		// blog masonry
		if($('.sns-grid-masonry').length > 0){
			$('.sns-grid-masonry').masonry({
				// options
				itemSelector: '.sns-grid-item',
			});
		}
	});
		
	$(window).load(function(){
		// Tooltip
	    $("body.use-tooltip *[data-toggle='tooltip']").each(function(){
			$(this).tooltip({
	    		container: 'body'
	    	}, 'show');
		})
		$(document).ajaxComplete(function(){
			$("body.use-tooltip *[data-toggle='tooltip']").each(function(){
				$(this).tooltip({
		    		container: 'body'
		    	});
			});
			// lazyload for woo product
			if( $('body').hasClass('use_lazyload') ){
				var timeout = setTimeout(function() {
					$(".sns-main img.lazy:not(.loaded)").lazyload();
				}, 1000);
			}
		})
	});
	$.fn.SnsAccordion = function(options) {
		var $el    = $(this);
		var defaults = {
			active: 'open',
			active_default: 'nav-2',
			el_wrap: 'li',
			el_content: 'ul',
			accordion: true,
			expand: true,
			btn_open: '<i class="fa fa-plus-square-o"></i>',
			btn_close: '<i class="fa fa-minus-square-o"></i>'
		};
		var options = $.extend({}, defaults, options);
		
		
		$(document).ready(function() {
			$el.find(options.el_wrap).each(function(){
				$(this).find('> a, > span, > h4').wrap('<div class="accr_header"></div>');
				if(($(this).find(options.el_content)).length){
					$(this).find('> .accr_header').append('<span class="btn_accor">' + options.btn_open + '</span>');
					$(this).find('> '+options.el_content+':not(".accr_header")').wrap('<div class="accr_content"></div>');
				}
			});
			if(options.accordion){
				$('.accr_content').hide();
				$el.find(options.el_wrap).each(function(){
					if(options.active_default!==''){
						if( $(this).hasClass(options.active_default) ){
							$(this).addClass(options.active);
						}
					}
					if($(this).hasClass(options.active)) {
						$(this).find('> .accr_content')
							   .addClass(options.active)
							   .slideDown();
						$(this).find('> .accr_header')
							   .addClass(options.active);
					}
				});
			} else {
				$el.find(options.el_wrap).each(function(){
					if(!options.expand){
						$('.accr_content').hide();
					} else {
						$(this).find('> .accr_content').addClass(options.active);
						$(this).find('> .accr_header').addClass(options.active);
						$(this).find('> .accr_header .btn_accor').html(options.btn_close);
					}
				});
			}

	    });
	    $(window).load(function() {
			$el.find(options.el_wrap).each(function(){
				var $wrap = $(this);
				var $accrhead = $wrap.find('> .accr_header');
				var btn_accor = '.btn_accor';
				
				$accrhead.find(btn_accor).on('click', function(event) {
					event.preventDefault();
					var obj = $(this);
					var slide = true;
					if($accrhead.hasClass(options.active)) {
						slide = false;
					}
					if(options.accordion){
						$wrap.siblings(options.el_wrap).find('> .accr_content').slideUp().removeClass(options.active);
						$wrap.siblings(options.el_wrap).find('> .accr_header').removeClass(options.active);
						$wrap.siblings(options.el_wrap).find('> .accr_header ' + btn_accor).html(options.btn_open);
					}
					if(slide) {
						$accrhead.addClass(options.active);
						obj.html(options.btn_close);
						$accrhead.siblings('.accr_content').addClass(options.active).stop(true, true).slideDown();
					} else {
						$accrhead.removeClass(options.active);
						obj.html(options.btn_open);
						$accrhead.siblings('.accr_content').removeClass(options.active).stop(true, true).slideUp();
					}
					return false;
				});
			});
		});
	    // Top header background transparent
	    if($('#sns_topheader_transpareant').length > 0){
	    	var $snsTopheaderTranspareant = $('#sns_topheader_transpareant');
	    	var $snsTopheaderTranspareant_height = -$($snsTopheaderTranspareant).height();
	    	// Set margin bottom
	    	$($snsTopheaderTranspareant).css({
	    		'margin-bottom': $snsTopheaderTranspareant_height,
	    		});
	    	// display topheader
	    	setTimeout(function(){
	    		$($snsTopheaderTranspareant).addClass('sns_transparent_active');
	    	},300);
	    }
	};
})(jQuery);