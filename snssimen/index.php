<?php
$lclass = '';
$rclass = '';
$mclass = '';
$hasL = 0;
$hasR = 0;

$layouttype = snssimen_get_option('layouttype', 'l-m');

if ( $layouttype == 'l-m'){
    $lclass .= 'col-md-3';
    $mclass = 'col-md-9';
    $hasL = 1;
}elseif( $layouttype == 'm-r' ){
    $rclass .= 'col-md-3';
    $mclass = 'col-md-9';
    $hasR = 1;
}elseif( $layouttype == 'l-m-r' ){
    $lclass .= 'col-md-3';
    $rclass .= 'col-md-3';
    $mclass = 'col-md-6';
    $hasL = 1;
    $hasR = 1;
}else{
    $mclass = 'col-md-12';
}
?>
<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
		    <?php if( $hasL == 1): ?>
			<!-- left sidebar -->
			<div class="<?php echo esc_attr($lclass); ?> sns-left">
			    <?php 
			    if( class_exists('WooCommerce') && is_woocommerce() ){
			        dynamic_sidebar( 'woo-sidebar');
			    }else{
			        if( snssimen_get_option('leftsidebar')!= '' && is_active_sidebar( snssimen_get_option('leftsidebar') ) ) :
			        	dynamic_sidebar( snssimen_get_option('leftsidebar') ); 
			        else :
			        	dynamic_sidebar('widget-area');
			        endif;
			    }
			    ?>
			</div>
			<?php endif; ?>
			<!-- Main content -->
			<div class="<?php echo esc_attr($mclass); ?> sns-main">
			    <?php
			    if ( have_posts() ) :
			        get_template_part( 'framework/tpl/blog/blog', snssimen_get_option('blog_type','') );
			    else:
			        get_template_part( 'content', 'none' );
			    endif; ?>
			</div>
			<?php if ($hasR == 1): ?>
			<!-- Right sidebar -->
			<div class="<?php echo esc_attr($rclass); ?> sns-right">
			    <?php 
			    if( class_exists('WooCommerce') && is_woocommerce() ){
			        dynamic_sidebar( 'woo-sidebar'); 
			    }else{
			        dynamic_sidebar( snssimen_get_option('rightsidebar') ); 
			    }
			    ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>