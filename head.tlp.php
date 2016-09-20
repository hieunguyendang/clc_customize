<?php global $woocommerce ;
// Theme option
global $snssimen_headerLayout, $snssimen_topHeaderSidebar;


$showbreadcrumbs = 1;
if ( get_post_type( get_the_ID() ) == 'page' ) :
	if ( is_home() || is_front_page() || ( snssimen_get_option('showbreadcrump') == 2 ) ) :
		$showbreadcrumbs = 0;
	endif;
elseif ( get_post_type( get_the_ID() ) == 'post') :
		$showbreadcrumbs = 1;
		$showbreadcrumbs = (is_home()) ? 0 : 1;
endif;
?>
<?php
if( is_active_sidebar('topheader_left') ||  has_nav_menu('top_navigation')): ?>
<!-- Top Header -->
<div class="wrap" id="sns_topheader">
	<div class="container">
		<?php 
		if( is_active_sidebar('topheader_left') ) :
		?>
		<div class="topheader-left">
			<?php dynamic_sidebar('topheader_left'); ?>
		</div>
		<?php endif; ?>
		<div class="topheader-right">
			<!-- Top Menu -->
			<?php
            if(has_nav_menu('top_navigation')): ?>
            <div class="sns-quickaccess">
				<div class="quickaccess-inner">
			<?php
	           wp_nav_menu( array(
	           				'theme_location' => 'top_navigation',
	           				'container' => false, 
	           				'menu_id' => 'top_navigation',
	           				'menu_class' => 'links',
	           				'walker' => new sns_Megamenu_Front,
	           			));
	        ?>
	        	</div>
	        </div>
	        <?php endif; ?>
		</div>
	</div>
</div>
<!-- Header -->
<?php endif; ?>
<div class="wrap" id="sns_header">
	<div class="container">
		<div class="row">
			<div id="logo" class="col-sm-3">
				<?php 
				$logourl = SNSSIMEN_THEME_URI.'/assets/img/logo.png';
				if ( snssimen_get_option('header_logo') && snssimen_get_option('header_logo','','url') !='' ){
					$logourl = snssimen_get_option('header_logo','','url');
				}
				?>
				<a href="<?php echo esc_url( home_url('/') ) ?>" title="<?php echo esc_attr(get_bloginfo( 'sitename' )); ?>">
					<img src="<?php echo esc_url($logourl); ?>" alt="<?php echo esc_attr(get_bloginfo( 'sitename' )); ?>"/>
				</a>
			</div>
			<div class="header-right col-sm-9">
				<div class="header-right-inner">
					<div class="row">
					<?php if ( $snssimen_topHeaderSidebar == 'header_sidebar'):?>
					 	<?php if(is_active_sidebar('header_sidebar')) dynamic_sidebar('header_sidebar');?>
					<?php else: // Header sidebar search box?>
						<div class="col-md-8">
							<div id="headerRightSearchForm">
									<?php // Get Woocommerce categoies
									$args = array(
										'taxonomy'		=> 'product_cat',
										'orderby'		=> 'name',
										'show_count'	=> 0,
										'pad_counts'	=> 0,
										'hierarchical'	=> 0,
										'title_li'		=> '',
										'hide_empty'	=> 0,
										'parent' => 0
									);
									$all_categories = get_categories($args);

									?>
									<form method="get" action="<?php echo esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ); ?>">
										<select name="snssimen_woo_category">
											<option value=""><?php echo esc_html__('All Categories', 'snssimen');?></option>
											<?php 
											foreach ($all_categories as $cat):?>
												<option value="<?php echo esc_attr( $cat->slug ); ?>">
													<?php echo esc_html($cat->name); ?>
												</option>
											
												<?php 
												$args = array(
													'taxonomy'		=> 'product_cat',
													'orderby'		=> 'name',
													'show_count'	=> 0,
													'pad_counts'	=> 0,
													'hierarchical'	=> 0,
													'title_li'		=> '',
													'hide_empty'	=> 0,
													'parent' 		=> $cat->term_id
												);
												$sub_categories = get_categories($args);
												?>
												<?php 
													foreach ($sub_categories as $sub_cat):?>
													<option value="<?php echo esc_attr( $sub_cat->slug ); ?>">
														<?php echo esc_html("+".$sub_cat->name); ?>
													</option>
												<?php 	
													endforeach;
												?>
											<?php 	
											endforeach;
											?>
										</select>
										<i class="fa fa-angle-down"></i>
		                                <input type="text" name="s" id="s" class="input-search"
		                                       placeholder="<?php echo esc_attr__('Search entire store here', 'snssimen'); ?>" />
		                                <input type="hidden" name="post_type" value="product" />
		                                <button type="submit"><i class="fa fa-search"></i></button>
		                            </form>
							</div>
						</div>
						<div class="col-md-4">
							<?php if ( class_exists('WooCommerce') ) : ?>
								<div class="mini-cart sns-ajaxcart">
									<div class="mycart mini-cart">
										<a title="<?php esc_attr_e( 'View my shopping cart', 'snssimen' ); ?>" class="tongle" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() );?>">
											<div class="sns-shopping-cart-icon">
												<i class="fa fa-shopping-cart"></i>
											</div>
											<div class="sns-shopping-cart-info">
												<span class="sns-shopping-cart-title"><?php echo esc_html__('SHOPPING CART', 'snssimen')?></span>
												<span class="ajax_cart_quantity">
													<span class="number-item"><?php echo sizeof( WC()->cart->get_cart() );?></span>
													<span class="number-item-text"><?php (sizeof( WC()->cart->get_cart() )) == 1 ? esc_html_e('( item )', 'snssimen') : esc_html_e('( items )', 'snssimen') ?></span>
													<?php echo $woocommerce->cart->get_cart_total(); ?>
												</span>
											</div>
										</a>
										<?php if ( !is_cart() && !is_checkout() ) : ?>
										<div class="content"><div class="block-inner">
											<?php the_widget( 'WC_Widget_Cart', 'title= ', array('before_title' => '', 'after_title' => '') ); ?>
										</div></div>
										<?php endif; ?>
									</div>
								</div>
								<?php endif; ?>
						</div>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Menu  -->
<?php 
$menu_bg = '';
if ( snssimen_get_option('menu_bg', '', 'url' !== null ) && snssimen_get_option('menu_bg', '', 'url') !='' ) $menu_bg = snssimen_get_option('menu_bg', '', 'url');
if ( snssimen_metabox('snssimen_menubg') !='' ) :
	$m_imgs = snssimen_metabox('snssimen_menubg', 'type=image_advanced');
	foreach ( $m_imgs as $m_img ) :
		$menu_bg = $m_img['full_url'];
	endforeach;
endif;
if ( $menu_bg != '') { ?>
	<style scoped>
		#sns_menu_wrap{ background-image: url('<?php echo esc_attr($menu_bg); ?>') }
	</style>
<?php
}
?>
<div id="sns_menu_wrap" class="<?php if($showbreadcrumbs == 1 && ( !is_front_page() || !is_home() )) echo 'has_breadcrumbs' ?>">
	<div class="wrap" id="sns_menu">
		<div class="container">
			<div class="inner">
				<div class="sns-mainnav-wrapper">
						<div id="sns_mainnav">
							<div class="visible-lg" id="sns_mainmenu">
								<?php
				                if(has_nav_menu('main_navigation')):
						           wp_nav_menu( array(
						           				'theme_location' => 'main_navigation',
						           				'container' => false, 
						           				'menu_id' => 'main_navigation',
						           				'walker' => new sns_Megamenu_Front,
						           				'menu_class' => 'nav navbar-nav'
						           	) ); 
								else:
									echo '<p class="main_navigation_alert">'.esc_html__('Please sellect menu for Main navigation', 'snssimen').'</p>';
								endif;
								?>
							</div>
							<?php get_template_part('tpl-respmenu'); ?>
						</div>
						<?php if ( $snssimen_topHeaderSidebar == 'header_sidebar'):?>
						<div class="sns_nav-right">
							<div class="header-right-inner">
								<div class="block-search">
									<a class="icon-search"><i class="fa fa-search"></i></a>
									<div class="top-search">
										<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			                                <input type="text" name="s" class="input-search" value="<?php echo get_search_query() ?>"
			                                       placeholder="<?php echo esc_html__('Search entire store here ...', 'snssimen'); ?>">
			                                <button type="submit"  id="searchsubmit"><?php echo esc_html__('Search', 'snssimen'); ?></button>
			                            </form>
									</div>
								</div>
								
								<?php if ( class_exists('WooCommerce') ) : ?>
								<div class="mini-cart sns-ajaxcart">
									<div class="mycart mini-cart">
										<a title="<?php esc_attr_e( 'View my shopping cart', 'snssimen' ); ?>" class="tongle" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() );?>">
											<i class="fa fa-shopping-cart"></i>
											<span class="ajax_cart_quantity">
												<span class="number-item"><?php echo sizeof( WC()->cart->get_cart() );?></span>
												<span><?php echo sizeof( WC()->cart->get_cart() ) == 1 ? esc_html__('( item )', 'snssimen') : esc_html__('( items )', 'snssimen') ?></span>
											</span>
										</a>
										<?php if ( !is_cart() && !is_checkout() ) : ?>
										<div class="content">
											<div class="block-inner">
											<?php the_widget( 'WC_Widget_Cart', 'title= ', array('before_title' => '', 'after_title' => '') ); ?>
											</div>
										</div>
										<?php endif; ?>
									</div>
								</div>
								<?php endif; ?>
							</div>
						</div>
						<?php 
						endif;
						?>
				</div>
			</div>
		</div>
	</div>
	
	<?php if (!is_search() && $showbreadcrumbs == 1 && ( !is_front_page() || !is_home()) ) : ?>
	<div id="sns_breadcrumbs" class="wrap">
		<div class="container">
			<div id="sns_pathway" class="clearfix">
				<?php snssimen_breadcrumbs(); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if ( is_page() && snssimen_metabox('snssimen_useslideshow') == 1 ): ?>
	<div id="sns_slideshow" class="wrap">
		<?php
			echo do_shortcode('[rev_slider '.esc_attr(snssimen_metabox('snssimen_revolutionslider')).' ]');
		?>
	</div>
	<?php endif; ?>
</div>


