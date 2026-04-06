<?php
/**
 * News - Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

if ( ! empty( $block['data']['icw_preview'] ) ) {
	echo '<img src="' . get_template_directory_uri() . '/blocks/blog/' . $block['data']['icw_preview'] . '" alt=""/>';
	return;
}

$group_title_info      = get_field( 'title_group' );
$group_show_blog_style = get_field( 'show_blog_style' );

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
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section post-section pt-0 <?php echo $gs_class; ?>" <?php echo $gs_style; ?>> 
	<div class="container<?php echo ($group_show_blog_style == 'is-filter') ? ' container-theme' : ''; ?>">
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

	<?php 
		$paged = max( 1, get_query_var('paged') );

		$blog_pager_style = icw_get_field('pager_style');

		$blog_posts_per_page = icw_get_field('blog_posts_per_page');
		$default_ppp        = get_option('posts_per_page', 8);
		$per_page           = $blog_posts_per_page ? (int) $blog_posts_per_page : (int) $default_ppp;

		// Sticky posts
		$sticky_posts = get_option('sticky_posts');
		if ( ! is_array( $sticky_posts ) ) {
			$sticky_posts = [];
		}

		// =======================================
		// Calculate how many normal posts to fetch
		// =======================================
		$fetch_normal = $per_page;

		if ( $paged === 1 && ! empty( $sticky_posts ) ) {
			$fetch_normal = max( 0, $per_page - count( $sticky_posts ) );
		}

		// ===============================
		// Sticky query (ONLY page 1)
		// ===============================
		$sticky_query = [];

		if ( $paged === 1 && ! empty( $sticky_posts ) ) {
			$sticky_args = [
				'post_type'           => 'post',
				'post__in'            => $sticky_posts,
				'orderby'             => 'post__in',
				'posts_per_page'      => -1,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'has_password'        => false,
			];

			// ✅ Conditionally exclude "case-study"
			if ( $group_show_blog_style === 'is-latest' ) {
				$sticky_args['tax_query'] = [
					[
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => [ 'case-study' ],
						'operator' => 'NOT IN',
					],
				];
			}

			// ✅ Now fetch posts
			$sticky_query = get_posts( $sticky_args );
		}

		// ===============================
		// Normal posts query
		// ===============================
		$args = [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $fetch_normal,
			'paged'               => $paged,
			'order'               => 'DESC',
			'post__not_in'        => $sticky_posts,
			'ignore_sticky_posts' => 1,
			'has_password'        => false,
		];

		$normal_query = new WP_Query( $args );

		// ===============================
		// Merge posts
		// ===============================
		$news_posts = ( $paged === 1 )
			? array_merge( $sticky_query, $normal_query->posts )
			: $normal_query->posts;

		// ===============================
		// Fix pagination globals
		// ===============================
		// global $wp_query;

		$wp_query = $normal_query;
		$wp_query->posts       = $news_posts;
		$wp_query->post_count  = count( $news_posts );

		// Sticky count only affects page 1
		$extra = ( $paged === 1 ) ? count( $sticky_query ) : 0;

		$wp_query->found_posts   = $normal_query->found_posts + $extra;
		$wp_query->max_num_pages = ceil( $wp_query->found_posts / $per_page );

		// ===============================
		// Loop
		// ===============================
		if (!empty($news_posts)) {
			if($group_show_blog_style == 'is-latest') {
				echo '<div class="splide post-splide splide-js"><div class="splide__track"><ul class="splide__list">';
							foreach ($news_posts as $post) {
								setup_postdata($post);
								set_query_var('postid', $post->ID);
								set_query_var('post_excerpt', 'hide');
								echo '<li class="splide__slide">';
									get_template_part('template-parts/content', 'post');
								echo '</li>';
							}
						echo '</ul></div></div>';
					wp_reset_postdata();
			}

			if ($group_show_blog_style == 'is-full') {
				echo '<div class="post-list-block"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="blog-posts-wrapper">';
					foreach ($news_posts as $post) {
						setup_postdata($post);
						set_query_var('postid', $post->ID);
						echo '<div class="col">';
							get_template_part('template-parts/content', 'post');
						echo '</div>';
					}
				echo '</div>';
				wp_reset_postdata();

				if(!empty($blog_pager_style) && $blog_pager_style == 'is-pagination') {
					echo '<div class="icw-pagination">';
					echo paginate_links([
						'total'   => $normal_query->max_num_pages,
						'current' => $paged,
						'prev_text' => '← Previous',
						'next_text' => 'Next →',
					]);
					echo '</div>';
				}
				if(!empty($blog_pager_style) && $blog_pager_style == 'is-load-more') {
					if ($normal_query->max_num_pages > 1) :
						echo '<div class="icw-pager"><button class="btn btn-white" id="loadMorePosts" data-page="1" data-max="'.$normal_query->max_num_pages.'">More articles</button></div>';
					endif;
				}
				echo '</div>';
			}
		}

		if ($group_show_blog_style == 'is-filter') { 
			$sticky_post_id = icw_get_field('blog_sticky_hero_post_id');
			if (!empty($sticky_post_id)) {
				$post = get_post($sticky_post_id[0]);
				setup_postdata($post);
				set_query_var('postid', $post->ID);
				get_template_part('template-parts/content', 'post-hero');
				wp_reset_postdata();
			}
			/*
			global $wp_query;
			$j=0; 
				if ( have_posts() ): ?>
					<?php
					while ( have_posts() ): the_post();
					$first_post = $wp_query->posts[0];
					// pr($first_post);
						if ($j==0){ 
							get_template_part('template-parts/content', 'post-hero');
						}
						$j ++;
					endwhile;
					?>
				</div>
			<?php 
				endif;
				wp_reset_postdata();
				*/
		}
	?>
	</div>
	<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section> 
<?php if ($group_show_blog_style == 'is-filter') { ?>
<section class="theme-section blog-section pt-0">
    <div class="container container-theme">
        <div class="posts-archive">
          <?php
		  	$sticky_post_id = '';
		  	$is_sticky_post_id = icw_get_field('blog_sticky_hero_post_id');
			if (!empty($is_sticky_post_id)) {
				$sticky_post_id = $is_sticky_post_id[0];
			}
            $per_page = (get_option('posts_per_page')) ? get_option('posts_per_page') : 9;
            echo do_shortcode('[icw_filter_posts per_page="' . $per_page . '" post_not_in="' . $sticky_post_id . '" ]');
          ?>
        </div>
    </div>
</section>
<?php } ?>