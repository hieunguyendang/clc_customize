<?php
if ( ! function_exists( 'snssimen_importdata' ) ) {
	function snssimen_importdata(){
		$msg = '';
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
		    require_once ABSPATH . '/wp-admin/includes/file.php';
		    WP_Filesystem();
		}
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
			require_once ABSPATH . 'wp-admin/includes/import.php';
			$importer_error = false;
		if ( !class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) ){
				require_once $class_wp_importer;
			}else{
				$importer_error = true;
			}
		}
		if ( !class_exists( 'WP_Import' ) ) {
			$class_wp_import = get_template_directory() . '/framework/sample-data/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) ){
				require_once $class_wp_import;
				
			}else{
				$importer_error = true;
			}	  
		}
		if($importer_error){
			die("Import error! Please unninstall WP importer plugin and try again");
		}
		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;
		ob_start();
		$datatype = isset($_POST['datatype'])?$_POST['datatype']:'';
		if( $datatype=='slider' ){
			if(!snssimen_import_revslider()){
				die('<br />You haven\'t install Rev Slider plugin. Slider isn\'t imported<br />');
			}
		}
		if( $datatype=='widget' ){
			$widgets_json = get_template_directory_uri() . '/framework/sample-data/data/widget_data.json';
	        $widget_data = $wp_filesystem->get_contents($widgets_json);
	        ob_start();
			snssimen_import_widget($widget_data);
			ob_end_clean();
			update_option('snssimen_imported_widget', 1);
		}
		if( $datatype=='content' ){
			// Delete old menu and import new
			wp_delete_nav_menu('main-menu');
			wp_delete_nav_menu('customer-services');
			wp_delete_nav_menu('footer-menu');
			wp_delete_nav_menu('information');
			wp_delete_nav_menu('shipping-info');
			wp_delete_nav_menu('top-menu');
			// Import content
			$wp_import->import(get_template_directory() . '/framework/sample-data/data/all-content.xml');
			update_option('snssimen_imported_content',1);

			// Set menu location
			$locations = get_nav_menu_locations();
			if(empty($locations)){
				$locations = array(
					'main_navigation' => '',
					'top_navigation'  => '',
					'footer_navigation'  => ''
				);
			}
		    foreach($locations as $locationId => $menuValue){
		        switch($locationId){
		            case 'main_navigation':
		                $menu = get_term_by('name', 'Main Menu', 'nav_menu');
		            break;

		            case 'top_navigation':
		                $menu = get_term_by('name', 'Top Menu', 'nav_menu');
		            break;

		            case 'footer_navigation':
		                $menu = get_term_by('name', 'Footer Menu', 'nav_menu');
		            break;
		        }

		        if(isset($menu)){
		            $locations[$locationId] = $menu->term_id;
		        }
		    }
		    set_theme_mod('nav_menu_locations', $locations);
		}
		if( $datatype=='theme' ){
			$option_json = get_template_directory_uri() . '/framework/sample-data/data/theme-options.json';
	        $option_data = $wp_filesystem->get_contents($option_json);
			snssimen_set_themeoptions($option_data);
		}
		ob_end_clean();
		if($datatype == 'widget'){
			$msg .= 'Import is finished.';
		}
		die($msg);
	}
}
if ( ! function_exists( 'snssimen_set_themeoptions' ) ){
	function snssimen_set_themeoptions($option){
		$option = json_decode($option,true);
		update_option('snssimen_themeoptions',$option);
	}
}
if(!function_exists('snssimen_import_revslider')){
	function snssimen_import_revslider(){

		if(class_exists('UniteBaseAdminClassRev')){
			require_once ABSPATH .'wp-content/plugins/revslider/admin/revslider-admin.class.php';
			if ($handle = opendir(get_template_directory().'/framework/sample-data/data/revslider')) {
			    while (false !== ($entry = readdir($handle))) {
			        if ($entry != "." && $entry != "..") {
			            $_FILES['import_file']['tmp_name']=get_template_directory().'/framework/sample-data/data/revslider/'.$entry;
			            $slider = new RevSlider();
			            ob_start();
						$response = $slider->importSliderFromPost(true, true);
						ob_end_clean();
			        }
			    }
			    closedir($handle);
			}
			return true;
		}
		return false;
	}
}
if(!function_exists('snssimen_import_widget')){
	function snssimen_import_widget($import_array){
		global $wp_registered_sidebars;
		$json_data 		= $import_array;
    	$json_data 		= json_decode( $json_data, true );
		$sidebars_data 	= $json_data[0];
		$widget_data 	= $json_data[1];
		$new_widgets 	= array( );
		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :
			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
					$title 					= trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index 					= trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data 	= get_option( 'widget_' . $title );
					$new_widget_name 		= snssimen_widget_name( $title, $index );
					$new_index 				= trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] 		= $widget_data[$title][$index];
						// $multiwidget 							= $new_widgets[$title]['_multiwidget'];
						// unset( $new_widgets[$title]['_multiwidget'] );
						// $new_widgets[$title]['_multiwidget'] 	= $multiwidget;
					} else {
						$current_widget_data[$new_index] 		= $widget_data[$title][$index];
						// $current_multiwidget 					= $current_widget_data['_multiwidget'];
						// $new_multiwidget 						= isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
						// $multiwidget 							= ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
						// unset( $current_widget_data['_multiwidget'] );
						// $current_widget_data['_multiwidget'] 	= $multiwidget;
						$new_widgets[$title] 					= $current_widget_data;
					}
				endif;
			endforeach;
		endforeach;

		if( isset( $new_widgets ) || isset( $current_sidebars ) ){
			if ( isset( $new_widgets ) ) {
				foreach ( $new_widgets as $title => $content ){
					update_option( 'widget_' . $title, $content );
				}
			}
			if ( isset( $current_sidebars ) ){
				update_option( 'sidebars_widgets', $current_sidebars );
			}
			return true;
		}
		return false;
	}
}
if(!function_exists('snssimen_widget_name')){
	function snssimen_widget_name($widget_name, $widget_index){
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
}
?>