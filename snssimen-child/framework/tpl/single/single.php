<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    // Post Quote
    if ( get_post_format() == 'quote' && get_post_meta( get_the_id(), 'snssimen_post_quotecontent', true ) != '' && get_post_meta( get_the_id(), 'snssimen_post_quoteauthor', true ) != '' ) : ?>
        <div class="quote-info post-thumb">
            <?php if ( rwmb_meta('snssimen_post_quotecontent') ) : ?>
            <div class="quote-content gfont"><?php echo esc_html(rwmb_meta('snssimen_post_quotecontent')); ?></div>
            <?php endif; ?>
             <?php if ( rwmb_meta('snssimen_post_quoteauthor') ) : ?>
            <div class="quote-author"><?php echo esc_html(rwmb_meta('snssimen_post_quoteauthor')); ?></div>
            <?php endif; ?>
        </div>
    <?php
    // Post Link
    elseif ( get_post_format() == 'link' && get_post_meta( get_the_id(), 'snssimen_post_linkurl', true ) != '' ) : ?>
        <div class="link-info post-thumb">
            <a class="gfont" title="<?php echo esc_attr(rwmb_meta('snssimen_post_linktitle')) ?>" href="<?php echo esc_url( get_post_meta( get_the_id(), 'snssimen_post_linkurl', true ) ) ?>"><?php echo esc_html(rwmb_meta('snssimen_post_linktitle')) ?></a>
        </div>
    <?php
    // Post Video
    elseif ( get_post_format() == 'video' && get_post_meta( get_the_id(), 'snssimen_post_video', true ) != '') : ?>
        <div class="video-thumb video-responsive">
            <?php
            echo wp_oembed_get(esc_attr(get_post_meta( get_the_id(), 'snssimen_post_video', true )));
            ?>
        </div>
    <?php
    // Post Gallery
    elseif ( get_post_format() == 'gallery' && get_post_meta( get_the_id(), 'snssimen_post_gallery', true ) != '' ) : 
        
        wp_enqueue_script('owlcarousel');
    ?>
        <div class="gallery-thumb">
            <div class="navslider"><span class="prev"><i class="fa fa-angle-left"></i></span><span class="next"><i class="fa fa-angle-right"></i></span></div>
            <div class="thumb-container">
            <?php
            foreach (rwmb_meta('snssimen_post_gallery', 'type=image') as $image) {?>
               <div class="item"><img alt="<?php echo esc_attr($image['alt']); ?>" src="<?php echo esc_attr($image['full_url']); ?>"/></div>
            <?php
            }
            ?>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#post-<?php the_ID() ?> .thumb-container').owlCarousel({
                    items: 1,
                    loop:true,
                    dots: false,
                    // animateOut: 'flipInY',
                    //animateIn: 'pulse',
                    //autoplay: true,
                    onInitialized: callback,
                    slideSpeed : 800
                });
                function callback(event) {
                    if(this._items.length > this.options.items){
                        jQuery('#post-<?php the_ID() ?> .navslider').show();
                    }else{
                        jQuery('#post-<?php the_ID() ?> .navslider').hide();
                    }
                }
                jQuery('#post-<?php the_ID() ?> .navslider .prev').on('click', function(e){
                    e.preventDefault();
                    jQuery('#post-<?php the_ID() ?> .thumb-container').trigger('prev.owl.carousel');
                });
                jQuery('#post-<?php the_ID() ?> .navslider .next').on('click', function(e){
                    e.preventDefault();
                    jQuery('#post-<?php the_ID() ?> .thumb-container').trigger('next.owl.carousel');
                });
            });
        </script>
    <?php
    // Post Image
    elseif ( has_post_thumbnail() ) : ?>
        <div class="post-thumb">
            <?php
           the_post_thumbnail();
            ?>
        </div>
    <?php
    endif;?>
    
    <div class="single-post-date">
    	<span class="date-post"><i class="fa fa-calendar-o"></i> <?php the_time('F jS, Y'); ?></span>
    	<span class="single-post-date-space">/</span>
    	<span class="author-post"><?php echo esc_html__('by', 'snssimen') . ' ' . get_the_author(); ?></span>
    	<?php
        // Edit link
        edit_post_link(esc_html__('Edit','snssimen'), '<span class="edit-post"><i class="fa fa-edit"></i> ', '</span>'); ?>
    </div>
    
    <h1 class="page-header">
        <?php the_title(); ?>
    </h1>
    <div class="post-content">
        <?php 
        the_content();
        // Post Paging
        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'snssimen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
        ?>
    </div>
    <?php
    if ( is_sticky() && is_home() && ! is_page() ) {
        printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'snssimen' ) );
    }
    ?>
    <div class="post-meta">
    	<span class="cat-links"><i class="fa fa-folder"></i> <?php echo get_the_category_list(', '); ?></span>
    	<?php
        // List tags
        $tag_list = get_the_tag_list( '', esc_html__( ', ', 'snssimen' ) );
        if ( $tag_list ) {
            echo '<span class="tags-links"><i class="fa fa-tags"></i> ' . $tag_list . '</span>';
        }
        ?>
        <?php if( snssimen_get_option('show_comment_count', true) == true ): ?>
    	<span class="post-comment-count"><?php comments_number(esc_html__('0 Comments','snssimen'), esc_html__('1 Comment','snssimen'), '%' . esc_html__(' Comments','snssimen') ); ?></span>
        <?php endif; ?>
        <?php if( snssimen_get_option('show_view_count', true) == true ): ?>
    	<span class="post-view-count"><?php echo snssimen_get_post_views(get_the_ID());?></span>
        <?php endif; ?>
        
    </div>
    <?php
    if ( snssimen_get_option('show_postsharebox') ) : 
        snssimen_sharebox();
    endif;
    ?>
    <?php
    // Author bio
    if ( snssimen_get_option('show_postauthor') ) :
        get_template_part( 'author-bio' );
    endif;
    // Related post
    if ( snssimen_get_option('enalble_related') ) :
    ?>
    <div class="post-related">
        <?php
            snssimen_relatedpost();
        ?>
    </div>
    <?php
    endif;
    ?>
    <?php
    // Prev & Next post navigation.
      the_post_navigation( array(
          'prev_text' => '<span class="prev-post screen-reader-text">' . esc_html__( 'Previous post', 'snssimen' ) . '</span>' .
          '<span class="post-title">: %title</span>',
          'next_text' => '<span class="next-post screen-reader-text">' . esc_html__( 'Next post', 'snssimen' ) . '</span>' .
          '<span class="post-title">: %title</span>',
      ) );
    ?>
    
    <?php 
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
    comments_template();
    endif;
    ?>
</article>