<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package millor
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>


</head>
<?php
global $woocommerce; ?>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="header">
		<div class="container">
			<div class="row">
				<div class="header-wrapp">
					<div class="col-lg-3">
						<?php the_custom_logo(); ?>
					</div>
					<div class="col-lg-7">
						<nav class="menu-header">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'header',
									'container'      => 'ul',
									'menu_class'     => 'navigation',
								)
							);
							?>
						</nav>
					</div>
					<div class="col-lg-2">
						<div class="button-group">
							<button class="search-icon" type="submit">
								<svg class="icon search-icon__svg">
									<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/svg-sprite.svg#icon-search"></use>
								</svg>
							</button>
							<?php echo do_shortcode('[yith_woocommerce_ajax_search]'); ?>
							<div class="cart">
								<a href="<?php echo $woocommerce->cart->get_cart_url() ?>" class="wc-block-mini-cart__button" aria-label="Cart Page">
									<svg class="icon wc-block-mini-cart__icon">
										<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/svg-sprite.svg#icon-cart"></use>
									</svg>
									<?php $items_count = WC()->cart->get_cart_contents_count(); ?>
									<span class="wc-block-mini-cart__badge"><?php echo $items_count ? $items_count : '&nbsp;'; ?></span>
								</a>
							</div>

							<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="login" aria-label="My Account">
								<svg class="icon">
									<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/svg-sprite.svg#icon-myaccount"></use>
								</svg>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="mobi-nenu">
					<div class="col-5 col-lg-3">
						<?php the_custom_logo(); ?>
					</div>
					<div class="col-5 col-lg-4 col-xl-2">
						<div class="button-group">
							<?php get_sidebar('header'); ?>
							<?php get_sidebar(); ?>

							<?php
							if (class_exists('WooCommerce')) { ?>
								<div class="cart">
									<a href="<?php echo $woocommerce->cart->get_cart_url() ?>" class="wc-block-mini-cart__button" aria-label="Cart Page">
										<svg class="icon wc-block-mini-cart__icon">
											<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/svg-sprite.svg#icon-cart"></use>
										</svg>
										<span class="wc-block-mini-cart__badge"><?php echo sprintf($woocommerce->cart->cart_contents_count); ?></span>
									</a>
								</div>
							<?php } ?>
							<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="login" aria-label="My Account">
								<svg class="icon">
									<use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/svg-sprite.svg#icon-myaccount"></use>
								</svg>
							</a>
							<div class="nav-bar">
								<div class="nav-icon">
									<span class="line" id="one"></span>
									<span class="line" id="two"></span>
									<span class="line" id="three"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-xl-7">
					<nav class="menu-header menu-header_mobi">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_mobi',
								'container'      => 'ul',
								'menu_class'     => 'navigation navigation_mobi',
							)
						);
						?>
						<div class="searsh-form searsh-form_mobi">
							<?php echo do_shortcode('[yith_woocommerce_ajax_search]'); ?>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<main>