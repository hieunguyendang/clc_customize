<?php
$lclass = '';
$rclass = '';
$mclass = '';
$hasL = 0;
$hasR = 0;

$snssimen_layouttype = snssimen_metabox('snssimen_layouttype');

if( is_product() ){
	$mclass = 'col-md-12';
}else{
	if ( $snssimen_layouttype == '' || $snssimen_layouttype == 'l-m'){
	    $lclass .= 'col-md-3';
	    $mclass = 'col-md-9';
	    $hasL = 1;
	}elseif( $snssimen_layouttype == 'm-r' ){
	    $rclass .= 'col-md-3';
	    $mclass = 'col-md-9';
	    $hasR = 1;
	}elseif( $snssimen_layouttype == 'l-m-r' ){
	    $lclass .= 'col-md-3';
	    $rclass .= 'col-md-3';
	    $mclass = 'col-md-6';
	    $hasL = 1;
	    $hasR = 1;
	}else{
	    $mclass = 'col-md-12';
	}
}
?>
<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content sns-woocommerce-page">
			<?php if ($hasL == 1) :?>
			<!-- left sidebar -->
			<div class="<?php echo esc_attr($lclass); ?> sns-left">
			    <?php 
				if( snssimen_metabox('snssimen_leftsidebar')!= '' && is_active_sidebar( snssimen_metabox('snssimen_leftsidebar') ) ){
			        dynamic_sidebar( snssimen_metabox('snssimen_leftsidebar') );
			    }else{
			        dynamic_sidebar( 'woo-sidebar' );
			    }
			    ?>
			</div>
		<?php endif; ?>
			<!-- Main content -->
			<div class="<?php echo esc_attr($mclass); ?> sns-main">
			    <?php
		    	if( is_product() ){
					wc_get_template( 'single-product.php' );
				}else{
					wc_get_template( 'listing-product.php' );
				}
				?>
			</div>
			<?php if ($hasR == 1): ?>
			<!-- Right sidebar -->
			<div class="<?php echo esc_attr($rclass); ?> sns-right">
			    <?php 
			    if( snssimen_metabox('snssimen_rightsidebar')!= '' && is_active_sidebar( snssimen_metabox('snssimen_rightsidebar') ) ){
			        dynamic_sidebar( snssimen_metabox('snssimen_rightsidebar') );
			    }else{
			        dynamic_sidebar( 'woo-sidebar' );
			    }
			    ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>