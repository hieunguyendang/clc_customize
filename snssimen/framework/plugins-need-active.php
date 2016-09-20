<?php
add_action( 'tgmpa_register', 'sns_plugin_activation' );
function sns_plugin_activation() {
    $plugins = array(
            // install Redux Framework, it on wordpress.org/plugins
            array(
                'name'      => esc_html__( 'Redux Framework', 'snssimen' ),
                'slug'      => 'redux-framework', // Slug name of plugin on URL
                'required'  => true,
            ),
            array(
                'name'               => esc_html__( 'Meta Box', 'snssimen' ),
                'slug'               => 'meta-box',
                'version'            => '4.8.7',
                'source'             => 'https://downloads.wordpress.org/plugin/meta-box.4.8.7.zip',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'                  => esc_html__( 'Slider Revolution', 'snssimen' ),
                'slug'                  => 'revslider',
                'source'                => 'http://demo.snstheme.com/wp/resource/revslider.zip',
                'required'              => true,
                'force_activation'      => false,
                'force_deactivation'    => false,
            ),
            array(
                'name'                  => esc_html__( 'WPBakery Visual Composer', 'snssimen' ),
                'slug'                  => 'js_composer',
                'source'                => 'http://demo.snstheme.com/wp/resource/js_composer.zip',
                'required'              => true,
                'force_activation'      => false,
                'force_deactivation'    => false,
            ),
            array(
                'name'                  => esc_html__( 'SNS Posttype', 'snssimen' ),
                'slug'                  => 'sns-posttype',
                'source'                => get_template_directory_uri() . '/framework/plugins/sns-posttype.zip',
                'required'              => true,
                'force_activation'      => false,
                'force_deactivation'    => false,
            ),
            array(
                'name'               => esc_html__( 'WooCommerce - excelling eCommerce', 'snssimen' ),
                'version'            => '2.6.4',
                'source'             => 'https://downloads.wordpress.org/plugin/woocommerce.2.6.4.zip',
                'slug'               => 'woocommerce',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__( 'YITH WooCommerce Wishlist', 'snssimen' ),
                'slug'               => 'yith-woocommerce-wishlist',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__( 'YITH WooCommerce Compare', 'snssimen' ),
                'slug'               => 'yith-woocommerce-compare',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__( 'YITH WooCommerce Quick View', 'snssimen' ),
                'slug'               => 'yith-woocommerce-quick-view',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
	    	array(
	    		'name'               => esc_html__( 'YITH WooCommerce Ajax Product Filter', 'snssimen' ),
	    		'slug'               => 'yith-woocommerce-ajax-navigation',
	    		'required'           => true,
	    		'force_activation'   => false,
	    		'force_deactivation' => false,
	    	),
	    	array(
	    		'name'               => esc_html__( 'YITH Newsletter Popup', 'snssimen' ),
	    		'slug'               => 'yith-newsletter-popup',
	    		'required'           => true,
	    		'force_activation'   => false,
	    		'force_deactivation' => false,
	    	),
            array(
                'name'               => esc_html__( 'Contact Form 7', 'snssimen' ),
                'slug'               => 'contact-form-7',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__( 'Image Widget', 'snssimen' ),
                'slug'               => 'image-widget',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),

        );
  
    $config = array(
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Is show notices or not?
        'dismissable'  => false,                   // If false then user cannot colose notices above.
        'is_automatic' => true,                    // If false thene plugin cannot auto active after install.
    );
    tgmpa( $plugins, $config );
}