<?php

if(!function_exists('as_soa_setup')):
function as_soa_setup(){
	// load translate
	load_theme_textdomain('soa', get_template_directory() . '/languages');
	// head title
	add_theme_support('title-tag');
	// registration menu
	register_nav_menus(array(
		'main' => __('Main Menu', 'soa'),
		'side' => __('Side Menu', 'soa'),
	));
}
endif;
add_action('after_setup_theme', 'as_soa_setup');

function soa_scripts() {
	// Load our main stylesheet
	wp_enqueue_style('soa-style', get_stylesheet_uri());
	//wp_enqueue_style('soa-overrule-style', get_template_directory_uri() . '/overrule.css');
	//wp_enqueue_style('soa-angistudio-style', get_template_directory_uri() . '/update.css');

	wp_enqueue_script('soa-threedots', get_template_directory_uri() . '/js/jquery.threedots.min.js', array('jquery'));
	wp_enqueue_script('soa-libs', get_template_directory_uri() . '/js/jquery.libs.min.js', array('jquery'));

	wp_enqueue_script('soa-main', get_template_directory_uri() . '/js/jquery.main.min.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'soa_scripts');

// clean head
require get_template_directory() . '/inc/clear-html.php';




/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';


// custom post type
require get_template_directory() . '/inc/article-post.php';

//require get_template_directory() . '/inc/custom-fields.php';

function as_logo_customize_register($wp_customize){
	$theme = wp_get_theme();
	// name option
	$settings = sanitize_title($theme);
	// add setting
	$wp_customize->add_setting(
		$settings.'-logo',
		array(
			'default' => get_template_directory_uri() . '/images/logo.png',
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options'
		)
	);
	// add control
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			$settings.'-logo',
			array(
				'label' => __('Logo', 'soa'),
				'section' => 'title_tagline'
			)
		)
	);
}
add_action('customize_register', 'as_logo_customize_register', 11);

function as_lang_menu_item($items, $args){
	if(class_exists('MslsOutput')){ // && 'main' == $args->theme_location
		$obj = new MslsOutput;
		$arr = $obj->get(1);
		if(!empty($arr)){
			$items .= '<li>' . implode('</li><li>', $arr) . '</li>';
		}
	}
	return $items;
}
add_filter('wp_nav_menu_items', 'as_lang_menu_item', 10, 2);

function cpcm_replace_taxonomy_by_posts1($sorted_menu_items, $args){
	if($args->theme_location == 'main'){
		return $sorted_menu_items;
	}else{
		$result = array();
		$inc = 0;
		$menu_item_parent_map = array();
		foreach((array) $sorted_menu_items as $key => $menu_item){
			$menu_item->menu_order = $menu_item->menu_order + $inc;
			if($menu_item->type == 'taxonomy'){
				//
				$query_arr = array();
				$query_arr['tax_query'] = array(
					'relation' => 'AND',
					array(
						'taxonomy'=>$menu_item->object,
						'field'=>'id',
						'terms'=>$menu_item->object_id
					)
				);

				$tag = get_taxonomy($menu_item->object);

				$query_arr['post_type'] = $tag->object_type;


				$posts = get_posts($query_arr);
				//var_dump($posts);
				$menu_item_parent = $menu_item->menu_item_parent;
				// empty not show
				if(empty($posts)){
					$inc -= 1;
					$menu_item_parent_map[$menu_item->db_id] = $menu_item->menu_item_parent;
				}else{
					array_push($result, $menu_item);
				}

				$current_parent_id = $menu_item->menu_item_parent;

				while(array_key_exists(strval($current_parent_id), $menu_item_parent_map) == 1){
					$current_parent_id = $menu_item_parent_map[$current_parent_id];
				}
				$menu_item->menu_item_parent = $current_parent_id;
				//var_dump($menu_item->menu_item_parent);
				foreach((array) $posts as $pkey => $post){
					$post = wp_setup_nav_menu_item( $post );
					$current_parent_id = $menu_item->db_id;
					while(array_key_exists(strval($current_parent_id), $menu_item_parent_map) == 1){
						$current_parent_id = $menu_item_parent_map[$current_parent_id];
					}
					$post->menu_item_parent = $current_parent_id;
					// properties from the old to the new one
					$post->target = $menu_item->target;
					$post->classes = array_merge( $post->classes, (array) get_post_meta($menu_item->db_id, "_menu_item_classes", true) ); // copy custom css classes that the user specified under "CSS Classes (optional)"
					$post->xfn = $menu_item->xfn;
					$post->description = $menu_item->description;
					// title of the new menu item
					//$post->title = get_post_meta($menu_item->db_id, "_cpcm-item-titles", true);
					// Replace the placeholders in the title by the properties of the post
					//$post->title = $this->replace_placeholders($post, $post->title);
					$inc += 1;
					$post->menu_order = $menu_item->menu_order + $inc;
					// Extend the items with classes.



				}
				_wp_menu_item_classes_by_context( $posts );
				$result = array_merge( $result, $posts );
			}
			else
			{
				// Other objects may have a parent that has been removed by cpcm. Fix that here.
				// Set the menu_item_parent for the menu_item: If the parent item was removed, go up a level
				$current_parent_id = $menu_item->menu_item_parent;
				//var_dump($menu_item_parent_map);
				while (array_key_exists(strval($current_parent_id), $menu_item_parent_map) == 1)
				{
					$current_parent_id = $menu_item_parent_map[$current_parent_id];
				}
				$menu_item->menu_item_parent = $current_parent_id;

				// Treat other objects as usual, but note that the position
				// of elements in the array changes.
				array_push($result,$menu_item);
			}


		}
		unset($sorted_menu_items);
		unset($menu_item_parent_map);
		_wp_menu_item_classes_by_context($result);
		return $result;
	}
}

add_filter( 'wp_nav_menu_objects', 'cpcm_replace_taxonomy_by_posts1', 1, 2 );



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