<?php
/**
 * Block - Posts
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
$posts = get_field_value($block_fields, 'posts');
$button = get_field_value($block_fields, 'button');
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
    <div class="block-posts__wrap">
        <?php if ($title) { ?>
            <h2 class="block-posts__title"><?php echo esc_html($title); ?></h2>
        <?php } ?>

        <?php if ($posts) { ?>
            <div class="block-posts__carousel-wrap">
                <div class="swiper block-posts__carousel overflow-visible js--carousel">
                    <div class="swiper-wrapper">
                        <?php foreach ($posts as $item) : ?>
                            <div class="swiper-slide block-posts__item">
                                <div class="block-posts__item-tag">
                                    <?php if ($item['topic']) : ?>
                                        <?php echo esc_html($item['topic']); ?>
                                    <?php endif; ?>
                                </div>
                                <?php if ($item['image']) : ?>
                                    <figure class="block-posts__item-figure">
                                        <?php echo wp_get_attachment_image($item['image'], 'large', false, ['class' => 'block-posts__item-img']); ?>
                                    </figure>
                                <?php endif; ?>
                                <div class="block-posts__item-content">
                                    <div class="block-posts__item-meta">
                                        <?php if ($item['date']) : ?>
                                            <span class="block-posts__item-date"><?php echo esc_html($item['date']); ?></span>
                                            <?php echo ' | '; ?>
                                        <?php endif; ?>
                                        <?php if ($item['time']) : ?>
                                            <span class="block-posts__item-time"><?php echo esc_html($item['time']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="block-posts__item-header">
                                        <h3 class="block-posts__item-title"><?php echo esc_html($item['title']); ?></h3>
                                        <p class="block-posts__item-excerpt"><?php echo esc_html($item['excerpt']); ?></p>
                                    </div>
                                    <?php if ($item['link']) : ?>
                                        <a class="block-posts__item-link" href="<?php echo esc_url($item['link']); ?>">
                                            <?php esc_html_e('Read more', 'wp-rock'); ?> 
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination d-xl-none"></div>
                </div>

                <div class="block-posts__navigation d-none d-xl-flex">
                    <div class="block-posts__slider">
                        <div class="block-posts__progress"></div>
                        <div class="block-posts__handle"></div>
                    </div>                    
                </div>
            </div>
        <?php } ?>

        <?php if ($button):?>
            <div class="block-posts__button text-center">
                <a class="btn btn-secondary_black" href="<?php echo esc_url($button['url']); ?>"
                   target="<?php echo esc_attr($button['target']); ?>"><?php echo esc_html($button['title']); ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>
