<?php
/**
 * Careers Block Template 
 */
if ( ! empty( $block['data']['icw_preview'] ) ) {
	echo '<img src="' . get_template_directory_uri() . '/blocks/careers/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'title_group' );
$bottom_content        = get_field( 'bottom_content' );

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
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section cta-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>> 
	<div class="container">
		<div class="job-content-block">
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
				echo '<div class="section-title mb-0 '.$s_title_class.'">';
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
		<?php 
			$args = array(
				'post_type'         => 'job',
				'posts_per_page'    => -1,
				'order'             => 'ASC',
				'orderby'           => 'menu_order',
				'post_status'       => 'publish',
				'has_password'      => false, // ✅ removes protected posts
			);  
			$jobs_array = get_posts($args);
			if(!empty($jobs_array)) {
				echo '<div class="job-card-block">';
				foreach ($jobs_array as $job) {
					$postID = $job->ID;
					$job_location       = get_field('job_location', $postID) ?? '';
					echo '<a href="'.get_permalink($postID).'" class="job-card"><div class="card-body">';
						if(!empty($job_location)){
							echo '<div class="location"><span class="icon-location"></span>'.$job_location.'</div>';
						}
						echo '<h3>'.get_the_title($postID).'</h3>';
						echo '</div>';
						echo '<div class="card-footer"><span class="btn btn-link-arrow">View details<span class="icon-arrow"></span></span></div>';
						echo '</a>';
					}
				echo '</div>';
				} else {
					echo '<div class="text-icons-div mt-medium">' . esc_html__( 'No jobs found.', 'ICWTHEME' ) . '</div>';
			}
		?>
		<?php if(!empty($bottom_content)){ ?>
			<div class="content-bottom">
				<?php echo $bottom_content; ?>
			</div>
		<?php } ?>
	</div>
	</div>
	<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section> 
