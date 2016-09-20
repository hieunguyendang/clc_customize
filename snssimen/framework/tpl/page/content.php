<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	// Page title
	snssimen_pagetitle();
	?>
    <?php
    while ( have_posts() ) : the_post();
        the_content();
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    endwhile;
    ?>
</section>