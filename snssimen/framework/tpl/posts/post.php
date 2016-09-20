<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    // Post Quote
    if ( get_post_format() == 'quote' && function_exists('rwmb_meta') && rwmb_meta('snssimen_post_quotecontent') && rwmb_meta('snssimen_post_quoteauthor') ) : ?>
        <div class="quote-info">
            <?php if ( rwmb_meta('snssimen_post_quotecontent') ) : ?>
            <div class="quote-content gfont"><i class="fa fa-quote-left"></i><?php echo esc_html(rwmb_meta('snssimen_post_quotecontent')); ?><i class="fa fa-quote-right"></i></div>
            <?php endif; ?>
             <?php if ( rwmb_meta('snssimen_post_quoteauthor') ) : ?>
            <div class="quote-author">&#45;&#45; <?php echo esc_html(rwmb_meta('snssimen_post_quoteauthor')); ?>&#45;&#45; </div>
            <?php endif; ?>
        </div>
    <?php
    // Post Link
    elseif ( get_post_format() == 'link' && function_exists('rwmb_meta') && rwmb_meta('snssimen_post_linkurl') ) : ?>
        <div class="link-info">
            <a class="gfont" title="<?php echo esc_attr(rwmb_meta('snssimen_post_linktitle')) ?>" href="<?php echo esc_url( rwmb_meta('snssimen_post_linkurl') ) ?>"><?php echo esc_html(rwmb_meta('snssimen_post_linktitle')) ?></a>
           
        </div>
    <?php
    // Post Video
    elseif ( get_post_format() == 'video' && get_post_meta(get_the_id(), 'snssimen_post_video', true) ) : ?>
        <div class="video-thumb video-responsive">
            <?php
            echo wp_oembed_get(esc_attr(get_post_meta(get_the_id(), 'snssimen_post_video', true)));
            ?>
            
        </div>
    <?php
    // Post audio
        elseif ( get_post_format() == 'audio' && get_post_meta(get_the_id(), 'snssimen_post_audio', true) ) : ?>
            <div class="audio-thumb audio-responsive">
                <?php
                echo wp_oembed_get(esc_attr(get_post_meta(get_the_id(), 'snssimen_post_audio', true)));
                ?>
            </div>
        <?php
    // Post Gallery
    elseif ( get_post_format() == 'gallery' && function_exists('rwmb_meta') && rwmb_meta('snssimen_post_gallery') ) : 
        
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
                    autoHeight: true,
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
            $blog_type = snssimen_get_option('blog_type');
            $img_size = 'full';
            switch ($blog_type){
            	case 'grid-2-col';
            		$img_size = 'snssimen_blog_grid2_thumbnail_size';
            		break;
            	case 'grid-3-col';
            		$img_size = 'snssimen_blog_grid3_thumbnail_size';
            		break;
            	case 'masonry';
            		$img_size = 'full';
            		break;
            	default: // standard post
            		$img_size = 'full';
            		break;
            }?>
	            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( '%s', 'snssimen' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
	            <?php
	            	the_post_thumbnail($img_size);
	            ?>
	            </a>
        </div>
    <?php
    endif;?>
    <div class="post-content">
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
	       
            <?php if( is_sticky() || snssimen_get_option('show_categories', true) == true || snssimen_get_option('show_tags', true) || snssimen_get_option('show_tags', true) == true || snssimen_get_option('show_view_count', true) == true || snssimen_get_option('show_comment_count', true) == true ): ?>
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
	            	<?php if( snssimen_get_option('show_comment_count', true) == true ): ?>
	            		<span class="post-comment-count"><?php comments_number(esc_html__('0 Comments','snssimen'), esc_html__('1 Comment','snssimen'), '%' . esc_html__(' Comments','snssimen') ); ?></span>
	            	<?php endif; ?>
	            	<?php if( snssimen_get_option('show_view_count', true) == true ): ?>
	            		<span class="post-view-count"><?php echo snssimen_get_post_views(get_the_ID()); ?></span>
	            	<?php endif; ?>
	            </div>
            <?php endif; ?>
        </div>
    </div>
</article>