<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) :
wp_enqueue_script('owlcarousel');
?>

	<div class="related products">

		<h2><span><?php _e( 'Related Products', 'snssimen' ); ?></span></h2>
		<div class="navslider">
			<span class="prev"><i class="fa fa-long-arrow-left"></i></span>
			<span class="next"><i class="fa fa-long-arrow-right"></i></span>
		</div>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.related ul').owlCarousel({
					items: 4,
					responsive : {
					    0 : { items: 1 },
					    480 : { items: 2 },
					    768 : { items: 3 },
					    992 : { items: 4 },
					    1200 : { items: 4 }
					},
					loop:true,
		            dots: false,
		            // animateOut: 'flipInY',
				    //animateIn: 'pulse',
				    autoplay: true,
		            onInitialized: callback,
		            slideSpeed : 800
				});
				function callback(event) {
		   			if(this._items.length > this.options.items){
				        jQuery('.related .navslider').show();
				        jQuery('.related').addClass('has-nav');
				    }else{
				        jQuery('.related .navslider').hide();
				        jQuery('.related').removeClass('has-nav');
				    }
				}
				jQuery('.related .navslider .prev').on('click', function(e){
					e.preventDefault();
					jQuery('.related ul').trigger('prev.owl.carousel');
				});
				jQuery('.related .navslider .next').on('click', function(e){
					e.preventDefault();
					jQuery('.related ul').trigger('next.owl.carousel');
				});
			});
		</script>
	</div>

<?php endif;

wp_reset_postdata();
