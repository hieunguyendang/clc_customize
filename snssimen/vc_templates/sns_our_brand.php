<?php
wp_enqueue_script('owlcarousel');

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$uq = rand().time();
$class = 'sns-ourbrand';
$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));

$args = array(
	'post_type' => 'brand',
	'posts_per_page' => -1
);
$brand = new WP_Query($args);

if ( $brand->have_posts() ) :
	ob_start();
?>
	<div id="sns_ourbrand<?php echo esc_attr($uq); ?>" class="<?php echo esc_attr($class) ?>">
		<?php if ( $title !='' ): ?>
		<h2 class="wpb_heading"><?php echo esc_html($title); ?></h2>
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
					<a href="<?php echo esc_url( rwmb_meta('snssimen_brandlink') ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" target="<?php echo esc_attr($link_target); ?>">
						<?php the_post_thumbnail( 'brand-logo' ); ?>
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
		            onInitialized: callback,
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
$output .= ob_get_clean();
echo $output;
wp_reset_postdata();
endif; 

?>