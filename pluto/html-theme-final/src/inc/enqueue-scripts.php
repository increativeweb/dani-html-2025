<?php
/**
 * Connecting scripts to site
 *
 * @package WP-rock
 */

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function px_site_scripts()
{
    $general_style_ver = gmdate('ymd-Gis', filemtime(STYLE_DIR . '/style.css'));
    $custom_style_ver = gmdate('ymd-Gis', filemtime(STYLE_DIR . '/assets/public/css/frontend.css'));
    $custom_js_ver = gmdate('ymd-Gis', filemtime(STYLE_DIR . '/assets/public/js/frontend.js'));

    // Load our main stylesheet.
    wp_enqueue_style('wp-rock-style', STYLE_URI, $general_style_ver);

    wp_enqueue_style('wp-rock_style', ASSETS_CSS . 'frontend.css', array(), $custom_style_ver);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_404()) {
        $page_404_style_file = THEME_DIR . '/assets/public/css/404.css';
        if (file_exists($page_404_style_file) && file_get_contents($page_404_style_file)) {
            wp_enqueue_style('page_404', ASSETS_CSS . '404.css', array(), null);
        }
    }

    wp_enqueue_script('frontend_js', ASSETS_JS . 'frontend.js', array('jquery'), $custom_js_ver, true);

    $vars = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'theme_path' => get_stylesheet_directory_uri(),
        'site_url' => get_site_url(),
    );

    wp_localize_script('frontend_js', 'var_from_php', $vars);

    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);

    wp_enqueue_style( 'icw-main', ICWCSS . 'main.css' );
    wp_enqueue_script( 'icw-main', ICWJS . 'main.js', array( 'jquery' ), false, true );

    // ICW
    if ( is_singular() || is_author() || ( is_home() && ! is_front_page() ) || is_archive() || is_search() ) {
        wp_enqueue_style( 'icw-blog', ICWCSS . 'blog.css', array(), null );
        wp_enqueue_script( 'post-single', ICWJS . 'post-single.js', array( 'jquery' ), false, true );
    }

}


add_action('wp_enqueue_scripts', 'px_site_scripts');


add_action(
    'admin_enqueue_scripts',
    function () {
        wp_enqueue_style('wp-rock_style_admin', ASSETS_CSS . 'backend.css', array(), '1.2.0');

        wp_enqueue_script(
            'backend_js',
            ASSETS_JS . 'backend.js',
            array('jquery'),
            '1.2.0',
            true
        );
    },
    99
);

function enqueue_swiper_styles()
{
    wp_enqueue_style('swiper_css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), null);
    wp_style_add_data('swiper_css', 'async', true);
}