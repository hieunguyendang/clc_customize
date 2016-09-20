<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
global $post, $woocommerce, $product;

while ( have_posts() ) : the_post(); ?>

<div class="primary_block row sns-quick-view">
	<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-img col-md-5 col-sm-6">
			<div class="inner">
		<?php
			//add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			add_action( 'woocommerce_before_single_product_summary', 'snssimen_woo_images_quickview', 20 );
			do_action( 'woocommerce_before_single_product_summary' );
		?>
			</div>
		</div>
		<div class="summary entry-summary col-md-7 col-sm-6">
			<div class="inner">
			<?php do_action( 'woocommerce_single_product_summary' ); ?>
			</div>
		</div>

	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.sns-quick-view a').click(function(){
				return;
			})
		});
	</script>
</div>

<?php endwhile; // end of the loop.