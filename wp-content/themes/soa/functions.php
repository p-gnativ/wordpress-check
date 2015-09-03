<?php

if(!function_exists('as_soa_setup')):
function as_soa_setup(){
	// load translate
	load_theme_textdomain('soa', get_template_directory() . '/languages');
	// head title
	add_theme_support('title-tag');
	// registration menu
	register_nav_menus(array(
		'main' => __('Main Menu', 'soa'),
		'side' => __('Side Menu', 'soa'),
	));
	// add menu to location
	if(!wp_get_nav_menu_object('Main Menu')){
		$menu_id = wp_create_nav_menu('Main Menu');
		$locations = get_theme_mod('nav_menu_locations');
		$locations['main'] = $menu_id;
		set_theme_mod('nav_menu_locations', $locations);
	}
}
endif;
add_action('after_setup_theme', 'as_soa_setup');

function soa_scripts() {
	// Load our main stylesheet
	wp_enqueue_style('soa-style', get_stylesheet_uri());
	//wp_enqueue_style('soa-overrule-style', get_template_directory_uri() . '/overrule.css');
	//wp_enqueue_style('soa-angistudio-style', get_template_directory_uri() . '/update.css');

	wp_enqueue_script('soa-threedots', get_template_directory_uri() . '/js/jquery.threedots.min.js', array('jquery'));
	wp_enqueue_script('soa-libs', get_template_directory_uri() . '/js/jquery.libs.min.js', array('jquery'));

	wp_enqueue_script('soa-main', get_template_directory_uri() . '/js/jquery.main.min.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'soa_scripts');

// clean head
require get_template_directory() . '/inc/clear-html.php';
// custom post type
require get_template_directory() . '/inc/article-post.php';
// customize theme
require get_template_directory() . '/inc/customize-theme.php';
// add lang to menu
require get_template_directory() . '/inc/p-lang-to-menu.php';
// list post in menu
require get_template_directory() . '/inc/taxonomy-menu.php';
// body classes
require get_template_directory() . '/inc/body-classes.php';

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

