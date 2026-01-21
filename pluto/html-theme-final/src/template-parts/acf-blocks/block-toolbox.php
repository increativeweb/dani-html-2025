<?php
/**
 * Block - Toolbox
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
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>

        <div class="block-toolbox__wrap">
            <?php if ($title) { ?>
                <h2 class="block-toolbox__title"><?php echo esc_html($title); ?></h2>
            <?php } ?>

            <?php if ($carousel) { ?>
                <div class="overflow-visible">
                    <div class="swiper block-toolbox__carousel overflow-visible js--carousel">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($carousel as $item) :
                                $soon_class = $item['soon'] ? ' block-toolbox--soon' : ''; ?>
                                <div class="swiper-slide block-toolbox__carousel-item<?php echo $soon_class; ?>">
                                    <div class="block-toolbox__carousel-item-container">
                                        <?php if($item['soon']) { ?>
                                            <div class="block-toolbox__carousel-item-elements">
                                                <div class="block-toolbox__carousel-item-elements-left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                      <circle cx="11.5269" cy="11.4448" r="9.79242" fill="black"/>
                                                      <circle cx="10.4204" cy="10.4204" r="9.92044" fill="#DCE6DE" stroke="black"/>
                                                      <path d="M16.8439 17.168L3.51328 3.83737" stroke="black"/>
                                                    </svg>
                                                </div>
                                                <div class="block-toolbox__carousel-item-elements-right">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                      <circle cx="11.5268" cy="11.4448" r="9.79242" fill="black"/>
                                                      <circle cx="10.4204" cy="10.4204" r="9.92044" fill="#DCE6DE" stroke="black"/>
                                                      <path d="M3.51562 17.168L16.8462 3.83737" stroke="black"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="block-toolbox__carousel-item-text"><?php echo esc_html($item['text']); ?></div>
                                        <?php } else { ?>
                                            <?php if($item['image']): ?>
                                                <div class="block-toolbox__carousel-img-area">
                                                    <div class="block-toolbox__carousel-img-top-area"></div>
                                                        <figure class="block-toolbox__carousel-img-wrapper">
                                                            <?php echo wp_get_attachment_image($item['image'], 'large', false, ['class' => 'block-toolbox__carousel-img']); ?>
                                                        </figure>
                                                    <div class="block-toolbox__carousel-img-bottom-area"></div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="block-toolbox__carousel-item-text"><?php echo esc_html($item['text']); ?></div>
                                            <?php
                                                if ($item['button']): ?>
                                                    <?php $button = $item['button']; ?>
                                                    <div class="block-toolbox__carousel-item-button text-center">
                                                        <a class="btn btn-secondary_black d-inline-flex" href="<?php echo esc_url($button['url']); ?>"
                                                        target="<?php echo esc_attr($button['target']); ?>"><?php echo esc_html($button['title']); ?></a>
                                                    </div>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
</section>
