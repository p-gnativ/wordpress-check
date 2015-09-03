<?php
// plugin Multisite Language Switcher - add lang item
function as_lang_menu_item($items, $args){
	if(class_exists('MslsOutput')){ // if add single menu (&& 'main' == $args->theme_location)
		$obj = new MslsOutput;
		$arr = $obj->get(1);
		if(!empty($arr)){
			$items .= '<li>' . implode('</li><li>', $arr) . '</li>';
		}
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'as_lang_menu_item', 10, 2);
?>