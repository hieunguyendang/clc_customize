<?php
if ( ! class_exists( 'snssimen_Class' ) ) {
	class snssimen_Class {
		public function __construct() {
			// Set cookie theme option
			add_action( 'wp_ajax_sns_setcookies', array($this,'sns_setcookies') );
			add_action( 'wp_ajax_nopriv_sns_setcookies', array($this,'sns_setcookies') );
			// Reset cookie theme option
			add_action( 'wp_ajax_sns_resetcookies', array($this,'sns_resetcookies') );
			add_action( 'wp_ajax_nopriv_sns_resetcookies', array($this,'sns_resetcookies') );
		}
		public function sns_setcookies(){
			setcookie('snssimen_'.$_POST['key'], $_POST['value'], time()+3600*24*1, '/'); // 1 day
			
		}
		public function sns_resetcookies(){
			setcookie('snssimen_theme_color', '', 0, '/');
			setcookie('snssimen_use_boxedlayout', '', 0, '/');
			setcookie('snssimen_use_stickmenu', '', 0, '/');
		}
		function getStyle($compile = 2, $scss = array('dir' => '', 'name' => ''), $css = array('dir' => '', 'name' => ''), $format = 'scss_formatter_compressed', $variables = array() ) {
			if($css['name'] == '') $css['name'] = $scss['name'];
			$scss_variables = '';
			if($variables) {
				//$css['name'] .= '-';
				foreach($variables as $propety => $value) {
					$scss_variables .= $propety . ':' . $value . ';';
					$css['name'] .= '-'.strtolower(preg_replace('/\W/i', '', $value));
				}
			}
			
			if( $compile == 2 || !file_exists(get_template_directory() . '/assets/css/' . $css['name'] . '.css') )
				$this->compileScss($scss, $css, $format, $scss_variables);
			return $css['name'] . '.css';
		}
		function compileScss($scss, $css, $format, $scss_variables) {
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			require "scssphp/scss.inc.php";
			require "scssphp/compass/compass.inc.php";
			$sass = new scssc();
			new scss_compass($sass);
			$format = ($format == NULL) ? 'scss_formatter_compressed' : $format;
			$sass->setFormatter($format);
			$sass->addImportPath($scss['dir']);
			$string_sass = $scss_variables . $wp_filesystem->get_contents($scss['dir'] . $scss['name'] . '.scss');
			$string_css = $sass->compile($string_sass);
			//$string_css = preg_replace('/\/\*[\s\S]*?\*\//', '', $string_css); // remove mutiple comments
			$wp_filesystem->put_contents(
				$css['dir'] . $css['name'] . '.css',
				$string_css,
			  	FS_CHMOD_FILE
			);
		}
		function getOption($param, $default = '', $key = ''){
			global $snssimen_opt;
			$value = '';
			// Get config via theme option
			if($key !== ''){
				if ( isset($snssimen_opt[$param][$key]) && $snssimen_opt[$param][$key] ) $value = $snssimen_opt[$param][$key];
			}else{
				if ( isset($snssimen_opt[$param]) && $snssimen_opt[$param] ) $value = $snssimen_opt[$param];
			}
			
			// Get config via cookie
			if ( isset($_COOKIE['snssimen_'.$param]) && $_COOKIE['snssimen_'.$param] != '' ) {
				$value = $_COOKIE['snssimen_'.$param];
			}
			
			// Get config via page config
			if(is_page()){
				if ( function_exists('rwmb_meta') && rwmb_meta('snssimen_'.$param) ) $value = rwmb_meta('snssimen_'.$param);
			}
			
			if($value || class_exists( 'ReduxFramework' ))
				return $value; 
			// return default value
			return $default;
		}
		function theme_css_file(){
			$optimize = '';
			$theme_color = $this->getOption('theme_color', '#e34444');
			$top_header_bg = $this->getOption('top_header_bg', '#222222');
			$top_header_color = $this->getOption('top_header_color','#888888');
			
			// Get page meta data
			if ( is_page() && function_exists('rwmb_meta') && rwmb_meta('snssimen_page_themecolor') == 1) {
				$theme_color = rwmb_meta('sns_theme_color') != '' ? rwmb_meta('snssimen_theme_color') : $theme_color;
			}
			
			// Body color
			$body_color = $this->getOption('body_font', '#666666', 'color');
			if( empty($body_color) ) $body_color = '#666666';
			
			// Config for header layout
			if(function_exists('rwmb_meta') && rwmb_meta('snssimen_header_layout') != '' ){
				$top_header_bg = rwmb_meta('snssimen_header_bg') != '' ? rwmb_meta('snssimen_header_bg') : $top_header_bg;
				$top_header_color = rwmb_meta('snssimen_header_color') != '' ? rwmb_meta('snssimen_header_color') : $top_header_color;
			}
			
			$scss_compile = $this->getOption('advance_scss_compile', 1);
			$scss_format = $this->getOption('advance_scss_format', 'scss_formatter_compressed');
			
			// Compile scss and get css file name
			$css_file = $this->getStyle(
				$scss_compile,
				array('dir' => SNSSIMEN_THEME_DIR . '/assets/scss/', 'name' => 'theme'),
				array('dir' => SNSSIMEN_THEME_DIR . '/assets/css/', 'name' => 'theme'),
				$scss_format,
				array(
					'$color1' => $theme_color,
					'$color' => $body_color,
					'$top_header_bg' => $top_header_bg,
					'$top_header_color' => $top_header_color,
				)
			);
			
			return $css_file;
		}
	}
}
?>