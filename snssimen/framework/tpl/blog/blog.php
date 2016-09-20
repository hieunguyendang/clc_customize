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
<div id="snsmain" class="blog-standard posts sns-blog-posts <?php echo esc_attr($wclass);?>">
<?php
// Theloop
while ( have_posts() ) : the_post();
    get_template_part( 'framework/tpl/posts/post', get_post_format() );
endwhile;
// Paging
if( $pagination == 'def' || $pagination == '')
	get_template_part('tpl-paging');
?>
</div>
<?php
if( $pagination == 'ajax')
	snssimen_paging_nav_ajax('#snsmain', 'framework/tpl/posts/post' ); // This paging nav should be outside #snsmain div

echo '<input type="hidden" name="hidden_snssimen_blog_layout" value="' . esc_attr( snssimen_get_option('blog_type') ).  '">';