<?php
class snssimen_MegaMenu {
    function __construct() {
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'sns_megamenuset' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'sns_megamenusave'), 10, 3 );
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'sns_megamenuedit'), 10, 2 );
		add_action( 'admin_print_footer_scripts', array( $this, 'sns_megamenujs' ), 99 );
		add_action( 'admin_print_styles', array( $this , 'sns_loadadmincss'));
		add_action( 'admin_print_scripts', array( $this , 'sns_loadadminjs'));
	
    }
    // Set value
	function sns_megamenuset ( $item ) {
		// For 1st level
		$item->enablemega 	= get_post_meta( $item->ID, '_sns_megamenu_item_enable', true );
		$item->stylemega 	= get_post_meta( $item->ID, '_sns_megamenu_item_style', true );
		$item->sidebaremega = get_post_meta( $item->ID, '_sns_megamenu_item_sidebar', true );
		// For 2nd level
		$item->hidetitlemega = get_post_meta( $item->ID, '_sns_megamenu_item_hidetitle', true );
		// All level
		$item->iconmega = get_post_meta( $item->ID, '_sns_megamenu_item_icon', true );

		return $item;
	}
	
	// Save option to db	
    function sns_megamenusave( $menu_id, $menu_item_db_id, $args ) {
		// Enable
		if ( isset( $_REQUEST['sns-mega-mitem-enable'][$menu_item_db_id]) ) {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_enable', 1 );
		    
		    // Megamenu style
		    if ( isset( $_REQUEST['sns-mega-mitem-style'][$menu_item_db_id] ) ){
		    	$style_value = $_REQUEST['sns-mega-mitem-style'][$menu_item_db_id];
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_style', $style_value);
		    }
		    // Megamenu sidebar
		    if ( isset( $_REQUEST['sns-mega-mitem-sidebar'][$menu_item_db_id] ) ){
		    	$sidebar_value = $_REQUEST['sns-mega-mitem-sidebar'][$menu_item_db_id];
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_sidebar', $sidebar_value);
		    }
		} else {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_enable', 0 );
		    
		    // Megamenu style
		    if ( isset( $_REQUEST['sns-mega-mitem-style'][$menu_item_db_id] ) ){
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_style', '');
		    }
		    // Megamenu sidebar
		    if ( isset( $_REQUEST['sns-mega-mitem-sidebar'][$menu_item_db_id] ) ){
		    	update_post_meta($menu_item_db_id, '_sns_megamenu_item_sidebar', '');
		    }
		}
		
		// Hide title
		if ( isset( $_REQUEST['sns-mega-mitem-hidetitle'][$menu_item_db_id]) ) {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_hidetitle', 1 );
		} else {
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_hidetitle', 0 );
		}
		// Icon
		if ( isset( $_REQUEST['sns-mega-mitem-icon'][$menu_item_db_id]) ) {
		    $icon_value = $_REQUEST['sns-mega-mitem-icon'][$menu_item_db_id];
		    update_post_meta( $menu_item_db_id, '_sns_megamenu_item_icon', $icon_value );
		}
		    
    }
	// Edit form
    function sns_megamenuedit($walker, $menu_id) {
	    return 'sns_Megamenu_Admin'; 
	}
	// Load css file
	function sns_loadadmincss(){
		wp_enqueue_style('thickbox');
		wp_enqueue_style( 'icon-picker', SNSSIMEN_THEME_URI.'/assets/css/admin_megamenu.css', false, '1.0', 'all' );
		wp_enqueue_style('fonts-awesome', SNSSIMEN_THEME_URI . '/assets/fonts/awesome/css/font-awesome.min.css');
		
	}
	// Load js file
	function sns_loadadminjs(){
		wp_enqueue_script('thickbox');
		
	}
	// Load js inline
    function sns_megamenujs() {
    	global $wp_filesystem;
        // Initialize the Wordpress filesystem, no more using file_put_contents function
        if ( empty( $wp_filesystem ) ) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }
	    $icon_fa = array();
		$content_fa = '';
	    if( file_exists( get_template_directory().'/assets/fonts/awesome/css/font-awesome.css' ) ) {
			$content_fa = $wp_filesystem->get_contents(get_template_directory().'/assets/fonts/awesome/css/font-awesome.css');
	    }
	    preg_match_all('/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/', $content_fa , $matches_fa, PREG_SET_ORDER);
	    foreach($matches_fa as $k => $v){
		   $icon_fa[$k] = $v[1];
	    }
	    ?>
		<div id="sns_iconmegapicker" style="display:none">
		    <div class="mega-icon-option wpb-icon-prefix">
		    <?php		
		    if( is_array($icon_fa ) && !empty($icon_fa)) {
		    	echo '<i class=""></i>';
		        foreach( $icon_fa as $k => $v) { 
		            echo '<i class="fa '.esc_attr($v).'"></i>';
		        }
	     	}
			?>
		    </div>
		</div> 
		<script type="text/javascript">
			jQuery(function(){
			  	var snsmegamenu = {
					timeout : false ,
					$show: '',
					init : function(){
						var iconfield = null ;
						var megaicon = null;
						jQuery('.sns-iconpicker').on('click',function(e){
								iconfield = jQuery('#sns-mega-mitem-icon-'+ jQuery(this).attr('data-pickerid') );
								megaicon = iconfield.parent().find('i');
							    tb_show( jQuery(this).attr('title') , '#TB_inline?width=580&height=450&inlineId=sns_iconmegapicker');
							    jQuery('.mega-icon-option i').each(function(){
							    	if( jQuery(this).attr('class') == megaicon.attr('class') ){
							    		jQuery('.mega-icon-option i').removeClass('selected'); jQuery(this).addClass('selected');
							    	}
							    })
							    return false;
						});
					    jQuery('.mega-icon-option i').live('click', function(e) {
					       e.preventDefault();
					       iclass = jQuery(this).attr('class').replace('selected', '').trim();
						   iconfield.attr('value', iclass);
						   megaicon.attr('class', iclass).attr('style', 'display:inline-block');
						   if( megaicon.attr('class') == '' ) megaicon.attr('style', 'display:none');
						   window.parent.tb_remove();
						});

						// megamenu style
						jQuery('.field-megamenu-enable').each(function(){
							var $this = jQuery(this);
							// Checked
							if( $this.find('input:checkbox').attr('checked') == 'checked' ){
								$this.closest('.sns-megamenu-options').find('.field-megamenu-style').show();
							}
							
							// on change
							$this.find('input:checkbox').change(function(){
								var $snsMegam_check = (this.checked) ? 'checked' : 'uncheck'; 
								if( $snsMegam_check == 'checked' ){ // display megamenu style
									$this.closest('.sns-megamenu-options').find('.field-megamenu-style').show();
									if($this.closest('.sns-megamenu-options').find('.field-megamenu-style select option:selected').val() == 'columns'){
										$this.closest('.sns-megamenu-options').find('.field-megamenu-sidebar').show();
									}
								}else{
									$this.closest('.sns-megamenu-options').find('.field-megamenu-style').hide();
									$this.closest('.sns-megamenu-options').find('.field-megamenu-sidebar').hide();
								}
							});
						});

						// Sidebar Megamenu, the sidebar menu only support for megamenu columns style
						jQuery('.field-megamenu-style').each(function(){
							var $this = jQuery(this);

							// show option menu sidebar if meny style is columns
							var $columns = $this.find("select option:selected" ).val();
							if($columns == 'columns'){
								$this.closest('.sns-megamenu-options').find('.field-megamenu-sidebar').show();
							}

							// on change style
							$this.find('select').change(function(){
								var $this_val = jQuery(this).find(":selected").val();
								if($this_val == 'columns'){
									$this.closest('.sns-megamenu-options').find('.field-megamenu-sidebar').show();
								}else{
									$this.closest('.sns-megamenu-options').find('.field-megamenu-sidebar').hide();
								}
							});
						});
					},
			    }
			
				snsmegamenu.init();
				jQuery( ".menu-item-bar" ).live( "mouseup", function(event, ui) {
			        if ( !jQuery(event.target).is('a') ) {
					     clearTimeout(snsmegamenu.timeout);
				         snsmegamenu.timeout = setTimeout(snsmegamenu.init() , 700);
					}
			    });
			});
		</script>
	<?php
	}		
}

// Init snssimen_MegaMenu
$sns_mega = new snssimen_MegaMenu();
require_once SNSSIMEN_THEME_DIR . '/framework/mega-menu/admin.php';
require_once SNSSIMEN_THEME_DIR . '/framework/mega-menu/frontend.php';

?>
