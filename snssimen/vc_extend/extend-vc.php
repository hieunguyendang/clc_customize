<?php
$vc_add_css_animation = array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'CSS Animation', 'js_composer' ),
	'param_name' => 'css_animation',
	'admin_label' => true,
	'value' => array(
		esc_html__( 'No', 'js_composer' ) => '',
		esc_html__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
		esc_html__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
		esc_html__( 'Left to right', 'js_composer' ) => 'left-to-right',
		esc_html__( 'Right to left', 'js_composer' ) => 'right-to-left',
		esc_html__( 'Appear from center', 'js_composer' ) => 'appear'
	),
	'description' => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'js_composer' )
);
$sns_extra_class =array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'snssimen'),
			"param_name" => "extra_class"
		);

global $wpdb;
// Get category name
$sql = $wpdb->prepare( "
	SELECT a.name,a.slug,a.term_id 
	FROM {$wpdb->terms} a JOIN  {$wpdb->term_taxonomy} b ON (a.term_id= b.term_id ) 
	WHERE b.count> %d and b.taxonomy = %s",
	0,'category' );
$results = $wpdb->get_results($sql);
$cat_value = array();
foreach ($results as $cat) {
	$cat_value[$cat->name] = $cat->slug;
}
// Get woo category name
$sql = $wpdb->prepare( "
	SELECT a.name,a.slug,a.term_id 
	FROM {$wpdb->terms} a JOIN  {$wpdb->term_taxonomy} b ON (a.term_id= b.term_id ) 
	WHERE b.count> %d and b.taxonomy = %s",
	0,'product_cat' );
$results = $wpdb->get_results($sql);
$woocat_value = array();
foreach ($results as $cat) {
	$woocat_value[$cat->name] = $cat->slug;
}

// SNS Custom Box
class WPBakeryShortCode_SNS_Custom_Box extends WPBakeryShortCode {}
vc_map( array(
	"name"  => esc_html__("SNS Custom Box", 'snssimen'),
	"base" => "sns_custom_box",
	"show_settings_on_create" => true ,
	"is_container" => false ,
	"icon" => "vc_icon_snstheme",
	"class" => "vc_icon_snstheme",
	"content_element" => true ,
	"category" => esc_html__('Content', 'snssimen'),
	'description' => esc_html__( 'Box contain: icon, title, description', 'snssimen' ),
	"params" => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Icon library', 'js_composer' ),
			'value' => array(
				esc_html__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				// esc_html__( 'Open Iconic', 'js_composer' ) => 'openiconic',
				// esc_html__( 'Typicons', 'js_composer' ) => 'typicons',
				// esc_html__( 'Entypo', 'js_composer' ) => 'entypo',
				esc_html__( 'Linecons', 'js_composer' ) => 'linecons',
			),
			'param_name' => 'icon_type',
			'description' => esc_html__( 'Select icon library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_openiconic',
			'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_typicons',
			'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_entypo',
			'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'entypo',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_linecons',
			'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Color for icon", 'snssimen'),
			"param_name" => "icon_color"
	    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font size for icon", 'snssimen'),
			"param_name" => "icon_font_size" ,
			"description" => esc_html__("It's font-size for icon you sellected, example: 24px", 'snssimen')
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"No border" => "" ,
						"1px" => "1px" ,
						"2px" => "2px" ,
						"3px" => "3px" ,
						"4px" => "4px" ,
						"5px" => "5px" ,
						"6px" => "6px" ,
						"7px" => "7px" ,
						"8px" => "8px" 
			), 	
			"heading" => esc_html__("Border size for icon", 'snssimen'),
			"param_name" => "icon_border_size" ,
			"description" => esc_html__("It's border size for icon box", 'snssimen')
		),
		array(
			"type" => "textfield",	
			"heading" => esc_html__("Border radius for icon box", 'snssimen'),
			"param_name" => "icon_border_radius" ,
			'dependency' => array(
				'element' => 'icon_border_size',
				'value' => array('1px', '2px', '3px', '4px', '5px', '6px', '7px', '8px')
			),
			"description" => esc_html__("It's border radius for icon box, example: 10px, or 50%, or none ", 'snssimen')
		),
		array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Border color", 'snssimen'),
			"param_name" => "border_color",
			'dependency' => array(
				'element' => 'icon_border_size',
				'value' => array('1px', '2px', '3px', '4px', '5px', '6px', '7px', '8px')
			)

	    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Link", 'snssimen'),
			"param_name" => "link" ,
			"description" => esc_html__("Enter the  link. Do't forget to include http:// ", 'snssimen')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'snssimen'),
			"param_name" => "title",
			"value" => esc_html__("Your Title Here ...",'snssimen'),
			"admin_label" => true 
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"Sellect text align" => "" ,
						"left" => "left" ,
						"right" => "right" ,
						"center" => "center"
			), 	
			"heading" => esc_html__("Text align for box", 'snssimen'),
			"param_name" => "text_align" 
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Description", 'snssimen'),
			"param_name" => "desc"
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
));

// SNS Twitter
class WPBakeryShortCode_SNS_Twitter extends WPBakeryShortCode {}
vc_map( array(
	"name"  => esc_html__("SNS Twitter", 'snssimen'),
	"base" => "sns_twitter",
	"show_settings_on_create" => true ,
	"is_container" => false ,
	"icon" => "",
	"class" => "sns_twitter",
	"content_element" => true ,
	"category" => esc_html__('Content', 'snssimen'),
	'description' => esc_html__( 'Show your list tweets', 'snssimen' ),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'snssimen'),
			"param_name" => "title",
			"value" => esc_html__("Latest Tweets",'snssimen'),
			"admin_label" => true 
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Widget ID", 'snssimen'),
			"param_name" => "widget_id",
			"value" => "420187988887212033",
			"admin_label" => true 
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Twitter Account", 'snssimen'),
			"param_name" => "account_name",
			"value" => "snstheme",
			"admin_label" => true 
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"List" => "list" ,
						"Carousel" => "carousel" 
			), 	
			"heading" => esc_html__("Template", 'snssimen'),
			"param_name" => "template" 
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"Yes" => "1" ,
						"No" => "2" ,
			), 	
			"heading" => esc_html__("Show Navigation", 'snssimen'),
			"param_name" => "show_navigation",
			'dependency' => array(
				'element' => 'template',
				'value' => 'carousel'
			)
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Tweets number display", 'snssimen'),
			"param_name" => "tweets_num_display",
			"value" => "2",
			"admin_label" => true 
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Tweets number limit", 'snssimen'),
			"param_name" => "tweets_num_limit",
			"value" => "6",
			'dependency' => array(
				'element' => 'template',
				'value' => 'carousel'
			),
			"admin_label" => true 
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"Yes" => "1" ,
						"No" => "2" ,
			), 	
			"heading" => esc_html__("Show Avartar", 'snssimen'),
			"param_name" => "show_avartar",
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"Yes" => "1" ,
						"No" => "2" ,
			), 	
			"heading" => esc_html__("Show Follow Link", 'snssimen'),
			"param_name" => "show_follow_link",
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"Yes" => "1" ,
						"No" => "2" ,
			), 	
			"heading" => esc_html__("Show Interact Link", 'snssimen'),
			"param_name" => "show_interact_link",
		),
		array(
			"type" => "dropdown",
			"value" => Array( 
						"Yes" => "1" ,
						"No" => "2" ,
			), 	
			"heading" => esc_html__("Show Date", 'snssimen'),
			"param_name" => "show_date",
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
));

class WPBakeryShortCode_SNS_Latest_Posts extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Latest Posts",'snssimen'),
	"base" => "sns_latest_posts",
	"icon" => "sns_icon_latestpost",
	"class" => "sns_latestpost",
	"category" => esc_html__("Content",'snssimen'),
	"description" => esc_html__( "Show latest posts", 'snssimen' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snssimen'),
			"param_name" => "title",
			"value" => "Latest Posts",
			"admin_label" => true,
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Author",'snssimen'),
			"param_name" => "show_author",
			"value" => array(
				"Show" => "show",
				"Hide" =>  "hide"
			),
			"description" => esc_html__("Show / Hide Author",'snssimen'),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Post Date",'snssimen'),
			"param_name" => "show_date",
			"value" => array(
				"Show" => "show",
				"Hide" =>  "hide"
			),
			"description" => esc_html__("Show / Hide post date",'snssimen'),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Posts number limit",'snssimen'),
			"param_name" => "number_limit",
			"value" => "12"
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Blog_Page extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Blog Page",'snssimen'),
	"base" => "sns_blog_page",
	"icon" => "sns_icon_blogpage",
	"class" => "sns_blogpage",
	"category" => esc_html__("Content",'snssimen'),
	"description" => esc_html__( "To create blog page with some style", 'snssimen' ),
	"params" => array(
		array(
			"type" => "checkbox",
			"value" => $cat_value,
			"class" => "",
			"heading" => esc_html__("Categories",'snssimen'),
			"description" => "If you dont sellect category, the default is sellected all category",
			"param_name" => "category"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Blog Style",'snssimen'),
			"param_name" => "blog_type",
			"value" => array(
				"Standard Blog" 	=> "",
				"Grid 2 Columns" 	=>  "grid-2-col",
				"Grid 3 Columns" 	=>  "grid-3-col",
				"Masonry" 			=>  "masonry",
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Post per pages",'snssimen'),
			"param_name" => "posts_per_page",
			"value" => "6"
		),
// 		array(
// 			"type" => "dropdown",
// 			"class" => "",
// 			"heading" => esc_html__("Image Size",'snssimen'),
// 			"param_name" => "img_size",
// 			"value" => array(
// 				"Full" => "full",
// 				"Large" => "large",
// 				"Medium" =>  "medium",
// 				"Blog List Thumb" => "bloglist_thumb"
// 			),
// 			"description" => "" ,
// 			"dependency" => array("element" => "type" , "value" => array("1") )
// 		),
		// array(
		// 	"type" => "checkbox",
		// 	"class" => "",
		// 	"heading" => esc_html__("Show Comments",'snssimen'),
		// 	"param_name" => "show_comments",
		// 	"value" => array(esc_html__("Yes",'snssimen') => "yes")
		// ),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Excerpt Length",'snssimen'),
			"param_name" => "excerpt_length",
			"value" => "35"
		),
// 		array(
// 			"type" => "dropdown",
// 			"class" => "",
// 			"heading" => esc_html__("Enable Read More Button",'snssimen'),
// 			"param_name" => "enable_readmore",
// 			"value" => array(
// 				"Yes" => true,
// 				"No" =>  false
// 			),
// 		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Categories",'snssimen'),
			"param_name" => "show_categories",
			"value" => array(
				"Yes" => true,
				"No" =>  false
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Comment Count",'snssimen'),
			"param_name" => "show_comment_count",
			"value" => array(
				"Yes" => true,
				"No" =>  false
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show View Count",'snssimen'),
			"param_name" => "show_view_count",
			"value" => array(
				"Yes" => true,
				"No" =>  false
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Date",'snssimen'),
			"param_name" => "show_date",
			"value" => array(
				"Yes" => true,
				"No" =>  false
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Page Navigation",'snssimen'),
			"param_name" => "pagination",
			"value" => array(
				"Default" => 'def',
				"Ajax" =>  'ajax'
			),
			'description' => esc_html__('Choose Type of navigation.','snssimen')
		),
		// array(
		// 	"type" => "textfield",
		// 	"class" => "",
		// 	"heading" => esc_html__("Posts number display",'snssimen'),
		// 	"param_name" => "num_display",
		// 	"value" => "4"
		// ),
		// array(
		// 	"type" => "textfield",
		// 	"class" => "",
		// 	"heading" => esc_html__("Posts number limit",'snssimen'),
		// 	"param_name" => "number_limit",
		// 	"dependency" => array("element" => "template" , "value" => "2" ),
		// 	"value" => "12"
		// ),
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );


class WPBakeryShortCode_SNS_Our_Brand extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Our Brand",'snssimen'),
	"base" => "sns_our_brand",
	"icon" => "sns_icon_ourbrand",
	"class" => "sns_ourbrand",
	"category" => esc_html__("Content",'snssimen'),
	"description" => esc_html__( "Carousel list brands(image, link)", 'snssimen' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snssimen'),
			"param_name" => "title",
			"value" => "Our brands"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Link Target",'snssimen'),
			"param_name" => "link_target",
			"value" => array(
				"New Windown" => "blank",
				"Same Windown" =>  "_self"
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Brands number display",'snssimen'),
			"param_name" => "num_display",
			"value" => "4",
			"description" => "Numbers display with each page carousel"
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Testimonial extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Testimonial",'snssimen'),
	"base" => "sns_testimonial",
	"icon" => "sns_icon_testimonial",
	"class" => "sns_testimonial",
	"category" => esc_html__("Content",'snssimen'),
	"description" => esc_html__( "Carousel list testimonial", 'snssimen' ),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Template",'snssimen'),
			"param_name" => "template",
			"value" => array(
				"While" =>  "sns_testimonial_white",
				"Dark" => "sns_testimonial_dark",
			),
			"description" => esc_html__("The template Dark allow you to use a background image.",'snssimen'),
		),
		/*array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Icon type",'snssimen'),
			"param_name" => "icon_type",
			"value" => array(
				"Image" => "image",
				"FontAwesome" =>  "fontawesome"
			),
			"description" => ""
		),
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => esc_html__("Icon",'snssimen'),
			"param_name" => "icon_image",
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'image',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snssimen'),
			"param_name" => "title",
			"value" => "What client say"
		),*/
		$vc_add_css_animation,
		$sns_extra_class,
		
	)
) );

class WPBakeryShortCode_SNS_Member extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Member",'snssimen'),
	"base" => "sns_member",
	"icon" => "sns_icon_member",
	"class" => "sns_member",
	"category" => esc_html__("Content",'snssimen'),
	"description" => esc_html__( "Display team member", 'snssimen' ),
	"params" => array(
		array(
	      "type" => "attach_image",
	      "heading" => esc_html__("Avartar", 'snssimen'),
	      "param_name" => "avartar" 
	    ),
	    array(
			"type" => "dropdown",
			"heading" => esc_html__("Avartar style",'snssimen'),
			"param_name" => "avartar_style",
			"value" => array(
				"Default" => "",
				"Rounded" =>  "rounded",
				"Circle" =>  "circle"
			),
			"description" => ""
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'Link to member', 'snssimen' ),
			'param_name' => 'link',
		),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Member name", 'snssimen'),
	      "param_name" => "name",
		  "admin_label" => true
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Member role", 'snssimen'),
	      "param_name" => "role",
		  "admin_label" => true
	    ),
	    array(
	      "type" => "textarea_html",
	      "heading" => esc_html__("Short description", 'snssimen'),
	      "param_name" => "short_desc",
	    ),
	   //  array(
	   //    "type" => "checkbox",
	   //    "heading" => esc_html__("Social Links", 'snssimen'),
	   //    "param_name" => "social_links",
		  // "value" => Array('Twitter'=>'twitter' ,'Facebook'=>'facebook','Linkedin'=>'linkedin','Youtube'=>'youtube','Google plus'=>'google','Behance'=>'behance','Dribbble'=>'dribbble','Pinterest'=>'pinterest')
	   //  ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("Twitter link", 'snssimen'),
	      "param_name" => "twitter",
		  //"dependency" => Array('element' => "social_links", 'value' => 'twitter')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("Facebook link", 'snssimen'),
	      "param_name" => "facebook",
		  //"dependency" => Array('element' => "social_links", 'value' => 'facebook')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("linkedin link", 'snssimen'),
	      "param_name" => "linkedin",
		  //"dependency" => Array('element' => "social_links", 'value' => 'linkedin')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("youtube link", 'snssimen'),
	      "param_name" => "youtube",
		  //"dependency" => Array('element' => "social_links", 'value' => 'youtube')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("google link", 'snssimen'),
	      "param_name" => "google",
		  //"dependency" => Array('element' => "social_links", 'value' => 'google')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("behance link", 'snssimen'),
	      "param_name" => "behance",
		  //"dependency" => Array('element' => "social_links", 'value' => 'behance')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("dribbble link", 'snssimen'),
	      "param_name" => "dribbble",
		  //"dependency" => Array('element' => "social_links", 'value' => 'dribbble')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("pinterest link", 'snssimen'),
	      "param_name" => "pinterest",
		  //"dependency" => Array('element' => "social_links", 'value' => 'pinterest')
	    ),
	    $vc_add_css_animation,
	    $sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Counter extends WPBakeryShortCode {

}

vc_map( array(
	"name" => esc_html__("SNS Counter", 'snssimen'),
	"base" => "sns_counter",
	"class" => "sns_counter",
	"icon" => "sns_icon_counter",
	"description" => esc_html__( "Display box count to", 'snssimen' ),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Use icon?",'snssimen'),
			"param_name" => "enable_icon",
			"value" => array(
				esc_html__('Yes', 'snssimen') => "1",
				esc_html__('No', 'snssimen') => "0"
			),
			"description" => ""
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Icon library', 'js_composer' ),
			'value' => array(
				esc_html__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				esc_html__( 'Linecons', 'js_composer' ) => 'linecons',
			),
			'param_name' => 'icon_type',
			'description' => esc_html__( 'Select icon library.', 'js_composer' ),
			'dependency' => array(
				'element' => 'enable_icon',
				'value' => '1',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon_linecons',
			'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Color for icon", 'snssimen'),
			"param_name" => "icon_color",
			'dependency' => array(
				'element' => 'enable_icon',
				'value' => '1',
			),
	    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font size for icon", 'snssimen'),
			"param_name" => "icon_font_size" ,
			"description" => esc_html__("It's font-size for icon you sellected, example: 24px", 'snssimen'),
			'dependency' => array(
				'element' => 'enable_icon',
				'value' => '1',
			),
		),
  
	  	array(
	      "type" => "textfield",
	      "heading" => esc_html__("Value to Count", 'snssimen'),
	      "param_name" => "value" ,
		  "description" => "This value must be an integer", 
		  "admin_label" => true
	    ),
	    array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Color for Value", 'snssimen'),
			"param_name" => "value_color"
	    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font size for Value", 'snssimen'),
			"param_name" => "value_font_size" ,
			"description" => esc_html__("It's font-size for Value, example: 18px", 'snssimen')
		),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Unit", 'snssimen'),
	      "param_name" => "unit",
		  "description" => 'You can use any text such as % , cm or any other . Leave Blank if you do not want to display any unit value'
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Counter Title", 'snssimen'),
	      "param_name" => "title" ,
		  "value" => esc_html__("Your Title Goes Here...",'snssimen'),
	    ),
	    array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Color for Title", 'snssimen'),
			"param_name" => "title_color"
	    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font size for Title", 'snssimen'),
			"param_name" => "title_font_size" ,
			"description" => esc_html__("It's font-size for Title, example: 12px", 'snssimen')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("From to count", 'snssimen'),
			"param_name" => "from" ,
			"value"		=> "0",
			"description" => esc_html__("The number the element should start at, example: 0", 'snssimen')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Speed to count", 'snssimen'),
			"param_name" => "speed",
			"value"		=> "900",
			"description" => esc_html__("How long it should take to count between the target numbers, example: 900", 'snssimen')
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Interval to count", 'snssimen'),
			"param_name" => "interval",
			"value"		=> "10",
			"description" => esc_html__("How often the element should be updated, example: 10", 'snssimen')
		),
		$vc_add_css_animation,
		$sns_extra_class,
  	)

));

class WPBakeryShortCode_SNS_Featured_Categories extends WPBakeryShortCode {}

vc_map( array(
"name" => esc_html__("SNS Featured Categories",'snssimen'),
"base" => "sns_featured_categories",
"icon" => "sns_icon_featured_categories",
"class" => "sns_featured_categories",
"category" => esc_html__("WooCommerce",'snssimen'),
"description" => esc_html__( 'Display Categories set as Featured','snssimen' ),
"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snssimen'),
			"param_name" => "title",
			"admin_label" => true,
			"value" => "Featured Categories"
			),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Number",'snssimen'),
			"param_name" => "number_display",
			"value" => "6",
			"description" => esc_html__('Number Category to show on the slider.', 'snssimen')
			),
// 		array(
// 			"type" => "dropdown",
// 			"class" => "",
// 			"heading" => esc_html__("Categories Thumbnail Type",'snssimen'),
// 			"param_name" => "cat_thumbnail_type",
// 			"value" => array(
// 				esc_html__('Thumbnail ID', 'snssimen') => "thumbnail_id",
// 				esc_html__('Custom Thumbnail ID', 'snssimen') => "snscustom_product_cat_thumbnail_id",
// 			),
// 			"description" => "Select Thumbnail type of product category. The Thumbnail ID is default and used in Category page, the Custom Thumbnail ID to use for shortcodes. If you not upload a Custom Thumbnail, the default Thumbnail will be used."
			//),
		
		$vc_add_css_animation,
		$sns_extra_class,
		)
) );

class WPBakeryShortCode_SNS_Products extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Products",'snssimen'),
	"base" => "sns_products",
	"icon" => "sns_icon_products",
	"class" => "sns_products",
	"category" => esc_html__("WooCommerce",'snssimen'),
	"description" => esc_html__( "WooCommerce products",'snssimen' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snssimen'),
			"param_name" => "title",
			"admin_label" => true,
			"value" => "New Products"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Type",'snssimen'),
			"param_name" => "type",
			"value" => array(
				esc_html__('Latest Products', 'snssimen') => "recent",
				esc_html__('BestSeller Products', 'snssimen') => "best_selling",
				esc_html__('Top Rated Products', 'snssimen') => "top_rate",
				esc_html__('Special Products', 'snssimen') => "on_sale",
				esc_html__('Featured Products', 'snssimen') => "featured_product",
				esc_html__('Recent Review', 'snssimen') => "recent_review",
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Template",'snssimen'),
			"param_name" => "template",
			"admin_label" => true,
			"value" => array(
				esc_html__("Carousel",'snssimen') => '1',
				esc_html__("List",'snssimen') => '2',
			),
			"description" => esc_html__("Select template.", 'snssimen')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Row",'snssimen'),
			"param_name" => "row",
			"value" => array(
				esc_html__("Carousel One Row",'snssimen') => '1',
				esc_html__("Carousel Two Rows",'snssimen') => '2',
			),
			'dependency' => array(
				'element' => 'template',
				'value' => '1',
			),
			"description" => esc_html__("Display with one row slider or two rows slider.", 'snssimen')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Product number display per row",'snssimen'),
			"param_name" => "number_display",
			"value" => "4",
			'dependency' => array(
				'element' => 'template',
				'value' => '1',
			),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Product number limit",'snssimen'),
			"param_name" => "number_limit",
			"value" => "10",
		),
		$vc_add_css_animation,
		$sns_extra_class,
		
	)
) );

class WPBakeryShortCode_SNS_Product_Tabs extends WPBakeryShortCode {
	public function getListTabTitle(){
		$this->atts = vc_map_get_attributes( $this->getShortcode(), $this->atts );
		$array_tab = array();
		if ( $this->atts['tab_types'] == 'category' ) :
			if( empty($this->atts['list_cat']) ) :
				$array_tab = $this->getCats();
			else :
				$array_tab = explode(',', $this->atts['list_cat']);
			endif;
			//var_dump($array_tab);
		else :
			$array_tab = explode(',', $this->atts['list_orderby']);
		endif;
		foreach ($array_tab as $tab) {
			$list_tab[$tab] = $this->tabTitle($tab, $this->atts['tab_types'], $this->atts['cat_thumbnail']);
		}
		return $list_tab;
	}

	public function tabTitle($tab, $tab_types, $show_cat_thumbnail){
		if( $tab_types == 'category' ){
			$cat = get_term_by('slug', $tab, 'product_cat');
			
			// Get category thumbnail
			$image = '';
			if( $show_cat_thumbnail == 'show' ){
				$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
				if($thumbnail_id == '')
					$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'snscustom_product_cat_thumbnail_id', true);
					
				$cat_thumb = wp_get_attachment_image_src($thumbnail_id, 'snssimen_product_tabs_thumbnail');
				$image = isset($cat_thumb[0]) ? $cat_thumb[0] : wc_placeholder_img_src();
			}
			
			return array('name'=>str_replace(' ', '_', $tab),'title'=>$cat->name,'short_title'=>$cat->name, 'thumbnail' => $image);
		}else{
			switch ($tab) {
				case 'recent':
					return array('name'=>$tab,'title'=>esc_html__('Latest Products','snssimen'),'short_title'=>esc_html__('Latest','snssimen'));
				case 'featured_product':
					return array('name'=>$tab,'title'=>esc_html__('Featured Products','snssimen'),'short_title'=>esc_html__('Featured','snssimen'));
				case 'top_rate':
					return array('name'=>$tab,'title'=> esc_html__('Top Rated Products','snssimen'),'short_title'=>esc_html__('Top Rated', 'snssimen'));
				case 'best_selling':
					return array('name'=>$tab,'title'=>esc_html__('BestSeller Products','snssimen'),'short_title'=>esc_html__('Best Seller','snssimen'));
				case 'on_sale':
					return array('name'=>$tab,'title'=>esc_html__('Special Products','snssimen'),'short_title'=>esc_html__('Special','snssimen'));
			}
		}
	}
	public function getCats(){
		$cats = get_terms('product_cat');
		$arr = array();
		foreach ($cats as $cat) {
			$arr[] = $cat->slug;
		}
		return $arr;
	}
}

vc_map( array(
	"name" => esc_html__("SNS Product Tabs",'snssimen'),
	"base" => "sns_product_tabs",
	"icon" => "sns_icon_product_tabs",
	"class" => "sns_product_tabs",
	"category" => esc_html__("WooCommerce",'snssimen'),
	"description" => esc_html__( "WooCommerce product tabs", 'snssimen' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snssimen'),
			"param_name" => "title",
			"admin_label" => true,
			"value" => "New Products"
		),
// 		array(
// 			"type" => "textarea",
// 			"heading" => esc_html__("Pre text", 'snssimen'),
// 			"param_name" => "pretext"
// 		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Template",'snssimen'),
			"param_name" => "template",
			"value" => array(
				"Grid" => "grid",
				"Carousel" =>  "carousel"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Tab types",'snssimen'),
			"param_name" => "tab_types",
			"value" => array(
				"Categories" => "category",
				"Order By" =>  "orderby"
			),
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"value" => $woocat_value,
			"heading" => esc_html__("Select Category",'snssimen'),
			"param_name" => "list_cat",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Categories Thumbnail",'snssimen'),
			"param_name" => "cat_thumbnail",
			"value" => array(
				esc_html__('Hide', 'snssimen') => "hide",
				esc_html__('Show', 'snssimen') => "show",
			),
			"dependency" => array("element" => "template" , "value" => "carousel" ),
			"description" => "Display Categories thumbnail with Tab types is Categires."
		),
// 		array(
// 			"type" => "dropdown",
// 			"class" => "",
// 			"heading" => esc_html__("Categories Thumbnail Type",'snssimen'),
// 			"param_name" => "cat_thumbnail_type",
// 			"value" => array(
// 				esc_html__('Thumbnail ID', 'snssimen') => "thumbnail_id",
// 				esc_html__('Custom Thumbnail ID', 'snssimen') => "snscustom_product_cat_thumbnail_id",
// 			),
// 			"dependency" => array("element" => "cat_thumbnail" , "value" => "show" ),
// 			"description" => "Select Thumbnail type of product category. The Thumbnail ID is default and used in Category page, the Custom Thumbnail ID to use for shortcodes. If you not upload a Custom Thumbnail, the default Thumbnail will be used."
// 		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Order By for all tab",'snssimen'),
			"param_name" => "orderby",
			"value" => array(
				esc_html__('Latest Products', 'snssimen') => "recent",
				esc_html__('BestSeller Products', 'snssimen') => "best_selling",
				esc_html__('Top Rated Products', 'snssimen') => "top_rate",
				esc_html__('Special Products', 'snssimen') => "on_sale",
				esc_html__('Featured Products', 'snssimen') => "featured_product",
				esc_html__('Recent Review', 'snssimen') => "recent_review",
			),
			"dependency" => array("element" => "tab_types" , "value" => "category" ),
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Select Order By",'snssimen'),
			"param_name" => "list_orderby",
			"value" => array(
				esc_html__('Latest Products', 'snssimen') => "recent",
				esc_html__('BestSeller Products', 'snssimen') => "best_selling",
				esc_html__('Top Rated Products', 'snssimen') => "top_rate",
				esc_html__('Special Products', 'snssimen') => "on_sale",
				esc_html__('Featured Products', 'snssimen') => "featured_product",
				esc_html__('Recent Review', 'snssimen') => "recent_review",
			),
			"dependency" => array("element" => "tab_types" , "value" => "orderby" ),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Row",'snssimen'),
			"param_name" => "row",
			"dependency" => array("element" => "template" , "value" => "grid" ),
			"value" => "2"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Column per Row",'snssimen'),
			"param_name" => "col",
			"dependency" => array("element" => "template" , "value" => "grid" ),
			"value" => "5"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Number product with each click to Load more button",'snssimen'),
			"param_name" => "number_load",
			"dependency" => array("element" => "template" , "value" => "grid" ),
			"value" => "5"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Effect for product when click to Load more button",'snssimen'),
			"param_name" => "effect_load",
			"value" => array(
				esc_html__('zoomOut', 'snssimen') => "zoomOut",
				esc_html__('zoomIn', 'snssimen') => "zoomIn",
				esc_html__('pageRight', 'snssimen') => "pageRight",
				esc_html__('pageLeft', 'snssimen') => "pageLeft",
				esc_html__('pageTop', 'snssimen') => "pageTop",
				esc_html__('pageBottom', 'snssimen') => "pageBottom",
				esc_html__('starwars', 'snssimen') => "starwars",
				esc_html__('slideBottom', 'snssimen') => "slideBottom",
				esc_html__('slideLeft', 'snssimen') => "slideLeft",
				esc_html__('slideRight', 'snssimen') => "slideRight",
				esc_html__('bounceIn', 'snssimen') => "bounceIn",
			),
			"dependency" => array("element" => "template" , "value" => "grid" ),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Carousel Row",'snssimen'),
			"param_name" => "carousel_row",
			"dependency" => array("element" => "template" , "value" => "carousel" ),
			"value" => array(
				esc_html__("One Row",'snssimen') => '1',
				esc_html__("Two Rows",'snssimen') => '2',
			),
			"dependency" => array("element" => "cat_thumbnail" , "value" => "hide" ),
			"description" => esc_html__("Display with one row slider or two rows slider.", 'snssimen')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Product number display per row",'snssimen'),
			"param_name" => "number_display",
			"dependency" => array("element" => "template" , "value" => "carousel" ),
			"value" => "4"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Product number limit",'snssimen'),
			"param_name" => "number_limit",
			"dependency" => array("element" => "template" , "value" => "carousel" ),
			"value" => "10"
		),
		$vc_add_css_animation,
		$sns_extra_class,
		
	)
) );

?>