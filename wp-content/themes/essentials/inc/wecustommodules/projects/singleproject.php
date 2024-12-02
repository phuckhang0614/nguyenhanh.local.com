<?php
/**
 * Wemetrics functions and definitions
 *
 * @package single project
 */
// Khởi tạo post_type là project
function create_project_post_type() {
    $labels = array(
        'name'               => _x('Projects', 'post type general name'),
        'singular_name'      => _x('Project', 'post type singular name'),
        'menu_name'          => _x('Dự án', 'admin menu'),
        'name_admin_bar'     => _x('Dự án', 'add new on admin bar'),
        'add_new'            => _x('Add New', 'project'),
        'add_new_item'       => __('Add New Project'),
        'new_item'           => __('New Project'),
        'edit_item'          => __('Edit Project'),
        'view_item'          => __('View Project'),
        'all_items'          => __('All Project'),
        'search_items'       => __('Search Project'),
        'parent_item_colon'  => __('Parent Project:'),
        'not_found'          => __('No projects found.'),
        'not_found_in_trash' => __('No projects found in Trash.')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'du-an'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'         => array('project_category'),
        'show_in_rest'       => true
    );

    register_post_type('project', $args);
}
add_action('init', 'create_project_post_type');