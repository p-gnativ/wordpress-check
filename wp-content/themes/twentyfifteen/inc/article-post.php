<?php

function as_article_post(){
    $labels = array(
        'name' => _x('Articles', 'general post type'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_position' => 4, // 4 - after posts, 3 - before space
    );
    //echo 'test';
    register_post_type('article', $args);
}
add_action('init', 'as_article_post');

?>