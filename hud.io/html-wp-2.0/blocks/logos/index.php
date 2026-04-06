<?php
/**
 * Trusted Logos Block Template.
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
if(!empty($block['data']['icw_preview'])){
    echo '<img src="'.get_template_directory_uri().'/blocks/logos/'. $block['data']['icw_preview'].'" alt=""/>';
    return;
}

$group_title_info = get_field('title_group');

$group_view_style = get_field('view_style');
$group_logos = get_field('logos');
$slider_style = get_field('slider_style');

$gs_setting = get_field('section_setting');

$gs_class = '';
$gs_anchor = '';
$gs_style = '';
$gs_css    = '';
if(!empty($gs_setting)){
    $settings = icw_gs_setting($gs_setting);
    $gs_anchor = $settings['gs_anchor'];
    $gs_style = $settings['gs_style'];
    $gs_class = $settings['gs_class'];
    $gs_css    = $settings['gs_css'];
    $gs_public = $settings['gs_public'];
}
if(!empty($gs_public) && $gs_public == 'hide') {
    return;
}

$data_theme = '';
if (strpos($gs_class, 'is-dark') !== false) {
    $data_theme = 'data-theme="dark"';
} elseif (strpos($gs_class, 'is-light') !== false) {
    $data_theme = 'data-theme="light"';
}

if(!empty($slider_style) && (!empty($slider_style['scroll_full_width_desktop'] && $slider_style['scroll_full_width_desktop'] == 1))){
    $gs_class .= " trusted-logo-slider-full";
}
?>
<section <?php echo $gs_anchor; ?> <?php echo $data_theme; ?> class="theme-section trusted-logo-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>          
<div class="container">
    <?php 
        if(!empty($group_title_info) && (!empty($group_title_info['title'] || $group_title_info['info']))){
            $title_align    = isset($group_title_info['title_align_style']) ? $group_title_info['title_align_style'] : '';
            $tagline        = isset($group_title_info['tagline']) ? $group_title_info['tagline'] : '';
            $title          = isset($group_title_info['title']) ? $group_title_info['title'] : '';
            $info           = isset($group_title_info['info']) ? $group_title_info['info'] : '';
            $link           = isset($group_title_info['cta_group']) ? $group_title_info['cta_group'] : '';

            $title_tag   = isset($group_title_info['title_tag']) ? $group_title_info['title_tag'] : 'h2';
            $title_class = isset($group_title_info['title_class']) ? $group_title_info['title_class'] : '';
            $h_title_class = '';
            if(!empty($title_class)){
                $h_title_class = $title_class;
            }

            $s_title_class = '';
            if(!empty($title_align)){
                $s_title_class = $title_align;
            }

            echo '<div class="section-title '.$s_title_class.'">';
            if(!empty($tagline)){
                echo '<div class="tag-line">'.$tagline.'</div>';
            }
            if(!empty($title)){
                echo '<'.$title_tag.' class="title '.$h_title_class.'">'.$title.'</'.$title_tag.'>';
            }
            if(!empty($info)){
                echo '<div class="sort-info">'.$info.'</div>';
            }
            if(!empty($link) && $link['btn']){
                echo '<div  class="action">'.acfield_btn_group($link).'</div>';
            }
            echo '</div>';
        }
    ?>
    <?php 
        if(!empty($group_logos)){

            if(!empty($group_view_style) && $group_view_style == 'slider-view' ){
                $desktop_no = '7';
                $slide_mask = '';
                if(!empty($slider_style)){
                    $autoscroll    = isset($slider_style['autoscroll']) ? $slider_style['autoscroll'] : '';
                    $desktop_no    = isset($slider_style['perpage_desktop']) ? $slider_style['perpage_desktop'] : '7';
                }

                $logos_icount = count( $group_logos );
                if($logos_icount > $desktop_no){
                    $slide_mask = 'slide-mask';
                }

                echo '<div class="splide splide-js logo-slider '.$slide_mask.'" data-desktop-perpage="'.$desktop_no.'" data-autoscroll="'.$autoscroll.'"><div class="splide__track"><ul class="splide__list">';
                    foreach($group_logos as $logo){
                        $logo_id = isset($logo['logo']) ? $logo['logo'] : '';
                        $logo_link = isset($logo['link']) ? $logo['link'] : '';

                        if(!empty ($logo_id)){
                            $alt_text = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );

                            // Fallback: alt → title → default
                            if ( empty( $alt_text ) ) {
                                $alt_text = get_the_title( $logo_id );
                            }
                            if ( empty( $alt_text ) ) {
                                $alt_text = 'Partner Logo';
                            }

                        echo '<li class="splide__slide">
                                <div class="logo-item">
                                    <div class="logo-img">'.wp_get_attachment_image(
                                        $logo_id,
                                        'thumbnail',
                                        false,
                                        [
                                            'data-splide-lazy'               => wp_get_attachment_image_url( $logo_id, 'thumbnail' ),
                                            'alt'              => esc_attr( $alt_text ),
                                            'decoding'         => 'async',
                                        ]
                                    ).'</div>';
                                    /*
                                    <span class="splide__spinner" role="presentation"></span>
                                    wp_get_attachment_image(
                                        $logo_id,
                                        'thumbnail',
                                        false,
                                        [
                                            'src'               => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
                                            'data-splide-lazy'  => wp_get_attachment_image_url( $logo_id, 'thumbnail' ),
                                            'alt'              => esc_attr( $alt_text ),
                                            'decoding'         => 'async',
                                        ]
                                    )
                                    */
                                    if(!empty($logo_link) && isset($logo['link'])) {
                                        $link = isset($logo['link']) ? $logo['link'] : '';
                                        $link_url = isset($link['url']) ? $link['url'] : '';
                                        $link_title = isset($link['title']) ? $link['title'] : '';
                                        $link_target = isset($link['target']) ? $link['target'] : '';

                                        echo '<a href="'.$link_url.'" target="'.$link_target.'" class="btn btn-link-arrow">'.$link_title.'<span class="icon-arrow"></span></a>';
                                    }
                                echo '</div>
                            </li>';
                        }
                    }
                echo '</ul></div></div>';
                ?>
                <?php
            }


            if(!empty($group_view_style) && $group_view_style == 'grid-view' ){
                echo '<div class="trusted-logos">';
                foreach($group_logos as $logo){
                        $logo_id = isset($logo['logo']) ? $logo['logo'] : '';
                        $logo_link = isset($logo['link']) ? $logo['link'] : '';
                        if(!empty ($logo_id)){
                        echo '<div class="logo-item">
                                    <div class="logo-img">'.wp_get_attachment_image( $logo_id, 'full' ).'</div>';
                                    if(!empty($logo_link) && isset($logo['link'])) {
                                        $link = isset($logo['link']) ? $logo['link'] : '';
                                        $link_url = isset($link['url']) ? $link['url'] : '';
                                        $link_title = isset($link['title']) ? $link['title'] : '';
                                        $link_target = isset($link['target']) ? $link['target'] : '';

                                        echo '<a href="'.$link_url.'" target="'.$link_target.'" class="btn btn-link-arrow">'.$link_title.'<span class="icon-arrow"></span></a>';
                                    }
                                echo '</div>';
                        }
                    }
                echo '</div>';
            }

        }
    ?>
</div>
<?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>