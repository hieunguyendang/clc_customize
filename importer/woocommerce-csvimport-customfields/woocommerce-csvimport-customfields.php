<?php
/*
 	* Plugin Name:			Woocommerce CSV import custom fields
 	* Plugin URI:			https://allaerd.org/shop/woocommerce-import-custom-fields/
 	* Description:			Import custom fields into Woocommerce

 	* Author:				Allaerd Mensonides
 	* Author URI:			https://allaerd.org
 	
 	* Version:				3.0.1
	* Requires at least: 	4.0
	* Tested up to: 		4.2
	
	* Text Domain: woocsv
	* Domain Path: /i18n/languages/
	 
	This plugin is part of the free woocommerce csv importer. It must be used in conjunction wiht it.
*/	

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// hook into woocommerce csv import 
add_action('woocsv_after_init', 'woocsv_import_custom_fields_init');

//old one
add_action('woocsvAfterInit', 	'woocsv_import_custom_fields_init_old');

//checkversion
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
	
function woocsv_import_custom_fields_init() {
	new woocsv_import_custom_fields;			
}

function woocsv_import_custom_fields_init_old() { 
	include_once 'old/woocommerce-csvimport-customfields.php';
	new woocsv_import_custom_fields_old;
}


class woocsv_import_custom_fields {
	
	public $version;
	public $name;
	public $remote_slug;
	public $url;
	
	public function __construct() {	
		global $woocsv_import;
			
		/* register add-on */
		$this->version  	= '3.0.1';
		$this->name 		= 'Import custom fields';
		$this->url 			= 'https://allaerd.org/shop/woocommerce-import-custom-fields/';
		$this->remote_slug 	= 'woocsv-custom-fields';
		$woocsv_import->addons[$this->remote_slug] = $this;
		
		/* save hook */		
		add_action('woocsv_product_after_fill_in_data',array($this,'save'));

		/* docs */
		add_action ('woocsv_documentation',array ( $this, 'content' ) );
		
		/* settings */
		add_action( 'admin_init', array( $this,'settings' ));
		
		/* add fields to dropdown */
		$this->fields();
		
		/* migrate data from old versions */
		$this->check_for_old_version();
	}
	
	public function check_for_old_version () {
		if ( get_option( 'woocsv-customfields' ) ) {
			update_option('woocsv_custom_fields', get_option( 'woocsv-customfields' ) ) ;
			delete_option( 'woocsv-customfields' );
		}
	}	
		
	public function fields() {
		global $woocsv_import;
		// add fields to dropdown
		$temp_custom_fields = get_option('woocsv_custom_fields');
		if ($temp_custom_fields) {
			$custom_fields = explode(',', $temp_custom_fields);
			foreach ($custom_fields as $key=>$value) {
				$woocsv_import->fields[] = trim($value);
			}
		}
	}

	public function save () {
		global $woocsv_product;
		
		// get the custom fields
		$temp_custom_fields = get_option('woocsv_custom_fields');
		
		// if there are none....return
		if ($temp_custom_fields == false) {
			return;
		}
			

		// there are custom fields!
		$custom_fields = explode( ',' , $temp_custom_fields );

		foreach ($custom_fields as $cf) {
			$meta = '';
			//find the custom field in the header
			$key = array_search( $cf , $woocsv_product->header );			
			
			// if it is in the header process it
			if ( $key !== false ) {
				$value = $woocsv_product->raw_data[$key];
				//split it up
			
				$pieces = explode('|', $value);
				
			
				//single value or single key->value	
				if ( count ( $pieces ) ==1 ) {
					$splits = explode('->', current($pieces));
					
					if ( count ( $splits ) == 1 ) {
						// it's a single value soooooo no encode
						$woocsv_product->meta[$cf] = current($splits);
					}
					
					if ( count ( $splits ) == 2 ) {
						// it's a key => value pair soooooooo encode
						$woocsv_product->meta[$cf] =  array( $splits[0] => $splits[1] ) ;
					}					
					
				} else {
				//multiple pieces loop them
					$meta = array ();
					foreach ( $pieces as $piece ) {
						$splits = explode('->', $piece);
						
						if ( count ( $splits ) == 1 ) {
							// it's a single value soooooo no encode
							$meta[] = current($splits);
						}
					
						if ( count ( $splits ) == 2 ) {
							// it's a key => value pair soooooooo encode
							$meta[$splits[0]] =  $splits[1] ;
						}			
					}
					//now save the array
					$woocsv_product->meta[$cf] =  $meta ;
				}				
			}
			//and reset the key to be sure
			unset($key,$meta);
		}
	} 
	
	function settings () {
		add_settings_field('woocsv_custom_fields', 'Custom fields', array($this,'custom_fields'), 'woocsv-settings','woocsv-settings');
		register_setting( 'woocsv-settings', 'woocsv_custom_fields', array($this,'options_validate') );
	}
	
	function custom_fields () {
		$custom_fields = get_option('woocsv_custom_fields');
		echo '<input type="text" class="large-text" id="woocsv_custom_fields" name="woocsv_custom_fields" placeholder="field1,field2,field3" value="'.$custom_fields.'">';
		echo '<p class="description">Add your custom fields as a comma separated list.</p>';
	}
	
	//! validation
	function options_validate($input) {
		//no validation yet
		return $input;
	}
	
	function content () {
		?>
		<h2>Import custom fields</h2>
		<p>
		Custom fields are fields that are used to store meta data. They can hold regular values or complex arrays. They are used by many plugins to store additional data. Yoast SEO stores SEO data in them, Woocommerce stores prices and stock and lots of other stuff
		Before importing you must enter the custom fields you want to import as a comma separated list in the <a href="<?php echo get_admin_url().'admin.php?page=woocsv-settings';?>">settings page</a>. Example: <code>custom field,additional data,_yoast_seo_title</code> these fields will than be added to the dropdown's in the header section
		</p>
		<p>
		In your CSV you can have regular values or complex arrays. Simple values are stored like : <code>value</code>. To create array use the pipe separator <code>value1|value2|value3</code> If you need key value pairs you can do like this: <code>key->value|key->value|key->value</code>.
		</p>
		<h4>Example:</h4>
		<code>
		sku,post_title,seo_title,complex_field</br>
		sku1,product 1,my title,</br>
		sku2,product 2,another title,value1|value2|value3</br>
		sku3,product 2,another title,key1=>value1|key2=>value2|key3=>value3</br>
		</code>
		<?php
	}
}