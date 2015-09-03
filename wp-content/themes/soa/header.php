<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="skiplinks">
		<?php _e('Go directly', 'soa'); ?> <a href="#content"><?php _e('content', 'soa'); ?></a>, <a href="#main_nav"><?php _e('main menu', 'soa'); ?></a> <?php _e('of', 'soa'); ?> <a href="#meta_nav"><?php _e('service menu', 'soa'); ?></a>
	</div>
	<div id="wrapper" class="inner">
		<header id="header">
			<div class="section">
				<div class="holder">
					<?php
						$logo_path = get_template_directory_uri() . '/images/logo.png';
						if (is_front_page() && is_home()) : ?>
							<h1 class="logo"><a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><img src="<?php echo get_theme_mod(sanitize_title(wp_get_theme()) . '-logo', $logo_path); ?>" alt="<?php bloginfo('name'); ?>"></a></h1>
						<?php else : ?>
							<div class="logo"><a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><img src="<?php echo get_theme_mod(sanitize_title(wp_get_theme()) . '-logo', $logo_path); ?>" alt="<?php bloginfo('name'); ?>"></a></div>
						<?php endif;
					?>
				</div>
			</div>
			<nav class="nav-box" id="menu">
				<div class="holder">
					<?php
						// main menu
						wp_nav_menu( array(
							'menu_class' => 'main-menu',
							'container' => 'none',
							'theme_location' => 'main',
							'menu_id' => 'nav',
							'before' => '<span>',
							'after' => '</span>',
						) );
					?>
				</div>
			</nav>
		</header><!-- #header -->