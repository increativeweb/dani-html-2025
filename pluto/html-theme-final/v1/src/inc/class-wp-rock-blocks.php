<?php
/**
 * General class for the site.
 *
 * @package WP-rock
 */

/**
 * Disables the Quick Edit link in the post actions.
 *
 * This function removes the "Quick Edit" option from the list of actions available
 * in the WordPress post list table.
 *
 * @param array $actions An array of row action links for each post. Default empty.
 * @param WP_Post|null $post The post object. Default null.
 *
 * @return array Filtered array of row action links.
 */
function disable_quick_edit($actions = array(), $post = null)
{

    // Remove the Quick Edit link
    if (isset($actions['inline hide-if-no-js'])) {
        unset($actions['inline hide-if-no-js']);
    }

    // Return the set of links without Quick Edit
    return $actions;

}


add_filter('post_row_actions', 'disable_quick_edit', 10, 2);
add_filter('page_row_actions', 'disable_quick_edit', 10, 2);


/**
 *  Custom ACF Gutenberg blocks.
 *
 * @package WP-rock
 * @since 4.4.0
 */

/**
 * Registering ACF blocks.
 */
class WP_Rock_Blocks
{


    /**
     * Array with blocks defining.
     *
     * @var array[]
     */
    public array $blocks = array(

        // Standard WP Rock blocks
        'block-simple-content' => array(),
        'block-footer-cta' => array(),
        'block-quote' => array(),
        'block-toolbox' => array(),
        'block-posts' => array(),
        'block-posts' => array(),
        'block-hero' => array(),
        'block-numbers' => array(),
        'block-logos' => array(),
        'block-options' => array(),
        'block-go' => array(),
        'block-secure' => array(),
        'block-cards-slider' => array(),

        // CMS blocks
        'block-jay'            => [ 'category' => 'wp-icw-cms' ],
    );

    /**
     * List of Allowed blocks
     * core/freeform  - it's standard WYSIWYG.
     *
     * @var string[]
     */
    // protected array $allowed = array( 'core/freeform' );


    /**
     *  Construct of the class
     */
    public function __construct()
    {
        add_action('init', array($this, 'add_custom_blocks'));
        add_filter('allowed_block_types_all', array($this, 'filter_allowed_blocks'), 10, 2);
    }


    /**
     * Function for `allowed_block_types_all` filter-hook.
     *
     * @param bool|string[] $allowed_block_types Array of block type slugs, or boolean to enable/disable all.
     * @param WP_Block_Editor_Context $editor_context The current block editor context.
     *
     * @return bool|string[]
     */
    public function filter_allowed_blocks($allowed_block_types, $editor_context)
    {
        if (!empty($editor_context->post)) {
            $allowed = array_map(array($this, 'add_prefix'), array_keys($this->blocks));

            if (!empty($this->allowed)) {
                foreach ($this->allowed as $block) {
                    $allowed[] = $block;
                }
            }

            return $allowed;
        }

        return $allowed_block_types;

    }


    /**
     * Just adding prefix to blocks.
     *
     * @param string $value - name of block.
     * @return string
     */
    public function add_prefix($value)
    {
        return 'acf/' . $value;
    }

    /**
     * Adds a custom category "WP Rock" to the block editor categories.
     *
     * This function appends a new custom category, "WP Rock", to the list of
     * block categories in the WordPress block editor.
     *
     * @param array $categories Existing categories in the block editor.
     * @param WP_Post $post The current post object.
     *
     * @return array Modified array of block editor categories.
     */
    public function wp_rock_category($categories, $post): array
    {
        return array_merge(
            $categories,
            array(
                array(
                    'slug' => 'wp-rock',
                    'title' => 'WP Rock',
                    'icon' => 'wordpress-alt',
                ),
                array(
                    'slug' => 'wp-icw-cms',
                    'title' => 'InCreativeWeb CMS',
                    'icon' => 'wordpress-alt',
                ),
            )
        );
    }

    /**
     * Callback to render the block or its preview image.
     *
     * If a preview image is provided in the block data, it will be displayed.
     * Otherwise, the block's template is loaded.
     *
     * @param array $block The block settings and attributes.
     *
     * @return void
     */
    public function block_render($block)
    {
        // Show preview image in editor only (no DB calls)
        if (!empty($block['data']['is_example']) && is_admin()) {
            echo '<img src="' . esc_url($block['data']['preview_image']) . '" style="width: 468px;">';
            return;
        }

        // Get ACF fields only when really needed
        $block_fields = get_fields();

        // If disabled on frontend, do not render
        if (!is_admin() && get_field_value($block_fields, 'disabled')) {
            return;
        }

        // Load the template part
        $template = str_replace('.php', '', $block['render_template']);
        get_template_part('/' . $template, null, $block);
    }



    /**
     * Registers custom ACF blocks and adds a custom category to the WordPress block editor.
     *
     * This method dynamically registers custom ACF blocks based on the configuration in `$this->blocks`.
     * It also adds a custom block category "WP Rock" and includes additional features like preview images,
     * enqueueing custom scripts, and block-specific configurations.
     *
     * @return void
     */
    public function add_custom_blocks()
    {
        if (!function_exists('acf_register_block_type')) {
            return;
        }

        add_filter('block_categories_all', array($this, 'wp_rock_category'), 10, 2);

        // Optional: static cache to avoid repeated disk access
        static $script_cache = [];

        foreach ($this->blocks as $id => $block) {

            $category = $block['category'] ?? 'wp-rock';

            // 🔥 Template path switch
            $template_base = ( $category === 'wp-icw-cms' )
                ? 'src/template-parts/acf-icw-cms-blocks/'
                : 'src/template-parts/acf-blocks/';


            $title = ucwords( str_replace( [ 'block-', '-' ], [ '', ' ' ], $id ) );

            // $cleaned_id = str_replace('block-', '', $id);
            // $cleaned_title = str_replace('-', ' ', $cleaned_id);
            // $title = ($block['title'] ?? ucwords($cleaned_title));

            $args = array(
                'title' => __($title, 'wp-rock'),
                'name' => $id,
                'category'        => $category,
                'render_template' => $template_base . $id . '.php',
                'render_callback' => array($this, 'block_render'),
                // 'render_template' => 'src/template-parts/acf-blocks/' . $id . '.php',
                // 'category' => 'wp-rock',
                'post_types' => $block['post_types'] ?? array('page'),
                'mode' => $block['mode'] ?? 'preview',
                'supports' => array(
                    'align' => true,
                    'full_height' => true,
                    'anchor' => true,
                    'multiple' => $block['multiple'] ?? false,
                    'color' => array(
                        'gradients' => true,
                        'background' => true,
                    ),
                ),
                'example' => array(
                    'attributes' => array(
                        'mode' => 'preview',
                        'data' => array(
                            'is_example' => true,
                            'preview_image' => file_exists(THEME_DIR . '/src/images/acf-blocks/' . $id . '.jpg')
                                ? THEME_URI . '/src/images/acf-blocks/' . $id . '.jpg'
                                : THEME_URI . '/src/images/acf-blocks/no-preview.jpg',
                        ),
                    ),
                ),
            );

            if (isset($block['description'])) {
                $args['description'] = __($block['description'], 'wp-rock');
            }

            if (isset($block['enqueue_assets'])) {
                $args['enqueue_assets'] = $block['enqueue_assets'];
            }

            $script_file = THEME_DIR . '/assets/public/js/js-' . $id . '.js';

            // Avoid using file_get_contents — just check file exists once
            if (!isset($script_cache[$id])) {
                $script_cache[$id] = file_exists($script_file);
            }

            if ($script_cache[$id]) {
                $args['enqueue_script'] = ASSETS_JS . 'js-' . $id . '.js';
            }

            acf_register_block_type($args);
        }
    }


    /**
     * Prepare block wrapper attributes and field data.
     * Optimized version with caching to avoid repeated get_fields() calls for same block.
     *
     * @param array $args Block args passed to render_template.
     * @param array $extra_classes Optional extra class names.
     *
     * @return array {
     * @type string $id_attr
     * @type string $class_attr
     * @type string $disabled_attr
     * @type array $block_fields
     * }
     */
    public static function prepare_attrs(array $args, array $extra_classes = []): array
    {
        static $fields_cache = [];

        $is_admin = is_admin();
        $base_class = '';

        if (!empty($args['name'])) {
            $base_class = str_replace(['acf/', ' '], '', $args['name']);
        }

        // Build the final class list
        $classes = array_filter(array_merge(
            [$base_class],
            $extra_classes,
            isset($args['className']) ? explode(' ', trim($args['className'])) : [],
            $is_admin ? ['visible'] : []
        ));

        $id_attr = !empty($args['anchor']) ? ' id="' . esc_attr($args['anchor']) . '"' : '';
        $class_attr = 'class="' . esc_attr(implode(' ', $classes)) . '"';

        // Attempt to determine a unique block key to cache fields by
        $block_key = $args['id'] ?? ($args['anchor'] ?? uniqid('block'));

        if (isset($fields_cache[$block_key])) {
            $block_fields = $fields_cache[$block_key];
        } else {
            $block_fields = get_fields();
            $fields_cache[$block_key] = $block_fields;
        }

        $disabled = get_field_value($block_fields, 'disabled');

        return [
            'id_attr' => $id_attr,
            'class_attr' => $class_attr,
            'disabled_attr' => ($is_admin && $disabled) ? ' disabled="disabled"' : '',
            'block_fields' => $block_fields,
        ];
    }


}

new WP_Rock_Blocks();
