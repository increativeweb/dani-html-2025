<?php
/**
 * Block - Go for It
 *
 * @package WP-rock
 * @since   4.4.0
 */

// Get block HTML attributes: ID, class list, disabled status, and all ACF fields
/** @var array $args Passed block arguments from ACF render_template */
$attrs = WP_Rock_Blocks::prepare_attrs($args);

// Get all ACF fields associated with this block
$block_fields = $attrs['block_fields'];

// Define individual ACF fields for use in the template
$title = get_field_value($block_fields, 'title');
$sub_title = get_field_value($block_fields, 'sub_title');
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
    <div class="container">
        <div class="block-go__wrap">
            <?php if ($title) { ?>
                <h2 class="block-go__title"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            
            <?php if ($sub_title) { ?>
                <div class="block-go__subtitle"><?php echo esc_html($sub_title); ?></div>
            <?php } ?>
            <div class="block-go__can"></div>
        </div>
    </div>
</section>
        