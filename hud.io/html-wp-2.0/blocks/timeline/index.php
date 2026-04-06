<?php
/**
 * Timeline Block Template.
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
	echo '<img src="' . get_template_directory_uri() . '/blocks/timeline/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'title_group' );
$group_timeline_details = get_field( 'timeline_details' );

$gs_setting            = get_field( 'section_setting' );

$gs_class  = '';
$gs_anchor = '';
$gs_style  = '';
$gs_css    = '';
if ( ! empty( $gs_setting ) ) {
	$settings  = icw_gs_setting( $gs_setting );
	$gs_anchor = $settings['gs_anchor'];
	$gs_style  = $settings['gs_style'];
	$gs_class  = $settings['gs_class'];
	$gs_css    = $settings['gs_css'];
	$gs_public = $settings['gs_public'];
}
if ( ! empty( $gs_public ) && $gs_public == 'hide' ) {
	return;
}

$data_theme = '';
if (strpos($gs_class, 'is-dark') !== false) {
    $data_theme = 'data-theme="dark"';
} elseif (strpos($gs_class, 'is-light') !== false) {
    $data_theme = 'data-theme="light"';
}
?>
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section history-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>       
<div class="container">
	<?php
		if(!empty($group_title_info) && !empty($group_title_info['title'])) {
			$title_align    = isset($group_title_info['title_align_style']) ? $group_title_info['title_align_style'] : '';
			$tagline        = isset($group_title_info['tagline']) ? $group_title_info['tagline'] : '';
			$title          = isset($group_title_info['title']) ? $group_title_info['title'] : '';
			$info           = isset($group_title_info['info']) ? $group_title_info['info'] : '';
			$link           = isset($group_title_info['cta_group']) ? $group_title_info['cta_group'] : '';

			$title_tag   = isset($group_title_info['title_tag']) ? $group_title_info['title_tag'] : 'h2';
			$title_class = isset($group_title_info['title_class']) ? $group_title_info['title_class'] : '';

			$h_title_class = '';
			if(!empty($title_class)) {
				$h_title_class = $title_class;
			}
			$s_title_class = '';
			if(!empty($title_align)) {
				$s_title_class = $title_align;
			}
				echo '<div class="section-title '.$s_title_class.'">';
				if(!empty($tagline)) {
					echo '<div class="tag-line">'.$tagline.'</div>';
				}
				if(!empty($title)) {
					echo '<'.$title_tag.' class="title '.$h_title_class.'">'.$title.'</'.$title_tag.'>';
				}
				if(!empty($info)) {
					echo '<div class="sort-info">'.$info.'</div>';
				}
				if(!empty($link['btn'])) {
					echo '<div class="action">' . acfield_btn_group($link) . '</div>';
				}
				echo '</div>';
			}
		?>
	<?php if ( ! empty( $group_timeline_details ) ) : 
			$is_slide_show_desktop = get_field( 'is_slide_show_desktop' );
			$desktop_no = $is_slide_show_desktop ? $is_slide_show_desktop : '7';
		?>
		<div class="splide splide-js history-slider" data-desktop-perpage="<?php echo esc_attr( $desktop_no ); ?>">
			<div class="splide__track">
				<ul class="splide__list">
					<?php 
					foreach ($group_timeline_details as $index => $item):
					?>
					<li class="splide__slide">
						<div class="history-card <?php echo $item['is_current'] ? 'is-current' : ''; ?>">
							<?php 
								if(!empty($item['label'])) {
									echo '<span class="history-year">'.$item['label'].'</span>';
								}
								echo '<div class="history-info">';
									if(!empty($item['logo'])) {
										echo '<div class="logo-img">'.wp_get_attachment_image( $item['logo'], 'thumbnail' ).'</div>';
									}
									if(!empty($item['title'])) {
										echo '<div class="info">'.$item['title'].'</div>';
									}
								echo '</div>';
							?>
						</div>
					</li>
					<?php 
					endforeach;
					?>
				</ul>
			</div>
		</div>
	<?php endif; ?>  
</div>
<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>