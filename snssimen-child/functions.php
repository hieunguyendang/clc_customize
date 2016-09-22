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
 *  Set base function for theme.
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
    register_sidebar(array(
      'name' => esc_html__( 'Menu Sidebar #2','snssimen' ),
      'id'   => 'menu_sidebar_2',
      'description'   => esc_html__( 'These are widgets for Mega Menu Columns style. This sidebar displayed in the bottom of column.','snssimen' ),
      'before_widget' => '<div class="sidebar-menu-widget col-md-6 %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4 class="widget-title">',
      'after_title'   => '</h4>'
    ));
?>
