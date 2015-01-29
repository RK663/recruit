<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package RECRUIT
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="container">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'recruit' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e( 'Primary Menu', 'recruit' ); ?></button>
			<?php //wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>
			<?php
			$args = array(
				'theme_location' => 'primary',
				'container_class' => 'sf-menu',
				'menu_class' => 'recruit-menu visible-lg visible-md',
				'container' => '',
				'fallback_cb' => 'wp_page_menu',
			);
			wp_nav_menu($args);
			?>
			<ul class="nav-menu-right pull-right">
				<li><a href="" class="fa fa-search"></a></li>
			</ul>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="row">
