<?php
/**
 * Scroll Content Block Template.
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
	echo '<img src="' . get_template_directory_uri() . '/blocks/scroll-content/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'group_title_title_group' );
$group_process_details = get_field( 'process_details' );

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
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section scroll-content-sticky-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>       
<div class="container">
	<div class="row g-4 gx-35 row-gap">
		<div class="col-title col-md-6 col-lg-6">
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
		</div>
		<div class="col-info col-md-6 col-lg-6">
			<div class="scroll-content">
				<div class="scroll-content-block">
					<h3>Hud runs with the entire codebase</h3>
					<div class="sort-info">
						Runs with the entire codebase in production, no configuration needed
					</div>
					<div class="media">
						<img src="http://hud.local/wp-content/uploads/2026/04/img-hud-sends-context-agents.png" alt="">
					</div>
				</div>

				<div class="scroll-content-block">
					<h3>Hud runs with the entire codebase</h3>
					<div class="sort-info">
						Runs with the entire codebase in production, no configuration needed
					</div>
					<div class="media">
						<img src="http://hud.local/wp-content/uploads/2026/04/img-hud-sends-context-agents.png" alt="">
					</div>
				</div>

				<div class="scroll-content-block">
					<h3>Hud runs with the entire codebase</h3>
					<div class="sort-info">
						Runs with the entire codebase in production, no configuration needed
					</div>
					<div class="media">
						<img src="http://hud.local/wp-content/uploads/2026/04/img-hud-sends-context-agents.png" alt="">
					</div>
				</div>
			</div>
		<?php if ( ! empty( $group_process_details ) ) : ?>
			<div class="scroll-content-blocks">
				<div class="content-block">
					<?php 
						foreach ($group_process_details as $index => $item):
					
						endforeach;
					?>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</div>  
</div>
<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>