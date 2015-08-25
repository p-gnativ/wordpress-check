<?php

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


// menu
// remove all classes and id, save the necessary classes
function custom_wp_nav_menu($css_class_id, $item){
    //var_dump($css_class_id);
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
            'home' // for icon
        ));
        $replace_class = array(
            // list of classes that need to be replaced on 'active'
            'current_page_item',
            'current_page_parent',
            'current_page_ancestor',
            'current-menu-item', // for plugin 'Category Posts in Custom Menu'
        );
        //var_dump($update_class_id);
        foreach($update_class_id as &$value){
            if(in_array($value, $replace_class)){
                $value = 'active';
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

// replacement list classes for 'active'
function as_replace_class_to_active($text){
    //var_dump($text);
    $replace = array(
        // list of classes that need to be replaced on 'active'
        'current_page_item' => 'active',
        'current_page_parent' => 'active',
        'current_page_ancestor' => 'active',
        'current-menu-item' => 'active', // for plugin 'Category Posts in Custom Menu'
    );
    $text = str_replace(array_keys($replace), $replace, $text);
    return $text;
}
//add_filter('wp_nav_menu','as_replace_class_to_active');
// remove empty classes and classes for sub menu
function as_remove_empty_classes($menu) {
    $menu = preg_replace('/ class=""| class="sub-menu"/', '', $menu);
    return $menu;
}
//add_filter('wp_nav_menu', 'as_remove_empty_classes');
?>