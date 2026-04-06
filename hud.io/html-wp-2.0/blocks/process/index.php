<?php
/**
 * Process Media Block Template.
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
	echo '<img src="' . get_template_directory_uri() . '/blocks/process/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'title_group' );
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
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section scroll-content-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>       
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
	<?php if ( ! empty( $group_process_details ) ) : ?>
		<div class="scroll-content-blocks">
			<div class="content-block">
				<?php 
					foreach ($group_process_details as $index => $item):
				?>
					<div class="scroll-content <?php echo $index == 0 ? 'active' : ''; ?>" id="scrollContent<?php echo $index; ?>">
						<div class="section-title">
							<?php 
								if(!empty($item['title'])) {
									echo '<h3>'.$item['title'].'</h3>';
								}
								if(!empty($item['sort_info'])) {
									echo '<div class="sort-info">'.$item['sort_info'].'</div>';
								}
								if(!empty($item['link_cta_group'])) {
									echo '<div class="action">' . acfield_btn_group($item['link_cta_group']) . '</div>';
								}
							?>
						</div>
					</div>
				<?php 
					endforeach;
				?>
			</div>
			<div class="content-media-block">
				<?php 
					foreach ($group_process_details as $index => $item_media):
						$media_video_image = $item_media['media_video_image']
				?>
					<div class="content-media <?php echo $index == 0 ? 'active' : ''; ?>" data-id="scrollContent<?php echo $index; ?>">
						<?php 
							echo '<div class="section-title d-block d-lg-none">';
								if(!empty($item_media['title'])) {
									echo '<h3>'.$item_media['title'].'</h3>';
								}
								if(!empty($item_media['sort_info'])) {
									echo '<div class="sort-info">'.$item_media['sort_info'].'</div>';
								}
								if(!empty($item_media['link_cta_group'])) {
									echo '<div class="action">' . acfield_btn_group($item_media['link_cta_group']) . '</div>';
								}
							echo '</div>';
						?>
						<div class="content-media-items">
								<?php 
									if(!empty($media_video_image)) {
										$video_url = $media_video_image['video_url'];
										$image_id = $media_video_image['image'];

										$alt = esc_attr($item_media['title'] ? $item_media['title'] : '');

										$media_src = '';
										if(!empty($image_id)) {
											$image_src = wp_get_attachment_image_src($image_id, 'full');
											$media_src = $image_src[0];
										}
										if(	!empty($video_url)) {
											echo '<div class="media-block"><video autoplay muted loop playsinline poster="'.$media_src.'" controlsList="nodownload" oncontextmenu="return false;"><source src="'.$video_url.'" type="video/mp4"></video></div>';
										} elseif(!empty($image_id)) {
											echo '<div class="media-block ratio ratio-4x3"><img src="'.$media_src.'" alt="'.esc_attr($alt).'"></div>';
										}
									}
								?>
						</div>
					</div>
				<?php 
				endforeach;
			?>
			</div>
		</div>
	<?php endif; ?>  
</div>
<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>