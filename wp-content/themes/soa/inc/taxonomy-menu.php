<?php
//
function as_menu_items_taxonomy($sorted_menu_items, $args){
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
				foreach((array) $posts as $pkey => $post){
					$post = wp_setup_nav_menu_item($post);
					$current_parent_id = $menu_item->db_id;
					while(array_key_exists(strval($current_parent_id), $menu_item_parent_map) == 1){
						$current_parent_id = $menu_item_parent_map[$current_parent_id];
					}
					$post->menu_item_parent = $current_parent_id;
					$post->target = $menu_item->target;
					$post->classes = array_merge($post->classes, (array) get_post_meta($menu_item->db_id, "_menu_item_classes", true));
					$post->xfn = $menu_item->xfn;
					$post->description = $menu_item->description;
					$inc += 1;
					$post->menu_order = $menu_item->menu_order + $inc;
				}
				_wp_menu_item_classes_by_context($posts);
				$result = array_merge($result, $posts);
			}else{
				$current_parent_id = $menu_item->menu_item_parent;
				while (array_key_exists(strval($current_parent_id), $menu_item_parent_map) == 1){
					$current_parent_id = $menu_item_parent_map[$current_parent_id];
				}
				$menu_item->menu_item_parent = $current_parent_id;
				array_push($result,$menu_item);
			}
		}
		unset($sorted_menu_items);
		unset($menu_item_parent_map);
		_wp_menu_item_classes_by_context($result);
		return $result;
	}
}
add_filter('wp_nav_menu_objects', 'as_menu_items_taxonomy', 1, 2);
?>