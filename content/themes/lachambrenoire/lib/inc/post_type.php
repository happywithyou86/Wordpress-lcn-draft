<?php
// Register Custom Post Type
function custom_post_type() {

  $labels = array(
    'name'                => _x( 'Artists', 'Post Type General Name', '_s' ),
    'singular_name'       => _x( 'Artist', 'Post Type Singular Name', '_s' ),
    'menu_name'           => __( 'Artists', '_s' ),
    'name_admin_bar'      => __( 'Artists', '_s' ),
    'parent_item_colon'   => __( 'Parent Item:', '_s' ),
    'all_items'           => __( 'All Artists', '_s' ),
    'add_new_item'        => __( 'Add New Artist', '_s' ),
    'add_new'             => __( 'Add New', '_s' ),
    'new_item'            => __( 'New Artist', '_s' ),
    'edit_item'           => __( 'Edit Artist', '_s' ),
    'update_item'         => __( 'Update Artist', '_s' ),
    'view_item'           => __( 'View Artist', '_s' ),
    'search_items'        => __( 'Search Artist', '_s' ),
    'not_found'           => __( 'Not found', '_s' ),
    'not_found_in_trash'  => __( 'Not found in Trash', '_s' ),
  );
  $rewrite = array(
    'slug'                => 'artists',
    'with_front'          => true,
    'pages'               => true,
    'feeds'               => true,
  );
  $args = array(
    'label'               => __( 'artists', '_s' ),
    'description'         => __( 'Name for post type', '_s' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
    'taxonomies'          => array( 'category', 'post_tag' ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-art',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'post',
  );
  register_post_type( 'artists', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );