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
$info_title = get_field_value($block_fields, 'info_title');
$info_image_desk = get_field_value($block_fields, 'info_image');
$info_image_mob = get_field_value($block_fields, 'info_image_mob');
$logos_title = get_field_value($block_fields, 'logos_title');
$logos = get_field_value($block_fields, 'logos');
$form_code = get_field_value($block_fields, 'form_code');
?>


<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
    <div class="container">
        <div class="block-secure__content">
            <div class="block-secure__info">
                <?php if ($info_title) { ?>
                    <h2 class="block-secure__info-title"><?php echo esc_html($info_title); ?></h2>
                <?php } ?>

                <div class="block-secure__info-figure">
                    <?php echo wp_get_attachment_image( $info_image_desk, 'full', false, array('class' => 'block-secure__info-image-d') ); ?>
                    <?php echo wp_get_attachment_image( $info_image_mob, 'full', false, array('class' => 'block-secure__info-image-m') ); ?>
                </div>
            </div>

            <div class="block-secure__logos">
                <?php if ( $logos_title ) { ?>
                    <h2 class="block-secure__logos-title"><?php echo esc_html($logos_title); ?></h2>
                <?php } ?>
                <?php if ( $logos ) { ?>
                    <div class="block-secure__logos-wrap">
                        <?php foreach ( $logos as $item ) {
                            $logo = get_field_value( $item, 'logo' );
                            $link = get_field_value( $item, 'link' );
                            if ( $logo && $link ) {
                                ?>
                                <a href="<?php echo esc_url( $link ); ?>" class="block-secure__logo-link" target="_blank" rel="noopener">
                                    <?php echo wp_get_attachment_image( $logo, 'medium', false ); ?>
                                </a>
                                <?php
                            }
                        } ?>
                    </div>
                <?php } ?>
                <div class="block-secure__logos-form">
                    <?php echo do_shortcode( $form_code ) ?>
                </div>
            </div>
        </div>
    </div>
</section>
