<?php
if( $relates->have_posts() ):
wp_enqueue_script('owlcarousel');
?>
	<h3 class="related-title">
        <span><?php echo esc_html__( 'Related Post', 'snssimen' ); ?></span>
    </h3>
    <div class="navslider">
        <span class="prev"><i class="fa fa-angle-left"></i></span>
        <span class="next"><i class="fa fa-angle-right"></i></span>
    </div>
    <div class="related-content">
		<?php
		while ( $relates->have_posts() ) : $relates->the_post();
        ?>
            <div class="item">
                <h4 class="title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
                <?php if ( has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="image">
                        <?php the_post_thumbnail('snssimen_blog_grid3_thumbnail_size'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php
        endwhile; ?>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.post-related .related-content').owlCarousel({
                items: 3,
                responsive : {
                    0 : { items: 1},
                    480 : { items: 2 },
                    768 : { items: 3 },
                    992 : { items: 3 },
                    1200 : { items: 3 }
                },
                loop:true,
                dots: false,
                // animateOut: 'flipInY',
                //animateIn: 'pulse',
                // autoplay: true,
                onInitialized: callback,
                slideSpeed : 800
            });
            function callback(event) {
                if(this._items.length > this.options.items){
                    jQuery('.post-related .navslider').show();
                }else{
                    jQuery('.post-related .navslider').hide();
                }
            }
            jQuery('.post-related .navslider .prev').on('click', function(e){
                e.preventDefault();
                jQuery('.post-related .related-content').trigger('prev.owl.carousel');
            });
            jQuery('.post-related .navslider .next').on('click', function(e){
                e.preventDefault();
                jQuery('.post-related .related-content').trigger('next.owl.carousel');
            });
        });
    </script>
    <?php
    
endif;
?>