<?php
/**
 * FAQ Block – Simplified & Dynamic
 */
if ( ! empty( $block['data']['icw_preview'] ) ) {
	echo '<img src="' . get_template_directory_uri() . '/blocks/faq/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'title_group' );
$group_faqs_setting    = get_field( 'faqs_setting' );
$group_faqs            = get_field( 'faqs' );

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

$col_tclass = 'col-md-6 col-lg-4';
$col_qclass = 'col-md-6 col-lg-7 offset-lg-1';
if(!empty($group_faqs_setting) && $group_faqs_setting == 'half') {
    $col_tclass = 'col-md-6 col-lg-5 col-xl-4';
    $col_qclass = 'col-md-6 col-lg-7 col-lg-7 offset-xl-1';
}
if(!empty($group_faqs_setting) && $group_faqs_setting == 'full') {
    $col_tclass = 'col-md-12 col-lg-12';
    $col_qclass = 'col-md-12 col-lg-12';
}
if(!empty($group_faqs_setting) && $group_faqs_setting == 'inner') {
    $col_tclass = 'col-md-10 col-lg-8';
    $col_qclass = 'col-md-10 col-lg-8';
}
?>
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section cta-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>> 
	<div class="container">
		<div class="row justify-content-center">
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
					echo '<div class="col-12 '.$col_tclass.'"><div class="section-title '.$s_title_class.'">';
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
					echo '</div></div>';
				}
			?>

			<?php 
			if(!empty($group_faqs)){
				echo '<div class="col-12 '.$col_qclass.'"><div class="collapse-block">';
				// $j = 1;
				foreach( $group_faqs as $faq ) {
					$question = $faq['question'];
					$answer = $faq['answer'] ?: '-';
					if(!empty($question)){
						
						// if($j == 1) {
						//     $isopen = 'is-open';
						//     $style = '';
						// } else {
							$isopen = '';
							$style = 'style="display: none;"';
						// }
						echo '<div class="collapse-item '.$isopen.'">
						<button type="button" class="collapse-title"><h3>'.$question.'</h3><span class="collapse-btn"></span></button>
						<div class="collapse-body" '.$style.'>
							<div class="card-content">'.wpautop( $answer ).'</div>
						</div>
					</div>';
					// $j++;
					}
				}
				echo '</div></div>';
			}
			?>
		</div>	
	</div>
	<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section> 