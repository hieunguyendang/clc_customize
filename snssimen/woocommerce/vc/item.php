<?php
global $product, $woocommerce_loop, $yith_woocompare;
?>
<div class="item_product">
	<div class="block-product-inner grid-view">
		<div class="item-inner">
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<div class="item-info have-iconew have-additional clearfix">
				<div class="item-img-info-left">
					<a class="product-image" href="<?php the_permalink(); ?>">
						<?php
							/**
							 * woocommerce_before_shop_loop_item_title hook
							 *
							 * @hooked woocommerce_show_product_loop_sale_flash - 10
							 * @hooked woocommerce_template_loop_product_thumbnail - 10
							 */
							do_action( 'woocommerce_before_shop_loop_item_title' );
						?>
					</a>
				</div>
				<div class="item-info-right">
					<div class="info-inner">
						<h3 class="item-title"><a class="product-name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="item-content">
							<?php
								/**
								 * woocommerce_after_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_template_loop_rating - 5
								 * @hooked woocommerce_template_loop_price - 10
								 */
								remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
								remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
								// Re-order
								add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
								add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);
								do_action( 'woocommerce_after_shop_loop_item_title' );
							?>
						</div>
					</div>
					<div class="cart-wrap">
						<?php
							/**
							 * woocommerce_after_shop_loop_item hook
							 *
							 * @hooked woocommerce_template_loop_add_to_cart - 10
							 */
							if ( class_exists('YITH_WCQV_Frontend') ) {
								remove_action('woocommerce_after_shop_loop_item',  array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
							}
							if ( isset($yith_woocompare) ) {
							    remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
							}
							do_action( 'woocommerce_after_shop_loop_item' ); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>