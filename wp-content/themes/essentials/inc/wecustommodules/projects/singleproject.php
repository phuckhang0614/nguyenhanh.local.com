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

function pix_project_meta_add(){

    global $pix_project_meta_box;


    // Layouts ----------------------------------
    $layouts = array( 0 => '-- Theme Options --' );

    // Custom menu ------------------------------
    $aMenus = array( 0 => '-- Default --' );
    $oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

    if( is_array($oMenus) ){
        foreach( $oMenus as $menu ){
            $aMenus[$menu->term_id] = $menu->name;
        }
    }


    $header_posts = get_posts([
        'post_type' => 'pixheader',
        'post_status' => array('publish', 'private'),
        'numberposts' => -1
        // 'order'    => 'ASC'
    ]);

    $headers = array();

    $headers[''] = "Theme Default";
    $headers['disable'] = "Disable";
    foreach ($header_posts as $key => $value) {
        $headers[$value->ID] = $value->post_title;
    }

    $footer_posts = get_posts([
        'post_type' => 'pixfooter',
        'post_status' => array('publish', 'private'),
        'numberposts' => -1
        // 'order'    => 'ASC'
    ]);

    $footers = array();
    $footers[''] = "Theme Default";
    $footers['disable'] = "Disabled";
    foreach ($footer_posts as $key => $value) {
        $footers[$value->ID] = $value->post_title;
    }


    $pix_project_meta_box = array(
        'id'        => 'pix-meta-post',
        'title'     => __('PixFort Post Options','pix-opts'),
        'page'      => 'project',
        'post_types'    => array('project'),
        'context'   => 'normal',
        'priority'  => 'default',
        'fields'    => array(

            array(
                'id'        => 'pix-page-header',
                'type'      => 'select',
                'title'     => __('Custom Header', 'pixfort-core'),
                'options'   => $headers,
            ),
            array(
                'id'        => 'pix-page-footer',
                'type'      => 'select',
                'title'     => __('Custom Footer', 'pixfort-core'),
                'options'   => $footers,
            ),

            array(
                'id'        => 'pix-custom-intro-bg',
                'type'      => 'media',
                'title'     => __('Page intro background image', 'pix-opts'),
                'sub_desc'  => __('Select an image to override the default intro background image.', 'pix-opts'),
            ),


        ),
    );
    add_meta_box($pix_project_meta_box['id'], $pix_project_meta_box['title'], 'pix_project_show_box', $pix_project_meta_box['page'], $pix_project_meta_box['context'], $pix_project_meta_box['priority']);
}

add_action('admin_menu', 'pix_project_meta_add');

function pix_project_show_box() {
    global $pix_project_meta_box, $post;

    // Use nonce for verification
    echo '<div id="pix-wrapper">';
        echo '<input type="hidden" name="pix_project_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

        echo '<table class="form-table">';
            echo '<tbody>';

                foreach ($pix_project_meta_box['fields'] as $field) {
                    $meta = get_post_meta($post->ID, $field['id'], true);
                    if( ! key_exists('std', $field) ) $field['std'] = false;
                    $meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES ));
                    pix_meta_field_input( $field, $meta );
                }

            echo '</tbody>';
        echo '</table>';

    echo '</div>';
}

/*-----------------------------------------------------------------------------------*/
/*  Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function pix_project_save_data($post_id) {
    global $pix_project_meta_box;

    // verify nonce
    if( key_exists( 'pix_project_meta_nonce',$_POST ) ) {
        if ( ! wp_verify_nonce( $_POST['pix_project_meta_nonce'], basename(__FILE__) ) ) {
            return $post_id;
        }
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if(!empty($pix_project_meta_box)){
        foreach ( (array)$pix_project_meta_box['fields'] as $field ) {
            $old = get_post_meta($post_id, $field['id'], true);
            if( key_exists($field['id'], $_POST) ) {
                $new = $_POST[$field['id']];
            } else {
                $new = ""; // problem with "quick edit"
                //continue;
            }

            if( isset($new) && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            }elseif('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }

        }
    }
}
add_action('save_post', 'pix_project_save_data');

/*-----------------------------------------------------------------------------------*/
/*  Styles & scripts
/*-----------------------------------------------------------------------------------*/
function pix_design_project_admin_styles() {
    wp_enqueue_style( 'pix-meta', PIX_CORE_PLUGIN_URI. 'functions/css/pixbuilder.css', false, time(), 'all');
    wp_enqueue_style( 'pix-meta2', PIX_CORE_PLUGIN_URI. 'functions/pixbuilder.css', false, time(), 'all');
}
add_action('admin_print_styles', 'pix_design_project_admin_styles');

function pix_design_project_admin_scripts() {
    wp_enqueue_script( 'pix-admin-piximations', PIX_CORE_PLUGIN_URI . 'functions/js/piximations.js');
    wp_enqueue_script( 'pix-admin-custom', PIX_CORE_PLUGIN_URI . 'functions/js/custom.js', array('jquery'));
    wp_localize_script( 'pix-admin-custom', 'plugin_object', array(
        'PIX_CORE_PLUGIN_URI' => PIX_CORE_PLUGIN_URI,
    ));
}
add_action('admin_print_scripts', 'pix_design_project_admin_scripts');