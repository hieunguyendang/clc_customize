<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */
add_filter( 'rwmb_meta_boxes', 'sns_register_meta_boxes' );
/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
function sns_register_meta_boxes( $meta_boxes ){
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	wp_enqueue_script('sns-imgselect', SNSSIMEN_THEME_URI . '/framework/meta-box/sns-metabox.js', array('jquery'), '', true);
	$prefix = 'snssimen_';
	global $wpdb, $snssimen_opt;
	$revsliders =array();
	$revsliders[0] = 'Select a slider';
	if (is_plugin_active('revslider/revslider.php')) {
		$query = $wpdb->prepare("
			SELECT * 
			FROM {$wpdb->prefix}revslider_sliders 
			ORDER BY %s"
			, "ASC");
	    $get_sliders = $wpdb->get_results($query);
	    if($get_sliders) {
		    foreach($get_sliders as $slider) {
			   $revsliders[$slider->alias] = $slider->title;
		   }
	    }
	}
	//
	$default_layout = 'l-m';
	if ( isset($snssimen_opt['blog_layout']) ) $default_layout = $snssimen_opt['blog_layout'];
	//
	$siderbars = array();
	foreach ($GLOBALS['wp_registered_sidebars'] as $sidebars) {
		$siderbars[ $sidebars['id']] = $sidebars['name'];
	}
	// Layout config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_layout',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Layout Config', 'snssimen' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			
			array(
				'name'        => esc_html__( 'Config layout for this page', 'snssimen' ),
				'id'          => "{$prefix}enablelayoutconfig",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snssimen' ),
					'2' => esc_html__( 'No', 'snssimen' ),
				),
				'std'         => '2',
				'desc'		  => esc_html__( 'Sellect Yes if you want config layout for this page', 'snssimen' ),
			),
			// Layout Type
			array(
				'name'        => esc_html__( 'Layout Type', 'snssimen' ),
				'id'          => "{$prefix}layouttype",
				'type'        => 'layouttype',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'm' => esc_html__( 'Without Sidebar', 'snssimen' ),
					'l-m' => esc_html__( 'Use Left Sidebar', 'snssimen' ),
					'm-r' => esc_html__( 'Use Right Sidebar', 'snssimen' ),
					'l-m-r' => esc_html__( 'Use Left & Right Sidebar', 'snssimen' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => $default_layout,
				'placeholder' => esc_html__( '--- Select a layout type ---', 'snssimen' ),
			),
			// Left Sidebar
			array(
				'name'  => esc_html__( 'Left Sidebar', 'snssimen' ),
				'id'    => "{$prefix}leftsidebar",
				//'desc'  => esc_html__( 'Text description', 'snssimen' ),
				'type'  => 'select',
				'options'	=> $siderbars,
				'multiple'	=> false,
				'std'		=> 'left-sidebar',
				'placeholder' => esc_html__( '--- Select a sidebar ---', 'snssimen' ),
			),
			// Right Sidebar
			array(
				'name'  => esc_html__( 'Right Sidebar', 'snssimen' ),
				'id'    => "{$prefix}rightsidebar",
				//'desc'  => esc_html__( 'Text description', 'snssimen' ),
				'type'  => 'select',
				'options'	=> $siderbars,
				'multiple'	=> false,
				'std'		=> 'right-sidebar',
				'placeholder' => esc_html__( '--- Select a sidebar ---', 'snssimen' ),
			),
		)
	);
	
	$menus = get_terms('nav_menu', array( 'hide_empty' => false ));
	$menu_options[''] = esc_html__('Default Menu...', 'snssimen');
	foreach ( $menus as $menu ){
		$menu_options[$menu->term_id] = $menu->name;
	}
	
	// Page config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_pageconfig',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Page Config', 'snssimen' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			array(
				'name'    => esc_html__( 'Header Layout', 'snssimen' ),
				'id'       => "{$prefix}header_layout",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					''  => esc_html__( 'Default', 'snssimen' ),
					'layout_1'  => esc_html__( 'Layout 1', 'snssimen' ),
					'layout_2'  => esc_html__( 'Layout 2 (Transparent)', 'snssimen' ),
					'layout_3'  => esc_html__( 'Layout 3', 'snssimen' ),
				),
				'desc'		=> esc_html__('Select Header layout. Select "Default" to use in Theme Options.', 'snssimen'),
			),
			array(
				'name'    => esc_html__( 'Top Header Sidebar', 'snssimen' ),
				'id'       => "{$prefix}header_sidebar",
				'type'     => 'select',
				'std'  => 'header_sidebar',
				'options'  => array(
					'header_sidebar'  => esc_html__( 'Header Sidebar', 'snssimen' ),
					'search_property'  => esc_html__( 'Search Box', 'snssimen' ),
				),
			),
			array(
				'name' => esc_html__( 'Top Header Background Color', 'snssimen' ),
				'id'   => "{$prefix}header_bg",
				'type' => 'color',
				'std'  => '#222222',
				'desc' => esc_html__( 'It will priority than Top Header Background Color in Theme Option panel. Default use setting in Theme Option.', 'snssimen' ),
			),
			array(
				'name' => esc_html__( 'Top Header Color', 'snssimen' ),
				'id'   => "{$prefix}header_color",
				'type' => 'color',
				'std'  => '#888888',
				'desc' => esc_html__( 'It will priority than Top Header Color in Theme Option panel. Default use setting in Theme Option.', 'snssimen' ),
			),
			array(
				'name'    => esc_html__( 'Main Navigation Menu', 'snssimen' ),
				'id'       => "{$prefix}main_menu",
				'type'     => 'select',
				'std'  => 'def',
				'options'  => $menu_options,
				'desc' => esc_html__( 'Select which main menu displays on this page.', 'snssimen' ),
			),
			array(
				'name'    => esc_html__( 'Show Title', 'snssimen' ),
				'id'      => "{$prefix}showtitle",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snssimen' ),
					'2' => esc_html__( 'No', 'snssimen' ),
				),
				'std'         => '1',
			),
			array(
				'name'    => esc_html__( 'Use Slideshow', 'snssimen' ),
				'id'      => "{$prefix}useslideshow",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snssimen' ),
					'2' => esc_html__( 'No', 'snssimen' ),
				),
				'std'         => '2',
			),
			array(
				'name'    => esc_html__( 'Select Slideshow', 'snssimen' ),
				'id'      => "{$prefix}revolutionslider",
				'type'    => 'select',
				'options' =>  $revsliders ,
				'std'         => '',
			),
			array(
				'name'    => esc_html__( 'Show Breadcrumbs', 'snssimen' ),
				'id'      => "{$prefix}showbreadcrump",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snssimen' ),
					'2' => esc_html__( 'No', 'snssimen' ),
				),
				'std'         => '1',
				'desc' => esc_html__( 'Dont apply for homepage. Because breadcrumbs dont sense in homepage', 'snssimen' ),
			),
			array(
				'name' => esc_html__( 'Image background for menu wrapper', 'snssimen' ),
				'id'   => "{$prefix}menubg",
				'type' => 'image_advanced',
				'max_file_uploads' => 1,
				'desc' => esc_html__( 'Default value in theme option - SNS Theme', 'snssimen' ),
			),
			array(
				'name'    => esc_html__( 'Config Theme Color for this page?', 'snssimen' ),
				'id'      => "{$prefix}page_themecolor",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snssimen' ),
					'2' => esc_html__( 'No', 'snssimen' ),
				),
				'std'         => '2',
			),
			array(
				'name' => esc_html__( 'Sellect Theme Color', 'snssimen' ),
				'id'   => "{$prefix}theme_color",
				'type' => 'color',
				'desc' => esc_html__( 'It will priority than Theme Color in Theme Option panel', 'snssimen' ),
			),
			array(
				'name'    => esc_html__( 'Show Bottom Fullwidth Sidebar', 'snssimen' ),
				'id'      => "{$prefix}showbottomfullsidebar",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snssimen' ),
					'2' => esc_html__( 'No', 'snssimen' ),
				),
				'std'         => '2',
			),
		)
	);
	// Post format - Gallery
	$meta_boxes[] = array(
	    	'id' => 'sns-post-gallery',
		    'title' =>  esc_html__('Gallery Settings','snssimen'),
	    	'description' => '',
    		'pages'      => array( 'post' ), // Post type
	    	'context'    => 'normal',
		    'priority'   => 'high',
	    	'fields' => array(
			     array(
			        'name'		=> 'Gallery Images',
			        'desc'	    => 'Upload Images for post Gallery ( Limit is 15 Images ).',
			        'type'      => 'image_advanced',
			        'id'	    => "{$prefix}post_gallery",
	         		'max_file_uploads' => 15 
	        	)
			)
	);
	// Post format - Video
    $meta_boxes[] = array(
		'id' => 'sns-post-video',
		'title' => esc_html__('Featured Video','snssimen'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_video",
				'name'  => esc_html__( 'Video', 'snssimen' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				// Input size
				'size'  => 50,
			)
		)
	);
	// Post format - Audio
    $meta_boxes[] = array(
		'id' => 'sns-post-audio',
		'title' => esc_html__('Featured Audio','snssimen'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_audio",
				'name'  => esc_html__( 'Audio', 'snssimen' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				// Input size
				'size'  => 50,
			)
		)
	);
	// Post format - quote
    $meta_boxes[] = array(
		'id' => 'sns-post-quote',
		'title' => esc_html__('Featured Quote','snssimen'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_quotecontent",
				'name'  => esc_html__( 'Quote Content', 'snssimen' ),
				'type'  => 'textarea',
				// Allow to clone? Default is false
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_quoteauthor",
				'name'    => esc_html__( 'Quote author', 'snssimen' ),
				'type'    => 'text',
				'clone' => false,
			),
		)
	);
	// Post format - Link
    $meta_boxes[] = array(
		'id' => 'sns-post-link',
		'title' => esc_html__('Link Settings','snssimen'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_linkurl",
				'name'  => esc_html__( 'Link URL', 'snssimen' ),
				'type'  => 'text',
				// Allow to clone? Default is false
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_linktitle",
				'name'    => esc_html__( 'Link Title', 'snssimen' ),
				'type'    => 'text',
				'clone' => false,
			),
		)
	);
	// Brand config
	$meta_boxes[] = array(
		'id'         => 'sns_brandconfig',
		'title'      => esc_html__( 'Brand Config', 'snssimen' ),
		'post_types' => array( 'brand' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Link for brand', 'snssimen' ),
				'id'      => "{$prefix}brandlink",
				'type'    => 'text'
			),
		)
	);
	// Testimonial subtitle
	$meta_boxes[] = array(
		'id'         => 'sns_testisub',
		'title'      => esc_html__( 'Sub Title', 'snssimen' ),
		'post_types' => array( 'testimonial' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Sub Title', 'snssimen' ),
				'id'      => "{$prefix}testisub",
				'type'    => 'text',
				'desc'	  => esc_html__('Ex: display your company.', 'snssimen')
			),
		),
	);

	// Product page config
	$meta_boxes[] = array(
	    	'id' => 'sns-product-config',
		    'title' =>  esc_html__('Product Config','snssimen'),
	    	'description' => '',
    		'pages'      => array( 'product' ), // type product
	    	'context'    => 'normal',
		    'priority'   => 'high',
	    	'fields' => array(
			    array(
					'name'    => esc_html__( 'Zoom Type for Cloud Zoom', 'snssimen' ),
					'id'       => "{$prefix}woo_zoomtype",
					'type'     => 'select',
					'std'  => '',
					'options'  => array(
						''  => esc_html__( 'Default', 'snssimen' ),
						'window'  => esc_html__( 'window', 'snssimen' ),
						'lens'  => esc_html__( 'lens', 'snssimen' ),
						'inner'  => esc_html__( 'Inner', 'snssimen' ),
					),
					'desc'		=> '',
				),
			     array(
					'id'    => "{$prefix}product_video",
					'name'  => esc_html__( 'Product Video', 'snssimen' ),
					'type'  => 'oembed',
					// Allow to clone? Default is false
					'clone' => false,
					'desc'		  => esc_html__( 'Enter your video url(youtube, video)', 'snssimen' ),
					// Input size
					'size'  => 50,
				)
			)
	);

	return $meta_boxes;
}


if ( class_exists( 'RWMB_Field' ) ) {
	class RWMB_Layouttype_Field extends RWMB_Select_Field {
		
		static function admin_enqueue_scripts(){
			wp_enqueue_style( 'sns-imgselect', SNSSIMEN_THEME_URI . '/framework/meta-box/img-select.css' );
		}
	}
}
