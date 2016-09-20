<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div id="sns_tab_products" class="product-collateral clearfix">
		<ul class="nav-tabs gfont">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>" data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
			<?php if ( is_active_sidebar( 'product-tab-sidebar' ) ) : ?>
				<li class="sns_prod_custom_tab">
					<a href="#tab-sns_prod_custom_tab" data-toggle="tab"><?php echo esc_html__('Custom Tab', 'snssimen'); ?></a>
				</li>
			<?php endif; ?>
		</ul>
		<div class="tab-content">
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div class="tab-pane fade" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>

		<?php endforeach; ?>
			<?php if ( is_active_sidebar( 'product-tab-sidebar' ) ) : ?>
				<div class="tab-pane fade" id="tab-sns_prod_custom_tab">
					<?php dynamic_sidebar( 'product-tab-sidebar' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<script>
        	jQuery(document).ready(function($){
        		if ( window.location.href.indexOf('#comments') > 0 ) {
        			$('#sns_tab_products .nav-tabs').find("li.reviews_tab").addClass("active");
	        		$('#sns_tab_products .tab-content').find("#tab-reviews").addClass("active in");
        		}else{
	        		$('#sns_tab_products .nav-tabs').find("li").first().addClass("active");
	        		$('#sns_tab_products .tab-content').find(".tab-pane").first().addClass("active in");
	        	}
	        	if($(window).width() < 992){
	        		$('#sns_tab_products .nav-tabs').tabdrop();
	        	}
	       	});
		</script>
	</div>

<?php endif; ?>
