<?php
/*
	Header
*/
// meta name=generator
remove_action('wp_head', 'wp_generator');
// link rel=EditURI
remove_action('wp_head', 'rsd_link');
// link rel=wlwmanifest
remove_action('wp_head', 'wlwmanifest_link');
// link rel=shortlink
remove_action('wp_head', 'wp_shortlink_wp_head');
// rss, remove -> add_theme_support('automatic-feed-links');
remove_action('wp_head', 'feed_links');
remove_action('wp_head', 'feed_links_extra');
// and redirect to home page
function as_feed_redirect_to_home(){
	wp_redirect(get_option('siteurl'), 301);
}
add_action('do_feed', 'as_feed_redirect_to_home', 1);
add_action('do_feed_rdf', 'as_feed_redirect_to_home', 1);
add_action('do_feed_rss', 'as_feed_redirect_to_home', 1);
add_action('do_feed_rss2', 'as_feed_redirect_to_home', 1);
add_action('do_feed_atom', 'as_feed_redirect_to_home', 1);
/*
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'index_rel_link');
remove_action( 'wp_head', 'parent_post_rel_link');
remove_action( 'wp_head', 'start_post_rel_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link');
*/
// response headers
// Link rel=shortlink
remove_action('template_redirect', 'wp_shortlink_header', 11);
// X-Pingback
function as_remove_x_pingback($headers){
	unset($headers['X-Pingback']);
	return $headers;
}
add_filter('wp_headers', 'as_remove_x_pingback');
// X-Powered-By
header_remove('x-powered-by');
// emojicons in tinymce
function as_disable_emojicons_tinymce($plugins){
	if(is_array($plugins)){
		return array_diff($plugins, array('wpemoji'));
	}else{
		return array();
  }
}
function as_disable_emojicons(){
	// actions emojis
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');

	// filter to remove emojicons in tinymce
	add_filter('tiny_mce_plugins', 'as_disable_emojicons_tinymce');
}
add_action('init', 'as_disable_emojicons');

/*
	Menu
*/
// removed id and changed all classes, save the necessary classes
function custom_wp_nav_menu($css_class_id, $item){
    if(is_array($css_class_id)){
        $update_class_id = array_intersect($css_class_id, array(
            // list of stored classes for menu
            'current_page_item',
            'current_page_parent',
            'current_page_ancestor',
            'current-menu-item', // for plugin 'Category Posts in Custom Menu'
            'first',
            'last',
            'vertical',
            'horizontal',
            'home', // for home icon
            'current-menu-parent',
        ));
        $replace_class = array(
            // list of classes that need to be replaced on 'active'
            'current_page_item',
            'current_page_parent',
            'current_page_ancestor',
            'current-menu-item', // for plugin 'Category Posts in Custom Menu'
        );
        foreach($update_class_id as &$value){
            if(in_array($value, $replace_class)){
                $value = 'active';
            }
            if($value == 'current-menu-parent'){
				$value = 'parent-active';
			}
        }
        unset($value);
        return array_unique($update_class_id);
    }else{
        return '';
    }
}
add_filter('nav_menu_css_class', 'custom_wp_nav_menu', 10, 2);
add_filter('nav_menu_item_id', 'custom_wp_nav_menu', 10, 2);
add_filter('page_css_class', 'custom_wp_nav_menu', 10, 2);

/*
//remove empty classes and classes for sub menu
function as_remove_empty_classes($menu) {
	$menu = preg_replace('/ class=""| class="sub-menu"/', '', $menu);
	return $menu;
}
add_filter('wp_nav_menu', 'as_remove_empty_classes');
*/
add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');
?>