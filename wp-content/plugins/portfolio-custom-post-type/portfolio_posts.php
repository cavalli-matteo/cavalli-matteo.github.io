<?php
/*
Plugin Name: Rs Card Portfolio Posts
Description: Declares a plugin that will create a custom post type displaying portfolio.
Version: 1.0
*/
?>
<?php
add_action( 'init', 'create_portfolio' );

// Register Portfolio Post Type
function create_portfolio() {

    $labels = array(
        'name'                  => _x( 'Portfolio', 'Post Type General Name', 'portfolio' ),
        'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'portfolio' ),
        'menu_name'             => __( 'Portfolio', 'portfolio' ),
        'name_admin_bar'        => __( 'Portfolio', 'portfolio' ),
        'parent_item_colon'     => __( 'Parent Post:', 'portfolio' ),
        'all_items'             => __( 'All Posts', 'portfolio' ),
        'add_new_item'          => __( 'Add New Post', 'portfolio' ),
        'add_new'               => __( 'Add New', 'portfolio' ),
        'new_item'              => __( 'New Post', 'portfolio' ),
        'edit_item'             => __( 'Edit Post', 'portfolio' ),
        'update_item'           => __( 'Update Post', 'portfolio' ),
        'view_item'             => __( 'View Post', 'portfolio' ),
        'search_items'          => __( 'Search Post', 'portfolio' ),
        'not_found'             => __( 'Not found', 'portfolio' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'portfolio' ),
        'items_list'            => __( 'Posts list', 'portfolio' ),
        'items_list_navigation' => __( 'Posts list navigation', 'portfolio' ),
        'filter_items_list'     => __( 'Filter Posts list', 'portfolio' ),
    );
    $args = array(
        'label'                 => __( 'Portfolio', 'portfolio' ),
        'description'           => __( 'Portfolio Posts', 'portfolio' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'thumbnail','editor','excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'menu_position' => 15,
        'menu_icon' => plugins_url( 'images/Portfolio-Icon-grey.png', __FILE__ ),
    );
    register_post_type( 'portfolio', $args );

}

// Register Portfolio Taxonomy
function portfolio_categories() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'portfolio_categories' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'portfolio_categories' ),
        'menu_name'                  => __( 'Categories', 'portfolio_categories' ),
        'all_items'                  => __( 'All Categories', 'portfolio_categories' ),
        'parent_item'                => __( 'Parent Category', 'portfolio_categories' ),
        'parent_item_colon'          => __( 'Parent Category:', 'portfolio_categories' ),
        'new_item_name'              => __( 'New Category Name', 'portfolio_categories' ),
        'add_new_item'               => __( 'Add New Category', 'portfolio_categories' ),
        'edit_item'                  => __( 'Edit Category', 'portfolio_categories' ),
        'update_item'                => __( 'Update Category', 'portfolio_categories' ),
        'view_item'                  => __( 'View Category', 'portfolio_categories' ),
        'separate_items_with_commas' => __( 'Separate Categories with commas', 'portfolio_categories' ),
        'add_or_remove_items'        => __( 'Add or remove Categories', 'portfolio_categories' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'portfolio_categories' ),
        'popular_items'              => __( 'Popular Categories', 'portfolio_categories' ),
        'search_items'               => __( 'Search Categories', 'portfolio_categories' ),
        'not_found'                  => __( 'Not Found', 'portfolio_categories' ),
        'items_list'                 => __( 'Categories list', 'portfolio_categories' ),
        'items_list_navigation'      => __( 'Categories list navigation', 'portfolio_categories' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'portfolio_categories', array( 'portfolio' ), $args );

}
add_action( 'init', 'portfolio_categories', 0 );