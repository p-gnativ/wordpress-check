<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<link rel="stylesheet" media="all" href="<?php echo esc_url(get_template_directory_uri()); ?>/all.css" type="text/css" />
</head>

<body <?php body_class(); ?>>
<div id="page">
	<div class="skip-links">
		<?php _e('Go directly', 'as-text-domain'); ?> <a href="#content"><?php _e('content', 'as-text-domain'); ?></a>, <a href="#main_nav"><?php _e('main menu', 'as-text-domain'); ?></a> <?php _e('of', 'as-text-domain'); ?> <a href="#meta_nav"><?php _e('service menu', 'as-text-domain'); ?></a>
	</div>
	<header class="header-wrapper">
		<div class="section">
			<div class="holder">
				<div class="mobile-box">
					<span class="btn-menu">
						<button>Menu <span data-close="Close" data-open="Open">Open</span></button>
					</span>
				</div>
				<?php
					if (is_front_page() && is_home()) : ?>
						<h1 class="logo"><a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><img src="<?php echo get_theme_mod(sanitize_title(wp_get_theme()) . '-logo'); ?>" alt="<?php bloginfo('name'); ?>"></a></h1>
					<?php else : ?>
						<div class="logo"><a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><img src="<?php echo get_theme_mod(sanitize_title(wp_get_theme()) . '-logo'); ?>" alt="<?php bloginfo('name'); ?>"></a></div>
					<?php endif;
				?>
			</div>
		</div>
		<nav class="nav-box" id="menu">
			<div class="holder">
				<?php
					// side navigation menu.
					wp_nav_menu( array(
						'menu_class' => 'main-menu',
						'container' => 'none',
						'theme_location' => 'main',
					) );
				?>
			</div>
		</nav>
	</header>
	<div id="sidebar" class="sidebar" style="top:300px">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					if (is_front_page() && is_home()) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
					<?php else : ?>
						<div class="site-title"><a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><?php bloginfo('name'); ?></a></div>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif;
				?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
			</div><!-- .site-branding -->
		</header><!-- .site-header -->

		<?php get_sidebar(); ?>
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
