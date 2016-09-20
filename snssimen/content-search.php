<?php
/**
 * The template part for displaying results in search pages
 */
?>
<?php 
$row_wrapper_cl = '';
if( has_post_thumbnail() )
	$row_wrapper_cl = 'row';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($row_wrapper_cl); ?>>
    <?php
    if ( has_post_thumbnail() ) : ?>
        <div class="post-thumb col-sm-3 col-xs-3 col-phone-12">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( '%s', 'snssimen' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
            <?php
            	the_post_thumbnail('snssimen_search_thumbnail_size');
            ?>
            </a>
        </div>
    <?php
    endif;?>
    <div class="post-content <?php if(has_post_thumbnail()) echo 'col-sm-9 col-xs-9 col-phone-12'; ?>">
        <?php
        // Date
        if (snssimen_get_option('show_date', true) == true && !is_sticky()) : ?>
        <div class="sns-date-post">
            <div class="date">
            <span><i class="fa fa-calendar"></i><?php echo date_i18n(get_option('date_format') ,get_the_time('U')); ?></span>
            <?php
             // Edit link
            edit_post_link(esc_html__('Edit','snssimen'), '<span class="edit-post"><i class="fa fa-edit"></i>', '</span>'); ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="content">
            <h2 class="page-header">
              <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'snssimen' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <div class="excerpt">
	            <?php if( empty( $post->post_excerpt ) ) { ?>
                <?php
                $readmore = '<span>'.esc_html__('Read More', 'snssimen').'</span><span class="meta-nav">→</span>';
                if ( is_search() && $post->post_type == 'page' ) {
                    // Trip shortcodes for post type is page on search result page
                    echo strip_shortcodes(get_the_content($readmore));
                }else{
                    the_content($readmore);
                }
                wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'snssimen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                ?>
                <?php } else { ?>
                    <p class="excerpt"><?php echo snssimen_excerpt( (int)snssimen_get_option('excerpt_length', 55) ); ?></p>
                    <?php if ( snssimen_get_option('show_readmore', false) == true) : ?>
                        <div class="readmore-link">
                           <a href="<?php echo esc_url(get_the_permalink()); ?>" class="more-link" title="<?php echo esc_attr(get_the_title());?>"><?php esc_html_e('Read More', 'snssimen')?><span class="meta-nav">→</span></a>
                       </div>
                    <?php endif; ?>
                <?php } ?>
            </div>
	       
            <?php if( is_sticky() || snssimen_get_option('show_categories', true) == true || snssimen_get_option('show_tags', true) || snssimen_get_option('show_tags', true) == true ): ?>
	            <div class="post-meta">
                    <?php
                    // Is sticky or not
                    if ( is_sticky() && is_home() && ! is_paged() ): ?>
                       <span class="sticky-post"><i class="fa fa-thumb-tack"></i> <?php echo esc_html__( 'Sticky', 'snssimen' ) ; ?></span>
                    <?php
                    endif;
                    ?>
	            	<?php if( snssimen_get_option('show_categories', true) == true && get_the_category_list() ): ?>
	            		<span class="cat-links"><i class="fa fa-folder"></i> <?php echo get_the_category_list(', '); ?></span>
	            	<?php endif; ?>
	            	<?php if( snssimen_get_option('show_tags', true) == true && get_the_tag_list()): ?>
	            		<span class="tags-links"><?php the_tags('<i class="fa fa-tags"></i> ',', '); ?></span>
	            	<?php endif; ?>
	            </div>
            <?php endif; ?>
        </div>
    </div>
</article>