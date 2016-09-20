<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_script('owlcarousel');

global $post, $woocommerce, $product;

?>
<div class="imgs-quick">
	<div class="images">
	<?php
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<span class="quickview-image" title="%s">%s</span>', $image_title, $image ), $post->ID );
		}
		$attachment_ids = $product->get_gallery_attachment_ids();
		if ( $attachment_ids ) :
			foreach ( $attachment_ids as $attachment_id ) {
				$image_title = esc_attr( get_the_title( $attachment_id ) );
				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
				
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<span class="quickview-image" title="%s">%s</span>', $image_title, $image ), $post->ID );
			}
		endif;
	?>
	</div>
	<div class="navslider" style="display:none">
		<span class="prev"><i class="arrow_carrot-left"></i></span>
		<span class="next"><i class="arrow_carrot-right"></i></span>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.sns-quick-view .images').owlCarousel({
				items: 1,
				loop:true,
	            dots: false,
	            // animateOut: 'flipInY',
			    //animateIn: 'pulse',
			    // autoplay: true,
	            onInitialized: callback,
	            slideSpeed : 800
			});
			function callback(event) {
	   			if(this._items.length > this.options.items){
			        jQuery('.sns-quick-view .navslider').show();
			    }else{
			        jQuery('.sns-quick-view .navslider').hide();
			    }
			}
			jQuery('.sns-quick-view .prev').on('click', function(e){
				e.preventDefault();
				jQuery('.sns-quick-view .images').trigger('prev.owl.carousel');
			});
			jQuery('.sns-quick-view .next').on('click', function(e){
				e.preventDefault();
				jQuery('.sns-quick-view .images').trigger('next.owl.carousel');
			});
		});
	</script>
</div>
