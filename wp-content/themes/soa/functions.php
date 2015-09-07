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
// home page
require get_template_directory() . '/inc/home-widgets.php';


/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

// add style to editor
function as_add_editor_styles() {
    add_editor_style('editor-style.css');
}
add_action('admin_init', 'as_add_editor_styles');
// activate button in editor
function as_mce_editor_buttons($buttons){
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'as_mce_editor_buttons');
// add formats in dropdown
function as_mce_before_init_insert_formats($init_array){
	$style_formats = array(
		array(
			'title' => 'Home Widgets',
			'items' => array(
				array(
					'title' => 'Sub Title',
					'block' => 'p',
					'classes' => 'sub-title',
				),
				array(
					'title' => 'Figure',
					'block' => 'figure',
				),
				array(
					'title' => 'Class Link Underline',
					'classes' => 'underline',
					'selector' => 'a',
				),
			)
		),
		array(
			'title' => 'Block Element (div)',
			'block' => 'div',
		),
	);
	/*$init_array['block_formats'] =
		'Paragraph=p;' .
		'Block Element (div)=div;' .
		'Figure=figure;' .
		'Heading 1=h1;' .
		'Heading 2=h2;' .
		'Heading 3=h3;' .
		'Heading 4=h4;' .
		'Heading 5=h5;' .
		'Heading 6=h6;' .
		'Address=address;' .
        'Pre=pre';*/
	$init_array['style_formats'] = json_encode($style_formats);
	return $init_array;

}
add_filter('tiny_mce_before_init', 'as_mce_before_init_insert_formats');
//global $allowedposttags;
//var_dump($allowedposttags);
//$allowedposttags['figure'] = array('class' => array());
