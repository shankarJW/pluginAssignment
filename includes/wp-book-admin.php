<?php 

function wp_book_add_settings_page() {
    add_menu_page(
        'Book Settings',
        'Book Settings',
        'manage_options',
        'wp-book-settings',
        'wp_book_settings_page_html'
    );
}
add_action('admin_menu', 'wp_book_add_settings_page');

function wp_book_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>Book Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('wp_book_settings');
            do_settings_sections('wp-book-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function wp_book_register_settings() {
    register_setting('wp_book_settings', 'wp_book_currency');
    register_setting('wp_book_settings', 'wp_book_books_per_page');

    add_settings_section(
        'wp_book_settings_section',
        'General Settings',
        null,
        'wp-book-settings'
    );

    add_settings_field(
        'wp_book_currency',
        'Currency',
        'wp_book_currency_field_html',
        'wp-book-settings',
        'wp_book_settings_section'
    );

    add_settings_field(
        'wp_book_books_per_page',
        'Books Per Page',
        'wp_book_books_per_page_field_html',
        'wp-book-settings',
        'wp_book_settings_section'
    );
}
add_action('admin_init', 'wp_book_register_settings');

function wp_book_currency_field_html() {
    $value = get_option('wp_book_currency', 'USD');
    echo '<input type="text" name="wp_book_currency" value="' . esc_attr($value) . '" />';
}

function wp_book_books_per_page_field_html() {
    $value = get_option('wp_book_books_per_page', 10);
    echo '<input type="number" name="wp_book_books_per_page" value="' . esc_attr($value) . '" />';
}
