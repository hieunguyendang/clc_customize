<?php
/*
* SNS Twitter
*/
wp_enqueue_script('owlcarousel');

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$uq = rand().time();

wp_enqueue_script( 'twitter-js', SNSSIMEN_THEME_URI . '/assets/js/twitterfetcher.min.js', array('jquery'), '', true );
$tweetclass = 'sns-tweets';
if ( $show_avartar == '2' ) $tweetclass .= ' no-avatar';
if ( $show_follow_link == '2' ) $tweetclass .= ' no-follow-link';
if ( $show_interact_link == '2' ) $tweetclass .= ' no-interact-link';
if ( $show_date == '2' ) $tweetclass .= ' no-date';
if ( $template != 'carousel' ) $tweetclass .= ' no-carousel';
if ( trim(esc_attr($extra_class))!='' ) $tweetclass .= ' '.esc_attr($extra_class);
$tweetclass .= esc_attr($this->getCSSAnimation( $css_animation ));
$output .= '<div id="sns_twitter_'.$uq.'" class="'.$tweetclass.'">';
if($title != '') $output .= '<h2 class="wpb_heading">'.esc_attr($title).'</h2>';
if ($show_navigation == '1') $output .= '<div class="navslider"><span class="prev"><i class="fa fa-long-arrow-left"></i></span><span class="next"><i class="fa fa-long-arrow-right"></i></span></div>';
ob_start();
?>
<div id="twitter_<?php echo esc_attr($uq); ?>" class="content"></div>
<script type="text/javascript">
	function handleTweets(tweets){
		var x = tweets.length;
		var n = 0;
		var element = document.getElementById('twitter_<?php echo $uq; ?>');
		var html = '<ul>';

		<?php if ( $template == 'carousel'): ?>
		var numdisplay = <?php echo intval($tweets_num_display) ?>;
		/* Carousel */
		while(n < x) {
			if(n % numdisplay == 0) html += '<li>';
			html += '<div class="item-tweet"><div class="inner">' + tweets[n] + '</div></div>';
			if((n+1) % numdisplay == 0 || (n+1) == x) html += '</li>';
			n++;
		}
		html += '</ul>';
		element.innerHTML = html;
		// Call carousel
		jQuery('#twitter_<?php echo $uq; ?> > ul').owlCarousel({
			items: 1,
			loop:true,
            dots: false,
            // animateOut: 'flipInY',
		    //animateIn: 'pulse',
		    // autoplay: true,
            onInitialized: callback,
            slideSpeed : 800
		});
		// Custom carousel's next/prev
		function callback(event) {
   			if(this._items.length > this.options.items){
		        jQuery('#sns_twitter_<?php echo $uq; ?> .navslider').show();
		    }else{
		        jQuery('#sns_twitter_<?php echo $uq; ?> .navslider').hide();
		    }
		}
		jQuery('#sns_twitter_<?php echo $uq; ?> .navslider .prev').on('click', function(e){
			e.preventDefault();
			jQuery('#sns_twitter_<?php echo $uq; ?> ul').trigger('prev.owl.carousel');
		});
		jQuery('#sns_twitter_<?php echo $uq; ?> .navslider .next').on('click', function(e){
			e.preventDefault();
			jQuery('#sns_twitter_<?php echo $uq; ?> ul').trigger('next.owl.carousel');
		});
		<?php else: ?>
		/* List */
		while(n < x) {
			html += '<li>' + tweets[n] + '</li>';
			n++;
		}
		html += '</ul>';
		element.innerHTML = html;
		<?php endif; ?>
	}
	function dateFormater(date) {
		return date.toDateString();
	}
	jQuery(document).ready(function(){
		var widgetid = '<?php echo esc_attr($widget_id); ?>';
		var limit = 0;
		<?php if ( $template == 'carousel'): ?>
		limit = <?php echo intval($tweets_num_limit) ?>;
		<?php else: ?>
		limit = <?php echo intval($tweets_num_display) ?>;
		<?php endif; ?>
		twitterFetcher.fetch(widgetid, 'twitter_<?php echo $uq; ?>', limit, true, true, true, '', false, handleTweets);
	});
</script>
<?php

$output .= ob_get_clean();
$output .= '</div>';
echo $output;

?>