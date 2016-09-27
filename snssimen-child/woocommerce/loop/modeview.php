<?php
$modeview = snssimen_get_option('woo_list_modeview', 'grid');

if (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'grid') {
    $modeview = 'grid';
}elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list') {
    $modeview = 'list';
}
?>
<ul class="mode-view pull-left">
    <li class="grid">
    	<a class="grid<?php echo ($modeview=='grid')?' active':''; ?>" data-mode="grid" href="#" title="<?php echo esc_attr__('Grid', 'snssimen'); ?>">
    		<i class="fa fa-th"></i><span><?php echo esc_html__('Grid', 'snssimen'); ?></span>
    	</a>
    </li>
    <li class="list">
    	<a class="list<?php echo ($modeview=='list')?' active':''; ?>" data-mode="list" href="#" title="<?php echo esc_attr__('List', 'snssimen'); ?>">
            <i class="fa fa-th-list"></i><span><?php echo esc_html__('List', 'snssimen'); ?></span>
        </a>
    </li>
</ul>

<script>
    jQuery(document).ready(function($){
        if ($(window).width() < 1024 && window.location.href.indexOf("shop-category") > -1) {
          if(jQuery('.mode-view').length){
            html ='<div id="sidebar-filter"><span class="btn2 btn-navbar leftsidebar" style="display: inline-block;font-size: 32px;margin-top: -9px;"><i class="fa fa-filter" aria-hidden="true"></i> <span class="overlay" style="display: none;"></span></span></div>';
            jQuery('.mode-view').after(html);
          }
          $('#menu_offcanvas').SnsAccordion({
            // btn_open: '<i class="fa fa-plus"></i>',
            // btn_close: '<i class="fa fa-minus"></i>'
            btn_open: '<span class="ac-tongle open"></span>',
            btn_close: '<span class="ac-tongle close"></span>',
          });
          $('.btn2.offcanvas').on('click', function(){
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
          if($('#sidebar-filter .btn2.leftsidebar').length) {
            $('#sidebar-filter .btn2.leftsidebar').css('display', 'inline-block').on('click', function(){
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
        }
        
        
    });
</script>