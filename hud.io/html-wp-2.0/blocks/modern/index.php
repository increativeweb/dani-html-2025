<?php
/**
 * Modern Media Block Template.
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
	echo '<img src="' . get_template_directory_uri() . '/blocks/modern/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      	= get_field( 'title_group' );
$group_card_details 	= get_field( 'card_details' );

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
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section morden-card-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>       
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
	<?php if ( ! empty( $group_card_details ) ) : ?>
	<div class="morden-card-blocks">
		<div class="row">
			<?php 
			$morden_card_bg = array('br-bg-card', 'br-bg-card', 'center-bg-card', 'center-bg-card');
			$index = 0;
			$arrow_index = 0;
			foreach ($group_card_details as $key => $item) {
				// Example values (You can replace with your dynamic logic)
				$col_view       = $item['col_view'] ?? 12;      // lg-6 or 12
				$media_position = $item['media_position'] ?? ''; // left or right

				$morden_card_class = '';

				// Rotate background classes
				$morden_card_class .= ' ' . $morden_card_bg[$index % count($morden_card_bg)];

				if($col_view == 'lg-6') {
					$morden_card_class .= ' flex-lg-column';
				} else {
					$morden_card_class .= ' flex-lg-row';
				}
				if($media_position == 'mf' && $col_view == 'lg-6') { 
					$morden_card_class .= ' flex-lg-column-reverse';
				} elseif($media_position == 'mf' && $col_view == '12') {
					$morden_card_class .= ' flex-lg-row-reverse';
				}	
				?>
				<div class="position-relative col-<?php echo $col_view; ?> scroll-animate">
					<div class="morden-card is-modern-card-<?php echo $key; ?> <?php echo esc_attr($morden_card_class); ?>">
						<div class="card-content">
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
						<?php 
						if (strpos($gs_class, 'with-arrow-line') !== false) {
						 if($col_view == 'lg-6' && $arrow_index % 2 == 0) { ?>
							<div class="arrow-line"><svg width="396" height="448" viewBox="0 0 396 448" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M396 6L386 0.226637L386 11.7736L396 6ZM1 446C0.447715 446 0 446.448 0 447C0 447.552 0.447715 448 1 448L1 447V446ZM338.672 6.0008L338.672 7.0008L387 7.00013L387 6.00013L387 5.00013L338.672 5.0008L338.672 6.0008ZM278.672 447V446L1 446V447L1 448L278.672 448V447ZM308.672 36.0008H307.672L307.672 417H308.672H309.672L309.672 36.0008H308.672ZM278.672 447V448C295.793 448 309.672 434.121 309.672 417H308.672H307.672C307.672 433.016 294.688 446 278.672 446V447ZM338.672 6.0008L338.672 5.0008C321.551 5.00104 307.672 18.8801 307.672 36.0008H308.672H309.672C309.672 19.9847 322.655 7.00102 338.672 7.0008L338.672 6.0008Z" fill="url(#paint0_linear_680_6647)"/><defs><linearGradient id="paint0_linear_680_6647" x1="100.885" y1="-148.35" x2="490.532" y2="294.524" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="0.358867" stop-color="#F9BAF9"/><stop offset="1" stop-color="#9470FD"/></linearGradient></defs></svg></div>
						<?php 
						$arrow_index++;
					} 
					} ?>
						<div class="card-image">
							<?php 
									if(!empty($item['media_video_image'])) {
										$video_url = $item['media_video_image']['video_url'];
										$image_id = $item['media_video_image']['image'];

										$alt = esc_attr($item['title']);

										$media_src = '';
										if(!empty($image_id)) {
											$image_src = wp_get_attachment_image_src($image_id, 'full');
											$media_src = $image_src[0];
										}
										if(	!empty($video_url)) {
											echo '<div class="media-block"><video autoplay muted loop playsinline poster="'.$media_src.'" controlsList="nodownload" oncontextmenu="return false;"><source src="'.$video_url.'" type="video/mp4"></video></div>';
										} elseif(!empty($image_id)) {
											echo '<img src="'.$media_src.'" alt="'.esc_attr($alt).'">';
										}
									}
								?>
							</div>
					</div>
				</div>
				<?php
				$index++;
			} ?>
		</div>
	</div>
	<?php endif; ?>  
</div>
<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>