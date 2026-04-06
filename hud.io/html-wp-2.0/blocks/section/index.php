<?php
// ACF block render template

// $block_data = $block['data'];
if ( ! empty( $block['data']['icw_preview'] ) ) {
	echo '<img src="' . get_template_directory_uri() . '/blocks/section/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$gs_is_head_bottom	= get_field( 'is_section_head__bottom' );

$gs_head   	 	= get_field( 'section_title_title_group' );
$gs_bottom    	= get_field( 'section_title_bottom_title_group' );

$gs_setting 	= get_field( 'section_setting' );

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
$gs_data_theme = '';
if (strpos($gs_class, 'gs-is-dark') !== false) {
    $data_theme = 'data-theme="dark"';
	// $gs_data_theme = 'data-theme="light"';
} elseif (strpos($gs_class, 'gs-is-light') !== false) {
    $data_theme = 'data-theme="light"';
	// $gs_data_theme = 'data-theme="dark"';
}

?>
<div <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section icw-sections <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>
	<?php
		if (! empty( $gs_is_head_bottom ) && in_array( 'Head', $gs_is_head_bottom, true )) {
			$section_code_head = get_field( 'section_code_head' );
			if(!empty($section_code_head)) {
				echo $section_code_head;
			}

			if(!empty($gs_head) && !empty($gs_head['title'])) {
				$title_align    = isset($gs_head['title_align_style']) ? $gs_head['title_align_style'] : '';
				$tagline        = isset($gs_head['tagline']) ? $gs_head['tagline'] : '';
				$title          = isset($gs_head['title']) ? $gs_head['title'] : '';
				$info           = isset($gs_head['info']) ? $gs_head['info'] : '';
				$link           = isset($gs_head['cta_group']) ? $gs_head['cta_group'] : '';

				$title_tag   = isset($gs_head['title_tag']) ? $gs_head['title_tag'] : 'h2';
				$title_class = isset($gs_head['title_class']) ? $gs_head['title_class'] : '';

				$h_title_class = '';
				if(!empty($title_class)) {
					$h_title_class = $title_class;
				}
				$s_title_class = '';
				if(!empty($title_align)) {
					$s_title_class = $title_align;
				}

				$gs_head_class = get_field( 'head_section_text_color' );
				if(empty($gs_head_class)) {
					$gs_head_class = '';
				}

					echo '<section '.$gs_data_theme.' class="theme-section cta-section '.$gs_head_class.'"><div class="container"><div class="section-title mb-0 '.$s_title_class.'">';
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
					echo '</div></div></section>';
			}
		}
	?>
    <InnerBlocks />
	<?php
		if (! empty( $gs_is_head_bottom ) && in_array( 'Bottom', $gs_is_head_bottom, true ) ) {
			$section_code_bottom = get_field( 'section_code_bottom' );
			if(!empty($section_code_bottom)) {
				echo $section_code_bottom;
			}

			if(!empty($gs_bottom) && !empty($gs_bottom['title'])) {
				$title_align    = isset($gs_bottom['title_align_style']) ? $gs_bottom['title_align_style'] : '';
				$tagline        = isset($gs_bottom['tagline']) ? $gs_bottom['tagline'] : '';
				$title          = isset($gs_bottom['title']) ? $gs_bottom['title'] : '';
				$info           = isset($gs_bottom['info']) ? $gs_bottom['info'] : '';
				$link           = isset($gs_bottom['cta_group']) ? $gs_bottom['cta_group'] : '';

				$title_tag   = isset($gs_bottom['title_tag']) ? $gs_bottom['title_tag'] : 'h2';
				$title_class = isset($gs_bottom['title_class']) ? $gs_bottom['title_class'] : '';

				$h_title_class = '';
				if(!empty($title_class)) {
					$h_title_class = $title_class;
				}
				$s_title_class = '';
				if(!empty($title_align)) {
					$s_title_class = $title_align;
				}

				$gs_bottom_class = get_field( 'bottom_section_text_color' );
				if(empty($gs_bottom_class)) {
					$gs_bottom_class = '';
				}

					echo '<section '.$gs_data_theme.' class="theme-section cta-section '.$gs_bottom_class.'"><div class="container"><div class="section-title mb-0 '.$s_title_class.'">';
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
					echo '</div></div></section>';
			}
		}
	?>
	<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</div>
