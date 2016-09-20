<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $woocommerce;
// Array tabs title
$tab_titles = $this->getListTabTitle(); //var_dump($tab_titles);
$carousel_row_number = '';

$uq = rand().time();
$class = 'sns-product-tabs woocommerce template-'.esc_attr($template);
if( $template == 'carousel' ){
	
	wp_enqueue_script('owlcarousel');
	$class .= ' pre-load'; 
	$carousel_row_number = $carousel_row;
}
$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));

// Show category thumbnail for carousel. Only display with the tab titile is categiry.
$cat_thumb_class = '';
$navslider_class = '';
if($template ==  'carousel' && $tab_types == 'category' && $cat_thumbnail == 'show'){
	$cat_thumb_class = ' sns-tab-cat-thumbnails';
	$navslider_class = ' sns-navslider-thumbnail';
	$class .= ' wpb_heading_top';
}

ob_start();
?>
<div id="sns_product_tabs<?php echo esc_attr($uq);?>" class="<?php echo esc_attr($class); ?>">
<?php if( class_exists('WooCommerce') ){ ?>
	<?php 
	if ($template == 'grid') :
		$number_query = $row*$col;
	else:
		$number_query = $number_limit;
	endif;
	
	if ($tab_types == 'category'){
		if( empty($list_cat) ){
			$tabs = $this->getCats();
		}else{
			$tabs = explode(',', $list_cat);
		}
	}else{ // Tab type orderby
		$tabs = explode(',', $list_orderby);
	}
	?>
	
	<?php if($template ==  'carousel'):?>
	<div class="sns-nav-tabs-warpper">
	<?php endif; ?>
		<?php if ($title !='' ) : ?>
		<h2 class="wpb_heading"><span><?php echo esc_attr($title); ?></span></h2>
		<?php endif; ?>
		<ul class="nav-tabs gfont <?php echo esc_attr($cat_thumb_class); ?>">
			<?php
			$i = 0;
			$aclass = '';
			$data_type = 'cat';
			foreach ($tab_titles as $tab) { 
				$i++;
				$aclass = 'intent-tab ';
				if ( $i == 1){
					$class = 'nav-item first';
					$aclass .= 'tab-loaded ';
				}else{
					$class = 'nav-item';
				}
				
				if($tab_types == 'category'){
					$cat = $tab['name'];
					$data_type = 'cat';
				}else{
					$cat = $list_cat;
					$orderby = $tab['name'];
					$data_type = 'order';
				}
				
				?>
					<li class="<?php echo esc_attr($class); ?>">
						<a href="#producttabs_<?php echo esc_attr($tab['name']); ?>" class="<?php echo esc_attr($aclass);?>" title="<?php echo esc_attr($tab['title']); ?>"
							data-type			= "<?php echo esc_attr($data_type);?>"
							data-tab-id			= "producttabs_<?php echo esc_attr($tab['name']);?>"
							data-cat			= "<?php echo esc_attr($cat);?>"
							data-template		= "<?php echo esc_attr($template);?>"
							data-orderby		= "<?php echo esc_attr($orderby);?>"
							data-number-query	= "<?php echo esc_attr($number_query);?>"
							data-number-display	= "<?php echo esc_attr($number_display);?>"
							data-number-limit	= "<?php echo esc_attr($number_limit);?>"
							data-effect-load	= "<?php echo esc_attr($effect_load);?>"
							data-col			= "<?php echo esc_attr($col);?>"
							data-uq				= "<?php echo esc_attr($uq);?>"
							data-number-load	= "<?php echo esc_attr($number_load);?>"
							data-carousel-row-number = "<?php echo esc_attr($carousel_row_number);?>"
							>
							<?php if($cat_thumb_class != ''): // Show category thumbnail?>
							<img src="<?php echo esc_attr($tab['thumbnail']); ?>" alt=""/>
							<?php endif; ?>
							<span><?php echo esc_html($tab['short_title']); ?></span>
						</a>
					</li>
				<?php
			}
			?>
		</ul>
		<ul>
		    <li class="dropdown pull-left tabdrop hidden-lg hidden-md">
		        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
		            <span class="display-tab"><i class="fa fa-align-justify"></i></span>
		        </a>
		        <ul class="dropdown-menu gfont">
		            <?php
		            foreach ($tab_titles as $tab) { 
		                ?>
		                <li class="nav-item">
		                    <a href="#drop_producttabs_<?php echo esc_attr($tab['name']); ?>" class="<?php echo esc_attr($aclass);?>" title="<?php echo esc_attr($tab['title']); ?>"
								data-type			= "<?php echo esc_attr($data_type);?>"
								data-tab-id			= "producttabs_<?php echo esc_attr($tab['name']);?>"
								data-cat			= "<?php echo esc_attr($cat);?>"
								data-template		= "<?php echo esc_attr($template);?>"
								data-orderby		= "<?php echo esc_attr($orderby);?>"
								data-number-query	= "<?php echo esc_attr($number_query);?>"
								data-number-display	= "<?php echo esc_attr($number_display);?>"
								data-number-limit	= "<?php echo esc_attr($number_limit);?>"
								data-effect-load	= "<?php echo esc_attr($effect_load);?>"
								data-col			= "<?php echo esc_attr($col);?>"
								data-uq				= "<?php echo esc_attr($uq);?>"
								data-number-load	= "<?php echo esc_attr($number_load);?>"
								data-carousel-row-number = "<?php echo esc_attr($carousel_row_number);?>"
		                    ><?php echo esc_html($tab['short_title']); ?></a>
		                </li>
		            <?php } ?>
		        </ul>
		    </li>
		</ul>
	<?php if($template ==  'carousel'):?>
	</div><!-- /.sns-nav-tabs-warppe -->
	<?php endif; ?>
	
	<div class="tab-content <?php echo esc_attr( $navslider_class ) ; ?>">
	<?php 
		$ii = 0;
		foreach ($tabs as $tab) {
			$ii ++;
			if( $ii == 1){
				if($tab_types == 'category'){
					$cat = $tab;
				}else{
					$cat = $list_cat;
					$orderby = $tab;
				}
				$tab_args = array(
					'data_type'		=> $data_type,
					'tab_id'		=> 'producttabs_'.$tab,
					'cat'			=> $cat,
					'template'		=> $template,
					'orderby'		=> $orderby,
					'number_query'	=> $number_query,
					'number_display'=> $number_display,
					'number_limit'	=> $number_limit,
					'effect_load'	=> $effect_load,
					'col'			=> $col,
					'uq'			=> $uq,
					'number_load'	=> $number_load,
					'carousel_row_number'	=> $carousel_row_number
				);
				wc_get_template( 'vc/template-tab.php', array('tab_args' => $tab_args) );
	    	}
		}
	?>
	</div>
	<script>
		jQuery(document).ready(function($){
			// Only handle preload for template is carousel
			$('#sns_product_tabs<?php echo $uq;?>.template-carousel').removeClass('pre-load');
			// Tab
			$('#sns_product_tabs<?php echo $uq;?> .nav-tabs').find("li").first().addClass("active");
			$('#sns_product_tabs<?php echo $uq;?> ul.dropdown-menu').find("li").first().addClass("active");
			// Tab content
			$('#sns_product_tabs<?php echo $uq;?> .tab-content .tab-pan').css({'overflow':'hidden', 'height':'0'});
			$('#sns_product_tabs<?php echo $uq;?> .tab-content').find(".tab-pan").first().addClass("active in").css({'overflow':'', 'height':''});
			// Handle click
			$('#sns_product_tabs<?php echo $uq;?> .nav-tabs > li, '+ '#sns_product_tabs<?php echo $uq;?> ul.dropdown-menu > li').click(function(e){
				e.preventDefault();
				if( !$(this).hasClass('active') ){
					id = $(this).find('a').attr('href');
					// lazyload
					if( $('body').hasClass('use_lazyload') ){
						var timeout = setTimeout(function() {
					        $(id + " img.lazy:not(.loaded)").trigger("appear")
					    }, 2000);
					}
					// Tab
					$('#sns_product_tabs<?php echo $uq;?> .nav-tabs li').removeClass('active');
					$('#sns_product_tabs<?php echo $uq;?> ul.dropdown-menu li').removeClass('active');
					$(this).addClass('active');
					if( id.indexOf('drop_') == 1){
						id = id.replace('drop_', '');
						$('#sns_product_tabs<?php echo $uq;?> .nav-tabs li').each(function(){
							if ( $(this).find('a').attr('href') == id ) $(this).addClass('active');
						})	
					}else{
						$('#sns_product_tabs<?php echo $uq;?> ul.dropdown-menu li').each(function(){
							if ( $(this).find('a').attr('href').replace('drop_', '') == id ) $(this).addClass('active');
						})
					}
					// Tab content
					$('#sns_product_tabs<?php echo $uq;?> .tab-pan').removeClass('active').removeClass('in').css({'overflow':'hidden', 'height':'0'});
					$('#sns_product_tabs<?php echo $uq;?>').find(id).addClass('active').addClass('in').css({'overflow':'', 'height':''});
					
					// Reset effect
					
					SnsJsWoo.resetAnimate($(this));
	            	
					return false;
				}
			});
	   	});
	</script>
<?php } ?>
</div>
<?php
$output .= ob_get_clean();
wp_reset_postdata();
echo $output;
