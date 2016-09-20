<?php
wp_enqueue_style('slick');
wp_enqueue_script('slick');
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
if( class_exists('WooCommerce') ){
	global $woocommerce;
	$woo_categories = get_woocommerce_categories();
	
	$uq = rand().time();
	$class = 'sns-featured-categories woocommerce';
	$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
	$class .= esc_attr($this->getCSSAnimation( $css_animation ));
	ob_start();
	?>
	<div id="sns-featured-categories<?php echo esc_attr( $uq ); ?>" class="<?php echo esc_attr($class); ?>" >
		<div class="sns_featured_cat_heading">
			<h2 class="wpb_heading"><span><?php echo esc_html($title); ?></span></h2>
			<div class="navslider"><span class="prev"><i class="fa fa-long-arrow-left"></i></span><span class="next"><i class="fa fa-long-arrow-right"></i></span></div>
		</div>
		<div class="sns-featured-cat">
		<?php
		foreach ($woo_categories as $woo_cat){
			$featured_cat = get_woocommerce_term_meta($woo_cat->term_id, 'sns_product_cat_featured');
			if($featured_cat == 'yes'){ // is_featured
				// get category thumbnail id
				$thumbnail_id  = get_woocommerce_term_meta($woo_cat->term_id, 'thumbnail_id', true);
				if($thumbnail_id == '')
					$thumbnail_id  = get_woocommerce_term_meta($woo_cat->term_id, 'snscustom_product_cat_thumbnail_id', true);
				
				
				$cat_thumbnail = wp_get_attachment_image_src($thumbnail_id, 'full');
				$image = isset($cat_thumbnail[0]) ? $cat_thumbnail[0] : wc_placeholder_img_src();
				?>
				<div class="slick-item"><div class="cat-feature-img"><a href="<?php echo esc_url(get_term_link($woo_cat, 'product_cat'));?>" title="<?php echo esc_attr( $woo_cat->name );?>"><img src="<?php echo esc_attr($image); ?>" alt="<?php echo esc_attr( $woo_cat->name ); ?>"/><span class="view_more"><?php esc_html_e('View now', 'snssimen')?></span><span class="featured-cat-title"><?php echo esc_html($woo_cat->name); ?></span><div class="thumb-gradient"></div></a></div></div>
				<?php
			}
		}
		?>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#sns-featured-categories<?php echo $uq;?> .sns-featured-cat').slick({
			slidesToShow: <?php echo (int)$number_display?>,
			slidesToScroll: 1,
			centerMode: true,
			centerPadding: '60px',
			arrows: false,
			responsive: [
             {
               breakpoint: 768,
               settings: {
            	 arrows: false,
                 centerMode: true,
                 centerPadding: '40px',
                 slidesToShow: 3
               }
             },
             {
               breakpoint: 480,
               settings: {
                 arrows: false,
                 centerMode: true,
                 centerPadding: '40px',
                 slidesToShow: 1
               }
             }
           ]
		});
		
		jQuery('#sns-featured-categories<?php echo $uq;?> .navslider .prev').on('click', function(e){
			e.preventDefault();
			jQuery('#sns-featured-categories<?php echo $uq;?> .sns-featured-cat').slick('slickPrev');
		});
		jQuery('#sns-featured-categories<?php echo $uq;?> .navslider .next').on('click', function(e){
			e.preventDefault();
			jQuery('#sns-featured-categories<?php echo $uq;?> .sns-featured-cat').slick('slickNext');
		});
	});
	</script>
	<?php
	$output .= ob_get_clean();
}
echo $output;
