<?php
/**
 * SNS Get theme options - post meta.
 * This function to get the options in theme option and the page config.
 * The option in page config will priority than the option in theme option if set.
 * 
 * @param string $option ID of the option to get. Required.
 * @param string|int|null $default Return to default value. Optional.
 * @param string $key. Enter the key if the $option is an array. Default leave blank. Optional.
 * 					   This only support for theme option.
 * 
 * @return the value of theme option or page config. If the page config leave blank or "def" return theme option.
 */
function snssimen_get_option($option, $default = '', $key = ''){
	global $snssimen_obj;
	
	return $snssimen_obj->getOption($option, $default, $key);
}

/*
 * get meta box data
 */
function snssimen_metabox($field_id, $args = array()){
	if( !function_exists('rwmb_meta') ){
		return '';
	}
	if( function_exists('is_shop') && is_shop() ) {
		return rwmb_meta($field_id, $args, get_option('woocommerce_shop_page_id'));
	}
	return rwmb_meta($field_id, $args);
}

/**
 * return number of published sticky posts
 */
function snssimen_get_sticky_posts_count(){
	global $wpdb;
	$sticky_posts = array_map('absint', (array)get_option('sticky_posts') );
	return count($sticky_posts) > 0 ? $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( 1 ) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND ID IN (".implode(',', $sticky_posts).")" ) ) : 0;
}

/**
 * Display Ajax loading
 * 
 * @param $content_div (string) ID of the DIV which contains items
 * @param $template (string) Name of the template file hold HTML for a single item.
 */
function snssimen_paging_nav_ajax( $content_div = '#snsmain', $template = '' ){
	// Don't print empty markup if there is only one page.
	if( $GLOBALS['wp_query']->max_num_pages < 2 ){
		return;
	}
	
	?>
	<nav class="navigation-ajax" role="navigation">
		<a href="javascript:void(0)" data-target="<?php echo esc_attr($content_div);?>" data-template="<?php echo esc_attr( $template ); ?>" id="navigation-ajax" class="load-more">
			<span><?php echo esc_html__('Load more', 'snssimen');?></span>
			<div class="sns-navloading"><div class="sns-navloader"></div></div>
		</a>
	</nav>
	<?php
}

/*
 * snssimen_featured_image_shop_page hook
 */
add_filter('snssimen_featured_image_shop_page', 'snssimen_featured_image_shop_page');
function snssimen_featured_image_shop_page(){
	global $post;
	$page_id = '';
	if( is_shop() ){
		$page_id = woocommerce_get_page_id('shop');
		// Check has post thumbnai
		if(has_post_thumbnail($page_id)): // return html featured image shop page
		?>
			<div class="sns-shop-page-thumbnail"><?php echo get_the_post_thumbnail($page_id, 'full')?></div>
		<?php
		endif;
	}
}