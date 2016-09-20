<?php
/*
 	* Plugin Name:			Woocommerce CSV import taxonomies
 	* Plugin URI:			https://allaerd.org/shop/woocommerce-import-taxonomies/
 	* Description:			Import taxonomies into Woocommerce

 	* Author:				Allaerd Mensonides
 	* Author URI:			https://allaerd.org
 	
 	* Version:				3.0.1
	* Requires at least: 	4.0
	* Tested up to: 		4.2
	
	* Text Domain: woocsv
	* Domain Path: /i18n/languages/
	 
	This plugin is part of the free woocommerce csv importer. It must be used in conjunction with it.
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// hook into woocommerce csv import 
add_action('woocsv_after_init', 'woocsv_import_taxonomies_init');

//old hook into woocommerce csv import 
add_action('woocsvAfterInit', 'woocsv_import_taxonomies_init_old');


function woocsv_import_taxonomies_init() {
	new woocsv_import_taxonomies();
}

function woocsv_import_taxonomies_init_old() {
	include_once 'old/woocommerce-csvimport-taxonomy_old.php';
	new woocsvTaxonomy_old();
}

class woocsv_import_taxonomies {

	public function __construct() {
		
		global $woocsv_import;
		
		//register plugin in importer
		$this->version  = '3.0.1';
		$this->name = 'Import taxonomies';
		$this->url = 'https://allaerd.org/shop/woocommerce-import-taxonomies/';
		$this->remote_slug = 'woocsv-taxonomies';
		$woocsv_import->addons[$this->remote_slug] = $this;

		
		//init hooks
		$this->hooks ();

	}


	public function hooks () {
		// save hook
		add_action('woocsv_product_after_body_save', array($this, 'save'));
		
		/* docs */
		add_action ('woocsv_documentation',array ( $this, 'content' ) );
		
		/* settings */
		add_action( 'admin_init', array( $this,'settings' ));

		/* fields */
		add_action ('woocsv_header_preview',array ( $this, 'fields' ) );
	}

	function settings () {
		add_settings_field('woocsv_demo_taxonomy', 'Add demo taxonomy', array($this,'demo_taxonomy'), 'woocsv-settings','woocsv-settings');
		register_setting( 'woocsv-settings', 'woocsv_demo_taxonomy', array($this,'options_validate') );
	}
	
	function demo_taxonomy () {
		$woocsv_demo_taxonomy = get_option('woocsv_demo_taxonomy');
		echo '<select id="woocsv_demo_taxonomy" name="woocsv_demo_taxonomy">';
			echo '<option '. selected("0",$woocsv_demo_taxonomy).' value="0">No</option>';
			echo '<option '. selected("1",$woocsv_demo_taxonomy).' value="1">Yes</option>';
		echo '</select>';
		echo '<p class="description">Enable a demo "brands" taxonomie </p>';
	}
	
	// validation
	function options_validate($input) {
		//no validation yet
		return $input;
	}

	public function get_custom_taxonomies()
	{
		// get all taxonomies that are attached to the custom post type product
		$taxonomies = get_object_taxonomies( 'product' );

		// remove the defaults and the product attributes
		$default_taxonomies = array ('product_type', 'product_cat', 'product_tag', 'product_shipping_class');
		$taxonomies = array_diff($taxonomies, $default_taxonomies);

		foreach ($taxonomies as $k=>$v) {
			if (substr($v, 0, 3) == 'pa_')
				unset($taxonomies[$k]);
		}
		
		return $taxonomies;
	}

	public function fields ()
	{
		global $woocsv_import;

		// fill in the header fields
		$taxonomies = $this->get_custom_taxonomies();
		
		if ($taxonomies) {
			foreach ($taxonomies as $taxonomy) {
				$woocsv_import->fields[] = $taxonomy;
			}
		}
	}


	public function save ()
	{
		global $woocsv_product;
		$taxonomies = $this->get_custom_taxonomies();
		
		// loop through the taxonomies and check if they are in the header
		foreach ($taxonomies as $taxonomy) {
			
			$key = array_search($taxonomy, $woocsv_product->header);
			
			if ( $key !== false && !empty($woocsv_product->raw_data[$key] ) ) {
			
				//clear currrent
				wp_set_object_terms( $woocsv_product->body['ID'], null, $taxonomy );

				$terms = explode('|', $woocsv_product->raw_data[$key]);
				foreach ($terms as $term) {
					$terms_taxs = explode( '->', $term );
					$parent = false;
					foreach ( $terms_taxs as $term_tax) {
						$new_term = term_exists( $term_tax, $taxonomy, $parent );
						if ( ! is_array( $new_term ) ) {
							$new_term = wp_insert_term( $term_tax, $taxonomy, array( 'slug' => $term_tax, 'parent'=> $parent) );
						}
						if (!is_wp_error($new_term)) {
							$parent = $new_term['term_id'];
						}

					}
					if (!is_wp_error($new_term))
						wp_set_object_terms( $woocsv_product->body['ID'], (int)$new_term['term_id'], $taxonomy, true );
				}

				// delete the children in the option table of the taxonomy
				delete_option($taxonomy.'_children');
			}
		}
	}

	function content()
	{
		$taxonomies = $this->get_custom_taxonomies();
?>
			<hr>
			<h2><?php echo __('Import taxonomies'); ?></h2>
			<?php if (empty($taxonomies) ) : ?>
				<div class="error"><p><?php echo __('There are no taxonomies!.'); ?></p></div>
			<?php else: ?>
				<h2><?php echo __('You have the following custom taxonomies:'); ?></h2>
				<ul>
				<?php foreach ($taxonomies as $taxonomy)
			echo sprintf(__('<li>Taxonomy: <b><i> %s </i></b> use this header tag in your CSV: <code> %s </code></li>' ),$taxonomy,$taxonomy);
?>
				</ul>

			<?php endif; ?>
			<h2><?php echo __('Usage'); ?> </h2>
			<p>
				<?php echo __('If there are custom taxonomies they will be added to the dropdowns in the header tab. Map the right taxonomy to the right field in your CSV.'); ?>
				<?php echo __('To have multiple values for the taxonomy you can use the pipe separator like this: <code>value1|vale2|value3</code>. If you want to have childs you can do like this <code>value1->subvalue1|value2->subvalue2</code>'); ?>
			</p>
			<?php
	}
}

//demo taxonomy
function woocsv_demo_taxonomy() {
	// create a new taxonomy
	register_taxonomy(
		'brands',
		'product',
		array(
			'label' => __( 'Brands' ),
			'rewrite' => array( 'slug' => 'brand' ),
			'hierarchical' => true,
		)
	);
}

if ( get_option('woocsv_demo_taxonomy') ) 
	add_action( 'init', 'woocsv_demo_taxonomy' );