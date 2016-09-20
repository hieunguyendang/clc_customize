<?php

?>
<div id="sns_respmenu" class="menu-offcanvas hidden-lg">
	<span class="btn2 btn-navbar leftsidebar">
		<i class="fa fa-align-left"></i>
	    <span class="overlay"></span>
	</span>
	<span class="btn2 btn-navbar offcanvas">
		<i class="fa fa-align-justify"></i>
	    <span class="overlay"></span>
	</span>
	<span class="btn2 btn-navbar rightsidebar">
		<i class="fa fa-align-right"></i>
	    <span class="overlay"></span>
	</span>
	<div id="menu_offcanvas" class="offcanvas">
		<?php
		$main_menu = '';
		if(is_page() && ($menu_selected = get_post_meta(get_the_ID(), 'snssimen_main_menu', true))){
			$main_menu = $menu_selected;
		}
		
        if(has_nav_menu('main_navigation')):
           wp_nav_menu( array(
           				'theme_location' => 'main_navigation',
           				'container' => false,
           				'menu'		=> $main_menu,
           				'menu_id' => 'res_main_nav',
           				'menu_class' => 'resp-nav'
           	) ); 
		else:
			esc_html_e('Please sellect menu for Main navigation', 'snssimen');
		endif;
		?>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#menu_offcanvas').SnsAccordion({
			// btn_open: '<i class="fa fa-plus"></i>',
			// btn_close: '<i class="fa fa-minus"></i>'
			btn_open: '<span class="ac-tongle open"></span>',
			btn_close: '<span class="ac-tongle close"></span>',
		});
		$('#sns_respmenu .btn2.offcanvas').on('click', function(){
			if($('#menu_offcanvas').hasClass('active')){
				$(this).find('.overlay').fadeOut(250);
				$('#menu_offcanvas').removeClass('active');
				$('body').removeClass('show-sidebar', 4000);
			} else {
				$('#menu_offcanvas').addClass('active');
				$(this).find('.overlay').fadeIn(250);
				$('body').addClass('show-sidebar');
			}
		});
		if($('#sns_content .sns-right').length) {
			$('#sns_respmenu .btn2.rightsidebar').css('display', 'inline-block').on('click', function(){
				if($('#sns_content .sns-right').hasClass('active')){
					$(this).find('.overlay').fadeOut(250);
					$('#sns_content .sns-right').removeClass('active');
					$('body').removeClass('show-sidebar', 4000);
				} else {
					$('#sns_content .sns-right').addClass('active');
					$(this).find('.overlay').fadeIn(250);
					$('body').addClass('show-sidebar');
				}
			});
		}
		if($('#sns_content .sns-left').length) {
			$('#sns_respmenu .btn2.leftsidebar').css('display', 'inline-block').on('click', function(){
				if($('#sns_content .sns-left').hasClass('active')){
					$(this).find('.overlay').fadeOut(250);
					$('#sns_content .sns-left').removeClass('active');
					$('body').removeClass('show-sidebar', 4000);
				} else {
					$('#sns_content .sns-left').addClass('active');
					$(this).find('.overlay').fadeIn();
					$('body').addClass('show-sidebar');
				}
			});
		}
	});
</script>