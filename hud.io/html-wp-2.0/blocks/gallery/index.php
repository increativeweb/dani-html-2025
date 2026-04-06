<?php
/**
 * Gallery Block Template.
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
	echo '<img src="' . get_template_directory_uri() . '/blocks/gallery/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'title_group' );
$group_gallery         = get_field( 'gallery' );

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
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section gallery-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>       
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
</div>
<?php 
	// pr($group_gallery);
	if ( ! empty( $group_gallery ) ) : 
		$gallery_lightbox      = get_field( 'gallery_lightbox' );
		$gallery_autoscroll    = get_field( 'gallery_autoscroll' );

		$autoscroll = '';
		if(!empty($gallery_autoscroll)){
			$autoscroll    = 'data-gallery-autoscroll="' . esc_attr($gallery_autoscroll) . '"';
		}
		echo '<div class="gallery-slider-block"><div class="splide splide-js gallery-slider" ' . $autoscroll . '><div class="splide__track"><ul class="splide__list">';
			foreach ($group_gallery as $index => $img_id):
				echo '<li class="splide__slide">';
						if($gallery_lightbox == 'yes') {
							echo '<a href="'.wp_get_attachment_image_url( $img_id, 'full' ).'" class="media-block glightbox">';
						} else {
							echo '<div class="media-block">';
						}
						echo icw_get_image_with_alt(
                                        $img_id,
                                        'large',
                                        null,
                                        [
											// 'src' => lazyloading,
											'data-splide-lazy' => wp_get_attachment_image_url( $img_id, 'large' ),
											'loading'          => false,
                                        ]
                                    ).'<span class="splide__spinner" role="presentation"></span>';
						if($gallery_lightbox == 'yes') {
							echo '</a>';
						} else {	
							echo '</div>';
						}
				echo '</li>';
			endforeach;
		echo '</ul></div></div></div>';
	endif;
?>	
<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>