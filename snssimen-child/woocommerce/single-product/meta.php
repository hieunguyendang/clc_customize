<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>
	<?php
		$languages = get_the_term_list( get_the_ID(), 'languages','',', ', '' );
		if($languages != null){
			echo '<span class="product-custom-field-title">Language:  </span>'.$languages;	
			echo '<br>';
		}									
	?>

	<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>
	<?php
		if(get_post_meta( get_the_ID(),'author', true ) != null){
			echo '<span class="product-custom-field-title">Author:  </span>'.get_post_meta( get_the_ID(),'author', true );
			echo '<br>';
		}
		if(get_post_meta( get_the_ID(),'number_of_pages', true) != null){
			echo '<span class="product-custom-field-title">Number of Pages:  </span>'.get_post_meta(get_the_ID(),'number_of_pages', true);	
			echo '<br>';
		}
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
