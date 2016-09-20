<?php

class woocsvTaxonomy_old {

	protected $textdomain = 'woocsvtaxonomy';

	public function __construct() {
		//========================
		//! save taxonomies hook
		//========================
		add_action('woocsv_after_save', array($this, 'saveTaxonomies'));


		//===================================
		//! create a submenu for the add-on
		//===================================
		add_action('admin_menu', array($this, 'adminMenu'));


		//===============================================================
		//! populate the fields for the dropdowns in the header section
		//===============================================================
		add_action ('woocsvOutputHeader', array($this, 'addToFields'));

	}


	public function adminMenu()
	{
		//================================
		//! Add submenu page to CSV menu
		//================================
		add_submenu_page( 'woocsv_import', 'Taxonomies', 'Taxonomies', 'manage_options', 'woocsvTaxonomies', array($this, 'addToAdmin'));
	}


	public function getCustomTaxonomies()
	{
		//========================================================================
		//! get all taxonomies that are attached to the custom post type product
		//========================================================================
		$taxonomies = get_object_taxonomies( 'product' );


		//==================================================
		//! remove the defaults and the product attributes
		//==================================================
		$default_taxonomies = array ('product_type', 'product_cat', 'product_tag', 'product_shipping_class');
		$taxonomies = array_diff($taxonomies, $default_taxonomies);

		foreach ($taxonomies as $k=>$v) {
			if (substr($v, 0, 3) == 'pa_')
				unset($taxonomies[$k]);
		}
		return $taxonomies;
	}

	public function addToFields()
	{
		global $woocsv_import;

		//=============================
		//! fill in the header fields
		//=============================
		$taxonomies = $this->getCustomTaxonomies();
		if ($taxonomies) {
			foreach ($taxonomies as $taxonomy) {
				$woocsv_import->fields[] = $taxonomy;
			}
		}


		//==========================
		//! add them to the fields
		//==========================
		$woocsv_import->fields[] = '';
	}


	public function saveTaxonomies()
	{
		global $woocsv_product;
		$taxonomies = $this->getCustomTaxonomies();

		//===================================================================
		//! loop through the taxonomies and check if they are in the header
		//===================================================================
		foreach ($taxonomies as $taxonomy) {
			$key = array_search($taxonomy, $woocsv_product->header);
			if ( $key > 0 && !empty($woocsv_product->rawData[$key] ) ) {

				//clear currrent
				wp_set_object_terms( $woocsv_product->body['ID'], null, $taxonomy );

				$terms = explode('|', $woocsv_product->rawData[$key]);
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

				//===========================================
				//! delete the children in the option table of the taxonomy
				//===========================================
				delete_option($taxonomy.'_children');

			}

		}

	}



	function addToAdmin()
	{
		$taxonomies = $this->getCustomTaxonomies();
?>

			<div class="woocsvContainer">
			<div id="icon-themes" class="icon32"><br></div>
			<h2 class="nav-tab-wrapper">
				<a href="#" class="nav-tab nav-tab-active"><?php echo __('Import taxonomies', $this->textdomain); ?></a>
			</h2>
			<?php if (empty($taxonomies) ) : ?>
				<div class="error"><p><?php echo __('There are no taxonomies!.', $this->textdomain); ?></p></div>
			<?php else: ?>
				<h2><?php echo __('You have the following custom taxonomies:', $this->textdomain); ?></h2>
				<ul>
				<?php foreach ($taxonomies as $taxonomy)
			echo sprintf(__('<li>Taxonomy: <b><i> %s </i></b> use this header tag in your CSV: <code> %s </code></li>', $this->textdomain ),$taxonomy,$taxonomy);
?>
				</ul>

			<?php endif; ?>
			<h2><?php echo __('Usage', $this->textdomain); ?> </h2>
			<p>
				<?php echo __('If there are custom taxonomies they will be added to the dropdowns in the header tab. Map the right taxonomy to the right field in your CSV.', $this->textdomain); ?>
				<?php echo __('To have multiple values for the taxonomy you can use the pipe separator like this: <code>value1|vale2|value3</code>. If you want to have childs you can do like this <code>value1->subvalue1|value2->subvalue2</code>', $this->textdomain); ?>
			</p>

			</div>
			<?php
	}
}