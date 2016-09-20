<?php global $woocommerce ;

?>
<?php if( snssimen_get_option('use_stickmenu') == 1):?>
<div id="sticky-navigation-holder" class=""></div>
 <?php      
   endif;
 ?>

<!-- Top Header -->
<div id="sns_topheader_transpareant">
	 <?php
	if(is_active_sidebar('topheader_left') ||  has_nav_menu('top_navigation')): ?>
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
					$logourl = SNSSIMEN_THEME_URI.'/assets/img/logo-siment-w.png';
					if ( snssimen_get_option('header_logo') && snssimen_get_option('header_logo', '', 'url') !='' ){
						$logourl = snssimen_get_option('header_logo', '', 'url');
					}
					?>
					<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php echo esc_attr(get_bloginfo( 'sitename' )); ?>">
						<img src="<?php echo esc_url($logourl); ?>" alt="<?php echo esc_attr(get_bloginfo( 'sitename' )); ?>"/>
					</a>
				</div>
				<div class="header-right col-sm-9">
					<div class="header-right-inner">
						<!-- Menu  -->
							<div id="sns_menu_wrap">
								<div class="wrap" id="sns_menu">
											<div class="sns-mainnav-wrapper">
													<div id="sns_mainnav">
														<div class="visible-lg" id="sns_mainmenu">
															<?php
															$main_menu = '';
															if(is_page() && ($menu_selected = get_post_meta(get_the_ID(), 'snssimen_main_menu', true))){
																$main_menu = $menu_selected;
															}
															
											                if(has_nav_menu('main_navigation')):
													           wp_nav_menu( array(
													           				'theme_location' => 'main_navigation',
													           				'container' => false, 
													           				'menu_id' => 'main_navigation',
													           				'menu'	=> $main_menu,
													           				'walker' => new sns_Megamenu_Front,
													           				'menu_class' => 'nav navbar-nav'
													           	) ); 
															else:
																echo '<p>'.esc_html__('Please sellect menu for Main navigation', 'snssimen').'</p>';
															endif;
															?>
														</div>
														<?php get_template_part('tpl-respmenu'); ?>
													</div>
													<div class="sns_nav-right">
														<div class="header-right-inner">
															<div class="block-search">
																<a class="icon-search"><i class="fa fa-search"></i></a>
																<div class="top-search">
																	<form method="get" action="<?php echo esc_url( home_url('/') ); ?>">
										                                <input type="text" name="s" class="input-search"
										                                       placeholder="<?php echo esc_html__('Search entire store here ...', 'snssimen'); ?>">
										                                <button type="submit"><?php echo esc_html__('Search', 'snssimen'); ?></button>
										                            </form>
																</div>
															</div>
															
															<?php if ( class_exists('WooCommerce') ) : ?>
															<div class="mini-cart sns-ajaxcart">
																<div class="mycart mini-cart">
																	<a title="<?php esc_attr_e( 'View my shopping cart', 'snssimen' ); ?>" class="tongle" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() );?>">
																		<i class="fa fa-shopping-cart"></i>
																		<span class="number-item ajax_cart_quantity"><?php echo sizeof( WC()->cart->get_cart() );?>
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
											</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if ( is_page() && snssimen_metabox('snssimen_useslideshow') == 1 ): ?>
<div id="sns_slideshow" class="wrap">
	<?php
		echo do_shortcode('[rev_slider '.esc_attr(snssimen_metabox('snssimen_revolutionslider')).' ]');
	?>
</div>
<?php endif; ?>
