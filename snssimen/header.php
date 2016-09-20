<?php 
global $snssimen_headerLayout, $snssimen_topHeaderSidebar;
$snssimen_headerLayout = snssimen_get_option('header_layout', 'layout_1');
$snssimen_topHeaderSidebar = snssimen_get_option('header_sidebar', 'header_sidebar'); // hide in header layout transparent

// Get page config
$page_config = false;
if( get_post_meta(get_the_ID(), 'snssimen_header_layout', true) !='' ){
	$snssimen_headerLayout = get_post_meta(get_the_ID(), 'snssimen_header_layout', true);
	$snssimen_topHeaderSidebar = get_post_meta(get_the_ID(), 'snssimen_header_sidebar', true);
	$page_config = true;
}

$sns_header_layout_class = 'sns_header_' . $snssimen_headerLayout;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class( esc_attr($sns_header_layout_class) ); ?>>
	<div id="sns_wrapper" class="sns-container">
<?php
if( (is_front_page() && snssimen_get_option('header_layout', 'layout_1') ==  'layout_2') || ($page_config && $snssimen_headerLayout == 'layout_2')){
	get_template_part('tpl-head-transparent'); // Template for layout 2 (transparent) called
}else{
	get_template_part('tpl-head'); // Template for layout 1 & layout 3 called
}
?>