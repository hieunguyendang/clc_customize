<?php
$lclass = '';
$rclass = '';
$mclass = '';
$hasL = 0;
$hasR = 0;

$layouttype = snssimen_get_option('layouttype', 'l-m');

if ( $layouttype == 'l-m'){
    $lclass .= 'col-md-3';
    $mclass = 'col-md-9';
    $hasL = 1;
}elseif( $layouttype == 'm-r' ){
    $rclass .= 'col-md-3';
    $mclass = 'col-md-9';
    $hasR = 1;
}elseif( $layouttype == 'l-m-r' ){
    $lclass .= 'col-md-3';
    $rclass .= 'col-md-3';
    $mclass = 'col-md-6';
    $hasL = 1;
    $hasR = 1;
}else{
    $mclass = 'col-md-12';
}
?>
<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
		    <?php if( $hasL == 1): ?>
			<!-- left sidebar -->
			<div class="<?php echo esc_attr($lclass); ?> sns-left">
			    <?php 
			    if( class_exists('WooCommerce') && is_woocommerce() ){
			        dynamic_sidebar( 'woo-sidebar'); 
			    }else{
			        if( snssimen_get_option('leftsidebar')!= '' && is_active_sidebar( snssimen_get_option('leftsidebar') ) ) :
			        	dynamic_sidebar( snssimen_get_option('leftsidebar') ); 
			        else :
			        	dynamic_sidebar('widget-area');
			        endif;
			    }
			    ?>
			</div>
			<?php endif; ?>
			<!-- Main content -->
			<div class="<?php echo esc_attr($mclass); ?> sns-main">
			    <?php
			    if ( have_posts() ) :
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					    <h1 class="page-header">
					        <?php the_title(); ?>
					    </h1>
						<div class="entry-attachment">
							<?php
								echo wp_get_attachment_image( get_the_ID(), 'large' );
							?>
							<?php if ( has_excerpt() ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

						</div>
						<nav id="image-navigation" class="navigation image-navigation">
							<div class="nav-links">
								<div class="nav-previous"><?php previous_image_link( false, esc_html__( 'Previous Image', 'snssimen' ) ); ?></div><div class="nav-next"><?php next_image_link( false, esc_html__( 'Next Image', 'snssimen' ) ); ?></div>
							</div>
						</nav>
					    <div class="post-content">
					        <?php 
					        the_content();
					        ?>
					    </div>
					    <div class="wp_postmeta">
					        <span class="separator">|</span><span class="user-post"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
					        <span class="separator">|</span><span class="date-post"><i class="fa fa-calendar-o"></i> <?php the_time('F jS, Y'); ?></span>
					        <?php edit_post_link(esc_html__('Edit','snssimen'), '<span class="separator">|</span><span class="edit-post"><i class="fa fa-edit"></i> ', '</span>'); ?>
					        <?php
					        // List categories
					        $categories_list = get_the_category_list( esc_html__( ', ', 'snssimen' ) );
					        if ( $categories_list ) {
					            echo '<span class="separator">|</span><span class="categories-links"><i class="fa fa-folder-o"></i> ' . $categories_list . '</span>';
					        }
					        // List tags
					        $tag_list = get_the_tag_list( '', esc_html__( ', ', 'snssimen' ) );
					        if ( $tag_list ) {
					            echo '<span class="separator">|</span><span class="tags-links"><i class="fa fa-tags"></i> ' . $tag_list . '</span>';
					        }
					        // Retrieve attachment metadata.
					        if ( is_attachment() && wp_attachment_is_image() ) {
								$metadata = wp_get_attachment_metadata();

								printf( '<span class="separator">|</span><span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
									_x( 'Full size', 'Used before full size attachment link.', 'snssimen' ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height']
								);
							}
					        ?>
					    </div>
					    <?php
					    // Post Comment
					    if ( comments_open() || get_comments_number() ) :
					        comments_template();
					    endif;
					    ?>
					</article>
				<?php
			    else:
			        get_template_part( 'content', 'none' );
			    endif; ?>
			</div>
			<?php if ($hasR == 1): ?>
			<!-- Right sidebar -->
			<div class="<?php echo esc_attr($rclass); ?> sns-right">
			    <?php 
			    if( class_exists('WooCommerce') && is_woocommerce() ){
			        dynamic_sidebar( 'woo-sidebar'); 
			    }else{
			        dynamic_sidebar( snssimen_get_option('rightsidebar') ); 
			    }
			    ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>