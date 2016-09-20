<?php
class sns_Megamenu_Front extends Walker_Nav_Menu { 
    var $columns = 0;
    var $enablemega = 0;
	var $stylemega = '';
	var $sidebaremega = '';

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
       
		if($depth === 0 && $this->enablemega && $this->stylemega !=''){
			$output .= "\n$indent<div class=\"sub-content dropdownmenu\"><ul class=\"". esc_attr( $this->stylemega ) ." {replace_class}\">\n";
		}else{
			$output .= "\n$indent<ul class=\"sub-menu {replace_class}\">\n";
		}
       
    }
    function end_lvl(&$output, $depth = 0, $args = array()) { 
        $indent = str_repeat("\t", $depth);
        // add menu sidebar
        if($depth === 0 && $this->enablemega && $this->stylemega !=''){
	        	if($this->sidebaremega == 'menu_sidebar_1'){
	        		$left_sidebar_content = '';
	        		if (is_active_sidebar('menu_sidebar_1')){
	        			ob_start();
	        			dynamic_sidebar('menu_sidebar_1');
	        			$left_sidebar_content	.= ob_get_clean();
	        		}
	        		
	        		$left_sidebar = '<li id="left-menu-item-sidebar" class="menu-item">'.$left_sidebar_content.'</li>';
	        		$output .= "$indent$left_sidebar</ul></div>\n";
	        		
	        	}elseif ($this->sidebaremega == 'menu_sidebar_2'){ // Menu Sidebar #2
	        		$bottom_sidebar_content = '';
	        		if (is_active_sidebar('menu_sidebar_2')){
	        			$bottom_sidebar_content = '<div class="row">';
	        			ob_start();
	        			dynamic_sidebar('menu_sidebar_2');
	        			$bottom_sidebar_content	.= ob_get_clean();
	        			$bottom_sidebar_content	.='</div>';
	        		}
	        		
	        		$bottom_sidebar = '<div id="bottom-menu-item-sidebar">'.$bottom_sidebar_content.'</div>';
	        		$output .= "$indent</ul>$bottom_sidebar</div>\n";
	        	}else{
	        		$output .= "$indent</ul></div>\n";
	        	}
        }
        else{
        	$output .= "$indent</ul>\n";
        }
        
        if ($depth === 0) {
            if($this->enablemega && $this->columns > 0){
            	if($this->sidebaremega == 'menu_sidebar_1') $this->columns = $this->columns + 1; // Add a column for Left Sidebar Menu
                $output = str_replace("{replace_class}", "enable-megamenu row-fluid col-".$this->columns."", $output);
                $this->columns = 0;
            }
            else{
                $output = str_replace("{replace_class}", "", $output);
            }
        }
    }    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $item_output = $li_text_block_class = $column_class = "";
        if($depth === 0){   
            $this->enablemega = get_post_meta( $item->ID, '_sns_megamenu_item_enable', true);
            $this->stylemega = get_post_meta( $item->ID, '_sns_megamenu_item_style', true);
            $this->sidebaremega = get_post_meta( $item->ID, '_sns_megamenu_item_sidebar', true);
        }
        if($depth === 1 && $this->enablemega) {
            $this->columns ++;
			if( $item->hidetitlemega != true && $this->stylemega == 'columns'){
                 $title = apply_filters( 'the_title', $item->title, $item->ID );
                if($title != "-" && $title != '"-"'){
                   $attributes = ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';      
            
                   $item_output .= $args->before;
                   $item_output .= '<h4 class="megamenu-title"'. $attributes .'>';
                   $item_output .= (get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '')?'<i class="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'"></i>':'';
                   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                   $item_output .= '</h4>';
                   $item_output .= $args->after;
               }
			}
			if( $this->stylemega == 'preview' ){ //var_dump($item);
				
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
				
				$description = $item->description;
				
				$item_output .= $args->before;
				$item_output .= '<div class="item-post">';
				$item_output .= '<div class="item-preview">';
				$item_output .= '<a'. $attributes .'>';
				$item_output .= $this->content_preview($item->object, $item->object_id);
				$item_output .= '</a>';
				$item_output .= '</div>';
				$item_output .= '<h3 class="title"><a'. $attributes .'>';
				$item_output .= (get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '')?'<i class="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'"></i>':'';
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= '</a></h3>';
				$item_output .= '<div class="item-desc">';
				$item_output .= $description;
				$item_output .= '</div>';
				$item_output .= '</div>';
				$item_output .= $args->after;
			}
        }else{
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';            
        
            $item_output .= $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= (get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '')?'<i class="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'"></i>':'';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
        }
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        if( $depth == 0 && $this->enablemega && $this->stylemega !='') $class_names .= ' enable-mega';
        if ( get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '' ) $class_names .= ' have-icon';
        $class_names = ' class="'.$li_text_block_class. esc_attr( $class_names ) . $column_class.'"';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li '.$id . $value . $class_names .'>'; 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    /*
     * Method to get content preview like post thumbnail, product thumbnail, product category thumbnail
     */
    function content_preview($type, $item_id){
    	if( $type == '' ||  $item_id == ''){
    		return;
    	}
    	$html = '';
    	switch ($type){
    		case 'post':
    			if(has_post_thumbnail($item_id))
    				$html = get_the_post_thumbnail($item_id, 'snssimen_megamenu_thumb');
    			break;
    		case 'product':
    				if(has_post_thumbnail($item_id))
    					$html = get_the_post_thumbnail($item_id, 'snssimen_megamenu_thumb');
    			break;
    		case 'product_cat':
    			$thumbnail_id = get_woocommerce_term_meta($item_id, 'thumbnail_id', true);
    			if($thumbnail_id == '')
    				$thumbnail_id = get_woocommerce_term_meta($item_id, 'snscustom_product_cat_thumbnail_id', true);
    			
    			$cat_thumbnail = wp_get_attachment_image_src($thumbnail_id, 'snssimen_megamenu_thumb');
    			$image = isset($cat_thumbnail[0]) ? $cat_thumbnail[0] : wc_placeholder_img_src();
    			
    			$html = '<img src="'.$image.'" alt=""/>';
    			break;
    		default: 
    			
    	}
    	
    	return $html;
    }
    
}
?>