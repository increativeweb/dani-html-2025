<?php
/**
 * Initial setup actions for the site.
 *
 * @package WP-rock
 */

// Initialize global variable for theme options.
global $global_options;

if (empty($global_options)) {
    $global_options = get_theme_general_settings();
}

/**
 * Retrieve theme general settings with caching.
 *
 * @return array The theme options as an associative array.
 */
function get_theme_general_settings(): array {
    global $global_options;

    if (!empty($global_options)) {
        return $global_options;
    }

    $cache_key = 'theme_general_settings';
    $cached_settings = get_transient($cache_key);

    if ($cached_settings !== false) {
        $global_options = $cached_settings;
        return $global_options;
    }

    if (function_exists('get_fields')) {
        $global_options = get_fields('theme-general-settings') ?: [];
        set_transient($cache_key, $global_options, WEEK_IN_SECONDS);
    } else {
        $global_options = [];
    }

    return $global_options;
}

/**
 * Update theme general settings cache when options are saved.
 *
 * @param string $post_id The ID of the saved post.
 */
function update_theme_general_settings_cache(string $post_id): void {
    if ($post_id === 'theme-general-settings') {
        global $global_options;
        delete_transient('theme_general_settings');
        $global_options = get_theme_general_settings();
    }
}
add_action('acf/save_post', 'update_theme_general_settings_cache');


/**
 * Initialize the theme's core functionality.
 */
$wp_rock = new WP_Rock();
add_action('after_setup_theme', array($wp_rock, 'px_site_setup'));


/**
 * Sanitize uploaded file name.
 */
add_filter('sanitize_file_name', array($wp_rock, 'custom_sanitize_file_name'), 10, 1);


/**
 * Set custom file upload size limit (in MB).
 */
$wp_rock->px_custom_upload_size_limit(5);


/**
 * Get a specific field value from a dataset or return a default value.
 *
 * @param array  $data     The dataset to check.
 * @param string $key      The key to retrieve.
 * @param mixed  $default  The default value to return if key is not found.
 * @return mixed|null      The field value or the default.
 */
function get_field_value(array $data, string $key, $default = null) {
    return isset($data[$key]) ? $data[$key] : $default;
}
