<?php
$col_class = '';
$show_bottom_fullwidth_sidebar = false;
if( snssimen_metabox('snssimen_showbottomfullsidebar') == 1 ){
	$show_bottom_fullwidth_sidebar = true; // Display bottom fullwidt sidebar
}

?>
	<?php if( is_active_sidebar('bottom_sidebar') && !is_404()):?>
	<div id="sns_bottom_sidebar" class="wrap">
		<div class="container">
			<div class="row">
			<?php dynamic_sidebar('bottom_sidebar'); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if( is_active_sidebar('bottom_fullwidth_sidebar') && ( is_front_page() || $show_bottom_fullwidth_sidebar ) ): ?>
	<div id="sns_bottom_fullwidth_sidebar">
		<div class="row">
			<?php dynamic_sidebar('bottom_fullwidth_sidebar'); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if( is_active_sidebar( 'Footer Widgets' ) ) : ?>
	<div id="sns_footer_middle" class="wrap">
		<div class="container">
			<div class="row">
	          <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widgets')) : ?><?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
    <div id="sns_footer" class="sns-footer">
		<div class="container">
			<?php $payment_img = snssimen_get_option('payment_img','','url'); ?>
			<?php if ( isset( $payment_img ) && $payment_img != '' ) :
			$col_class = 'col-md-6 col-md-pull-6'; ?>
			<div class="payment-logo col-md-6  col-md-push-6">
				<div class="inner">
					<img src="<?php echo esc_attr( $payment_img ); ?>" alt="<?php echo esc_html__('Payment method', 'snssimen'); ?>"/>
				</div>
			</div>
			<?php endif; ?>
			
			<?php 
			if ( has_nav_menu( 'footer_navigation' ) ) :
                wp_nav_menu( array(
                        'theme_location'    => 'footer_navigation',
                        'depth'             => 1,
                        'container'         => 'div',
                        'container_class'   => 'sns-info clearfix',
                        'menu_class'        => 'links',
                        'menu_id'			=> 'footer_links'
                ));
            endif;
            ?>
			<div class="sns-copyright <?php echo esc_attr( $col_class ); ?>">
				<?php $copyright = snssimen_get_option('copyright'); ?>
				<?php echo ( isset( $copyright ) && $copyright !='' ) ? wp_kses($copyright, array(
										'a' => array(
											'href' => array(),
											'class' => array(),
											'data-original-title' => array(),
											'data-toggle' => array(),
											'title' => array()
										),
										'img' => array(
											'src' => array(),
											'alt' => array(),
											'class' => array(), 
										),
										)) : esc_html__('Designed by SNSTheme.Com', 'snssimen'); ?>
			</div>
			
		</div>
    </div>
    <?php 
    $advance_scrolltotop = snssimen_get_option('advance_scrolltotop', 1);
    $advance_cpanel = snssimen_get_option('advance_cpanel', 0);
    ?>
    <?php if ( $advance_scrolltotop == 1 || $advance_cpanel == 1 ) : ?>
    <div id="sns_tools">
    	<?php 
		if ( $advance_scrolltotop == 1 ) : 
			get_template_part( 'tpl-scrolltotop');
		endif;
		if ( $advance_cpanel == 1 ) : 
			get_template_part( 'tpl-cpanel');
		endif;
		?>
	</div>
	<?php endif; ?>
</div>
<!-- end main container -->
<?php wp_footer(); ?>
</body>
</html>