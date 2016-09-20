<?php
if(class_exists('WooCommerce')){
	class snssimen_Woocommerce{
		public static function getInstance(){
			static $_instance;
			if( !$_instance ){
				$_instance = new snssimen_Woocommerce();
			}
			return $_instance;
		}
		public function __construct(){
			// Add Scripts
			add_action('wp_head', array($this, 'snssimen_renderurlajax'), 15);
			add_action( 'wp_enqueue_scripts', array($this,'snssimen_getscripts') );
			// Number product per page
			add_filter( 'loop_shop_columns', array($this, 'snssimen_woo_shop_columns') );
			// Grid cols per row
			add_filter( 'loop_shop_per_page', array($this, 'snssimen_woo_shop_perpage') );
			// Remove each style one by one
			add_filter( 'woocommerce_enqueue_styles', array($this, 'snssimen_dequeue_woostyles') );
			// Set modeview
			add_action( 'wp_ajax_sns_setmodeview', array($this,'snssimen_set_modeview') );
			add_action( 'wp_ajax_nopriv_sns_setmodeview', array($this,'snssimen_set_modeview') );
			// Ajax load more
			add_action('wp_ajax_sns_wooloadmore', array($this, 'snssimen_woo_loadmore'));
			add_action('wp_ajax_nopriv_sns_wooloadmore', array($this, 'snssimen_woo_loadmore'));
			
			// Ajax load more
			add_action('wp_ajax_sns_wootabloadproducts', array($this, 'snssimen_woo_tab_load_products'));
			add_action('wp_ajax_nopriv_sns_wootabloadproducts', array($this, 'snssimen_woo_tab_load_products'));
			
			// Add Taxonomy product_cat custom meta fields
			add_action('product_cat_add_form_fields', array(&$this, 'snssimen_product_cat_add_new_meta_field'), 20, 3);
			add_action('product_cat_edit_form_fields', array(&$this, 'snssimen_product_cat_edit_meta_field'), 20, 3);
			// Save extra taxonomy fields callback function
			add_action( 'edit_term', array(&$this,'snssimen_save_product_cat_custom_meta'), 10, 3 );
			add_action( 'created_term', array(&$this,'snssimen_save_product_cat_custom_meta'), 10, 3 );
			
			// Add Taxonomy product_attributes custom meta fields
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            if ( $attribute_taxonomies ) {
                foreach ( $attribute_taxonomies as $attribute) {
                    add_action( 'pa_' . $attribute->attribute_name . '_add_form_fields', array(&$this, 'snssimen_product_attribute_add_new_meta_field'), 20, 3 );
                    add_action( 'pa_' . $attribute->attribute_name . '_edit_form_fields', array(&$this, 'snssimen_product_attribute_edit_meta_field'), 20, 3);

                    add_action( 'edit_term', array(&$this,'snssimen_product_attribute_save_custom_meta'), 10, 3 );
                    add_action( 'created_term', array(&$this,'snssimen_product_attribute_save_custom_meta'), 10, 3 );
                }
            }
            /*
            * Variable Product
            */
            add_action('wp_head', array(&$this, 'snssimen_variable_product'), 1000);

            // Add product variation select anwhere.
            add_action( 'sns_show_product_loop_variable', array(&$this, 'snssimen_show_product_loop_variable'), 30 );

			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action( 'woocommerce_before_shop_loop_item_title', 'snssimen_product_thumbnail', 11 );

			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		}
		
		public function snssimen_getscripts(){
			$optimize = '.min';
			// $optimize = '';
			wp_enqueue_script('snssimen-woocommerce', SNSSIMEN_THEME_URI.'/assets/js/sns-woocommerce'.$optimize.'.js', array('jquery'), '', true);
			// WooCommerce Ajax Navigation
			if ( class_exists( 'YITH_WCAN_Frontend' ) ) {
                wp_dequeue_script('yith-wcan-script');
                if ( is_product_category() || is_shop() ) {
                    wp_enqueue_script('snssimen-wcan-script', SNSSIMEN_THEME_URI.'/assets/js/yith-wcan-frontend.js', array('jquery'), '', true);
                    $args = apply_filters( 'yith_wcan_ajax_frontend_classes', array(
                                'container'             => yith_wcan_get_option( 'yith_wcan_ajax_shop_container', '.products' ),
                                'pagination'            => yith_wcan_get_option( 'yith_wcan_ajax_shop_pagination', 'nav.woocommerce-pagination' ),
                                'result_count'          => yith_wcan_get_option( 'yith_wcan_ajax_shop_result_container', '.woocommerce-result-count' ),
                                'wc_price_slider'       => array(
                                    'wrapper'   => '.price_slider',
                                    'min_price' => '.price_slider_amount #min_price',
                                    'max_price' => '.price_slider_amount #max_price',
                                )
                            )
                    );
                    wp_localize_script( 'snssimen-wcan-script', 'yith_wcan', apply_filters( 'yith-wcan-frontend-args', $args ) );
                }
            }
            // producct page cloudzoom image
            wp_dequeue_script('prettyPhoto-init');
            if ( snssimen_get_option('woo_usecloudzoom') && is_product() )
                wp_enqueue_script('elevatezoom-custom', SNSSIMEN_THEME_URI.'/assets/js/elevatezoom-custom'.$optimize.'.js', array('jquery'), '', true);
		}
		
		public function snssimen_renderurlajax() {
		?>
			<script type="text/javascript">
				var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
			</script>
			<?php
		}

		public function snssimen_variable_product(){
           $theID = get_the_id();
           $product = wc_get_product( $theID );
           if( !is_product() ){
            return;
           }
            if( $product->product_type === 'variable' ){
                $attributes = $product->get_attributes();
                 ob_start();?>
                    <script type="text/javascript">
                        var sns_arr_attr = {};
                        <?php foreach ( $attributes as $attribute ) :
                            if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
                                continue;
                            } else {}
                            
                           $terms = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'all' ) );
                            
                            $type = '';
                            $key_val = array();
                            $i = 0;
                            foreach ($terms as $term) { $i++;
                                $type = get_woocommerce_term_meta( $term->term_id, 'snssimen_product_attribute_type' );
                                $type = ($type == '') ? 'text' : $type;
                                switch ($type) {
                                    case 'color':
                                        $key_val[$term->slug] = get_woocommerce_term_meta( $term->term_id, 'snssimen_product_attribute_color' );
                                        break;

                                    case 'image':
                                        $att_image_id = get_woocommerce_term_meta( $term->term_id, 'snssimen_product_attribute_image_id' );
                                        $att_image = wp_get_attachment_image_src( $att_image_id, 'snssimen_attribute_pa_images_size' );
                                        $att_image_url = (isset($att_image['0'])) ? $att_image['0'] : '';

                                        $key_val[$term->slug] = $att_image_url;
                                        break;
                                    
                                    default: // type is text
                                        $key_val[$term->slug] = $term->name;
                                        break;
                                }
                            }
                            ?>
                            var attributeName = '<?php echo $attribute['name'] ?>';
                            var data_type = '<?php echo $type; ?>';
                            var key_val = {};
                            <?php foreach ($key_val as $key => $value):?>
                                key_val['<?php echo $key ?>'] = '<?php echo $value ?>';
                            <?php endforeach;?>
                            sns_arr_attr['attribute_' + attributeName] = {'type': data_type, key_val};
                        <?php endforeach; ?>
                    </script>
                <?php
                echo ob_get_clean();
            }
        }
		
		public function snssimen_woo_loadmore(){
			$orderby        = $_POST['order'];
			$number_query   = $_POST['numberquery'];
			$start          = $_POST['start'];
			$list_cat       = $_POST['cat'];
			$col            = $_POST['col'];
			$eclass         = $_POST['eclass'];
			$loop = snssimen_woo_query($orderby, $number_query, $list_cat, $start);
			while ( $loop->have_posts() ) : $loop->the_post();
			wc_get_template( 'vc/item-grid.php', array('col' => $col, 'animate' => 1, 'eclass' => $eclass) );
			endwhile;
			wp_die();
		}
		
		public function snssimen_woo_tab_load_products(){
			
			$tab_args = array(
					'data_type'		=> $_POST['data_type'],
					'tab_id'		=> $_POST['tab_id'],
					'cat'			=> $_POST['cat'],
					'template'		=> $_POST['template'],
					'orderby'		=> $_POST['orderby'],
					'number_query'	=> $_POST['number_query'],
					'number_display'=> $_POST['number_display'],
					'number_limit'	=> $_POST['number_limit'],
					'effect_load'	=> $_POST['effect_load'],
					'col'			=> $_POST['col'],
					'uq'			=> $_POST['uq'],
					'number_load'	=> $_POST['number_load'],
					'carousel_row_number'	=> $_POST['carousel_row_number'],
					'eclass'		=> $_POST['eclass'],
					'animate'		=> 'yes',
				);
			
			wc_get_template( 'vc/template-tab.php', array('tab_args' => $tab_args) );
			wp_die();
		}
		
		public function snssimen_set_modeview(){
			setcookie('sns_woo_list_modeview', $_POST['mode'] , time()+3600*24*100, '/');
		}
		public function snssimen_woo_shop_columns( $columns ) {
			global $snssimen_opt;
		    return $snssimen_opt['woo_grid_col'];
		}
		public function snssimen_woo_shop_perpage( $columns ) {
			global $snssimen_opt;
		    return $snssimen_opt['woo_number_perpage'];
		}
		
		public function snssimen_dequeue_woostyles( $enqueue_styles ) {
			unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
			unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
			unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
			return $enqueue_styles;
		}
		
		// Add term page
		public function snssimen_product_cat_add_new_meta_field(){
			// This will add the custom meta field  to the add new term page
			?>
			<div class="form-field term-snscustom-thumbnail-wrap">
				<label for="snscustom_product_cat_thumbnail"><?php esc_html_e('Custom Thumbnail', 'snssimen'); ?></label>
				<div id="snscustom_product_cat_thumbnail" style="float: left; margin-right: 10px;">
					<img src="<?php echo wc_placeholder_img_src(); ?>" width="60px" height="60px">
				</div>
				<div style="line-height: 60px;">
					<input type="hidden" id="snscustom_product_cat_thumbnail_id" name="snscustom_product_cat_thumbnail_id">
					<button type="button" class="snscustom_upload_image_button button"><?php esc_html_e('Upload/Add image', 'snssimen'); ?></button>
					<button type="button" class="snscustom_remove_image_button button" style="display: none;"><?php esc_html_e('Remove image', 'snssimen'); ?></button>
				</div>
				<script type="text/javascript">
	
					// Only show the "remove image" button when needed
					if ( ! jQuery( '#snscustom_product_cat_thumbnail' ).val() ) {
						jQuery( '.snscustom_remove_image_button' ).hide();
					}
	
					// Uploading files
					var snscustom_file_frame;
	
					jQuery( document ).on( 'click', '.snscustom_upload_image_button', function( event ) {
	
						event.preventDefault();
	
						// If the media frame already exists, reopen it.
						if ( snscustom_file_frame ) {
							snscustom_file_frame.open();
							return;
						}
	
						// Create the media frame.
						snscustom_file_frame = wp.media.frames.downloadable_file = wp.media({
							title: 'Choose an image',
							button: {
								text: 'Use image'
							},
							multiple: false
						});
	
						// When an image is selected, run a callback.
						snscustom_file_frame.on( 'select', function() {
							var attachment = snscustom_file_frame.state().get( 'selection' ).first().toJSON();
	
							jQuery( '#snscustom_product_cat_thumbnail_id' ).val( attachment.id );
							jQuery( '#snscustom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.snscustom_remove_image_button' ).show();
						});
	
						// Finally, open the modal.
						snscustom_file_frame.open();
					});
	
					jQuery( document ).on( 'click', '.snscustom_remove_image_button', function() {
						var $wc_placeholder_img_src = '<?php echo wc_placeholder_img_src(); ?>';
						jQuery( '#snscustom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', $wc_placeholder_img_src );
						jQuery( '#snscustom_product_cat_thumbnail_id' ).val( '' );
						jQuery( '.snscustom_remove_image_button' ).hide();
						return false;
					});
	
				</script>
				<div class="clear"></div>
				<p class="description"><?php esc_html_e( 'The custom thumbnail to display in category page. Recommended image size 870x240 (px). If not set the Thumbnail default will be used by default.','snssimen' ); ?></p>
			</div>
			
			
			<div class="form-field term-sns_product_cat_featured">
				<label for="sns_product_cat_featured"><?php esc_html_e( 'Featured', 'snssimen' ); ?></label>
				<select name="sns_product_cat_featured" id="sns_product_cat_featured">
					<option value="no"><?php esc_html_e('No', 'snssimen');?></option>
					<option value="yes"><?php esc_html_e('Yes', 'snssimen');?></option>
				</select>
				<p class="description"><?php esc_html_e( 'Set as Featured','snssimen' ); ?></p>
			</div>
			
			<?php
		}
		// Edit term page
		public function snssimen_product_cat_edit_meta_field($term, $taxonomy){
			$cat_featured 						= get_woocommerce_term_meta( $term->term_id, 'sns_product_cat_featured' );
			$snscustom_product_cat_thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'snscustom_product_cat_thumbnail_id' );
			$image_src = wc_placeholder_img_src(); // WC Thumbnail default
			if($snscustom_product_cat_thumbnail_id !==''){
				$image_src = wp_get_attachment_image_src($snscustom_product_cat_thumbnail_id);
				$image_src = $image_src[0];
			}
			?>
			<tr class="form-field term-snscustom-thumbnail-wrap">
				<th scope="row" valign="top">
					<label for="snscustom_product_cat_thumbnail"><?php esc_html_e('Custom Thumbnail', 'snssimen'); ?></label>
				</th>
				<td>
					<div id="snscustom_product_cat_thumbnail" style="float: left; margin-right: 10px;">
						<img src="<?php echo esc_attr( $image_src ) ?>" width="60px" height="60px">
					</div>
					<div style="line-height: 60px;">
						<input type="hidden" id="snscustom_product_cat_thumbnail_id" name="snscustom_product_cat_thumbnail_id" value="<?php echo (int)$snscustom_product_cat_thumbnail_id; ?>">
						<button type="button" class="snscustom_upload_image_button button"><?php esc_html_e('Upload/Add image', 'snssimen'); ?></button>
						<button type="button" class="snscustom_remove_image_button button"><?php esc_html_e('Remove image', 'snssimen'); ?></button>
					</div>
					<script type="text/javascript">
						
						// Only show the "remove image" button when needed
						if ( '0' === jQuery( '#snscustom_product_cat_thumbnail_id' ).val() ) {
							jQuery( '.snscustom_remove_image_button' ).hide();
						}
	
						// Uploading files
						var snscustom_file_frame;
	
						jQuery( document ).on( 'click', '.snscustom_upload_image_button', function( event ) {
	
							event.preventDefault();
	
							// If the media frame already exists, reopen it.
							if ( snscustom_file_frame ) {
								snscustom_file_frame.open();
								return;
							}
	
							// Create the media frame.
							snscustom_file_frame = wp.media.frames.downloadable_file = wp.media({
								title: 'Choose an image',
								button: {
									text: 'Use image'
								},
								multiple: false
							});
	
							// When an image is selected, run a callback.
							snscustom_file_frame.on( 'select', function() {
								var attachment = snscustom_file_frame.state().get( 'selection' ).first().toJSON();
								jQuery( '#snscustom_product_cat_thumbnail_id' ).val( attachment.id );
								jQuery( '#snscustom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
								jQuery( '.snscustom_remove_image_button' ).show();
							});
	
							// Finally, open the modal.
							snscustom_file_frame.open();
						});
	
						jQuery( document ).on( 'click', '.snscustom_remove_image_button', function() {
							var $wc_placeholder_img_src = '<?php echo wc_placeholder_img_src(); ?>';
							jQuery( '#snscustom_product_cat_thumbnail' ).find( 'img' ).attr( 'src', $wc_placeholder_img_src );
							jQuery( '#snscustom_product_cat_thumbnail_id' ).val( '' );
							jQuery( '.snscustom_remove_image_button' ).hide();
							return false;
						});
		
					</script>
					<div class="clear"></div>
					<p class="description"><?php esc_html_e( 'The custom thumbnail to display in category page. Recommended image size 870x240 (px). If not set the Thumbnail default will be used by default.','snssimen' ); ?></p>
				</td>
			</tr>
			
			<tr class="form-field sns_product_cat_featured">
				<th scope="row"><label for="sns_product_cat_featured"><?php esc_html_e( 'Featured', 'snssimen' ); ?></label></th>
				<td>
					<select name="sns_product_cat_featured" id="sns_product_cat_featured">
						<option value="no" <?php selected($cat_featured, 'no', true)?>><?php esc_html_e('No', 'snssimen');?></option>
						<option value="yes" <?php selected($cat_featured, 'yes', true)?>><?php esc_html_e('Yes', 'snssimen');?></option>
					</select>
					
				<p class="description"><?php esc_html_e( 'Set as Featured','snssimen' ); ?></p></td>
			</tr>
			<?php
		}
		// Save term page
		public function snssimen_save_product_cat_custom_meta($term_id, $tt_id = '', $taxonomy = ''){
			$fields = array(
				'sns_product_cat_featured',
				'snscustom_product_cat_thumbnail_id'
			);
			
			foreach ($fields as $field){
				if( isset($_POST[$field]) ){
					$value = !empty($_POST[$field]) ? $_POST[$field] : '';
					
					update_woocommerce_term_meta($term_id, $field, $value);
				}
			}
		}
		/*
        *   Add term page for product_attribute
        */
        public function snssimen_product_attribute_add_new_meta_field(){
            // This will add the custom meta field  to the add new term page
            ?>
            <div class="form-field term-snssimen_product_attribute_type">
                <label for="snssimen_product_attribute_type"><?php esc_html_e( 'Type', 'snssimen' ); ?></label>
                <select name="snssimen_product_attribute_type" id="snssimen_product_attribute_type">
                    <option value="text"><?php esc_html_e('Text', 'snssimen');?></option>
                    <option value="color"><?php esc_html_e('Color Picker', 'snssimen');?></option>
                    <option value="image"><?php esc_html_e('Color Image', 'snssimen');?></option>
                </select>
                <p class="description"></p>
            </div>

            <div class="form-field term-snssimen_product_attribute_color">
                <label for="snssimen_product_attribute_color"><?php esc_html_e( 'Color Picker', 'snssimen' ); ?></label>
                <input type="text" class="colorpicker sns-colorpicker" value="" name="snssimen_product_attribute_color"/>
                <p class="description"></p>
            </div>
            
            <div class="form-field term-snssimen_product_attribute_image">
                <label for="snssimen_product_attribute_image"><?php esc_html_e('Color Image', 'snssimen'); ?></label>
                <div id="snssimen_product_attribute_image" style="float: left; margin-right: 10px;">
                    <img src="<?php echo wc_placeholder_img_src(); ?>" width="60px" height="60px">
                </div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="snssimen_product_attribute_image_id" name="snssimen_product_attribute_image_id">
                    <button type="button" class="snscustom_upload_image_button button"><?php esc_html_e('Upload/Add image', 'snssimen'); ?></button>
                    <button type="button" class="snscustom_remove_image_button button" style="display: none;"><?php esc_html_e('Remove image', 'snssimen'); ?></button>
                </div>
                <script type="text/javascript">
    
                    // Only show the "remove image" button when needed
                    if ( ! jQuery( '#snssimen_product_attribute_image' ).val() ) {
                        jQuery( '.snscustom_remove_image_button' ).hide();
                    }
    
                    // Uploading files
                    var snscustom_file_frame;
    
                    jQuery( document ).on( 'click', '.snscustom_upload_image_button', function( event ) {
    
                        event.preventDefault();
    
                        // If the media frame already exists, reopen it.
                        if ( snscustom_file_frame ) {
                            snscustom_file_frame.open();
                            return;
                        }
    
                        // Create the media frame.
                        snscustom_file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: 'Choose an image',
                            button: {
                                text: 'Use image'
                            },
                            multiple: false
                        });
    
                        // When an image is selected, run a callback.
                        snscustom_file_frame.on( 'select', function() {
                            var attachment = snscustom_file_frame.state().get( 'selection' ).first().toJSON();
    
                            jQuery( '#snssimen_product_attribute_image_id' ).val( attachment.id );
                            jQuery( '#snssimen_product_attribute_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
                            jQuery( '.snscustom_remove_image_button' ).show();
                        });
    
                        // Finally, open the modal.
                        snscustom_file_frame.open();
                    });
    
                    jQuery( document ).on( 'click', '.snscustom_remove_image_button', function() {
                        var $wc_placeholder_img_src = '<?php echo wc_placeholder_img_src(); ?>';
                        jQuery( '#snssimen_product_attribute_image' ).find( 'img' ).attr( 'src', $wc_placeholder_img_src );
                        jQuery( '#snssimen_product_attribute_image_id' ).val( '' );
                        jQuery( '.snscustom_remove_image_button' ).hide();
                        return false;
                    });
    
                </script>
                <div class="clear"></div>
                <p class="description"></p>
            </div>
            <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('select[id="snssimen_product_attribute_type"]').each(function(){
                    var $thisSelected = jQuery(this).val();
                    if( $thisSelected == 'color' ){
                        jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeIn(100);
                        jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                    }else if( $thisSelected == 'image' ){
                        jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeIn(100);
                        jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                    }else{
                        jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                        jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                    }

                    jQuery(this).on('change', function(){
                        if( this.value == 'color' ){
                            jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeIn(100);
                            jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                        }else if( this.value == 'image' ){
                            jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeIn(100);
                            jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                        }else{
                            jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                            jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                        }
                    });
                });
            });
            </script>
            <?php
        }
        // Edit term page
        public function snssimen_product_attribute_edit_meta_field($term, $taxonomy){
            $snssimen_product_attribute_type = get_woocommerce_term_meta( $term->term_id, 'snssimen_product_attribute_type' );
            $snssimen_product_attribute_color = get_woocommerce_term_meta( $term->term_id, 'snssimen_product_attribute_color' );
            $snssimen_product_attribute_image_id = get_woocommerce_term_meta( $term->term_id, 'snssimen_product_attribute_image_id' );
            $image_src = wc_placeholder_img_src(); // WC Thumbnail default
            if($snssimen_product_attribute_image_id !==''){
                $image_src = wp_get_attachment_image_src($snssimen_product_attribute_image_id);
                $image_src = $image_src[0];
            }
            ?>
            
            <tr class="form-field snssimen_product_attribute_type">
                <th scope="row"><label for="snssimen_product_attribute_type"><?php esc_html_e( 'Type', 'snssimen' ); ?></label></th>
                <td>
                    <select name="snssimen_product_attribute_type" id="snssimen_product_attribute_type">
                        <option value="text" <?php selected($snssimen_product_attribute_type, 'text', true)?>><?php esc_html_e('Text', 'snssimen');?></option>
                        <option value="color" <?php selected($snssimen_product_attribute_type, 'color', true)?>><?php esc_html_e('Color Picker', 'snssimen');?></option>
                        <option value="image" <?php selected($snssimen_product_attribute_type, 'image', true)?>><?php esc_html_e('Color Image', 'snssimen');?></option>
                    </select>
                    
                    <p class="description"></p>
                </td>
            </tr>

            <tr class="form-field term-snssimen_product_attribute_color">
                <th scope="row"><label for="snssimen_product_attribute_color"><?php esc_html_e( 'Color Picker', 'snssimen' ); ?></label></th>
                <td>
                    <input type="text" class="colorpicker sns-colorpicker" value="<?php echo esc_attr( $snssimen_product_attribute_color );?>" name="snssimen_product_attribute_color"/>
                    <p class="description"></p>
                </td>
            </tr>

            <tr class="form-field term-snssimen_product_attribute_image">
                <th scope="row" valign="top">
                    <label for="snssimen_product_attribute_image"><?php esc_html_e('Color Image', 'snssimen'); ?></label>
                </th>
                <td>
                    <div id="snssimen_product_attribute_image" style="float: left; margin-right: 10px;">
                        <img src="<?php echo esc_attr( $image_src ) ?>" width="60px" height="60px">
                    </div>
                    <div style="line-height: 60px;">
                        <input type="hidden" id="snssimen_product_attribute_image_id" name="snssimen_product_attribute_image_id" value="<?php echo (int)$snssimen_product_attribute_image_id; ?>">
                        <button type="button" class="snscustom_upload_image_button button"><?php esc_html_e('Upload/Add image', 'snssimen'); ?></button>
                        <button type="button" class="snscustom_remove_image_button button"><?php esc_html_e('Remove image', 'snssimen'); ?></button>
                    </div>
                    <script type="text/javascript">
                        
                        // Only show the "remove image" button when needed
                        if ( '0' === jQuery( '#snssimen_product_attribute_image_id' ).val() ) {
                            jQuery( '.snscustom_remove_image_button' ).hide();
                        }
    
                        // Uploading files
                        var snscustom_file_frame;
    
                        jQuery( document ).on( 'click', '.snscustom_upload_image_button', function( event ) {
    
                            event.preventDefault();
    
                            // If the media frame already exists, reopen it.
                            if ( snscustom_file_frame ) {
                                snscustom_file_frame.open();
                                return;
                            }
    
                            // Create the media frame.
                            snscustom_file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: 'Choose an image',
                                button: {
                                    text: 'Use image'
                                },
                                multiple: false
                            });
    
                            // When an image is selected, run a callback.
                            snscustom_file_frame.on( 'select', function() {
                                var attachment = snscustom_file_frame.state().get( 'selection' ).first().toJSON();
                                jQuery( '#snssimen_product_attribute_image_id' ).val( attachment.id );
                                jQuery( '#snssimen_product_attribute_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
                                jQuery( '.snscustom_remove_image_button' ).show();
                            });
    
                            // Finally, open the modal.
                            snscustom_file_frame.open();
                        });
    
                        jQuery( document ).on( 'click', '.snscustom_remove_image_button', function() {
                            var $wc_placeholder_img_src = '<?php echo wc_placeholder_img_src(); ?>';
                            jQuery( '#snssimen_product_attribute_image' ).find( 'img' ).attr( 'src', $wc_placeholder_img_src );
                            jQuery( '#snssimen_product_attribute_image_id' ).val( '' );
                            jQuery( '.snscustom_remove_image_button' ).hide();
                            return false;
                        });
        
                    </script>
                    <div class="clear"></div>
                    <p class="description"></p>
                </td>
            </tr>
            <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('select[id="snssimen_product_attribute_type"]').each(function(){
                    var $thisSelected = jQuery(this).val();
                    if( $thisSelected == 'color' ){
                        jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeIn(100);
                        jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                    }else if( $thisSelected == 'image' ){
                        jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeIn(100);
                        jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                    }else{
                        jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                        jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                    }

                    jQuery(this).on('change', function(){
                        if( this.value == 'color' ){
                            jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeIn(100);
                            jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                        }else if( this.value == 'image' ){
                            jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeIn(100);
                            jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                        }else{
                            jQuery('.term-snssimen_product_attribute_color').stop(true, true).fadeOut(0);
                            jQuery('.term-snssimen_product_attribute_image').stop(true, true).fadeOut(0);
                        }
                    });
                });
            });
            </script>
            <?php
        }
        // Save term page
        public function snssimen_product_attribute_save_custom_meta($term_id, $tt_id, $taxonomy){
            $fields = array(
                'snssimen_product_attribute_type',
                'snssimen_product_attribute_color',
                'snssimen_product_attribute_image_id'
            );
            
            foreach ($fields as $field){
                if( isset($_POST[$field]) ){
                    $value = !empty($_POST[$field]) ? $_POST[$field] : '';
                    
                    update_woocommerce_term_meta($term_id, $field, $value);
                }
            }
        }
		
	}
	snssimen_Woocommerce::getInstance();
    // Re-render rating
    add_filter( 'woocommerce_product_get_rating_html', 'snssimen_get_rating_html', 100, 2 );
    function snssimen_get_rating_html(){
        global $woocommerce, $product;
        if( $product && $product->get_average_rating() ) $rating = $product->get_average_rating();
        if( isset($rating) && $rating > 0){
        	$rating_html  = '<div class="star-rating sns-rating-width" title="' . sprintf( esc_html__( 'Rated %s out of 5', 'woocommerce' ), $rating ) . '">';
    		$rating_html .= '<span data-width="' . ( ( $rating / 5 ) * 100 ) . '"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'woocommerce' ) . '</span>';
        }else{
        	$rating_html  = '<div class="star-rating">';
        }
    	$rating_html .= '</div>';
    	return $rating_html;
    }

    // Set template view mode
    function snssimen_woo_modeview() {
    	wc_get_template( 'loop/modeview.php' );
    }
    // Override quickview
    function snssimen_woo_images_quickview() {
    	wc_get_template( 'single-product/product-image-quickview.php' );
    }

    function snssimen_woo_query($type, $post_per_page=-1, $cat='', $offset=0, $paged=1){
        global $woocommerce;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $post_per_page,
            'post_status' => 'publish',
        	'offset'            => $offset,
            'paged' => $paged
        );
        switch ($type) {
            case 'best_selling':
                $args['meta_key']='total_sales';
                $args['orderby']='meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $args['ignore_sticky_posts']=1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = array(
                             'key' => '_featured',
                             'value' => 'yes'
                         );
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'top_rate':
                add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'recent':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'on_sale':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['post__in'] = wc_get_product_ids_on_sale();
                break;
            case 'recent_review':
                if($post_per_page == -1) $_limit = 4;
                else $_limit = $post_per_page;
                global $wpdb;
                $query = $wpdb->prepare( "
                    SELECT c.comment_post_ID 
                    FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c 
                    WHERE p.ID = c.comment_post_ID AND c.comment_approved > %d 
                    AND p.post_type = %s AND p.post_status = %s
                    AND p.comment_count > %d ORDER BY c.comment_date ASC" ,
                    0, 'product', 'publish', 0 );
                $results = $wpdb->get_results($query, OBJECT);
                $_pids = array();
                foreach ($results as $re) {
                    if(!in_array($re->comment_post_ID, $_pids))
                        $_pids[] = $re->comment_post_ID;
                    if(count($_pids) == $_limit)
                        break;
                }

                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['post__in'] = $_pids;
                break;
        }

        if($cat!=''){
            $args['product_cat']= $cat;
        }
        return new WP_Query($args);
    }

    add_filter( 'body_class', 'snssimen_woo_class' );
    function snssimen_woo_class( $classes ) {
        $classes[] = 'woocommerce';
        return $classes;
    }
    //
    add_action('woocommerce_single_product_summary', 'snssimen_woo_addthis', 22);
    function snssimen_woo_addthis(){
        global $snssimen_opt;
        $html = '';
        if ( $snssimen_opt['woo_sharebox'] == 1 ) {
            $html .= '
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a>
            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-507b2455057cfd5f"></script>
            ';
        }
        echo wp_kses($html, array(
                                'div' => array(
                                    'class' => array(),
                                ),
                                'a' => array(
                                    'href' => array(),
                                    'class' => array(),
                                    'fb:like:layout' => array()
                                ),
                                'script' => array(
                                    'type' => array(),
                                    'src' => array()
                                ),
                            ) );
    }
    //
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    add_action('woocommerce_after_single_product_summary', 'snssimen_relatedproducts', 20);
    function snssimen_relatedproducts() {
        global $snssimen_opt;
        if ( $snssimen_opt['woo_related'] == '1' ) {
            $args = array(
                'posts_per_page' => $snssimen_opt['woo_related_num'],
                'orderby' => 'rand'
            );
            woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
        }else{
            return;
        }
    }
    add_action( 'woocommerce_archive_description', 'snssimen_woo_category_image', 2 );
    function snssimen_woo_category_image() {
        if ( is_product_category() ){
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            // get the custom thumbnail_id 
            $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'snscustom_product_cat_thumbnail_id', true );
            if( $thumbnail_id == '' )
            	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
            
            $image = wp_get_attachment_image_src($thumbnail_id, 'full');
            $image = isset($image[0]) ? $image[0] : '';
            if ( $image ) {
                echo '<p class="cate-img"><img src="' . esc_attr($image) . '" alt="" /></p>';
            }
        }
    }
    
    // Override thumbnail
    function snssimen_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
        if(snssimen_get_option('woo_uselazyload') == 1){
            $id = get_post_thumbnail_id();
            $src = wp_get_attachment_image_src($id, $size);
            $alt = get_the_title($id);
            $class = ( isset($attr['class']) ) ? $attr['class'] : '';
            if (strpos($class, 'lazy') !== false) {
                $html = '<img src="'.SNSSIMEN_THEME_URI.'/assets/img/prod_loading.gif" alt="'.$alt.'" data-original="' . $src[0] . '" class="' . $class . '" />';
            }
        }
        return $html;
    }
    add_filter('post_thumbnail_html', 'snssimen_post_thumbnail_html', 1, 5);
    function snssimen_product_thumbnail(){
        global $post;
        $size = 'shop_catalog';
        if ( has_post_thumbnail() ) {
            if( snssimen_get_option('woo_uselazyload') == 1 ){
                echo get_the_post_thumbnail( $post->ID, $size, array('class' => "lazy attachment-$size") );
            }else{
                echo get_the_post_thumbnail( $post->ID, $size );
            }
        } elseif ( wc_placeholder_img_src() ) {
            echo wc_placeholder_img( $size );
        }
    }

    function get_woocommerce_categories(){
    	$args = array(
    		'taxonomy' => 'product_cat'
    	);
    	 return get_categories($args);
    }
}

?>