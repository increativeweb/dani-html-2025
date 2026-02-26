<?php
/**
 * Disable plugin update notifications for selected plugins.
 *
 * @package WP-rock
 */

// Register admin menu page for plugin update restriction.
add_action('admin_menu', function () {
    add_menu_page(
        'Plugin Update Restrictor',
        'Update Restrictor',
        'manage_options',
        'plugin-update-restrictor',
        'wp_rock_plugin_update_restrictor_page'
    );
});

/**
 * Render the plugin update restrictor admin page.
 *
 * @return void
 */
function wp_rock_plugin_update_restrictor_page() {
    $all_plugins = get_plugins();
    $saved = get_option('disabled_plugin_updates', []);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('plugin_update_restrictor_save')) {
        $saved = isset($_POST['disabled_plugins']) ? array_keys($_POST['disabled_plugins']) : [];
        update_option('disabled_plugin_updates', $saved);
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    echo '<div class="wrap">';
    echo '<h1>Disable Plugin Updates</h1>';
    echo '<form method="post">';
    wp_nonce_field('plugin_update_restrictor_save');

    echo '<table class="widefat"><thead><tr><th>Disable</th><th>Plugin</th></tr></thead><tbody>';
    foreach ($all_plugins as $plugin_file => $plugin_data) {
        $checked = in_array($plugin_file, $saved, true) ? 'checked' : '';
        echo '<tr>';
        echo '<td><input type="checkbox" name="disabled_plugins[' . esc_attr($plugin_file) . ']" ' . $checked . '></td>';
        echo '<td><strong>' . esc_html($plugin_data['Name']) . '</strong><br><code>' . esc_html($plugin_file) . '</code></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    echo '<br><input type="submit" class="button-primary" value="Save Changes">';
    echo '</form></div>';
}

/**
 * Filter plugin update transient to exclude selected plugins.
 *
 * @param object $value The site transient object for plugin updates.
 * @return object Modified transient object.
 */
add_filter('site_transient_update_plugins', function ($value) {
    $disabled = get_option('disabled_plugin_updates', []);
    if (isset($value) && is_object($value)) {
        foreach ($disabled as $plugin) {
            unset($value->response[$plugin]);
        }
    }
    return $value;
});

/**
 * Customize the plugin auto-update UI to indicate disabled plugins.
 *
 * @param string $html        The HTML content.
 * @param string $plugin_file The plugin file path.
 * @return string Modified HTML content.
 */
add_filter('plugin_auto_update_setting_html', function ($html, $plugin_file) {
    $disabled = get_option('disabled_plugin_updates', []);
    if (in_array($plugin_file, $disabled, true)) {
        $html = '<span style="color:red;">Auto-Updates DISABLED</span>';
    }
    return $html;
}, 10, 2);
