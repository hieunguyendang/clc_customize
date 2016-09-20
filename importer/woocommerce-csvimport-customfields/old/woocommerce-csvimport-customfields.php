<?php

class woocsv_import_custom_fields_old {

	public function __construct() {

		add_action('woocsv_after_save',array($this,'saveCustomFields'));
		add_action('wp_ajax_saveCustomFields', array($this, 'saveCustomFieldForm'));
		
		add_action('admin_init', array($this, 'initJsCss'));
		add_action('admin_menu', array($this,'adminMenu'));
		
		$this->addToFields();
	}
		
	public function adminMenu() {
		add_submenu_page( 'woocsv_import', 'Custom Fields', 'Custom Fields', 'manage_options', 'woocsvCustomfields', array($this,'addToAdmin'));
	}
	
	public function addToFields() {
		global $woocsvImport;
		$customFields = get_option('woocsv-customfields');
		if ($customFields) {
			$customFields = explode(',', $customFields);
			foreach ($customFields as $key=>$value) {
				$woocsvImport->fields[] = 'cf_'.$value;
				}
		}
		
	}

	public function initJsCss () {
		wp_register_script( 'woocsv-custom-field-script', plugin_dir_url( __FILE__ ).'woocsv-custom-field.js' );
		wp_enqueue_script( 'woocsv-custom-field-script' );
	}

	public function saveCustomFieldForm() {
		$customfields = $_POST['customFields'];
		update_option('woocsv-customfields', trim($customfields));
		wp_die('<p>Custom fields saved!</p>');
	}

	public function saveCustomFields ($product) {
		foreach ($product->header as $key=>$value) {
			if (substr($value,0,3) === 'cf_') {				
				if (isset($product->rawData[$key])) {
					update_post_meta( $product->body['ID'], substr($value,3), $product->rawData[$key]);
				}
			}
		}
	}
	
	function addToAdmin () {
	?>
		<div class="wrap">
			<?php 
			$class = "error";
			$message = "You have an old version of the woocommerce CSV importer installed! Not all new functionality will work, please update to version 3.0.0 or higher. ";
		    echo"<div class=\"$class\"> <p>$message</p></div>";
		    ?>
		<h2>Add your custom fields</h2>
		<p>You can fill in your custom fields here. Fill them in as a comma separated list.
		Example: customfield1,customfield2,customfield3</p>
		<p>You can select them when you create your header as cf_customfield1,cf_customfield2, etc.....</p>
		<form id="customFieldForm" method="POST">
		<table class="form-table">
		<tbody>
			<tr>
				<th scope="row" class="titledesc"><label for="seperator">Custom fields</label></th>
				<td>
					<input type="text" size="100" placeholder="list your customfields comma seperated" 
						name="customFields" value="<?php echo get_option('woocsv-customfields');?>">
				</td>
			</tr>
			<tr>
				<td><button type="submit" class="button-primary">Save</button></td>
			</tr>
		</tbody>
		</table>

		<input type="hidden" name="action" value="saveCustomFields">
		</form>
		</div>
		<?php
	}
}