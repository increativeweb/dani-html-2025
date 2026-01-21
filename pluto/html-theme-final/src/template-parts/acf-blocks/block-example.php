<?php
/**
 * Block - Example
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
$carousel = get_field_value($block_fields, 'carousel');
$cta = get_field_value($block_fields, 'cta');
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>

    <div class="container text-center h-100 d-flex flex-column">

        <?php if ($title) { ?>
            <h1 class="block-example__title h6 h4-md"><?php echo esc_html($title); ?></h1>
        <?php } ?>

        <?php if ($carousel) { ?>
            <div class="overflow-visible">
                <div class="swiper block-example__carousel overflow-visible mt-9 js--carousel">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($carousel as $item) : ?>
                            <div class="swiper-slide block-example__carousel-item">
                                <?php echo wp_get_attachment_image($item, 'large', false, ['class' => 'block-example__carousel-img']); ?>
                                <p class="block-example__carousel-item-title mb-0"><?php echo esc_html($title); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        if ($cta):
            $cta_url = $cta['url'];
            $cta_title = $cta['title'];
            $cta_target = $cta['target'] ?: '_self';
            ?>
            <div class="text-center">
                <a class="btn btn-secondary" href="<?php echo esc_url($cta_url); ?>"
                   target="<?php echo esc_attr($cta_target); ?>"><?php echo esc_html($cta_title); ?></a>
            </div>
        <?php endif; ?>
        
    </div>
</section>
        