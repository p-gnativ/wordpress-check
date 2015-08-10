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

?>