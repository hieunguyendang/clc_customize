<?php
/**
 * SNSSIMEN_Widget_About_Me widget class
 */
class SNSSIMEN_Widget_About_Me extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSSIMEN_Widget_About_Me',
			esc_html__( 'SNS - About Me', 'snssimen' ),
			array( "description" => esc_html__("Display author info", 'snssimen') )
		);
	}

	function widget( $args, $instance ) {
		
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'About Simen','snssimen' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		$about_author 	= ( ! empty( $instance['about_author'] ) ) ? ( $instance['about_author'] ) : '';

		$author_socials = array(
			'facebook' => ( ! empty( $instance['facebook'] ) ) ? strip_tags($instance['facebook']) : '',
			'instagram' => ( ! empty( $instance['instagram'] ) ) ? strip_tags($instance['instagram']) : '',
			'twitter' => ( ! empty( $instance['twitter'] ) ) ? strip_tags($instance['twitter']) : '',
			'google-plus' => ( ! empty( $instance['google-plus'] ) ) ? strip_tags($instance['google-plus']) : '',
			'pinterest' => ( ! empty( $instance['pinterest'] ) ) ? strip_tags($instance['pinterest']) : '',
			'youtube' => ( ! empty( $instance['youtube'] ) ) ? strip_tags($instance['youtube']) : '',
			'linkedin' => ( ! empty( $instance['linkedin'] ) ) ? strip_tags($instance['linkedin']) : '',
			'tumblr' => ( ! empty( $instance['tumblr'] ) ) ? strip_tags($instance['tumblr']) : '',
			'flickr' => ( ! empty( $instance['flickr'] ) ) ? strip_tags($instance['flickr']) : ''
		);

		// Return HTML
		ob_start();
		?>
		<div class="block-sns-abount-me">
			
			<div class="sns-abount-content">
				<?php if( trim($about_author) != '' ) echo '<p>' . esc_html($about_author). '</p>';?>
				
				<div class="sns-abount-account">
					<?php 
                    	foreach ($author_socials as $key => $value){
                    		if( $value )
                    		echo '<a href="'.esc_url($value).'" target="_blank"><i class="fa fa-'.$key.'"></i> </a>';
                    	}
                    ?>
				</div>
				
			</div>
        </div><!-- /.block-sns-abount-me -->
		<?php 
		$output .= ob_get_contents();
		ob_end_clean();
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['about_author'] 	=  $new_instance['about_author'];
		
		$instance['facebook'] 		=  $new_instance['facebook'];
		$instance['instagram'] 		=  $new_instance['instagram'];
		$instance['twitter'] 		=  $new_instance['twitter'];
		$instance['google-plus'] 	=  $new_instance['google-plus'];
		$instance['pinterest'] 		=  $new_instance['pinterest'];
		$instance['youtube'] 		=  $new_instance['youtube'];
		$instance['linkedin'] 		=  $new_instance['linkedin'];
		$instance['tumblr'] 		=  $new_instance['tumblr'];
		$instance['flickr'] 		=  $new_instance['flickr'];

		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'About Simen';
		$about_author 	= isset( $instance['about_author'] ) ? esc_textarea( $instance['about_author'] ) : ''; //texteditor - About me content
		
		// 
		$author_socials = array(
			'facebook' => isset( $instance['facebook'] ) ? strip_tags($instance['facebook']) : '',
			'instagram' => isset( $instance['instagram'] ) ? strip_tags($instance['instagram']) : '',
			'twitter' => isset( $instance['twitter'] ) ? strip_tags($instance['twitter']) : '',
			'google-plus' => isset( $instance['google-plus'] ) ? strip_tags($instance['google-plus']) : '',
			'pinterest' => isset( $instance['pinterest'] ) ? strip_tags($instance['pinterest']) : '',
			'youtube' => isset( $instance['youtube'] ) ? strip_tags($instance['youtube']) : '',
			'linkedin' => isset( $instance['linkedin'] ) ? strip_tags($instance['linkedin']) : '',
			'tumblr' => isset( $instance['tumblr'] ) ? strip_tags($instance['tumblr']) : '',
			'flickr' => isset( $instance['flickr'] ) ? strip_tags($instance['flickr']) : ''
		);
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo  esc_attr($this->get_field_id( 'about_author' )); ?>"><?php esc_html_e( 'About me:', 'snssimen' ); ?></label>
			<br/><i><?php echo esc_html_e( 'About me content', 'snssimen' ); ?></i><br/>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('about_author')); ?>" name="<?php echo esc_attr($this->get_field_name('about_author')); ?>"><?php echo esc_html($about_author); ?></textarea>
		</p>
		
		<?php // Social accounts text fields
		foreach ( $author_socials as $key => $value ): ?>
		
			<p><label for="<?php echo esc_attr($this->get_field_id( $key )); ?>" style="text-transform:capitalize;" ><?php echo esc_attr( $key ). ' URL:'; ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( $key )); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>" type="text" value="<?php echo esc_html($value); ?>" /></p>
		
		<?php
		endforeach;
		?>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSSIMEN_Widget_About_Me_Register(){
	register_widget('SNSSIMEN_Widget_About_Me');
}
add_action('widgets_init', 'SNSSIMEN_Widget_About_Me_Register');

/**
 * SNSSIMEN_Widget_Testimonial widget class
 */
class SNSSIMEN_Widget_Testimonial extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSSIMEN_Widget_Testimonial',
			esc_html__( 'SNS - Testimonial', 'snssimen' ),
			array( "description" => esc_html__("Display Testimonial", 'snssimen') )
		);
	}

	function widget( $args, $instance ) {
		wp_enqueue_script('owlcarousel');
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Testimonial','snssimen' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$autoplay 	= ( ! empty( $instance['autoplay'] ) ) ? $instance['autoplay'] : 'false';

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		
		$uq = rand().time();
		$args_testi = array(
			'post_type' => 'testimonial',
			'posts_per_page' => -1
		);
		$brand = new WP_Query($args_testi);
		
		if ( $brand->have_posts() ) :
			ob_start();
			?>
				<style scoped>
						#sns_testimonial_widget<?php echo $uq;?> .navslider{ display: none; }
				</style>
				<div id="sns_testimonial_widget<?php echo esc_attr($uq); ?>" class="sns-testimonial-widget">
					<div class="testimonial-widget-content">
						<ul class="clearfix">
							<?php 
							while ( $brand->have_posts() ) : $brand->the_post(); ?>
							<li>
								<div class="quote-content"><i class="fa fa-quote-left"></i><?php the_content(); ?><i class="fa fa-quote-right"></i></div>
								<?php
								$title = get_the_title();
								$sub_title = get_post_meta(get_the_ID(), 'snssimen_testisub', true);
								if( $sub_title != '')
									$title = $title . '<span>'.$sub_title.'</span>';
								?>
								<div class="sns-test-title"><?php echo esc_html($title); ?></div>
							</li>
							<?php 
							endwhile;?>
						</ul>
					</div>
					<div class="navslider">
						<span class="prev"><i class="fa fa-long-arrow-left"></i></span>
						<span class="next"><i class="fa fa-long-arrow-right"></i></span>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('#sns_testimonial_widget<?php echo $uq;?> ul').owlCarousel({
								items: 1,
								loop: false,
					            dots: false,
					            nava: false,
							    autoplay: <?php echo esc_js($autoplay); ?>,
					            onInitialized: callback,
					            slideSpeed : 800
							});
			
							function callback(event) {
								if(this._items.length > this.options.items){
							        jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider').show();
							    }else{
							        jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider').hide();
							    }
							}
							jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider .prev').on('click', function(e){
								e.preventDefault();
								jQuery('#sns_testimonial_widget<?php echo $uq;?> ul').trigger('prev.owl.carousel');
							});
							jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider .next').on('click', function(e){
								e.preventDefault();
								jQuery('#sns_testimonial_widget<?php echo $uq;?> ul').trigger('next.owl.carousel');
							});
						});
					</script>
				</div>
			<?php
			$output .= ob_get_clean();
			wp_reset_postdata();
		endif;
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 	= strip_tags($new_instance['title']);
		$instance['autoplay']  = $new_instance['autoplay'];
		
		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Testimonial';
		$autoplay  = isset( $instance['autoplay'] ) ? esc_attr( $instance['autoplay'] ) : 'true';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php esc_html_e( 'Autoplay:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>">
				<option value="true" <?php selected($autoplay, 'true', true)?>><?php esc_html_e('Yes', 'snssimen')?></option>
				<option value="false" <?php selected($autoplay, 'false', true)?>><?php esc_html_e('No', 'snssimen')?></option>
			</select>
		</p>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSSIMEN_Widget_Testimonial_Register(){
	register_widget('SNSSIMEN_Widget_Testimonial');
}
add_action('widgets_init', 'SNSSIMEN_Widget_Testimonial_Register');


/**
 * SNSSIMEN_Widget_Products widget class
 */
class SNSSIMEN_Widget_Products extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSSIMEN_Widget_Products',
			esc_html__( 'SNS - Products', 'snssimen' ),
			array( "description" => esc_html__("Display products", 'snssimen') )
		);
	}

	function widget( $args, $instance ) {
		wp_enqueue_script('owlcarousel');
		$output = '';
		$uq = rand().time();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest posts','snssimen' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$type 	= ( ! empty( $instance['type'] ) ) ? $instance['type'] : 'recent';
		$number_display 	= ( ! empty( $instance['number_display'] ) ) ? (int)$instance['number_display'] : 4;
		$number_limit 	= ( ! empty( $instance['number_limit'] ) ) ? (int)$instance['number_limit'] : 4;
		$autoplay 	= ( ! empty( $instance['autoplay'] ) ) ? $instance['autoplay'] : 'false';

		$output .= $args['before_widget'];
		
		$output .= $args['before_title'] . esc_html($title) . $args['after_title'];

		if( class_exists('WooCommerce') ){
			global $woocommerce;
			$loop = snssimen_woo_query($type, $number_limit);
		
			$uq = rand().time();
			if( $loop->have_posts() ) : $post_count = $loop->post_count;
					ob_start();
					?>
					<div id="sns_widget_products<?php echo esc_attr( $uq ) ?>" class="sns-widget-products woocommerce sns-products sns-products-style-two">
							<div class="navslider"><span class="prev"><i class="fa fa-long-arrow-left"></i></span><span class="next"><i class="fa fa-long-arrow-right"></i></span></div>
							<ul class="widget_products product_list grid zoomOut">
								<?php
								$i = 0;
								while ( $loop->have_posts() ) : $loop->the_post();
									if($i == 0):?>
									<li class="item product">
									<?php
									endif;
								    	wc_get_template( 'vc/item.php' );
							    	if($i == $number_display):?>
				    		    	</li>
				    		    	<?php
				    		    	endif;
				    		    	$i++;
				    		    	if( $i == $number_display) $i = 0;
								endwhile; ?>
							</ul>
							<?php if($number_limit > $number_display && $post_count >= $number_limit):?>
								<script type="text/javascript">
								jQuery(document).ready(function(){
									jQuery('#sns_widget_products<?php echo $uq;?> ul').owlCarousel({
										items: 1,
										loop: true,
								        dots: false,
									   	autoplay: <?php echo esc_js($autoplay); ?>,
								        onInitialized: callback,
								        slideSpeed : 800
									});
									function callback(event) {
										<?php if($number_limit > $number_display): ?>
									        jQuery('#sns_widget_products<?php echo $uq;?> .navslider').show();
									    <?php else: ?>
									        jQuery('#sns_widget_products<?php echo $uq;?> .navslider').hide();
									    <?php endif; ?>
									}
									jQuery('#sns_widget_products<?php echo $uq;?> .navslider .prev').on('click', function(e){
										e.preventDefault();
										jQuery('#sns_widget_products<?php echo $uq;?> ul').trigger('prev.owl.carousel');
									});
									jQuery('#sns_widget_products<?php echo $uq;?> .navslider .next').on('click', function(e){
										e.preventDefault();
										jQuery('#sns_widget_products<?php echo $uq;?> ul').trigger('next.owl.carousel');
									});
								});
								</script>
							<?php endif; ?>
					</div>
					<?php
					$output .= ob_get_clean();
			endif;
			wp_reset_postdata();
		}
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['type'] 			=  $new_instance['type'];
		$instance['number_display'] =  (int)$new_instance['number_display'] == 0 ? 4 : (int)$new_instance['number_display'];
		$instance['number_limit'] 	=  (int)$new_instance['number_limit'] == 0 ? 4 : (int)$new_instance['number_limit'];
		$instance['autoplay'] 		=  $new_instance['autoplay'];

		return $instance;
	}

	function form( $instance ) {
		$title 	 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Latest Products';
		$typer 			= isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : 'recent';
		$number_display = isset( $instance['number_display'] ) ? esc_attr( $instance['number_display'] ) : '4';
		$number_limit 	= isset( $instance['number_limit'] ) ? esc_attr( $instance['number_limit'] ) : '4';
		$autoplay  		= isset( $instance['autoplay'] ) ? esc_attr( $instance['autoplay'] ) : 'false';
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'type' )); ?>"><?php esc_html_e( 'Type:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'type' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'type' )); ?>">
				<option value="recent" <?php selected($typer, 'recent', true)?>><?php esc_html_e('Latest Products', 'snssimen') ?></option>
				<option value="best_selling" <?php selected($typer, 'best_selling', true)?>><?php esc_html_e('BestSeller Products', 'snssimen') ?></option>
				<option value="top_rate" <?php selected($typer, 'top_rate', true)?>><?php esc_html_e('Top Rated Products', 'snssimen') ?></option>
				<option value="on_sale" <?php selected($typer, 'on_sale', true)?>><?php esc_html_e('Special Products', 'snssimen') ?></option>
				<option value="featured_product" <?php selected($typer, 'featured_product', true)?>><?php esc_html_e('Featured Products', 'snssimen') ?></option>
				<option value="recent_review" <?php selected($typer, 'recent_review', true)?>><?php esc_html_e('Recent Review', 'snssimen') ?></option>
			</select>
		</p>
		
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number_display' )); ?>"><?php esc_html_e( 'Number of products to show:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_display' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_display' )); ?>" type="text" value="<?php echo esc_html($number_display); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number_limit' )); ?>"><?php esc_html_e( 'Number limit:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_limit' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_limit' )); ?>" type="text" value="<?php echo esc_html($number_limit); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php esc_html_e( 'Autoplay:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>">
				<option value="true" <?php selected($autoplay, 'true', true)?>><?php esc_html_e('Yes', 'snssimen')?></option>
				<option value="false" <?php selected($autoplay, 'false', true)?>><?php esc_html_e('No', 'snssimen')?></option>
			</select>
		</p>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSSIMEN_Widget_Products_Register(){
	register_widget('SNSSIMEN_Widget_Products');
}
add_action('widgets_init', 'SNSSIMEN_Widget_Products_Register');

/**
 * SNSSIMEN_Widget_Product_Countdown widget class
 */
class SNSSIMEN_Widget_Product_Countdown extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSSIMEN_Widget_Product_Countdown',
			esc_html__( 'SNS - Product Sale Countdown', 'snssimen' ),
			array( "description" => esc_html__("Display the sale will end at the beginning of the set date.", 'snssimen') )
		);
	}

	function widget( $args, $instance ) {
		wp_enqueue_script('countdown');
		$output = '';
		$uq = rand().time();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Deal of day','snssimen' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$product_id = ( ! empty( $instance['product_id'] ) ) ? (int)$instance['product_id'] : '';
		
		// Get the Sale Price Date To of the product
		$sale_price_dates_to 	= ( $date = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y/m/d', $date ) : '';
		
		/** set sale price date to default 10 days for http://demo.snstheme.com/ */
		if($_SERVER['SERVER_NAME'] == 'demo.snstheme.com' || $_SERVER['SERVER_NAME'] == 'dev.snsgroup.me' ){
			if($sale_price_dates_to == 0)
				$sale_price_dates_to = date('Y/m/d', strtotime('+10 days'));
		}
		
		$output .= $args['before_widget'];

		$output .= $args['before_title'] . esc_html($title) . $args['after_title'];

		if( class_exists('WooCommerce') ){
			if($sale_price_dates_to == ''){ // Return if is blank
				echo '<div style="color: red">'.esc_html__('May be the Scheduled Sale End Date of this product is not set.', 'snssimen') . '</div>';
				return '';
			}
			
			$uq = rand().time();
			
			$output .= '<div id="sns_widget_product_sale_countdown'.esc_attr( $uq ).'" class="sns_widget_product_sale_countdown">';
			ob_start();
			?>		<div class="sns_sale_countdown_thumb">
						<?php
						if( has_post_thumbnail($product_id) ):?>
							<a href="<?php echo esc_url(get_permalink($product_id)); ?>" title="<?php echo esc_attr( get_the_title($product_id) );?>">
								<?php
								echo get_the_post_thumbnail($product_id);
								?>
							</a>
							<?php
						endif;
						?>
					</div>
					<div class="sns_sale_countdown">
						<div class="sns_sale_clock"></div>
						<div class="sns_sale_more"><a href="<?php echo esc_url(get_permalink($product_id)); ?>" title="<?php esc_attr_e('Click here', 'snssimen');?>"><?php esc_html_e('Click here', 'snssimen');?></a></div>
					</div>
					<div class="sns_sale_countdown_title">
						<div class="sns_sale_title"><a href="<?php echo esc_url(get_permalink($product_id)); ?>" title="<?php echo esc_attr(get_the_title($product_id)); ?>"><?php echo get_the_title($product_id); ?></a></div>
						<div class="sns_sale_price">
							<?php
							$product = new WC_Product( $product_id );
							echo $product->get_price_html();
							?>
						</div>
					</div>
					<script type="text/javascript">
					jQuery(document).ready(function($){
						$('#sns_widget_product_sale_countdown<?php echo $uq;?> .sns_sale_clock').countdown('<?php echo $sale_price_dates_to; ?>', function(event) {
							$(this).html(event.strftime('%-D day%!D : %H : %M : %S'));
						});
					});
					</script>
			<?php
			$output .= ob_get_clean();
			$output .= '</div>';
			wp_reset_postdata();
		}
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['product_id'] 	= esc_attr($new_instance['product_id']);
		

		return $instance;
	}

	function form( $instance ) {
		$title 	 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Deal of day';
		$product_id		= isset( $instance['product_id'] ) ? esc_attr( $instance['product_id'] ) : '';
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'product_id' )); ?>"><?php esc_html_e( 'Product ID:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'product_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'product_id' )); ?>" type="text" value="<?php echo esc_html($product_id); ?>" />
			<span class="description"><?php esc_html_e('The ID of the product to get the form Sale Price Date To.', 'snssimen'); ?></span>
		</p>

<?php
	}
}
/*
 * Register Wiget
*/
function SNSSIMEN_Widget_Product_Countdown_Register(){
	register_widget('SNSSIMEN_Widget_Product_Countdown');
}
add_action('widgets_init', 'SNSSIMEN_Widget_Product_Countdown_Register');


/**
 * SNSSIMEN_Widget_Latest_Posts widget class
 */
class SNSSIMEN_Widget_Latest_Posts extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSSIMEN_Widget_Latest_Posts',
			esc_html__( 'SNS - Latest Posts', 'snssimen' ),
			array( "description" => esc_html__("Display latest posts", 'snssimen') )
		);
	}

	function widget( $args, $instance ) {
		wp_enqueue_script('owlcarousel');
		$output = '';
		$uq = rand().time();
		
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest posts','snssimen' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$show_author 	= ( ! empty( $instance['show_author'] ) ) ? $instance['show_author'] : 'show';
		$show_date 	= ( ! empty( $instance['show_date'] ) ) ? $instance['show_date'] : 'show';
		$number 	= ( ! empty( $instance['number'] ) ) ? $instance['number'] : 3;
		$autoplay 	= ( ! empty( $instance['autoplay'] ) ) ? $instance['autoplay'] : 'false';

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		
		$my_query = array(
			'post_type'      => 'post',
			'posts_per_page' => $number ,
			'order'          => 'DESC',
			'orderby'        => 'date',
			'ignore_sticky_posts' => true,
			'post_status'    => 'publish'
		);
		$latest_posts = new WP_Query($my_query);
		
		
		if( $latest_posts->have_posts() ) :
			$output .= '<div id="sns_latestpost_wd'.esc_attr( $uq ).'" class="sns-latest-posts-widget">';
				$output .= '<ul>';
					while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
						$output .= '<li class="item-post">';
							if(has_post_thumbnail()):
								$output .= '<div class="post-thumb">';
									$output .= '<a class="post-author" href="'. esc_url(get_permalink()).'">';
										$output .= get_the_post_thumbnail(get_the_ID(), 'snssimen_latest_posts');
									$output .= '</a>';
								$output .= '</div>';
							endif;
							$output .= '<div class="post-info">';
							if ( $show_date == 'show' )
								$output .= '<div class="item-date date"><span class="d-day">'. esc_html(get_the_date('j')) .'</span><span class="d-month">'. esc_html(get_the_date('M')) .'</span>'.
								'</div>';
							$output .= '<div class="info-inner">';
							if ( $show_author == 'show' )
								$output .= '<a class="post-author" href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )) .'">'.get_the_author_meta('nickname').'</a>';
							
							$output .= '<h4 class="post-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h4>';
							$output .= '</div>';
							$output .= '</div>';
						$output .= '</li>';
					endwhile;
				
				$output .= '</ul>';
				$output .= '<div class="navslider"><span class="prev"><i class="fa fa-long-arrow-left"></i></span><span class="next"><i class="fa fa-long-arrow-right"></i></span></div>';
			$output .= '</div>';
			ob_start();
			?>
			<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#sns_latestpost_wd<?php echo $uq;?> ul').owlCarousel({
					items: 1,
					loop:true,
			        dots: false,
				   	autoplay: <?php echo esc_js($autoplay); ?>,
			        onInitialized: callback,
			        slideSpeed : 600
				});
				function callback(event) {
						if(this._items.length > this.options.items){
				        jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider').show();
				    }else{
				        jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider').hide();
				    }
				}
				jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider .prev').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_latestpost_wd<?php echo $uq;?> ul').trigger('prev.owl.carousel');
				});
				jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider .next').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_latestpost_wd<?php echo $uq;?> ul').trigger('next.owl.carousel');
				});
			});
			</script>
			<style scoped>
					#sns_latestpost_wd<?php echo $uq;?> .navslider{ display: none; }
			</style>
			<?php
			$output .= ob_get_clean();
		endif;
		/* Restore original Post Data */
		wp_reset_postdata();
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['show_author'] 	=  $new_instance['show_author'];
		$instance['show_date'] 		=  $new_instance['show_date'];
		$instance['number'] 		=  (int)$new_instance['number'] == 0 ? 3 : (int)$new_instance['number'];
		$instance['autoplay'] 		=  $new_instance['autoplay'];

		return $instance;
	}

	function form( $instance ) {
		$title 	 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Latest posts';
		$show_author 	= isset( $instance['show_author'] ) ? esc_attr( $instance['show_author'] ) : 'show';
		$show_date 		= isset( $instance['show_date'] ) ? esc_attr( $instance['show_date'] ) : 'show';
		$number 		= isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '3';
		$autoplay  = isset( $instance['autoplay'] ) ? esc_attr( $instance['autoplay'] ) : 'true';
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'show_author' )); ?>"><?php esc_html_e( 'Show Author:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'show_author' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_author' )); ?>">
				<option value="show" <?php selected($show_author, 'show', true)?>><?php esc_html_e('Show', 'snssimen')?></option>
				<option value="hide" <?php selected($show_author, 'hide', true)?>><?php esc_html_e('Hide', 'snssimen')?></option>
			</select>
		</p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php esc_html_e( 'Show Date:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>">
				<option value="show" <?php selected($show_date, 'show', true)?>><?php esc_html_e('Show', 'snssimen')?></option>
				<option value="hide" <?php selected($show_date, 'hide', true)?>><?php esc_html_e('Hide', 'snssimen')?></option>
			</select>
		</p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number Posts:', 'snssimen' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_html($number); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php esc_html_e( 'Autoplay:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>">
				<option value="true" <?php selected($autoplay, 'true', true)?>><?php esc_html_e('Yes', 'snssimen')?></option>
				<option value="false" <?php selected($autoplay, 'false', true)?>><?php esc_html_e('No', 'snssimen')?></option>
			</select>
		</p>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSSIMEN_Widget_Latest_Posts_Register(){
	register_widget('SNSSIMEN_Widget_Latest_Posts');
}
add_action('widgets_init', 'SNSSIMEN_Widget_Latest_Posts_Register');


class SNSSIMEN_Widget_Facebook extends WP_Widget {
	public function __construct() {
		$widget_ops = array('description' => esc_html__( 'Display your facebook like box', 'snssimen' ) );
		parent::__construct('sns_facebook', esc_html__('SNS - Facebook', 'snssimen'), $widget_ops);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo wp_kses( $args['before_widget'], array(
				                                'aside' => array(
				                                    'id' => array(),
				                                    'class' => array()
				                                ),
				                            ) );
		if ( $title ) echo wp_kses( $args['before_title'] . esc_html($title) . $args['after_title'], array(
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );

		$fanpageName = empty( $instance['fanpageName'] ) ? 'snstheme' : esc_html($instance['fanpageName']);
		?>
		<div class="content">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-page" 
			data-href="https://www.facebook.com/<?php echo esc_html($fanpageName); ?>" 
			data-small-header="true" 
			data-adapt-container-width="true" 
			data-hide-cover="false" 
			data-show-facepile="true" 
			data-show-posts="false">
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="https://www.facebook.com/<?php echo esc_html($fanpageName); ?>">
						<a href="https://www.facebook.com/<?php echo esc_html($fanpageName); ?>"><?php echo esc_html($fanpageName); ?></a>
					</blockquote>
				</div>
			</div>
		</div>
		<?php
		echo wp_kses( $args['after_widget'], array(
				                                'aside' => array()
				                            ) );
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 
			'title' => 'SNS Facebook',
			'fanpageName' => 'snstheme',
			'numberDisplay' => '12',
		));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['fanpageName'] = strip_tags($new_instance['fanpageName']);
		$instance['numberDisplay'] = strip_tags($new_instance['numberDisplay']);
		return $instance;
	}
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => 'SNS Facebook',
			'fanpageName' => 'snstheme',
			'numberDisplay' => '12',
		) );
		$title = $instance['title'];
		$fanpageName = $instance['fanpageName'];
		$numberDisplay = $instance['numberDisplay'];
?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
			<?php esc_html_e('Title:', 'snssimen'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('fanpageName')); ?>">
			<?php esc_html_e('Fanpage Name:', 'snssimen'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('fanpageName')); ?>" name="<?php echo esc_attr($this->get_field_name('fanpageName')); ?>" type="text" value="<?php echo esc_attr($fanpageName); ?>" />
		</label>
	</p>
<?php
	}
}

class SNSSIMEN_Widget_Recent_Post extends WP_Widget {
	
	function __construct(){
		$widget_ops = array('description' => esc_html__( 'Display recent posts', 'snssimen' ) );
		parent::__construct('snssimen_recentpost', esc_html__('SNS - Recent Post', 'snssimen'), $widget_ops);
	}
	
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$number = esc_attr($instance['number']);
		
		echo wp_kses( $before_widget, array(
				                                'aside' => array(
				                                	'class' => array()
				                                )
				                            ) );

		if($title) {
			echo wp_kses( $before_title . esc_html($title) . $after_title, array(
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );
		}
		?>
		<?php
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $number ,
			'order'          => 'DESC',
		    'orderby'        => 'date',
		    'ignore_sticky_posts' => true,
		    'post_status'    => 'publish'
		);
		$recent_posts = new WP_Query($args);
		if($recent_posts->have_posts()):
		?>
        <ul class="widget-posts">
		<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
	        <li class="post-item">
			<?php if(has_post_thumbnail()): ?>
			<a class="post-img" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		    <?php the_post_thumbnail('thumbnail'); ?>
			</a>
			<?php endif; ?>
	        <div><a class="post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></div>
	        <span class="post-date"><?php echo get_the_date();?></span>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        </ul>
		<?php endif; ?>
     
		<?php echo wp_kses( $after_widget, array(
				                                'aside' => array()
				                            ) );
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] = esc_attr($new_instance['title']);
		$instance['number'] = esc_attr($new_instance['number']);
		
		return $instance;
	}

	function form($instance){
		$defaults = array('title' => 'Recent posts', 'number' => 4);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'snssimen'); ?></label>
			<input class="widefat" type="text"  id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of items to show:', 'snssimen'); ?></label>
			<input class="widefat" type="text"  id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
	<?php
	}
}

class SNSSIMEN_Widget_Icon_Box extends WP_Widget{

	function __construct(){
		parent::__construct(
			'SNSSIMEN_Widget_Icon_Box',
			esc_html__('SNS - Icon Box', 'snssimen'),
			array('description' => esc_html__('Display a box with Awesome Icon, Title, Description.','snssimen'))
		);
	}

	function widget($args, $instance){
		$html = '';

		$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : esc_html__('Your Title Here...', 'snssimen');
		$url = ( !empty( $instance['url'] ) ) ? $instance['url'] : '#';
		$icon = ( !empty( $instance['icon'] ) ) ? $instance['icon'] : 'fa fa-home';
		$desc = ( !empty( $instance['desc'] ) ) ? $instance['desc'] : '';

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$html .= $args['before_widget'];
		
		ob_start();
		?>
		<div class="sns_icon_box">
			<div class="sns_icon_left">
				<div><a href="<?php echo esc_url($url) ?>" target="_blank"><i class="<?php echo esc_attr($icon); ?>"></i></a></div>
			</div>
			<div class="sns_icon_content_right">
				<div>
					<?php 
					if($title){
						echo $args['before_title'] . '<a href="'.esc_url($url).'" target="_blank">'. esc_html($title) . '</a>' . $args['after_title'];
					}
					echo esc_html($desc);
					?>
				</div>
			</div>
		</div>
		<?php
		$html .= ob_get_contents();
		ob_end_clean();

		$html .= $args['after_widget'];

			
		echo $html;

	}

	function update($new_instance, $old_instance){
		$instance 			= $old_instance;
		$instance['title'] 	= strip_tags($new_instance['title']);
		$instance['icon'] 	= esc_attr($new_instance['icon']);
		$instance['url'] 	= esc_attr($new_instance['url']);
		$instance['desc'] 	= $new_instance['desc'];

		return $instance;
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'url' => '#', 'icon' => 'fa fa-home', 'desc' => '' ) );
		$title = $instance['title'] ? strip_tags($instance['title']) : 'Your Title Here';
		$url = strip_tags($instance['url']);
		$icon = strip_tags($instance['icon']);
		$desc = esc_textarea($instance['desc']);
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'snssimen' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'url' )); ?>"><?php echo esc_html__( 'URL:', 'snssimen' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'url' )); ?>" type="text" value="<?php echo esc_html($url); ?>" /></p>
		<p class="description"><?php echo esc_html__('External url for Title', 'snssimen');?></p>
		</p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'icon' )); ?>"><?php echo esc_html__( 'Icon:', 'snssimen' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'icon' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'icon' )); ?>" type="text" value="<?php echo esc_html($icon); ?>" />
		<p class="description"><?php echo esc_html__('Use Font Awesome Icon. EX: fa fa-home', 'snssimen');?></p>
		</p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'desc' )); ?>"><?php esc_html__( 'Description:', 'snssimen'); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('desc')); ?>" name="<?php echo esc_attr($this->get_field_name('desc')); ?>"><?php echo esc_html($desc); ?></textarea></p>
		
	<?php
	}
	
}


class SNSSIMEN_Widget_Twitter extends WP_Widget {
	public function __construct() {
		$widget_ops = array('description' => esc_html__( 'Display your tweets', 'snssimen' ) );
		parent::__construct('sns_twitter', esc_html__('SNS - Twitter', 'snssimen'), $widget_ops);
	}
	public function widget( $args, $instance ) {
   		wp_enqueue_script('twitter-js', SNSSIMEN_THEME_URI . '/assets/js/twitterfetcher.min.js', array('jquery'), '', true );
   		
		$title 			= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$widgets_id 	= isset($instance['widgets_id']) ? $instance['widgets_id'] : '420187988887212033';
		$limit 			= isset($instance['limit']) ? $instance['limit'] : 3;
		$follow_link 	= isset($instance['follow_link']) ? $instance['follow_link'] : true;
		$account_name 	= isset($instance['account_name']) ? $instance['account_name'] : 'snstheme';
		$avartar 		= isset($instance['avartar']) ? $instance['avartar'] : true;
		$interact_link 	= isset($instance['interact_link']) ? $instance['interact_link'] : true;
		$date 			= isset($instance['date']) ? $instance['date'] : true;
		
		$uq = rand().time();
		$class  = "";
		$class .= ($avartar)?'':' no-avartar';
		$class .= ($follow_link)?'':' no-follow-link';
		$class .= ($interact_link)?'':' no-interact-link';
		$class .= ($date)?'':' no-date';
		
		echo wp_kses( $args['before_widget'], array(
				                                'aside' => array(
				                                	'class' => array(),
				                                	'id' => array()
				                                )
				                            ) );
		if ( $title ) echo wp_kses( $args['before_title'] . esc_html($title) . $args['after_title'], array(
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );
		
		if($follow_link && $account_name != ''){ ?>
		<a class="follow-link" href="http://twitter.com/follow?user=<?php echo esc_attr($account_name); ?>">
			<span><?php echo esc_html__("Follow", 'snssimen'); ?></span>
		</a>
		<?php
		}
		?>
		<div class="content">
			<div id="sns_twitter_<?php echo esc_attr( $uq ); ?>" class="sns-tweets <?php echo esc_attr($class); ?>"></div>
			<script type="text/javascript">
				function handleTweets(tweets){
					var x = tweets.length;
					var n = 0;
					var element = document.getElementById('sns_twitter_<?php echo $uq; ?>');
					var html = '<ul>';
					while(n < x) {
						html += '<li>' + tweets[n] + '</li>';
						n++;
					}
					html += '</ul>';
					element.innerHTML = html;
				}
				function dateFormater(date) {
					return date.toDateString();
				}
				jQuery(document).ready(function(){
					var widgetid = '<?php echo esc_attr($widgets_id); ?>';
					var limit = <?php echo esc_attr($limit) ?>;
				//	twitterFetcher.fetch(widgetid, 'sns_twitter', limit, true, true, true, '', true);
					twitterFetcher.fetch(widgetid, 'sns_twitter_<?php echo $uq; ?>', limit, true, true, true, '', false, handleTweets);
				});
			</script>
		</div>
		<?php
		
		echo wp_kses( $args['after_widget'], array(
				                                'aside' => array()
				                            ) );
	}
	public function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( 
			'follow_link' => 0,
			'avartar' => 0,
			'interact_link' => 0,
			'date' => 0,
		);
		foreach ( $instance as $field => $val )
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;

		$instance['title'] = ! empty( $new_instance['title'] ) ? $new_instance['title'] : 'SNS Twitter';
		$instance['widgets_id'] = ! empty( $new_instance['widgets_id'] ) ? $new_instance['widgets_id'] : '420187988887212033';
		$instance['limit'] = ! empty( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 3;
		$instance['account_name'] = ! empty( $new_instance['account_name'] ) ? $new_instance['account_name'] : 'snstheme';

		return $instance;
	}
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => 'SNS Twitter',
			'widgets_id' => '420187988887212033',
			'limit' => 3,
			'follow_link' => true,
			'account_name' => 'snstheme',
			'avartar' => true,
			'interact_link' => true,
			'date' => true
		) );
		$title = $instance['title'];
		$widgets_id = $instance['widgets_id'];
		$limit = $instance['limit'];
		$follow_link = $instance['follow_link'];
		$account_name = $instance['account_name'];
		$avartar = $instance['avartar'];
		$interact_link = $instance['interact_link'];
		$date = $instance['date'];
?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
			<?php esc_html_e('Title:', 'snssimen'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('widgets_id')); ?>">
			<?php esc_html_e('Widgets Id:', 'snssimen'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('widgets_id')); ?>" name="<?php echo esc_attr( $this->get_field_name('widgets_id') ); ?>" type="text" value="<?php echo esc_attr($widgets_id); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('limit')); ?>">
			<?php esc_html_e('Tweets Count:', 'snssimen'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
		</label>
	</p>
	<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['follow_link'], true) ?> id="<?php echo esc_attr($this->get_field_id('follow_link')); ?>" name="<?php echo esc_attr( $this->get_field_name('follow_link') ); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id('follow_link')); ?>"><?php esc_html_e('Show follow link', 'snssimen'); ?></label>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id('account_name') ); ?>">
			<?php esc_html_e('Account Name:', 'snssimen'); ?>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('account_name')); ?>" name="<?php echo esc_attr( $this->get_field_name('account_name')); ?>" type="text" value="<?php echo esc_attr($account_name); ?>" />
		</label>
	</p>
	<p style="margin: 0;">
		<input class="checkbox" type="checkbox" <?php checked($instance['avartar'], true) ?> id="<?php echo esc_attr( $this->get_field_id('avartar') ); ?>" name="<?php echo esc_attr( $this->get_field_name('avartar') ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id('avartar') ); ?>"><?php esc_html_e('Show avartar', 'snssimen'); ?></label>
	</p>
	<p style="margin: 0;">
		<input class="checkbox" type="checkbox" <?php checked($instance['interact_link'], true) ?> id="<?php echo esc_attr( $this->get_field_id('interact_link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('interact_link') ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id('interact_link') ); ?>"><?php esc_html_e('Show interact link', 'snssimen'); ?></label>
	</p>
	<p style="margin: 0;">
		<input class="checkbox" type="checkbox" <?php checked($instance['date'], true) ?> id="<?php echo esc_attr( $this->get_field_id('date') ); ?>" name="<?php echo esc_attr( $this->get_field_name('date') ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id('date') ); ?>"><?php esc_html_e('Show date', 'snssimen'); ?></label>
	</p>
	<br />

	<?php
	}
}

class SNSSIMEN_Widget_Our_Brands extends WP_Widget {

	function __construct(){
		$widget_ops = array('description' => esc_html__( 'Display Our Brands post type', 'snssimen' ) );
		parent::__construct('sns_ourbrands', esc_html__('SNS - Our Brands', 'snssimen'), $widget_ops);
	}

	function widget($args, $instance){
		extract($args);
		
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Our Brands','snssimen');

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$link_target 	= ( ! empty( $instance['link_target'] ) ) ? $instance['link_target'] : 'blank';
		$num_display 	= ( ! empty( $instance['num_display'] ) ) ? $instance['num_display'] : 6;
		
		$uq = rand().time();
		$class = 'sns-ourbrand';
		
		$args = array(
			'post_type' => 'brand',
			'posts_per_page' => -1
		);
		$brand = new WP_Query($args);
		
		if ( $brand->have_posts() ) :
			// Return HTML
			$output .= $before_widget;
			wp_enqueue_script('owlcarousel');
			ob_start();
			?>
				<div id="sns_ourbrand<?php echo esc_attr( $uq ); ?>" class="<?php echo esc_attr($class); ?>">
					<?php if ( $title): ?>
					<div class="wpb_heading"><?php echo $before_title . esc_html($title) . $after_title; ?></div>
					<?php endif; ?>
					
					<div class="ourbrand-content">
						<div class="navslider">
							<span class="prev"><i class="fa fa-long-arrow-right"></i></span>
							<span class="next"><i class="fa fa-long-arrow-left"></i></span>
						</div>
						<ul class="clearfix">
							<?php 
							while ( $brand->have_posts() ) : $brand->the_post(); ?>
							<li>
								<?php if ( function_exists('rwmb_meta') && rwmb_meta('snssimen_brandlink') ): ?>
								<a href="<?php echo esc_url( rwmb_meta('snssimen_brandlink') ); ?>" title="<?php echo esc_attr(get_the_title()); ?>" target="<?php echo esc_attr($link_target); ?>">
									<?php the_post_thumbnail( 'full' ); ?>
								</a>
								<?php else: ?>
								<?php the_post_thumbnail( 'brand-logo' ); ?>
								<?php endif; ?>
							</li>
							<?php 
							endwhile;?>
						</ul>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('#sns_ourbrand<?php echo $uq;?> ul').owlCarousel({
								items: <?php echo intval($num_display); ?>,
								responsive : {
								    0 : { items: 1},
								    480 : { items:2 },
								    768 : { items: <?php echo ( (intval($num_display)-2) > 2 ) ? intval($num_display)-2 : 2 ; ?> },
								    992 : { items: <?php echo intval($num_display)-1; ?> },
								    1200 : { items: <?php echo intval($num_display); ?> }
								},
								loop:true,
					            dots: false,
					            // animateOut: 'flipInY',
							    //animateIn: 'pulse',
							    autoplay: true,
					            //onInitialized: callback,
					            slideSpeed : 800
							});
							function callback(event) {
					   			if(this._items.length > this.options.items){
							        jQuery('#sns_ourbrand<?php echo $uq; ?> .navslider').show();
							    }else{
							        jQuery('#sns_ourbrand<?php echo $uq; ?> .navslider').hide();
							    }
							}
							jQuery('#sns_ourbrand<?php echo $uq; ?> .navslider .prev').on('click', function(e){
								e.preventDefault();
								jQuery('#sns_ourbrand<?php echo $uq; ?> ul').trigger('prev.owl.carousel');
							});
							jQuery('#sns_ourbrand<?php echo $uq; ?> .navslider .next').on('click', function(e){
								e.preventDefault();
								jQuery('#sns_ourbrand<?php echo $uq; ?> ul').trigger('next.owl.carousel');
							});
						});
					</script>
				</div>
			<?php
			$output .= ob_get_contents();
			ob_end_clean();
			
			$output .= $after_widget;
			echo $output;
		endif;
		
		wp_reset_postdata();
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['link_target'] = esc_attr($new_instance['link_target']);
		$instance['num_display'] = esc_attr($new_instance['num_display']);
		
		return $instance;
	}

	function form($instance){
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Our Brands';
		$link_target = isset($instance['link_target']) ? esc_attr($instance['link_target']) : 'blank';
		$num_display = isset($instance['num_display']) ? esc_attr($instance['num_display']) : 6;
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'snssimen'); ?></label>
			<input class="widefat" type="text"  id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'link_target' )); ?>"><?php esc_html_e( 'Link Target:', 'snssimen' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'link_target' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'link_target' )); ?>">
				<option value="blank" <?php selected($link_target, 'blank', true)?>><?php esc_html_e('New Windown', 'snssimen')?></option>
				<option value="_self" <?php selected($link_target, '_self', true)?>><?php esc_html_e('Same Windown', 'snssimen')?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('num_display')); ?>"><?php esc_html_e('Brands number display:', 'snssimen'); ?></label>
			<input class="widefat" type="text"  id="<?php echo esc_attr($this->get_field_id('num_display')); ?>" name="<?php echo esc_attr($this->get_field_name('num_display')); ?>" value="<?php echo esc_attr($num_display); ?>" />
		</p>
	<?php
	}
}


if ( class_exists('YITH_Woocompare_Widget') ){
	class SNSSIMEN_Woocompare_Widget extends YITH_Woocompare_Widget {
		function widget( $args, $instance ) {
            global $yith_woocompare;

            /**
             * WPML Support
             */
            $lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;

            extract( $args );

            $localized_widget_title = function_exists( 'icl_translate' ) ? icl_translate( 'Widget', 'widget_yit_compare_title_text', $instance['title'] ) : $instance['title'];

            echo wp_kses( $before_widget . $before_title . $localized_widget_title . $after_title, array(
            									'div' => array(
				                                    'class' => array()
				                                ),
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );
            ?>

            <ul class="products-list" data-lang="<?php echo esc_attr( $lang ); ?>">
                <?php echo $yith_woocompare->obj->list_products_html(); ?>
            </ul>

            <a href="<?php echo esc_url( $yith_woocompare->obj->remove_product_url('all') ) ?>" data-product_id="all" class="clear-all"><?php esc_html_e( 'Clear all', 'yith-wcmp' ) ?></a>
            <a href="<?php echo esc_url( add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ) ?>" class="compare button"><?php esc_html_e( 'Compare', 'yith-wcmp' ) ?></a>

            <?php echo wp_kses( $after_widget, array(
            									'div' => array()
				                            ) );
        }
	}
}

if( class_exists('WooCommerce') ){
	/**
	 * SNS Product Categories Widget
	 *
	 */
	class SNSSIMEN_Widget_Product_Categories extends WC_Widget {
	
		/**
		 * Category ancestors
		 *
		 * @var array
		 */
		public $cat_ancestors;
	
		/**
		 * Current Category
		 *
		 * @var bool
		 */
		public $current_cat;
	
		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce sns_widget_product_categories';
			$this->widget_description = esc_html__( 'A list of product categories.', 'snssimen' );
			$this->widget_id          = 'sns_product_categories';
			$this->widget_name        = esc_html__( 'SNS - Product Categories', 'snssimen' );
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'All Categories', 'snssimen' ),
					'label' => esc_html__( 'Title', 'snssimen' )
				),
				'orderby' => array(
					'type'  => 'select',
					'std'   => 'name',
					'label' => esc_html__( 'Order by', 'snssimen' ),
					'options' => array(
						'order' => esc_html__( 'Category Order', 'snssimen' ),
						'name'  => esc_html__( 'Name', 'snssimen' )
					)
				),
				'show_more_button' => array(
					'type'  => 'checkbox',
					'std'   => 1,
					'label' => esc_html__( 'Enable button More Categories', 'snssimen' )
				),
				'number_display'  => array(
					'type'  => 'text',
					'std'   => 10,
					'label' => esc_html__( 'The number for categoires display first. Apply for Enable button More Categories.', 'snssimen' )
				),
			);
	
			parent::__construct();
		}
	
		/**
		 * widget function.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			global $wp_query, $post;
	
			$c             = 0;
			$h             = 1;
			$s             = 0;
			$o             = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
			$dropdown_args = array( 'hide_empty' => false );
			$list_args     = array( 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'product_cat', 'hide_empty' => false );
			
			$show_more_button = isset( $instance['show_more_button'] ) ? $instance['show_more_button'] : $this->settings['show_more_button']['std'];
			$number_display	= isset( $instance['number_display'] ) ? $instance['number_display'] : $this->settings['number_display']['std'];
	
			// Menu Order
			$list_args['menu_order'] = false;
			if ( $o == 'order' ) {
				$list_args['menu_order'] = 'asc';
			} else {
				$list_args['orderby']    = 'title';
			}
	
			// Setup Current Category
			$this->current_cat   = false;
			$this->cat_ancestors = array();
	
			if ( is_tax( 'product_cat' ) ) {
	
				$this->current_cat   = $wp_query->queried_object;
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
	
			} elseif ( is_singular( 'product' ) ) {
	
				$product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );
	
				if ( $product_category ) {
					$this->current_cat   = end( $product_category );
					$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
				}
	
			}
	
			// Show Siblings and Children Only
			if ( $s && $this->current_cat ) {
	
				// Top level is needed
				$top_level = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => 0,
						'hierarchical' => true,
						'hide_empty'   => false
					)
				);
	
				// Direct children are wanted
				$direct_children = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => $this->current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false
					)
				);
	
				// Gather siblings of ancestors
				$siblings  = array();
				if ( $this->cat_ancestors ) {
					foreach ( $this->cat_ancestors as $ancestor ) {
						$ancestor_siblings = get_terms(
							'product_cat',
							array(
								'fields'       => 'ids',
								'parent'       => $ancestor,
								'hierarchical' => false,
								'hide_empty'   => false
							)
						);
						$siblings = array_merge( $siblings, $ancestor_siblings );
					}
				}
	
				if ( $h ) {
					$include = array_merge( $top_level, $this->cat_ancestors, $siblings, $direct_children, array( $this->current_cat->term_id ) );
				} else {
					$include = array_merge( $direct_children );
				}
	
				$dropdown_args['include'] = implode( ',', $include );
				$list_args['include']     = implode( ',', $include );
	
				if ( empty( $include ) ) {
					return;
				}
	
			} elseif ( $s ) {
				$dropdown_args['depth']        = 1;
				$dropdown_args['child_of']     = 0;
				$dropdown_args['hierarchical'] = 1;
				$list_args['depth']            = 1;
				$list_args['child_of']         = 0;
				$list_args['hierarchical']     = 1;
			}
	
			$this->widget_start( $args, $instance );
	
			
	
			include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

			$list_args['walker']                     = new WC_Product_Cat_List_Walker;
			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = esc_html__('No product categories exist.', 'snssimen' );
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
			$list_args['current_category_ancestors'] = $this->cat_ancestors;
			
			$sns_is_hidden_cl = '';
			if($show_more_button)
				$sns_is_hidden_cl = ' hidden';
			echo '<ul class="product-categories '.$sns_is_hidden_cl.'">';

			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

			echo '</ul>';
			
			if($show_more_button):
				$html = '';
				ob_start();
				?>
				<div class="sns_btn_more_cat hidden"><a href="#" title="<?php esc_attr_e('More Categories','snssimen'); ?>"><?php esc_html_e('More Categories','snssimen'); ?><i class="fa fa-angle-down"></i></a></div>
				<div class="sns_btn_hide_more_cat hidden"><a href="#" title="<?php esc_attr_e('Hide More Categories','snssimen'); ?>"><?php esc_html_e('Hide More Categories','snssimen'); ?><i class="fa fa-angle-up"></i></a></div>
				<script type="text/javascript">
					jQuery(document).ready(function($){
						var $sns_number_display = <?php echo (int)$number_display - 1; ?>;
						
						var $sns_number_cat = $('.sns_widget_product_categories ul.product-categories li').length;

						// Number of categories to be displayed
						if( $sns_number_cat >  $sns_number_display){
							$('.sns_widget_product_categories ul.product-categories li:gt('+$sns_number_display+')').addClass('li_visible').hide();

							// Show more categories
							setTimeout(function(){
								$('.sns_widget_product_categories .sns_btn_more_cat').removeClass('hidden');
							},10);
							
							var $sns_widget_products_cat = $('.sns_widget_product_categories ul.product-categories > li');
							var $sns_widget_products_ul_cat = $('.sns_widget_product_categories ul.product-categories');

							$('.sns_widget_product_categories .sns_btn_more_cat a').click(function(){
								if($sns_widget_products_cat.hasClass('li_visible')){
									$sns_widget_products_ul_cat.find('.li_visible').removeClass('li_visible').addClass('li_hidden').stop().slideDown(400);
								}
								$('.sns_widget_product_categories .sns_btn_more_cat').hide('slow');
								$('.sns_widget_product_categories .sns_btn_hide_more_cat').removeClass('hidden').show('slow');
								return false;
							});
							
							$('.sns_widget_product_categories .sns_btn_hide_more_cat a').click(function(){
								if($sns_widget_products_cat.hasClass('li_hidden')){
									$sns_widget_products_ul_cat.find('.li_hidden').removeClass('li_hidden').addClass('li_visible').stop().slideUp(300);
								}
								$('.sns_widget_product_categories .sns_btn_hide_more_cat').hide('slow');
								$('.sns_widget_product_categories .sns_btn_more_cat').show('slow');
								return false;
							});
							
						}

						// Show product categories
						setTimeout(function(){
							$('.sns_widget_product_categories ul.product-categories').removeClass('hidden').animate({ height: "show"}, 500);
						},10);
						
					});
				</script>
				<?php
				$html .= ob_get_clean();
				echo $html;
			endif; // Show more categories button
			$this->widget_end( $args );
		}
	}
	
	/**
	 * SNS - Layered Navigation Widget
	 *
	 */
	class SNSSIMEN_Widget_Layered_Nav extends WC_Widget {
	
		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce sns_widget_layered_nav widget_layered_nav';
			$this->widget_description = esc_html__( 'Shows a custom attribute in a widget which lets you narrow down the list of products when viewing product categories.', 'snssimen' );
			$this->widget_id          = 'sns_woo_layered_nav';
			$this->widget_name        = esc_html__( 'SNS - Woo Layered Nav', 'snssimen' );
			
			add_action('wp_ajax_sns_wcan_select_type', array( $this, 'ajax_print_terms') );
			
			parent::__construct();
		}
	
		
		public function update( $new_instance, $old_instance ) {
			
			$instance               = $old_instance;
            $instance['title']      = strip_tags( $new_instance['title'] );
            $instance['attribute']  = stripslashes( $new_instance['attribute'] );
            $instance['display_type']       = stripslashes( $new_instance['display_type'] );
            $instance['query_type'] = stripslashes( $new_instance['query_type'] );
            $instance['colors']     = ! empty( $new_instance['colors'] ) ? $new_instance['colors'] : array();

            return $instance;
		}
	
		
		public function form( $instance ) {
			$defaults = array(
				'title'      => '',
				'attribute'  => '',
				'display_type' => 'list',
				'query_type' => 'and',
				'colors' => array(),
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$title 			= $instance['title'] ? strip_tags($instance['title']) : 'Your Title Here';
			$attribute 		= $instance['attribute'];
			$display_type 	= $instance['display_type'];
			$query_type 	= $instance['query_type'];
			$colors 		= $instance['colors'];
			
			$attribute_array      = array();
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			
			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {
					if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
						$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
					}
				}
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'snssimen'); ?></label>
				<input class="widefat" type="text"  id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			
			<p class="sns-wcan-attribute-list">
				<label for="<?php echo esc_attr( $this->get_field_id('attribute') ); ?>"><?php esc_html_e('Attribute:', 'snssimen'); ?></label>
				<select class="sns_wcan_attributes widefat" id="<?php echo esc_attr( $this->get_field_id('attribute') ); ?>" name="<?php echo esc_attr( $this->get_field_name('attribute') ); ?>">
					<?php 
						foreach ($attribute_array as $key => $value){
						?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected($attribute, $value, true) ?>><?php echo esc_html($value); ?></option>
						<?php
						}
					?>
				</select>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('display_type') ); ?>"><?php esc_html_e('Display type:', 'snssimen'); ?></label>
				<select class="sns_wcan_type widefat" id="<?php echo esc_attr( $this->get_field_id('display_type') ); ?>" name="<?php echo esc_attr( $this->get_field_name('display_type') ); ?>">
						<option value="list" <?php selected($display_type, 'list', true) ?>><?php esc_html_e('List', 'snssimen'); ?></option>
						<option value="color" <?php selected($display_type, 'color', true) ?>><?php esc_html_e('Color', 'snssimen'); ?></option>
						<option value="dropdown" <?php selected($display_type, 'dropdown', true) ?>><?php esc_html_e('Dropdown', 'snssimen'); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('query_type') ); ?>"><?php esc_html_e('Query type:', 'snssimen'); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('query_type') ); ?>" name="<?php echo esc_attr( $this->get_field_name('query_type') ); ?>">
						<option value="and" <?php selected($query_type, 'and', true) ?>><?php esc_html_e('AND', 'snssimen'); ?></option>
						<option value="or" <?php selected($query_type, 'or', true) ?>><?php esc_html_e('OR', 'snssimen'); ?></option>
				</select>
			</p>
			
			<div class="sns_wcan_placeholder">
				<?php
                $values = array();

                if ( $instance['display_type'] == 'color' ) {
                    $values = $instance['colors'];
                }

                $this->sns_wcan_attributes_table(
                    $instance['display_type'],
                    $instance['attribute'],
                    'widget-' . $this->id . '-',
                    'widget-' . $this->id_base . '[' . $this->number . ']',
                    $values
                );
                ?>
			</div>
			
			<input type="hidden" name="widget_id" value="widget-<?php echo esc_attr( $this->id )?>-" />
        	<input type="hidden" name="widget_name" value="widget-<?php echo esc_attr( $this->id_base ) ?>[<?php echo esc_attr( $this->number ) ?>]" />

            <script>jQuery(document).trigger('sns_colorpicker');</script>
			<?php
		}
		
		/**
		 * Print terms for the element selected
		 */
		public function ajax_print_terms() {
			$type      = $_POST['value'];
			$attribute = $_POST['attribute'];
			$return    = array( 'message' => '', 'content' => $_POST );
		
			$terms = get_terms( 'pa_' . $attribute, array( 'hide_empty' => '0' ) );
		
			$settings        = $this->get_settings();
			$widget_settings = $settings[ $this->number ];
			$value           = '';
		
			if( 'color' == $type ){
				$value = $widget_settings['colors'];
			}
		
			if ( $type ) {
				$return['content'] = $this->sns_wcan_attributes_table(
					$type,
					$attribute,
					$_POST['id'],
					$_POST['name'],
					$value,
					false
				);
			}
			
			echo json_encode( $return );
			die();
		}
		
		/**
		 * Print the widgets options already filled
		 *
		 * @param $type      string list|colors|label
		 * @param $attribute woocommerce taxonomy
		 * @param $id        id used in the <input />
		 * @param $name      base name used in the <input />
		 * @param $values    array of values (could be empty if this is an ajax call)
		 *
		 * @return string
		 */
		public function sns_wcan_attributes_table( $type, $attribute, $id, $name, $values = array(), $echo = true ){
			$return = '';
			
			$terms = get_terms( 'pa_' . $attribute, array( 'hide_empty' => '0' ) );
			
			if ( 'list' == $type ) {
				$return = '<input type="hidden" name="' . esc_attr( $name ) . '[colors]" value="" /><input type="hidden" name="' . esc_attr( $name ). '[labels]" value="" />';
			}
			
			elseif ( 'color' == $type ) {
				if ( ! empty( $terms ) ) {
					$return = sprintf( '<table><tr><th>%s</th><th>%s</th></tr>', esc_html__( 'Term', 'snssimen' ), esc_html__( 'Color', 'snssimen' ) );
			
					foreach ( $terms as $term ) {
						$return .= "<tr><td><label for='{$id}{$term->term_id}'>{$term->name}</label></td><td><input type='text' id='{$id}{$term->term_id}' name='{$name}[colors][{$term->term_id}]' value='" . ( isset( $values[$term->term_id] ) ? $values[$term->term_id] : '' ) . "' size='3' class='sns-colorpicker' /></td></tr>";
					}
			
					$return .= '</table>';
				}
			
				$return .= '<input type="hidden" name="' . esc_attr( $name ) . '[labels]" value="" />';
			}
			
			
			if ( $echo ) {
				echo $return;
			}
			
			return $return;
		}
	
		/**
		 * widget function.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			global $_chosen_attributes;
	
			if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
				return;
			}
	
			$current_term = is_tax() ? get_queried_object()->term_id : '';
			$current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
			$taxonomy     = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : '';
			$query_type   = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
			$display_type = isset( $instance['display_type'] ) ? $instance['display_type'] : 'list';
	
			if ( ! taxonomy_exists( $taxonomy ) ) {
				return;
			}
	
			$get_terms_args = array( 'hide_empty' => '1' );
	
			$orderby = wc_attribute_orderby( $taxonomy );
	
			switch ( $orderby ) {
				case 'name' :
					$get_terms_args['orderby']    = 'name';
					$get_terms_args['menu_order'] = false;
					break;
				case 'id' :
					$get_terms_args['orderby']    = 'id';
					$get_terms_args['order']      = 'ASC';
					$get_terms_args['menu_order'] = false;
					break;
				case 'menu_order' :
					$get_terms_args['menu_order'] = 'ASC';
					break;
			}
	
			$terms = get_terms( $taxonomy, $get_terms_args );
	
			if ( 0 < count( $terms ) ) {
	
				ob_start();
	
				$found = false;
	
				$this->widget_start( $args, $instance );
	
				// Force found when option is selected - do not force found on taxonomy attributes
				if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
					$found = true;
				}
	
				if ( 'dropdown' == $display_type ) {
	
					// skip when viewing the taxonomy
					if ( $current_tax && $taxonomy == $current_tax ) {
	
						$found = false;
	
					} else {
	
						$taxonomy_filter = str_replace( 'pa_', '', $taxonomy );
	
						$found = false;
	
						echo '<select class="dropdown_layered_nav_' . $taxonomy_filter . '">';
	
						echo '<option value="">' . sprintf( esc_html__( 'Any %s', 'snssimen' ), wc_attribute_label( $taxonomy ) ) . '</option>';
	
						foreach ( $terms as $term ) {
	
							// If on a term page, skip that term in widget list
							if ( $term->term_id == $current_term ) {
								continue;
							}
	
							// Get count based on current view - uses transients
							$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );
	
							if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {
	
								$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );
	
								set_transient( $transient_name, $_products_in_term, DAY_IN_SECONDS * 30 );
							}
	
							$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );
	
							// If this is an AND query, only show options with count > 0
							if ( 'and' == $query_type ) {
	
								$count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );
	
								if ( 0 < $count ) {
									$found = true;
								}
	
								if ( 0 == $count && ! $option_is_set ) {
									continue;
								}
	
								// If this is an OR query, show all options so search can be expanded
							} else {
	
								$count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );
	
								if ( 0 < $count ) {
									$found = true;
								}
	
							}
	
							echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( isset( $_GET[ 'filter_' . $taxonomy_filter ] ) ? $_GET[ 'filter_' . $taxonomy_filter ] : '' , $term->term_id, false ) . '>' . esc_html( $term->name ) . '</option>';
						}
	
						echo '</select>';
	
						wc_enqueue_js( "
						jQuery( '.dropdown_layered_nav_$taxonomy_filter' ).change( function() {
						var term_id = parseInt( jQuery( this ).val(), 10 );
						location.href = '" . preg_replace( '%\/page\/[0-9]+%', '', str_replace( array( '&amp;', '%2C' ), array( '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 'filter_' . $taxonomy_filter ) ) ) ) ) ) . "&filter_$taxonomy_filter=' + ( isNaN( term_id ) ? '' : term_id );
					});
					" );
	
					}
	
					} else {
	
					// List display, include color type
						if( $display_type == 'color' ){
							echo '<ul class="sns_layered_nav_color">';
						}else{
							echo '<ul>';
						}
						
	
						foreach ( $terms as $term ) {
	
						// Get count based on current view - uses transients
							$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );
	
							if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {
	
							$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );
	
							set_transient( $transient_name, $_products_in_term );
							}
	
							$option_is_set = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );
	
							// skip the term for the current archive
							if ( $current_term == $term->term_id ) {
								continue;
							}
	
							// If this is an AND query, only show options with count > 0
							if ( 'and' == $query_type ) {
	
								$count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );
	
								if ( 0 < $count && $current_term !== $term->term_id ) {
									$found = true;
								}
	
								if ( 0 == $count && ! $option_is_set ) {
									continue;
								}
	
								// If this is an OR query, show all options so search can be expanded
							} else {
	
								$count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );
	
								if ( 0 < $count ) {
									$found = true;
								}
							}
	
							$arg = 'filter_' . sanitize_title( $instance['attribute'] );
	
							$current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();
	
							if ( ! is_array( $current_filter ) ) {
								$current_filter = array();
							}
	
							$current_filter = array_map( 'esc_attr', $current_filter );
	
							if ( ! in_array( $term->term_id, $current_filter ) ) {
								$current_filter[] = $term->term_id;
							}
	
							// Base Link decided by current page
							if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
								$link = esc_url( home_url( '/' ) );
							} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
								$link = get_post_type_archive_link( 'product' );
							} else {
								$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
							}
	
							// All current filters
							if ( $_chosen_attributes ) {
								foreach ( $_chosen_attributes as $name => $data ) {
									if ( $name !== $taxonomy ) {
	
										// Exclude query arg for current term archive term
										while ( in_array( $current_term, $data['terms'] ) ) {
											$key = array_search( $current_term, $data );
											unset( $data['terms'][$key] );
										}
	
										// Remove pa_ and sanitize
										$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
	
										if ( ! empty( $data['terms'] ) ) {
											$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
										}
	
										if ( 'or' == $data['query_type'] ) {
											$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
										}
									}
								}
							}
	
							// Min/Max
							if ( isset( $_GET['min_price'] ) ) {
								$link = add_query_arg( 'min_price', $_GET['min_price'], $link );
							}
	
							if ( isset( $_GET['max_price'] ) ) {
								$link = add_query_arg( 'max_price', $_GET['max_price'], $link );
							}
	
							// Orderby
							if ( isset( $_GET['orderby'] ) ) {
								$link = add_query_arg( 'orderby', $_GET['orderby'], $link );
							}
	
							// Current Filter = this widget
							if ( isset( $_chosen_attributes[ $taxonomy ] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) {
	
								$class = 'class="chosen"';
	
								// Remove this term is $current_filter has more than 1 term filtered
								if ( sizeof( $current_filter ) > 1 ) {
									$current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
									$link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
								}
	
							} else {
	
								$class = '';
								$link = add_query_arg( $arg, implode( ',', $current_filter ), $link );
	
							}
	
							// Search Arg
							if ( get_search_query() ) {
								$link = add_query_arg( 's', get_search_query(), $link );
							}
	
							// Post Type Arg
							if ( isset( $_GET['post_type'] ) ) {
								$link = add_query_arg( 'post_type', $_GET['post_type'], $link );
							}
	
							// Query type Arg
							if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) ) {
								$link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );
							}
							
							if( $display_type == 'color' && !empty( $instance['colors'][$term->term_id] )){
								$li_style = apply_filters( "{$args['widget_id']}-li_style", 'background-color:' . $instance['colors'][$term->term_id] . ';', $instance );
								
								echo '<li ' . $class . '>';
								
								echo ( $count > 0 || $option_is_set ) ? '<span class="sns_nav_color" style="' . $li_style . '"></span><a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '" title="' . esc_attr( $term->name ) . '" >' : '<span style="background-color:' . $instance['colors'][$term->term_id] . ';" >';
								
								echo esc_html($term->name);
								
								echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';
								
								echo ' <span class="count">(' . $count . ')</span></li>';
							}else{
								echo '<li ' . $class . '>';
								
								echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span>';
								
								echo $term->name;
								
								echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';
								
								echo ' <span class="count">(' . $count . ')</span></li>';
							}
							
						}
	
						echo '</ul>';
	
					} // End display type conditional
	
					$this->widget_end( $args );
	
					if ( ! $found ) {
						ob_end_clean();
					} else {
						echo ob_get_clean();
					}
			}
		}
	}
	
}// End check class exxit WooCommerce

function snssimen_load_widgets() {
    register_widget( 'SNSSIMEN_Widget_Facebook');
    register_widget( 'SNSSIMEN_Widget_Twitter');
    register_widget( 'SNSSIMEN_Widget_Recent_Post');
    register_widget( 'SNSSIMEN_Widget_Icon_Box');
    register_widget( 'SNSSIMEN_Widget_Our_Brands');
    if ( class_exists('WooCommerce') && class_exists('YITH_Woocompare_Widget') ) register_widget( 'SNSSIMEN_Woocompare_Widget');
    
    if ( class_exists('WooCommerce')){
    	register_widget('SNSSIMEN_Widget_Product_Categories');
    	register_widget('SNSSIMEN_Widget_Layered_Nav');
    }
}
add_action('widgets_init', 'snssimen_load_widgets');