<?php
// article type post
function as_article_post(){
    $labels = array(
        'name' => __('Articles', 'as_domain'),
        'singular_name' => __('Article', 'as_domain'),
        'add_new' => __('Add New', 'as_domain'),
        'add_new_item' => __('Add New Article', 'as_domain'),
        'edit_item' => __('Edit Article', 'as_domain'),
        'new_item' => __('New Article', 'as_domain'),
        'view_item' => __('View Article', 'as_domain'),
        //'all_items' => __('All Articles', 'as_domain'),
        'search_items' => __('Search Articles', 'as_domain'),
        'not_found' => __('No articles found', 'as_domain'),
        'not_found_in_trash' => __('No articles found in Trash', 'as_domain'),
        'parent_item_colon' => __('Parent Article:', 'as_domain'),
        'menu_name' => __('Articles', 'article'),
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
        'capability_type' => 'post'
    );
    register_post_type('article', $args);
}
add_action('init', 'as_article_post');
// taxonomy (category) for article type
function as_taxonomies_article() {
    $labels = array(
        'name' => __('Article Categories', 'as_domain'),
        'singular_name' => __('Article Category', 'as_domain'),
        'search_items' => __('Search Article Category', 'as_domain'),
        'all_items' => __('All Article Categories', 'as_domain'),
        'edit_item' => __('Edit Article Category', 'as_domain'),
        'update_item' => __('Update Article Category', 'as_domain'),
        'add_new_item' => __('Add New Article Category', 'as_domain'),
        'new_item_name' => __('New Article Category Name', 'as_domain'),
        'menu_name' => __('Article Categories', 'as_domain'),
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
// columns in article list
function as_edit_article_columns($columns){
    $columns = array(
        'title' => __('Article', 'as_domain'),
        'taxonomy-article_category' => __('Article Categories', 'as_domain'),
        //'category' => __('Category', 'as_domain'),
        'date' => __('Date', 'as_domain'),
    );
    return $columns;
}
add_filter('manage_edit-article_columns', 'as_edit_article_columns');
// add sorting
function as_article_category_sortable_columns($columns){
    $columns['taxonomy-article_category'] = 'taxonomy-article_category';
    return $columns;
}
add_filter('manage_edit-article_sortable_columns', 'as_article_category_sortable_columns');

?>