<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
if( class_exists('WooCommerce') ){
	global $woocommerce;
	$loop = snssimen_woo_query($type, $number_limit);
	$template = !empty($template) ? $template : '1';
	
	$uq = rand().time();
	$class = 'sns-products woocommerce';
	$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
	$class .= esc_attr($this->getCSSAnimation( $css_animation ));
	if($template == '1'){ // Template carousel
		wp_enqueue_script('owlcarousel');
		if($row == '2') $class .= ' sns-products-style-two';
		if( $loop->have_posts() ) :
		$output .= '<div id="sns_products'.$uq.'" class="'.$class.'">';
		if ( $title != '' ) $output .= '<h2 class="wpb_heading"><span>'.esc_attr($title).'</span></h2>';
		$output .= '<div class="navslider"><span class="prev"><i class="fa fa-long-arrow-left"></i></span><span class="next"><i class="fa fa-long-arrow-right"></i></span></div>';
		
		ob_start();
		wc_get_template( 'vc/carousel.php', array('loop' => $loop, 'number_display' => $number_display,'row' => $row, 'id' => 'sns_products'.$uq) );
		$output .= ob_get_clean();
		$output .= '</div>';
		endif;
	}else{ // Template list of products
		$class .= ' sns-products-list '; 
		if( $loop->have_posts() ) :
			$output .= '<div id="sns_products-list'.$uq.'" class="'.$class.'">';
			$title = !empty($title) ? $title : 'Product list';
			$output .= '<h2 class="sns_products-list_heading"><span>'.esc_attr($title).'</span></h2>';
			$output .= '<div class="products-list">';
			ob_start();
				while ( $loop->have_posts() ) : $loop->the_post();
				    	wc_get_template( 'vc/item.php' );
				endwhile;
			$output .= ob_get_clean();
			$output .= '</div>';
			$output .= '</div>';
		endif;
	}
	
	wp_reset_postdata();
}
echo $output;
