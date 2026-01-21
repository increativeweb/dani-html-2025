<?php
/**
 * Block - Numbers
 *
 * @package WP-rock
 * @since   4.4.0
 */

// Get block HTML attributes: ID, class list, disabled status, and all ACF fields
/** @var array $args Passed block arguments from ACF render_template */
$attrs = WP_Rock_Blocks::prepare_attrs($args);

// Get all ACF fields associated with this block
$block_fields = $attrs['block_fields'];
$numbers = get_field_value($block_fields, 'numbers');
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
    <?php if ( $numbers ) : ?>
        <div class="block-numbers__wrap container">

            <div class="block-numbers__list">
                <?php foreach ( $numbers as $item ) : ?>
                    <?php
                    $number      = isset( $item['number'] ) ? (int) $item['number'] : 0;
                    $symbol      = isset( $item['symbol'] ) ? $item['symbol'] : '';
                    $description = isset( $item['description'] ) ? $item['description'] : '';
                    ?>
                    <div class="block-numbers__item">
                        <div class="block-numbers__value">
                            <span
                                class="block-numbers__number js-number-counter"
                                data-target="<?php echo esc_attr( $number ); ?>"
                            >
                                0
                            </span>
                            <?php if ( $symbol ) : ?>
                                <span class="block-numbers__symbol">
                                    <?php echo esc_html( $symbol ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ( $description ) : ?>
                            <p class="block-numbers__description">
                                <?php echo esc_html( $description ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
