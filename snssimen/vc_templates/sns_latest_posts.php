<?php
wp_enqueue_script('owlcarousel');

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $post;
$args = array(
	'post_status' => 'publish',
	'post_type' => 'post',
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => (int)$number_limit,
	'ignore_sticky_posts' => 1,
);
 
$uq = rand().time();

$lp_query = new WP_Query( $args );

$class = 'sns-latest-posts ';
$class .= ( trim($extra_class)!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));

if( $lp_query->have_posts() ) :
	$output .= '<div id="sns_latestpost'.$uq.'" class="'.$class.'">';
	if ( $title != '' ) $output .= '<h2 class="wpb_heading"><span>'.esc_attr($title).'</span></h2>';
	$output .= '<div class="navslider"><span class="prev"><i class="fa fa-long-arrow-left"></i></span><span class="next"><i class="fa fa-long-arrow-right"></i></span></div>';
	$output .= '<ul>';
	while ( $lp_query->have_posts() ) : $lp_query->the_post();
		$output .= '<li class="item-post">';
			if(has_post_thumbnail()):
			$output .= '<div class="post-thumb">';
				$output .= '<a class="post-author" href="'.esc_url(get_permalink()).'">';
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
					$output .= '<div class="post-excerpt">' . get_the_excerpt() . '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</li>';
	endwhile;
	
	$output .= '</ul>';
	$output .= '</div>';
	ob_start();
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#sns_latestpost<?php echo $uq;?> ul').owlCarousel({
			items: 3,
			responsive : {
			    0 : { items: 1 },
			    480 : { items: 2 },
			    768 : { items: 2 },
			    992 : { items: 3 },
			    1200 : { items: 3 }
			},
			loop:true,
	        dots: false,
		    // autoplay: true,
	        onInitialized: callback,
	        slideSpeed : 800
		});
		function callback(event) {
				if(this._items.length > this.options.items){
		        jQuery('#sns_latestpost<?php echo $uq;?> .navslider').show();
		    }else{
		        jQuery('#sns_latestpost<?php echo $uq;?> .navslider').hide();
		    }
		}
		jQuery('#sns_latestpost<?php echo $uq;?> .navslider .prev').on('click', function(e){
			e.preventDefault();
			jQuery('#sns_latestpost<?php echo $uq;?> ul').trigger('prev.owl.carousel');
		});
		jQuery('#sns_latestpost<?php echo $uq;?> .navslider .next').on('click', function(e){
			e.preventDefault();
			jQuery('#sns_latestpost<?php echo $uq;?> ul').trigger('next.owl.carousel');
		});
	});
	</script>
	<?php
	$output .= ob_get_clean();
endif;
/* Restore original Post Data */
wp_reset_postdata();
echo $output;
