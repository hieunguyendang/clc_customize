<?php

define( 'SNSSIMEN_THEME_DIR', get_template_directory() );
define( 'SNSSIMEN_THEME_URI', get_template_directory_uri() );

// Require framework
require_once( SNSSIMEN_THEME_DIR.'/framework/init.php' );
/** 
 *	Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 **/
add_action( 'vc_before_init', 'snssimen_vcSetAsTheme' );
function snssimen_vcSetAsTheme() {
	vc_set_as_theme(true);
}
// Initialising Visual shortcode editor
 if (class_exists('WPBakeryVisualComposerAbstract')) {
 	function requireVcExtend(){
 		include_once( get_template_directory().'/vc_extend/extend-vc.php');
 	}
 	add_action('init', 'requireVcExtend', 2);
 }
/** 
 *	Width of content, it's max width of content without sidebar.
 **/
if ( ! isset( $content_width ) ) { $content_width = 660; }

/** 
 *	Set base function for theme.
 **/
if ( ! function_exists( 'snssimen_setup' ) ) {
    function snssimen_setup() {
    	// Load default theme textdomain.
        load_theme_textdomain( 'snssimen' , SNSSIMEN_THEME_DIR . '/languages' );
		// Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
		// Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        // Add title-tag, it auto title of head
        add_theme_support( 'title-tag' );
        // Enable support for Post Formats.
        add_theme_support( 'post-formats',
            array(
                'video', 'audio', 'quote', 'link', 'gallery'
            )
        );
        
        // Register images size
        add_image_size('snssimen_megamenu_thumb', 250, 150, true);
        add_image_size('snssimen_blog_grid2_thumbnail_size', 570,320, true); // blog fullwidth layout 2
        add_image_size('snssimen_blog_grid3_thumbnail_size', 370,210, true); // blog fullwidth layout 3
        add_image_size('snssimen_latest_posts', 370, 190, true);
        add_image_size('snssimen_search_thumbnail_size', 350, 350, false);
        add_image_size('snssimen_testimonial_avatar', 120, 120, true);
        add_image_size('snssimen_product_tabs_thumbnail', 130, 110, false);

        add_image_size('snssimen_attribute_pa_images_size', 60, 60, false);
        
		//Setup the WordPress core custom background & custom header feature.
         $default_background = array(
            'default-color' => '#FFF',
        );
        add_theme_support( 'custom-background', $default_background );
        $default_header = array();
        add_theme_support( 'custom-header', $default_header );
        // Register navigations
	    register_nav_menus( array(
	    	'top_navigation'  => esc_html__( 'Top navigation', 'snssimen' ),
			'main_navigation' => esc_html__( 'Main navigation', 'snssimen' ),
		) );
    }
    add_action ( 'init', 'snssimen_setup' ); // or add_action( 'after_setup_theme', 'snssimen_setup' );
}
add_action( 'after_setup_theme', 'snssimen_woocommerce_support' );
function snssimen_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_filter( 'body_class', 'snssimen_bodyclass' );
function snssimen_bodyclass( $classes ) {
    if ( snssimen_get_option('use_boxedlayout', 0) == 1) {
        $classes[] = 'boxed-layout';
    }
    
    if( snssimen_get_option('advance_tooltip',1) ){
        $classes[] = 'use-tooltip';
    }
    
    if( snssimen_get_option('use_stickmenu') == 1){
        $classes[] = 'use_stickmenu';
    }
    if( snssimen_get_option('use_logocolor', 0) == 1){
        $classes[] = 'use_logocolor';
    }
    if ( snssimen_get_option('woo_uselazyload') == 1 ){
        $classes[] = 'use_lazyload';
    }

    return $classes;
}
function snssimen_widgetlocations(){
    // Register widgetized locations
    if(function_exists('register_sidebar')) {
        register_sidebar(array(
           'name' => esc_html__( 'Main Area','snssimen' ),
           'id'   => 'widget-area',
            'description'   => esc_html__( 'These are widgets for the Widget Area.','snssimen' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));

        register_sidebar(array(
           'name' => esc_html__( 'Top Header Left Sidebar','snssimen' ),
           'id'   => 'topheader_left',
            'description'   => esc_html__( 'These are widgets for the Header Top Left.','snssimen' ),
            'before_widget' => '<div class="topheader_left-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="hidden">',
            'after_title'   => '</h4>'
        ));

        register_sidebar(array(
           'name' => esc_html__( 'Header Sidebar','snssimen' ),
           'id'   => 'header_sidebar',
            'description'   => esc_html__( 'These are widgets for the Header Top sidebar. Only display on Header Layout 1 and Layout 3.','snssimen' ),
            'before_widget' => '<div class="header-right-widget col-md-4 col-sm-4 col-xs-4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));
        
        register_sidebar(array(
	        'name' => esc_html__( 'Menu Sidebar #1','snssimen' ),
	        'id'   => 'menu_sidebar_1',
	        'description'   => esc_html__( 'These are widgets for Mega Menu Columns style. This sidebar displayed in the right of column.','snssimen' ),
	        'before_widget' => '<div class="sidebar-menu-widget %2$s">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>'
        ));
        
        register_sidebar(array(
	        'name' => esc_html__( 'Menu Sidebar #2','snssimen' ),
	        'id'   => 'menu_sidebar_2',
	        'description'   => esc_html__( 'These are widgets for Mega Menu Columns style. This sidebar displayed in the bottom of column.','snssimen' ),
	        'before_widget' => '<div class="sidebar-menu-widget col-md-6 %2$s">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>'
        ));
        
        register_sidebar(array(
           'name' => esc_html__( 'Bottom Sidebar','snssimen' ),
           'id'   => 'bottom_sidebar',
            'description'   => esc_html__( 'These are widgets for the Bottom sidebar.','snssimen' ),
            'before_widget' => '<div id="%1$s" class="widget bottom-sidebar %2$s col-md-12">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ));
        
        register_sidebar(array(
	        'name' => esc_html__( 'Bottom Fullwidth Sidebar','snssimen' ),
	        'id'   => 'bottom_fullwidth_sidebar',
	        'description'   => esc_html__( 'These are widgets for the Bottom fullwidth sidebar. This sidebar only show in Front page.','snssimen' ),
	        'before_widget' => '<div id="%1$s" class="widget %2$s col-md-12">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h3 class="widget-title"><span>',
	        'after_title'   => '</span></h3>'
        ));
        
        register_sidebar(array(
           'name' => esc_html__( 'Footer Widgets','snssimen' ),
           'id'   => 'footer-widgets',
            'description'   => esc_html__( 'These are widgets for the Footer.','snssimen' ),
            'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s col-md-15 col-sm-6">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));

        register_sidebar(
            array(
            'name' => esc_html__( 'Right Sidebar','snssimen' ),
            'id' => 'right-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));

        register_sidebar(
            array(
            'name' => esc_html__( 'Right2 Sidebar','snssimen' ),
            'id' => 'right2-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));

        register_sidebar(
            array(
            'name' => esc_html__( 'Left Sidebar','snssimen' ),
            'id' => 'left-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));

        register_sidebar(
            array(
            'name' => esc_html__( 'Woo Sidebar','snssimen' ),
            'id' => 'woo-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));

        register_sidebar(
            array(
            'name' => esc_html__( 'Product Sidebar','snssimen' ),
            'id' => 'product-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
        register_sidebar(
            array(
            'name' => esc_html__( 'Product Tab Sidebar','snssimen' ),
            'id' => 'product-tab-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
    }
}
add_action( 'widgets_init', 'snssimen_widgetlocations' );
/** 
 *	Add styles & scripts
 **/
function snssimen_scripts() {
	global $snssimen_obj;
    $optimize = '.min';
    
    wp_enqueue_style('owlcarousel', SNSSIMEN_THEME_URI . '/assets/css/owl.carousel.min.css');
    wp_register_style('slick', SNSSIMEN_THEME_URI . '/assets/slick/slick.min.css');
	// Enqueue style
	$css_file = $snssimen_obj->theme_css_file();
	wp_enqueue_style('bootstrap', SNSSIMEN_THEME_URI . '/assets/css/bootstrap.min.css');
	wp_enqueue_style('fonts-awesome', SNSSIMEN_THEME_URI . '/assets/fonts/awesome/css/font-awesome.min.css', array(), '4.5.0', false);
    wp_enqueue_style('fonts-awesome-animation', SNSSIMEN_THEME_URI . '/assets/fonts/awesome/css/font-awesome-animation.min.css');
    wp_enqueue_style('ie9', SNSSIMEN_THEME_URI . '/assets/css/ie9.css');
	wp_enqueue_style('snssimen-woocommerce', SNSSIMEN_THEME_URI . '/assets/css/woocommerce'.$optimize.'.css');
	wp_enqueue_style('snssimen-theme-style', SNSSIMEN_THEME_URI . '/assets/css/' . $css_file);
	
	wp_register_script('owlcarousel', SNSSIMEN_THEME_URI . '/assets/js/owl.carousel.min.js', array('jquery'), '', true);
	wp_register_script('masonry', SNSSIMEN_THEME_URI . '/assets/js/masonry.pkgd.min.js', array('jquery'), '', true);
	wp_register_script('imagesloaded', SNSSIMEN_THEME_URI . '/assets/js/imagesloaded.pkgd.min.js', array('jquery'), '', true);
	wp_register_script('slick', SNSSIMEN_THEME_URI . '/assets/slick/slick.min.js', array('jquery'), '', true);
	wp_register_script('countdown', SNSSIMEN_THEME_URI . '/assets/countdown/jquery.countdown.min.js', array('jquery'), '2.1.0', true);
	
    // Enqueue scripts
    wp_enqueue_script('bootstrap', SNSSIMEN_THEME_URI . '/assets/js/bootstrap.min.js', array('jquery'), '', true);
    wp_enqueue_script('jqtransform', SNSSIMEN_THEME_URI . '/assets/js/bootstrap-tabdrop.min.js', array('jquery'), '', true);
    if( snssimen_get_option('woo_uselazyload') == 1 ) wp_enqueue_script('snssimen-lazyload', SNSSIMEN_THEME_URI . '/assets/js/jquery.lazyload'.$optimize.'.js', array(), '', true);
    if( snssimen_get_option('advance_smooth_scroll', 1) == 1 ) wp_enqueue_script('smooth-scroll', SNSSIMEN_THEME_URI . '/assets/js/smooth-scroll.min.js', array('jquery'), '', true);
    wp_enqueue_script('snssimen-script', SNSSIMEN_THEME_URI . '/assets/js/sns-script'.$optimize.'.js', array('jquery'), '', true);
    
    // Add style inline with option in admin theme option
    wp_add_inline_style('snssimen-theme-style', snssimen_cssinline());
    
    // Code to embed the javascript file that makes the Ajax request
    wp_enqueue_script('ajax-request', SNSSIMEN_THEME_URI . '/assets/js/ajax.js', array('jquery'));
    // Code to declare the URL to the file handing the AJAX request
    $js_params = array(
    	'ajaxurl' => admin_url( 'admin-ajax.php' )
    );
    global $wp_query, $wp;
    $js_params['query_vars'] = $wp_query->query_vars;
    $js_params['current_url'] = esc_url(home_url($wp->request));
    
    wp_localize_script('ajax-request', 'sns', $js_params);
    
}
add_action( 'wp_enqueue_scripts', 'snssimen_scripts' );

/*
 * Enqueue admin styles and scripts
 */
function snssimen_admin_styles_scripts(){
	wp_enqueue_style('snssimen_admin_style', SNSSIMEN_THEME_URI.'/admin/assets/css/admin-style.css');
	wp_enqueue_style( 'wp-color-picker' );
	
	wp_enqueue_media();
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script('snssimen_admin_template_js', SNSSIMEN_THEME_URI.'/admin/assets/js/admin_template.js', array( 'jquery', 'wp-color-picker' ), false, true);
}
add_action('admin_enqueue_scripts', 'snssimen_admin_styles_scripts');

// Editor style
add_editor_style('assets/css/editor-style.css');

/**
 * CSS inline
*/
function snssimen_cssinline(){
    global $snssimen_opt, $snssimen_obj;
    $inline_css = '';
    // Body style
    $bodycss = '';
    if ($snssimen_obj->getOption('use_boxedlayout') == 1) {
        if ($snssimen_opt['body_bg_type'] == 'pantern') {
        	$body_bg_type_pantern = snssimen_get_option('body_bg_type_pantern', '');
            $bodycss .= 'background-image: url('.SNSSIMEN_THEME_URI.'/assets/img/patterns/'.$body_bg_type_pantern.');';
        }elseif( $snssimen_opt['body_bg_type'] == 'img' ){
            $bodycss .= 'background-image: url('.$snssimen_opt['body_bg_type_img']['url'].');';
        }
    }
    if(isset($snssimen_opt['body_font']) && is_array($snssimen_opt['body_font'])) {
        $body_font = '';
        foreach($snssimen_opt['body_font'] as $propety => $value)
            if($value != 'true' && $value != 'false' && $value != '' && $propety != 'subsets')
                $body_font .= $propety . ':' . $value . ';';
        
        if($body_font != '') $bodycss .= $body_font;
    }
    $inline_css .= 'body {'.$bodycss.'}';
    // Selectors use google font
    if(isset($snssimen_opt['secondary_font_target']) && $snssimen_opt['secondary_font_target']) {
        if(isset($snssimen_opt['secondary_font']) && is_array($snssimen_opt['secondary_font'])) {
            $secondary_font = '';
            foreach($snssimen_opt['secondary_font'] as $propety => $value)
                if($value != 'true' && $value != 'false' && $value != '' && $propety != 'subsets')
                    $secondary_font .= $propety . ':' . $value . ';';
            
            if($secondary_font != '') $inline_css .= $snssimen_opt['secondary_font_target'] . ' {'.$secondary_font.'}';
        }
    }
    
    return $inline_css;
}

/*
 * Custom CSS theme
 */
if(!function_exists('snssimen_wp_head')){
	function snssimen_wp_head(){
		echo '<!-- Custom CSS -->
				<style type="text/css">';
			require get_template_directory() . '/assets/css/custom.css.php';
			
		echo '</style>
			<!-- end custom css -->';
	}
	add_action('wp_head', 'snssimen_wp_head', 1000);
}

/* 
 * Custom code
 */
if(!function_exists('snssimen_wp_foot')){
	function snssimen_wp_foot(){
		// write out custom code
		echo '<script type="text/javascript">';
		echo snssimen_get_option('advance_customjs','');
		echo '</script>';
	}
	add_action('wp_footer', 'snssimen_wp_foot', 100);
}

/** 
 *	Tile for page, post
 **/
function snssimen_pagetitle(){
	// Disable title in page
	if( is_page() && function_exists('rwmb_meta') && rwmb_meta('snssimen_showtitle') == '2' ) return;
	// Show title in page, single post
	if( is_single() || is_page() || ( is_home() && get_option( 'show_on_front' ) == 'page' ) ) : ?>
		<h1 class="page-header">
          <?php the_title(); ?>
        </h1>
    <?php 
    // Show title for category page
    elseif ( is_category() ) : ?>
        <h1 class="page-header">
          <?php single_cat_title(); ?>
        </h1>
    <?php
    // Author
    elseif ( is_author() ) : ?>
        <h1 class="page-header">
        <?php
            printf( esc_html__( 'All posts by: %s', 'snssimen' ), get_the_author() );
        ?>
        </h1>
        <?php if ( get_the_author_meta( 'description' ) ) : ?>
        <header class="archive-header">
            <div class="author-description"><p><?php the_author_meta( 'description' ); ?></p></div>
        </header>
        <?php endif; ?>
    <?php 
    // Tag
    elseif ( is_tag() ) : ?>
        <h1 class="page-header">
            <?php printf( esc_html__( 'Tag Archives: %s', 'snssimen' ), single_tag_title( '', false ) ); ?>
        </h1>
        <?php
        $term_description = term_description();
        if ( ! empty( $term_description ) ) : ?>
        <header class="archive-header">
            <?php printf( '<div class="taxonomy-description">%s</div>', $term_description ); ?>
        </header>
        <?php endif; ?>
    <?php 
    // Search
    elseif ( is_search() ) : ?>
    <h1 class="page-header"><?php printf( esc_html__( 'Search Results for: %s', 'snssimen' ), get_search_query() ); ?></h1>
    <?php
    // Archive
    elseif ( is_archive() ) : ?>
        <?php the_archive_title( '<h1 class="page-header">', '</h1>' ); ?>
        <?php
        if( get_the_archive_description() ): ?>
        <header class="archive-header">
            <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
        </header>
        <?php    
        endif;
        ?>
    <?php
    // Default
    else : ?>
        <h1 class="page-header">
          <?php the_title(); ?>
        </h1>
    <?php
	endif;
}


// Excerpt Function
if(!function_exists('snssimen_excerpt')){
    function snssimen_excerpt($limit, $afterlimit='...') {
        $limit = ($limit) ? $limit : 55 ;
        $excerpt = get_the_excerpt();
        if( $excerpt != '' ){
           $excerpt = explode(' ', strip_tags( $excerpt ), intval($limit));
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), intval($limit));
        }
        if ( count($excerpt) >= $limit ) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

/*
 * Ajax page navigation
 */
function snssimen_ajax_load_next_page(){
	// Get current layout
	global $snssimen_blog_layout;
	$snssimen_blog_layout = isset($_POST['snssimen_blog_layout']) ? esc_html($_POST['snssimen_blog_layout']) : '';
	if( $snssimen_blog_layout == '' ) $snssimen_blog_layout = snssimen_get_option('blog_type');
	
	// Get current page
	$page = $_POST['page'];
	
	// Number of published sticky posts
	$sticky_posts = snssimen_get_sticky_posts_count();
	
	// Current query vars
	$vars = $_POST['vars'];
	
	// Convert string value into corresponding data types
	foreach ($vars as $key => $value){
		if( is_numeric($value) ) $vars[$key] = intval($value);
		if( $value == 'false' ) $vars[$key] = false;
		if( $value == 'true' ) $vars[$key] = true;
	}
	
	// Item template file 
	$template = $_POST['template'];
	
	// Return next page
	$page = intval($page) + 1;
	
	$posts_per_page = get_option('posts_per_page');
	
	if( $page == 0 ) $page = 1;
	$offset = ($page - 1) * $posts_per_page;
	/*
	 * This is confusing. Just leave it here to later reference
	 *
	
	 if(!$vars['ignore_sticky_posts']){
	 $offset += $sticky_posts;
	 }
	 *
	 */
	
	// Get more posts per page than necessary to detect if there are more posts
	$args = array('post_status'=>'publish', 'posts_per_page'=>$posts_per_page + 1, 'offset'=>$offset);
	$args = array_merge($vars, $args);
	
	// Remove unnecessary variables
	unset($args['paged']);
	unset($args['p']);
	unset($args['page']);
	unset($args['pagename']); // This is necessary in case Posts Page is set to static page
	
	$query = new WP_Query($args);
	
	$idx = 0;
	if( $query->have_posts() ){
		while ( $query->have_posts() ){
			$query->the_post();
			$idx = $idx + 1;
			if( $idx < $posts_per_page + 1 )
				get_template_part($template, get_post_format());
		}
		
		if( $query->post_count <= $posts_per_page ){
			// There are no more posts
			// Print a flag to detect
			echo '<div id="sns-load-more-no-posts" class="no-posts"><!-- --></div>';
		}
	}else{
		// No posts found
	}
	
	/* Restore original Post Data*/
	wp_reset_postdata();
	
	die('');
}
// When the request action is "load_more", the snssimen_ajax_load_next_page() will be called
add_action('wp_ajax_load_more', 'snssimen_ajax_load_next_page');
add_action('wp_ajax_nopriv_load_more', 'snssimen_ajax_load_next_page');

// Word Limiter
function snssimen_limitwords($string, $word_limit) {
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, $word_limit));
}
//
if(!function_exists('snssimen_sharebox')){
    function snssimen_sharebox( $layout='',$args=array() ){
        $default = array(
            'position' => 'top',
            'animation' => 'true'
            );
        $args = wp_parse_args( (array) $args, $default );
        
        $path = SNSSIMEN_THEME_DIR.'/tpl-sharebox';
        if( $layout!='' ){
            $path = $path.'-'.$layout;
        }
        $path .= '.php';

        if( is_file($path) ){
            require($path);
        }
 
    }
}
//
if(!function_exists('snssimen_relatedpost')){
    function snssimen_relatedpost(){
        global $post;
        if($post){
        	$post_id = $post->ID;
        }else{
        	// Return if cannot find any post
        }
        
        $relate_count = snssimen_get_option('related_num');
        $get_related_post_by = snssimen_get_option('related_posts_by');

        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => $relate_count,
            'orderby' => 'date',
            'ignore_sticky_posts' => 1,
            'post__not_in' => array ($post_id)
        );
        
        if($get_related_post_by == 'cat'){
        	$categories = wp_get_post_categories($post_id);
        	$args['category__in'] = $categories;
        }else{
        	$posttags = wp_get_post_tags($post_id);
        	
        	$array_tags = array();
        	if($posttags){
        		foreach ($posttags as $tag){
        			$tags = $tag->term_id;
        			array_push($array_tags, $tags);
        		}
        	}
        	$args['tag__in'] = $array_tags;
        }
        
        $relates = new WP_Query( $args );
        
        $template_name = '/framework/tpl/posts/related_post.php';
        if(is_file(SNSSIMEN_THEME_DIR.$template_name)) {
            include(SNSSIMEN_THEME_DIR.$template_name);
        }
        
        wp_reset_postdata();
    }
}

/*
 * Function to display number of posts.
 */
function snssimen_get_post_views($post_id){
	$count_key = 'post_views_count';
	$count = get_post_meta($post_id, $count_key, true);
	if($count == ''){
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
		return esc_html__('0 view', 'snssimen');
	}
	return $count. esc_html__(' View', 'snssimen');
}

/*
 * Function to count views.
 */
function snssimen_set_post_views($post_id){
	$count_key = 'post_views_count';
	$count = get_post_meta($post_id, $count_key, true);
	if($count == ''){
		$count = 0;
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
	}else{
		$count++;
		update_post_meta($post_id, $count_key, $count);
	}
}


function snssimen_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <?php $add_below = ''; ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
        <div class="comment-body">
            <?php echo get_avatar($comment, 60); ?>
            <h4 class="comment-user"><?php echo get_comment_author_link(); ?></h4>
            <?php if ($comment->comment_approved == '0') : ?>
            <p>
                <em><?php echo esc_html__('Your comment is awaiting moderation.', 'snssimen') ?></em><br />
            </p>
            <?php endif; ?>
             <?php comment_text() ?>
             <div class="comment-meta"><?php printf(esc_html__('%1$s at %2$s,', 'snssimen'), get_comment_date(),  get_comment_time()) ?></div>
            <div class="reply">
              <?php edit_comment_link(esc_html__('Edit', 'snssimen'),'  ','') ?>
              <?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'snssimen'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
            </div>
        </div>
  <?php 
}
/** 
 *	Breadcrumbs
 **/
function snssimen_breadcrumbs(){
    $template_name = '/tpl-breadcrumb.php';
	if(is_file(SNSSIMEN_THEME_DIR.$template_name)) {
        include(SNSSIMEN_THEME_DIR.$template_name);
    }
}

/*
 * Woocommerce advanced search functionlity
 */
add_action('pre_get_posts', 'snssimen_advanced_search_query', 1000);
function snssimen_advanced_search_query($query){
	if($query->is_search()) {
		// Category terms search
		if( isset($_GET['snssimen_woo_category']) && !empty($_GET['snssimen_woo_category']) ){
			$query->set('tax_query', array(array(
				'taxonomy' 	=> 'product_cat',
				'field'		=> 'slug',
				'term'		=> array($_GET['snssimen_woo_category']) )
			));
		}
	}
	return $query;
}

/* Sample data */
add_action( 'admin_enqueue_scripts', 'snssimen_importlib' );
function snssimen_importlib(){
    wp_enqueue_script('sampledata', get_template_directory_uri().'/framework/sample-data/assets/script.js', array('jquery'));
    wp_enqueue_style('sampledata-css',get_template_directory_uri().'/framework/sample-data/assets/style.css');
}
add_action( 'wp_ajax_sampledata', 'snssimen_importsampledata' );
function snssimen_importsampledata(){
    locate_template(array('/framework/sample-data/sns-importdata.php'), true, true);
    snssimen_importdata();
}

//remove_filter( 'post_class', 'wc_product_post_class', 20, 3 );

?>