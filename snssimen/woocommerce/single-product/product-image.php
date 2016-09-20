<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;
wp_enqueue_script('owlcarousel');
?>
<div class="images">

	<?php
		if ( has_post_thumbnail() ) {
			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );

			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'id'	 => 'sp_mainimage',
				'class'	 => 'attachment-shop_single size-shop_single wp-post-image',
				'title'	 => $image_title,
				'alt'    => $image_title,
			) );
			
			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			} ?>
			<div class="mainimage-wrap">
			<?php
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );
			?>
				<div class="popup-btn-wrap">
					<a class="btn sns-btn-popup" data-rel="prettyPhoto[product-gallery]" href="#" data-toggle="tooltip" data-original-title="<?php echo esc_html__( 'Zoom','snssimen' ); ?>"><i class="fa fa-search"></i></a>
					<?php if(  get_post_meta( $post->ID, 'snssimen_product_video', true ) ): ?>
					<a class="btn sns-btn-popupvideo" data-rel="prettyPhoto[product-gallery]" href="<?php echo get_post_meta( $post->ID, 'snssimen_product_video', true ) ?>" data-toggle="tooltip" data-original-title="<?php echo esc_html__( 'Video','snssimen' ); ?>"><i class="fa fa-youtube-play"></i></a>
					<?php endif; ?>
				</div>
			</div>
			<?php
		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="mainimage-wrap"><img src="%s" alt="%s" /></div>', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'snssimen' ) ), $post->ID );

		}
	?>
	<div class="sns-thumbnails handle-preload">
		<div id="sns_thumbs" class="thumbnails">
		<?php
		if ( has_post_thumbnail() ) {
			$image_thumb       = wp_get_attachment_image( get_post_thumbnail_id(), 'shop_thumbnail' );
			echo( '<a href="'.$image_link.'" class="elevatezoom-gallery zoom active cloned" title="'.$image_caption.'" data-image="'.$image_link.'" data-zoom-image="'.$image_link.'" data-rel="prettyPhoto[product-gallery]">'.$image_thumb.'</a>' );
		}
			do_action( 'woocommerce_product_thumbnails' ); 
		?>
		</div>
		<div class="navslider">
			<span class="prev"><i class="fa fa-long-arrow-right"></i></span>
			<span class="next"><i class="fa fa-long-arrow-left"></i></span>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			// Lightbox
			jQuery('.sns-thumbnails').append('<div id="sns_thumbs_clone" style="display:none">'+jQuery('.sns-thumbnails #sns_thumbs').html()+'</div>');
			elements = "#sns_thumbs_clone > a.zoom:not(.cloned)";
			if( jQuery('.sns_main_products .sns-btn-popup').length && jQuery('.sns_main_products a.woocommerce-main-image').length ){
				jQuery('.sns_main_products .sns-btn-popup').attr('href', jQuery('.sns_main_products a.woocommerce-main-image').attr('href') );
				elements = elements + ", .sns_main_products .sns-btn-popup";
				jQuery('.sns_main_products a.woocommerce-main-image').click(function(){
					return false;
				});
			}
			<?php if(  get_post_meta( $post->ID, 'snssimen_product_video', true ) ) : ?>
			elements = elements + ", .sns_main_products .sns-btn-popupvideo";
			<?php endif; ?>
			jQuery(elements).prettyPhoto({
				hook: 'data-rel',
				social_tools: false,
				theme: 'pp_woocommerce',
				horizontal_padding: 20,
				opacity: 0.8,
				deeplinking: false
			});
			// Carousel Gallery
			<?php if ( $attachment_count >= 2) : ?>
			jQuery('.sns-thumbnails #sns_thumbs').owlCarousel({
				items: 4,
				responsive : {
				    0 : { items: 1 },
				    480 : { items: 3 },
				    768 : { items: 2 },
				    992 : { items: 4 },
				    1200 : { items: 4 }
				},
				loop:true,
	            dots: false,
	            onInitialized: callback,
	            slideSpeed : 800
			});
			function callback(event) {
				console.log(this._items.length);
				console.log(this.options.items);
	   			if(this._items.length > this.options.items){
			        jQuery('.sns-thumbnails .navslider').show();
			    }else{
			        jQuery('.sns-thumbnails .navslider').hide();
			    }
			    
			}
			jQuery('.sns-thumbnails .prev').on('click', function(e){
				e.preventDefault();
				jQuery('.sns-thumbnails .thumbnails').trigger('prev.owl.carousel');
			});
			jQuery('.sns-thumbnails .next').on('click', function(e){
				e.preventDefault();
				jQuery('.sns-thumbnails .thumbnails').trigger('next.owl.carousel');
			});
			<?php endif; ?>
		});
		<?php if ( snssimen_get_option('woo_usecloudzoom') ) : 
			$woo_zoomtype = get_post_meta( get_the_id(), 'snssimen_woo_zoomtype', true );
			if($woo_zoomtype == '')
				$woo_zoomtype = snssimen_get_option('woo_zoomtype');
		?>
		jQuery(window).load(function(){
			jQuery('#sp_mainimage').elevateZoom({
				zoomType : "<?php echo $woo_zoomtype ?>",
				<?php if ( $woo_zoomtype == 'lens' ): ?>
				lensShape : "round", lensSize : 200,
				<?php endif; ?>
				<?php if ( $woo_zoomtype == 'inner' ): ?>
				cursor: "crosshair",
				<?php endif; ?>
				zoomWindowWidth: 500,
				zoomWindowHeight: 550,
				zoomWindowOffetx: 1,
				zoomWindowOffety: -0.5,
				gallery:'sns_thumbs',
				galleryActiveClass: 'active',
				imageCrossfade: true,
				responsive:true
				
			});
		});
		<?php endif; ?>
	</script>
</div>
