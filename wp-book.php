<?php
/*
Plugin Name: WP Book
Description: A plugin to manage and display books with custom post types, taxonomies, and metadata.
Version: 1.0
Author: shankar
*/

include_once(plugin_dir_path(__FILE__) . 'includes/wp-book-functions.php');

register_activation_hook(__FILE__, 'wp_book_activate');
register_deactivation_hook(__FILE__, 'wp_book_deactivate');

function wp_book_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'book_meta';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        book_id bigint(20) NOT NULL,
        author_name varchar(255) DEFAULT '' NOT NULL,
        price decimal(10,2) DEFAULT '0.00' NOT NULL,
        PRIMARY KEY  (id),
        KEY book_id (book_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function wp_book_deactivate() {
    
}