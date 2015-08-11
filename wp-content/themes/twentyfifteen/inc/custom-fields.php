<?php

function as_website_add_meta_box(){
    add_meta_box(
        'website_meta',
        'Website', // __('Website', 'theme_textdomain')
        'as_website_meta_box_callback',
        'page'
    );
}
add_action('add_meta_boxes', 'as_website_add_meta_box');

function as_website_meta_box_callback($post){
    //var_dump($post);
    //echo 'Custom meta box';
    wp_nonce_field(basename( __FILE__ ), 'website_meta_nonce');
    $stored_meta_website = get_post_meta($post->ID);
    ?>
    <p>
        <label for="meta_website">Website link:</label>
        <input type="text" name="meta_website" id="meta_website" value="<?php if(isset($stored_meta_website['meta_website'])) echo $stored_meta_website['meta_website'][0]; ?>" />
    </p>
    <?php
}
function as_website_meta_box_save($post_id){
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['website_meta_nonce']) && wp_verify_nonce($_POST['website_meta_nonce'], basename( __FILE__ ))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce){
        return;
    }

    if(isset($_POST['meta_website'])){
        update_post_meta($post_id, 'meta_website', sanitize_text_field( $_POST['meta_website']));
    }

}
add_action('save_post', 'as_website_meta_box_save');