<?php
// widget black studio tinyMCE fix container
add_filter('black_studio_tinymce_before_text', 'as_black_studio_tinymce_widget_before_text', 10, 2);
function as_black_studio_tinymce_widget_before_text($before_text, $instance){
	return '<div class="text">';
}
//add_filter('black_studio_tinymce_before_text', '__return_empty_string');
//add_filter('black_studio_tinymce_after_text', '__return_empty_string');

function sidebar_exist_and_active($sidebar_name){
	global $wp_registered_sidebars;
	foreach((array) $wp_registered_sidebars as $index => $sidebar){
		if(in_array($sidebar_name, $sidebar)){
			return is_active_sidebar($sidebar['id']);
		}
	}
	return false;
}
if(function_exists('register_sidebar')){
	// Home Page (Top Content Widget)
	register_sidebar(array(
		'name' => __('Home Top', 'soa'),
		'id' => 'home-top-widget',
		'description' => __('A widget area, used as image or content', 'soa'),
		'before_widget' => '<div class="holder">',
		'after_widget' => '</div>',
		'before_title' => '<h1>',
		'after_title' => '</h1>',
	));
	// Home Page (Second Content Widget)
	register_sidebar(array(
		'name' => __('Home Second Row', 'soa'),
		'id' => 'home-second-widget',
		'description' => __('A widget area, used as columns content (max 5)', 'soa'),
		'before_widget' => '<li><div class="holder">',
		'after_widget' => '</div></li>',
		'before_title' => '<div class="title"><h2>',
		'after_title' => '</h2></div>',
	));
	// Home Page (Banner Content Widget)
	register_sidebar(array(
		'name' => __('Home Banner Row', 'soa'),
		'id' => 'home-banner-widget',
		'description' => __('A widget area, used as columns content (max 5)', 'soa'),
		'before_widget' => '<li><div class="img-holder">',
		'after_widget' => '</div></li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
?>