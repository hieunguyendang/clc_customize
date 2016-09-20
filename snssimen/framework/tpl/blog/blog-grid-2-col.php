<?php
global $snssimen_blog_pagination;
$wclass = '';
if ( snssimen_get_option('blog_class') ) {
	$wclass = snssimen_get_option('blog_class');
}

$pagination = snssimen_get_option('pagination', 'def'); // get theme option
// get via page config
if(isset($snssimen_blog_pagination) && $snssimen_blog_pagination != 'def')
	$pagination = $snssimen_blog_pagination;
?>
<div class="blog-grid-2 posts sns-blog-posts <?php echo esc_attr($wclass);?>">
	<div id="snsmain" class="row">
		<?php 
		while ( have_posts() ) : the_post();
		?>
			<?php get_template_part( 'framework/tpl/posts/post-grid2', get_post_format() )?>
		<?php
		endwhile;
		?>
	</div>
	<?php
	// Paging
	if( $pagination == 'def' )
		get_template_part('tpl-paging');
	?>
</div>
<?php
if( $pagination == 'ajax')
	snssimen_paging_nav_ajax('#snsmain', 'framework/tpl/posts/post-grid2' ); // This paging nav should be outside #snsmain div

echo '<input type="hidden" name="hidden_snssimen_blog_layout" value="' . esc_attr( snssimen_get_option('blog_type') ) .  '">';