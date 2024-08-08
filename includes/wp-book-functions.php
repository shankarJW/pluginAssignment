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


