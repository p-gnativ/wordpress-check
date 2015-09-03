<?php
// article type post
function as_article_post(){
    $labels = array(
        'name' => __('Articles', 'soa'),
        'singular_name' => __('Article', 'soa'),
        'add_new' => __('Add New', 'soa'),
        'add_new_item' => __('Add New Article', 'soa'),
        'edit_item' => __('Edit Article', 'soa'),
        'new_item' => __('New Article', 'soa'),
        'view_item' => __('View Article', 'soa'),
        //'all_items' => __('All Articles', 'as_domain'),
        'search_items' => __('Search Articles', 'soa'),
        'not_found' => __('No articles found', 'soa'),
		'not_found_in_trash' => __('No articles found in Trash', 'soa'),
        'parent_item_colon' => __('Parent Article:', 'soa'),
        'menu_name' => __('Articles', 'soa'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_position' => 4, // 4 - after posts, 3 - before space
        'supports' => array('title', 'editor'),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
    );
    register_post_type('article', $args);
}
add_action('init', 'as_article_post');
// taxonomy (category) for article type
function as_taxonomies_article() {
    $labels = array(
        'name' => __('Article Categories', 'soa'),
        'singular_name' => __('Article Category', 'soa'),
        'all_items' => __('All Article Categories', 'soa'),
        'edit_item' => __('Edit Article Category', 'soa'),
        'search_items' => __('Search Article Category', 'soa'),
        'update_item' => __('Update Article Category', 'soa'),
        'add_new_item' => __('Add New Article Category', 'soa'),
        'new_item_name' => __('New Article Category Name', 'soa'),
        'menu_name' => __('Article Categories', 'soa'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        //'rewrite' => array('slug' => 'article_category'),
    );
    register_taxonomy('article_category', 'article', $args);
}
add_action('init', 'as_taxonomies_article', 0);
// columns in admin list article
function as_edit_article_columns($columns){
    $columns = array(
        'title' => __('Article', 'soa'),
        'taxonomy-article_category' => __('Article Categories', 'soa'),
        //'category' => __('Category', 'soa'),
        'date' => __('Date', 'as_domain'),
    );
    return $columns;
}
add_filter('manage_edit-article_columns', 'as_edit_article_columns');
// add admin list sorting
function as_article_category_sortable_columns($columns){
    $columns['taxonomy-article_category'] = 'taxonomy-article_category';
    return $columns;
}
add_filter('manage_edit-article_sortable_columns', 'as_article_category_sortable_columns');
?>