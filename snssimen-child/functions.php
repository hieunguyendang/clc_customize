<?php
/**
 * Enqueue style of child theme
 */
function snssimen_child_enqueue_styles() {
    wp_enqueue_style( 'snssimen-child-style', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'snssimen_child_enqueue_styles', 100000 );

// Add action to hook into the approp
//add_filter( 'woocommerce_placeholder_img_src', 'growdev_custom_woocommerce_placeholder', 10 );
/**
 * Function to return new placeholder image URL.
 */
function growdev_custom_woocommerce_placeholder( $image_url ) {
  $image_url = 'http://clc.flywheelsites.com/wp-content/uploads/2016/09/clc-product-placeholder.jpg';  // change this to the URL to your custom placeholder
  return $image_url;
}

/*
* goes in theme functions.php or a custom plugin. Replace the image filename/path with your own :)
*
**/
//add_action( 'init', 'custom_fix_thumbnail' );
 
function custom_fix_thumbnail() {
  add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
   
	function custom_woocommerce_placeholder_img_src( $src ) {
	$upload_dir = wp_upload_dir();
	$uploads = untrailingslashit( $upload_dir['baseurl'] );
	$src = $uploads . '/2016/09/clc-product-placeholder.jpg';
	 
	return $src;
	}
}

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
        add_image_size('snssimen_megamenu_thumb', 500, 500, true);
        //add_image_size('snssimen_megamenu_thumb', 250, 150, true);
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

if ( ! function_exists( 'snssimen_widgetlocations' ) ) {
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
}

?>

