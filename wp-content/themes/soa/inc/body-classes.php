<?php
// clear classes
function as_body_classes($classes){
	$classes = array();
	if(is_front_page()) $classes[] = 'home';
	if(is_user_logged_in()) $classes[] = 'logged-in';
	if(is_admin_bar_showing()){
		$classes[] = 'admin-bar';
		$classes[] = 'no-customize-support';
	}
	//$slug = strtolower(str_replace(' ', '-', trim(get_bloginfo('name'))));
	//$classes[] = $slug;
	return $classes;
}
add_filter('body_class', 'as_body_classes');
?>