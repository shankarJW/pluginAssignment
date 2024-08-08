<?php 
// Register Custom Post Type
function wp_book_register_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Books',
            'singular_name' => 'Book',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Book',
            'edit_item' => 'Edit Book',
            'new_item' => 'New Book',
            'view_item' => 'View Book',
            'search_items' => 'Search Books',
            'not_found' => 'No books found',
            'not_found_in_trash' => 'No books found in Trash',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-book',
    );
    register_post_type('book', $args);
}
add_action('init', 'wp_book_register_post_type');


// Register Custom Taxonomies
function wp_book_register_taxonomies() {
    // Book Category (Hierarchical)
    $args = array(
        'labels' => array(
            'name' => 'Book Categories',
            'singular_name' => 'Book Category',
            'search_items' => 'Search Categories',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item' => 'Edit Category',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add New Category',
            'new_item_name' => 'New Category Name',
            'menu_name' => 'Categories',
        ),
        'hierarchical' => true,
        'public' => true,
    );
    register_taxonomy('book_category', 'book', $args);

    // Book Tag (Non-Hierarchical)
    $args = array(
        'labels' => array(
            'name' => 'Book Tags',
            'singular_name' => 'Book Tag',
            'search_items' => 'Search Tags',
            'all_items' => 'All Tags',
            'edit_item' => 'Edit Tag',
            'update_item' => 'Update Tag',
            'add_new_item' => 'Add New Tag',
            'new_item_name' => 'New Tag Name',
            'menu_name' => 'Tags',
        ),
        'hierarchical' => false,
        'public' => true,
    );
    register_taxonomy('book_tag', 'book', $args);
}
add_action('init', 'wp_book_register_taxonomies');
