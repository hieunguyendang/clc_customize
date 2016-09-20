<div class="author-info">
	<div class="author-avatar">
		<?php
		$author_bio_avatar_size = apply_filters('80', '80');
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div><!-- .author-avatar -->
	<div class="author-description">
		<h4 class="author-title">
			<?php printf( wp_kses(__( '<a class="author-link" href="%s" ref="author">%s</a>', 'snssimen' ), array(
										'a' => array(
											'href' => array(),
											'class' => array(),
											'ref' => array()
										),
										) ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),  get_the_author_meta('display_name') ); ?>
		</h4>
		<p class="author-bio">
			<span class="author-desc"><?php the_author_meta( 'description' ); ?></span>
		</p>
	</div><!-- .author-description -->
</div><!-- .author-info -->