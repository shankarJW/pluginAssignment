<?php 

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



function wp_book_register_taxonomies() {
    
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


// Add Custom Meta Box
function wp_book_add_meta_box() {
    add_meta_box(
        'book_meta_box',        
        'Book Details',         
        'wp_book_meta_box_html', 
        'book'                  
    );
}
add_action('add_meta_boxes', 'wp_book_add_meta_box');

function wp_book_meta_box_html($post) {
    $author_name = get_post_meta($post->ID, '_author_name', true);
    $price = get_post_meta($post->ID, '_price', true);

    echo '<label for="author_name">Author Name:</label>';
    echo '<input type="text" id="author_name" name="author_name" value="' . esc_attr($author_name) . '" />';
    echo '<br><br>';
    echo '<label for="price">Price:</label>';
    echo '<input type="text" id="price" name="price" value="' . esc_attr($price) . '" />';
}

function wp_book_save_meta_box_data($post_id) {
    if (array_key_exists('author_name', $_POST)) {
        update_post_meta($post_id, '_author_name', sanitize_text_field($_POST['author_name']));
    }
    if (array_key_exists('price', $_POST)) {
        update_post_meta($post_id, '_price', sanitize_text_field($_POST['price']));
    }
}
add_action('save_post', 'wp_book_save_meta_box_data');

// Register Shortcode
function wp_book_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
        'author_name' => '',
        'year' => '',
        'category' => '',
        'tag' => '',
        'publisher' => ''
    ), $atts);

    $query_args = array(
        'post_type' => 'book',
        'posts_per_page' => -1
    );

    if ($atts['id']) {
        $query_args['p'] = $atts['id'];
    }
    if ($atts['author_name']) {
        $query_args['meta_query'][] = array(
            'key' => '_author_name',
            'value' => $atts['author_name'],
            'compare' => 'LIKE'
        );
    }
    if ($atts['year']) {
        $query_args['meta_query'][] = array(
            'key' => '_year',
            'value' => $atts['year'],
            'compare' => '='
        );
    }
    if ($atts['category']) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'book_category',
            'field' => 'slug',
            'terms' => $atts['category']
        );
    }
    if ($atts['tag']) {
        $query_args['tax_query'][] = array(
            'taxonomy' => 'book_tag',
            'field' => 'slug',
            'terms' => $atts['tag']
        );
    }
    if ($atts['publisher']) {
        $query_args['meta_query'][] = array(
            'key' => '_publisher',
            'value' => $atts['publisher'],
            'compare' => 'LIKE'
        );
    }

    $query = new WP_Query($query_args);

    $output = '<div class="book-list">';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= '<p>Author: ' . get_post_meta(get_the_ID(), '_author_name', true) . '</p>';
            // Add more details as needed
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No books found.</p>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('book', 'wp_book_shortcode');
