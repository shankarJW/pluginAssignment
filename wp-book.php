<?php
/*
Plugin Name: WP Book
Description: A plugin to manage and display books with custom post types, taxonomies, and metadata.
Version: 1.0
Author: shankar
*/

include_once(plugin_dir_path(__FILE__) . 'includes/wp-book-functions.php');

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'wp_book_activate');
register_deactivation_hook(__FILE__, 'wp_book_deactivate');

function wp_book_activate() {
    // Activation code here
}

function wp_book_deactivate() {
    // Deactivation code here
}