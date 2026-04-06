<?php
/**
 * Content Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */
// $block_data = $block['data'];
if ( ! empty( $block['data']['icw_preview'] ) ) {
	echo '<img src="' . get_template_directory_uri() . '/blocks/contentblock/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

if ( ! is_admin() ) {
	$icwlazy = 'class="icw-lazy" src="' . esc_url( lazyloading ) . '" data-';
	$icwlazy_view = '';
} else {
	$icwlazy = '';
	$icwlazy_view = ' is-visible is-complete';
}

/**
 * -------------------------------------------------
 * 1. GET & NORMALIZE ACF FIELDS
 * -------------------------------------------------
 */
$gs_setting         = get_field('section_setting') ?: [];
$title_group        = get_field('title_group') ?: [];
$content_left_bot   = get_field('content_left_bottom');
$content_right      = get_field('content_right');
$content_right_html = get_field('content_right_html');
$content_img        = get_field('content_img');
$section_align      = get_field('section_align') ?: '';
$size_col           = get_field('section_size_col') ?: 'default';
$is_sticky          = get_field('is_section_sticky');
$column_align       = get_field('column_align');
$order_mobile       = get_field('column_order_mobile') ?: 'auto';

/**
 * -------------------------------------------------
 * 2. SECTION SETTINGS (ANCHOR / CLASS / STYLE)
 * -------------------------------------------------
 */
$gs_anchor = $gs_style = $gs_class = $gs_css = '';
$gs_public = '';

if ($gs_setting) {
    $settings  = icw_gs_setting($gs_setting);
    $gs_anchor = isset($settings['gs_anchor']) ? $settings['gs_anchor'] : '';
    $gs_style  = isset($settings['gs_style']) ? $settings['gs_style'] : '';
    $gs_class  = isset($settings['gs_class']) ? $settings['gs_class'] : '';
    $gs_css    = isset($settings['gs_css']) ? $settings['gs_css'] : '';
    $gs_public = isset($settings['gs_public']) ? $settings['gs_public'] : '';
}

if ($gs_public === 'hide') {
    return;
}

/**
 * -------------------------------------------------
 * 3. COLUMN SIZE MAP
 * -------------------------------------------------
 */
$col_map = [
    'cal48'   => [4, 8],
    'cal57'   => [5, 7],
    'cal75'   => [7, 5],
    'cal84'   => [8, 4],
    'default' => [6, 6],
];

$col_pair = isset($col_map[$size_col]) ? $col_map[$size_col] : $col_map['default'];
$col_lg_l = $col_pair[0];
$col_lg_r = $col_pair[1];

/**
 * -------------------------------------------------
 * 4. BASE COLUMN CLASSES
 * -------------------------------------------------
 */
$col_l = 'col-img col-md-6 col-lg-' . $col_lg_l;
$col_r = 'col-info col-md-6 col-lg-' . $col_lg_r;
$row_classes = [];

/**
 * -------------------------------------------------
 * 5. ALIGNMENT & ORDER LOGIC
 * -------------------------------------------------
 */
switch ($section_align) {

    case 'imgright':
        $col_l .= ($order_mobile === 'reverse') ? ' order-1 order-md-2' : ' order-2';
        $col_r .= ($order_mobile === 'reverse') ? ' order-2 order-md-1' : ' order-1';
        break;

    case 'imgleft':
        $col_l .= ($order_mobile === 'reverse') ? ' order-2 order-md-1' : ' order-1';
        $col_r .= ($order_mobile === 'reverse') ? ' order-1 order-md-2' : ' order-2';
        break;

    case 'full':
        $col_l = 'col-12 order-2';
        $col_r = 'col-12 order-1';
        if ($order_mobile === 'reverse') {
            $col_l .= ' order-md-2';
            $col_r .= ' order-md-1';
        }
        break;

    case 'titleleft':
        $col_l .= ' col-content-sticky';
        break;
}

/**
 * -------------------------------------------------
 * 6. STICKY & ROW ALIGNMENT
 * -------------------------------------------------
 */
if ($is_sticky) {
    $gs_class .= ' image-content-fixed';
    $col_l    .= ' card-image-sticky';
} elseif ($content_img) {
    $row_classes[] = 'align-items-center';
}

if ($column_align) {
    $row_classes[] = $column_align;
}

/**
 * -------------------------------------------------
 * 7. THEME DETECTION (LIGHT / DARK)
 * -------------------------------------------------
 */
$data_theme = '';
if (strpos($gs_class, 'is-dark') !== false) {
    $data_theme = 'data-theme="dark"';
} elseif (strpos($gs_class, 'is-light') !== false) {
    $data_theme = 'data-theme="light"';
}

/**
 * -------------------------------------------------
 * 8. TITLE DATA
 * -------------------------------------------------
 */
$title_align = isset($title_group['title_align_style']) ? $title_group['title_align_style'] : '';
$title       = isset($title_group['title']) ? $title_group['title'] : '';
$tagline     = isset($title_group['tagline']) ? $title_group['tagline'] : '';
$info        = isset($title_group['info']) ? $title_group['info'] : '';
$cta         = isset($title_group['cta_group']) ? $title_group['cta_group'] : '';
$title_tag   = isset($title_group['title_tag']) ? $title_group['title_tag'] : 'h2';
$title_class = isset($title_group['title_class']) ? $title_group['title_class'] : '';

?>
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section content-section <?php echo esc_attr($gs_class); ?>" <?php echo $gs_style; ?>>
    <div class="container">
        <div class="row g-4 gx-35 row-gap <?php echo esc_attr(implode(' ', $row_classes)); ?>">

            <!-- LEFT COLUMN -->
            <div class="<?php echo esc_attr($col_l); ?>">

                <?php if ($section_align === 'titleleft' && $title) : ?>
                    <div class="section-title mb-4 <?php echo esc_attr($title_align); ?>">
                        <?php if ($tagline) : ?>
                            <div class="tag-line"><?php echo $tagline; ?></div>
                        <?php endif; ?>
                        <<?php echo esc_html($title_tag); ?> class="title <?php echo esc_attr($title_class); ?>">
                            <?php echo $title; ?>
                        </<?php echo esc_html($title_tag); ?>>
                    </div>
                <?php endif; ?>

                <?php if ($content_img) : ?>
                    <div class="media-block">
                        <?php echo wp_get_attachment_image($content_img, 'large'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($content_right) : ?>
                    <div class="content-info"><?php echo $content_right; ?></div>
                <?php endif; ?>

                <?php if ($content_right_html) : ?>
                    <div class="content-info"><?php echo $content_right_html; ?></div>
                <?php endif; ?>

            </div>

            <!-- RIGHT COLUMN -->
            <div class="<?php echo esc_attr($col_r); ?>">

                <?php if ($title || $info) : ?>
                    <div class="section-title <?php echo esc_attr($title_align); ?>">

                        <?php if ($title && $section_align !== 'titleleft') : ?>
                            <?php if ($tagline) : ?>
                                <div class="tag-line"><?php echo $tagline; ?></div>
                            <?php endif; ?>
                            <<?php echo esc_html($title_tag); ?> class="title <?php echo esc_attr($title_class); ?>">
                                <?php echo $title; ?>
                            </<?php echo esc_html($title_tag); ?>>
                        <?php endif; ?>

                        <?php if ($info) : ?>
                            <div class="sort-info"><?php echo $info; ?></div>
                        <?php endif; ?>

                        <?php if ($section_align === 'titleleft' && $content_right_html) : ?>
                            <div class="content-info"><?php echo $content_right_html; ?></div>
                        <?php endif; ?>

                        <?php if (!empty($cta['btn'])) : ?>
                            <div class="action"><?php echo acfield_btn_group($cta); ?></div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <?php if ($content_left_bot) : ?>
                    <div class="content-info"><?php echo $content_left_bot; ?></div>
                <?php endif; ?>

            </div>

        </div>
    </div>
    <?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>