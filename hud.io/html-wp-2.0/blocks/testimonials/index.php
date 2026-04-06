<?php
/**
 * Testimonials Sldier Block Template.
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
    echo '<img src="'.get_template_directory_uri().'/blocks/testimonials/'. $block['data']['icw_preview'].'" alt=""/>';
    return;
}

if ( ! is_admin() ) {
    $icwlazy = 'class="icw-lazy" src="'.esc_url(lazyloading).'" data-';
} else {
    $icwlazy = '';
}

$group_title_info = get_field('title_group');
$group_testimonials_show = get_field('testimonials_show');
$group_testimonials_view_style = get_field('testimonials_view_style');
$group_show_testimonials = get_field('show_testimonials');
$group_logostyle = get_field('logostyle');

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
?>
<section <?php echo $gs_anchor.$data_theme; ?> class="theme-section testimonial-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>         
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

                echo '<div class="section-title '.$title_align.'">';
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
                        echo '<div class="action">'.acfield_btn_group($link).'</div>';
                    }
                echo '</div>';
            }

        $testimonials_splide_class = 'testimonials-splide';
        $testimonials_splide_id = 'testimonials-splide-'.$block['id'];
        if(!empty($group_testimonials_view_style) && $group_testimonials_view_style == 'slide1'){
            $testimonials_splide_class = 'single-testimonials-splide';
            $testimonials_splide_id = 'single-testimonials-splide-'.$block['id'];
        }
            
        if(!empty($group_testimonials_show) && ($group_testimonials_show == 'auto' || $group_testimonials_show == 'manual')){
            $testimonials_array = '';
            if($group_testimonials_show == 'manual') {
                $select_custom_testi = get_field('testimonials_manual');
                $testimonials_array = $select_custom_testi;
            } else {
                $args = array(
                    'post_type'         => 'testimonial',
                    'posts_per_page'    => $group_show_testimonials,
                    'order'             => 'ASC',
                    'orderby'           => 'menu_order',
                    'post_status'       => 'publish',
                    'has_password'      => false, // ✅ removes protected posts
                );  
                $testimonials_array = get_posts($args);
            }
            
            if( $testimonials_array ):

                 if(!empty($group_testimonials_view_style) && $group_testimonials_view_style == 'modern'){
                    ?>
                     <div class="slider-block testimonials-modern">
                        <?php /* style="--h-desktop:26rem; --h-tablet:26.7rem; --h-mini-tablet:28.75rem; --h-mobile:auto;--h-desktop-info:17.438rem; --h-tablet-info:18rem; --h-mini-tablet-info:14rem; --h-mobile-info:100%;" */ ?>
                        <div class="splide testimonials-vertical-slider splide-js">
                            <div class="splide__track">
                                <ul class="splide__list">
                               <?php 
                                foreach( $testimonials_array as $index => $testi_post ){
                                        $postID = $testi_post->ID;
                                        $client_image       = get_field( 'client_img', $postID );
                                        $client_title        = get_field( 'client_title', $postID );

                                        $client_logo_name        = get_field( 'client_logo_name', $postID );
                                        $client_logo_white_lg  = get_field( 'client_logo_white_lg', $postID );

                                        $client_linkedin    = get_field( 'client_linkedin', $postID );
                                        $client_content     = get_field( 'client_content', $postID );

                                        $client_link     = get_field( 'client_link', $postID );

                                        
                                        $info_title      = get_field( 'info_title', $postID );
                                        $info_text       = get_field( 'info_text', $postID );

                                        $alt                = esc_attr(get_the_title($postID));

                                        $client_name = get_the_title($postID);

                                        if(!empty($client_linkedin)){
                                            $client_name = '<a href="'.$client_linkedin.'" target="_blank" title="LinkedIn" data-bs-toggle="tooltip">'.$client_name.'</a>';
                                        }

                                        if(!empty($client_title) && !empty($client_logo_name)){
                                            $client_title = $client_title . '<br>'.$client_logo_name;
                                        }

                                        $client_logo_src = '';
                                        if(!empty($client_logo_white_lg)){
                                            $client_logo_src = wp_get_attachment_image_url($client_logo_white_lg, 'medium');
                                        }

                                        $client_info = '';
                                        if(isset( $info_title ) && $info_title != '' || isset( $info_text ) && $info_text != ''){

                                            $info_aline      = get_field( 'info_aline', $postID );
                                            $info_title_style      = get_field( 'info_title_style', $postID );
                                            if(!empty($info_aline) && $info_aline == 1) {
                                               $info_aline = 'info-default';
                                            } else {
                                                $info_aline = 'info-reverse';
                                            }

                                            if(!empty($info_title_style)) {
                                                $info_title_style = 'info-title-'.$info_title_style;
                                            }

                                            $client_info = '';
                                            $client_info .= '<div class="client-info '.$info_aline.' '.$info_title_style.'">';
                                                if (isset( $info_title ) && $info_title != '') {
                                                    $client_info .= '<strong>'.$info_title.'</strong>';
                                                }
                                                if(isset( $info_text ) && $info_text != ''){
                                                    $client_info .= $info_text;
                                                }
                                            $client_info .='</div>';
                                        }
                                        
                                        if(!empty($client_content)){   
                                            echo '<li class="splide__slide">    
                                                <div class="testimonial-card">
                                                    <div class="client-logo-block">';
                                                        if(!empty($client_logo_src)){
                                                            echo '<div class="client-logo"><img src="'.$client_logo_src.'" alt="'.esc_attr($alt).'"></div>';
                                                        }
                                                        if(!empty($client_link)){
                                                            echo '<div class="action"><div class="btn-border-base">' . acfield_btn($client_link, 'btn btn-bordar-animation') . '</div></div>';
                                                        }
                                                    echo '</div>
                                                    <div class="client-body">
                                                        <div class="client-highlight-block">
                                                            '.$client_info.'
                                                        </div>
                                                        <div class="client-info-block">
                                                            <div class="sort-info">'.$client_content.'</div>
                                                            <div class="user-info">
                                                                <div class="user-img">';
                                                                    if(!empty($client_image)){
                                                                        $client_image_src = wp_get_attachment_image_url($client_image, 'thumbnail');
                                                                        echo '<img src="'.$client_image_src.'" alt="'.esc_attr($alt).'">';
                                                                    } else {
                                                                        $client_image_src = get_template_directory_uri().'/assets/images/no-client-img.svg';
                                                                        echo '<img src="'.$client_image_src.'" alt="'.esc_attr($alt).'">';
                                                                    }
                                                                echo '</div>
                                                                <div class="info">
                                                                    <div class="name">'.$client_name.'</div>';
                                                                    if(!empty($client_title)){
                                                                        echo '<div class="user-position">'.$client_title.'</div>';
                                                                    }
                                                                echo '</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </li>';
                                        }
                                    }
                               ?>
                            </ul>
                        </div>
                    </div>
                </div>
                    <?php
                 } else {
                    ?>
                        <div class="splide testimonial-splide splide-js <?php echo $testimonials_splide_class; ?>">
                        <?php
                        echo '<div class="splide__track"><ul class="splide__list">';

                        foreach( $testimonials_array as $index => $testi_post ){
                            $postID = $testi_post->ID;
                            $client_image       = get_field( 'client_img', $postID );
                            $client_title        = get_field( 'client_title', $postID );
                            $client_logo        = get_field( 'client_logo', $postID );
                            $client_logo_white  = get_field( 'client_logo_white', $postID );
                            $client_linkedin    = get_field( 'client_linkedin', $postID );
                            $client_content     = get_field( 'client_content', $postID );
                            $alt                = esc_attr(get_the_title($postID));

                            $client_link     = get_field( 'client_link', $postID );

                            $client_name = get_the_title($postID);

                            if(!empty($client_linkedin)){
                                $client_name = '<a href="'.$client_linkedin.'" target="_blank" title="LinkedIn" data-bs-toggle="tooltip">'.$client_name.'</a>';
                            }
                            if(!empty($client_title)){
                                $client_name = $client_name . ', <em>'.$client_title.'</em>';
                            }

                            $client_logo_src = '';
                            if(!empty($client_logo)){
                                $client_logo_src = wp_get_attachment_image_url($client_logo, 'medium');
                            }

                            if(!empty($client_logo_white) && $group_logostyle == 'light'){
                                $client_logo_src = wp_get_attachment_image_url($client_logo_white, 'medium');
                            }
                            
                            if(!empty($client_content)){   
                                echo '<li class="splide__slide">                                                                
                                        <div class="testimonial-card">
                                            <div class="client-img">';
                                            if(!empty($client_image)){
                                                        $client_image_src = wp_get_attachment_image_url($client_image, 'thumbnail');
                                                        echo '<img src="'.$client_image_src.'" alt="'.esc_attr($alt).'">';
                                                    } else {
                                                        $client_image_src = get_template_directory_uri().'/assets/images/no-client-img.svg';
                                                        echo '<img src="'.$client_image_src.'" alt="'.esc_attr($alt).'">';
                                                    }
                                            echo '</div>
                                            <div class="client-body">
                                                <div class="sort-info">'.$client_content;
                                                    if(!empty($client_link)){
                                                        echo '<p>' . acfield_btn($client_link) . '</p>';
                                                    }
                                                echo '</div>
                                            </div>
                                            <div class="client-footer">
                                                <div class="client-name">'.$client_name.'</div><div class="client-logo">';
                                                if(!empty($client_logo_src)){
                                                    echo '<img src="'.$client_logo_src.'" alt="'.esc_attr($alt).'">';
                                                }
                                            echo '</div></div>
                                        </div>
                                    </li>';
                            }
                        }
                    echo '</ul></div>';
                    echo '</div>';
                 }
            endif;  
        } 
            wp_reset_postdata(); 
        ?>
    </div>
    <?php if (!empty($gs_css)) { echo html_entity_decode($gs_css); } ?>
</section>