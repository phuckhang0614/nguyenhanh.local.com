<?php
/**
 * Wemetrics functions and definitions
 *
 * @package category project
 */
// Khởi tạo category dành cho project
function create_project_taxonomy() {
    $labels = array(
        'name'              => _x('Categories Projects', 'taxonomy general name'),
        'singular_name'     => _x('Category', 'taxonomy singular name'),
        'search_items'      => __('Search Categories'),
        'all_items'         => __('All Categories'),
        'parent_item'       => __('Parent Category'),
        'parent_item_colon' => __('Parent Category:'),
        'edit_item'         => __('Edit Category'),
        'update_item'       => __('Update Category'),
        'add_new_item'      => __('Add New Category'),
        'new_item_name'     => __('New Category Name'),
        'menu_name'         => __('Categories'),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_admin_bar' => true,
        'query_var'         => true,
        'show_in_rest'       => true,
        'rewrite'           => array('slug' => 'danh-muc-du-an')
    );

    register_taxonomy('project_category', array('project'), $args);
}
add_action('init', 'create_project_taxonomy', 0);