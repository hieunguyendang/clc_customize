<?php
global $post;
?>
<div class="sns-share-box">
<label><?php echo esc_html__('Share:', 'snssimen'); ?></label>
<ul class="socials">
	<?php if(snssimen_get_option('show_facebook_sharebox', 1) == 1 ): ?>
	<li class="facebook">
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr( $args['position'] ); ?>" data-animation="<?php echo esc_attr($args['animation'] ); ?>"  data-original-title="Facebook" href="http://www.facebook.com/sharer.php?s=100&p&#91;url&#93;=<?php the_permalink(); ?>&p&#91;title&#93;=<?php the_title(); ?>" target="_blank">
			<i class="fa fa-facebook"></i>
		</a>
	</li>
	<?php endif; ?>
	<?php if(snssimen_get_option('show_twitter_sharebox', 1) == 1 ): ?>
	<li class="twitter">
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Twitter" href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank">
			<i class="fa fa-twitter"></i>
		</a>
	</li>
	<?php endif; ?>
	<?php if(snssimen_get_option('show_linkedin_sharebox', 1) == 1 ): ?>
	<li class="linkedin">
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="LinkedIn" href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank">
			<i class="fa fa-linkedin"></i>
		</a>
	</li>
	<?php endif; ?>
	<?php if( snssimen_get_option('show_tumblr_sharebox', 1) == 1 ): ?>
	<li class="tumblr">
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Tumblr" href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>" target="_blank">
			<i class="fa fa-tumblr"></i>
		</a>
	</li>
	<?php endif; ?>
	<?php if( snssimen_get_option('show_gplus_sharebox', 1) == 1 ): ?>
	<li class="google">
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Google +1" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank">
			<i class="fa fa-google-plus"></i>
		</a>
	</li>
	<?php endif; ?>
	<?php if( snssimen_get_option('show_pinterest_sharebox', 1) == 1 ): ?>
	<li class="pinterest">
		<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>" target="_blank">
			<i class="fa fa-pinterest"></i>
		</a>
	</li>
	<?php endif; ?>
	<?php if( snssimen_get_option('show_email_sharebox', 1 ) == 1 ): ?>
	<li class="email">
		<a data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Email" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>">
			<i class="fa fa-envelope"></i>
		</a>
	</li>
	<?php endif; ?>
</ul>
</div>