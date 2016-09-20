<?php
/*
* SNS Testmonial
*/
wp_enqueue_script('owlcarousel');

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$class = 'sns-testimonial';
$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));
$uq = rand().time();
$args = array(
	'post_type' => 'testimonial',
	'posts_per_page' => -1
);
$brand = new WP_Query($args);

if ( $brand->have_posts() ) :
	ob_start();
?>
	<div id="sns_testimonial<?php echo esc_attr($uq); ?>" class="<?php echo esc_attr($class ). ' ' . esc_attr($template); ?>">
		<div class="navslider">
			<span class="prev"><i class="fa fa-long-arrow-left"></i></span>
			<span class="next"><i class="fa fa-long-arrow-right"></i></span>
		</div>
		<div class="testimonial-content">
			<ul class="clearfix">
				<?php 
				while ( $brand->have_posts() ) : $brand->the_post(); ?>
				<li>
					<?php
					if(has_post_thumbnail()):?>
					<div class="sns-testi-avatar">
						<?php the_post_thumbnail('snssimen_testimonial_avatar');?>
					</div>
					<?php
					endif;
					$title = get_the_title();
					$sub_title = get_post_meta(get_the_ID(), 'snssimen_testisub', true);
					if( $sub_title != '')
						$title = $title . '<span>'. esc_html($sub_title) .'</span>';
					?>
					<h2 class="sns-test-title"><?php echo esc_html( $title) ; ?></h2>
					<div class="quote-content"><?php the_content(); ?></div>
					<div class="icon-quote"><i class="fa fa-quote-left"></i></div>
				</li>
				<?php 
				endwhile;?>
			</ul>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#sns_testimonial<?php echo $uq;?> ul').owlCarousel({
					items: 1,
					loop:true,
		            dots: false,
		            nava: false,
				    autoplay: true,
		            onInitialized: callback,
		            slideSpeed : 800
				});

				function callback(event) {
					if(this._items.length > this.options.items){
				        jQuery('#sns_testimonial<?php echo $uq;?> .navslider').show();
				    }else{
				        jQuery('#sns_testimonial<?php echo $uq;?> .navslider').hide();
				    }
				}
				jQuery('#sns_testimonial<?php echo $uq;?> .navslider .prev').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_testimonial<?php echo $uq;?> ul').trigger('prev.owl.carousel');
				});
				jQuery('#sns_testimonial<?php echo $uq;?> .navslider .next').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_testimonial<?php echo $uq;?> ul').trigger('next.owl.carousel');
				});
			});
		</script>
	</div>
<?php
$output .= ob_get_clean();
echo $output;
wp_reset_postdata();
endif; 

?>