<?php
/**
 * Agent CTA Block Template.
 *
 */

if (!empty($block['data']['icw_preview'])) {
    echo '<img src="' . get_template_directory_uri() . '/blocks/agent-cta/' . $block['data']['icw_preview'] . '" alt=""/>';
    return;
}

$gs_setting = get_field('section_setting');
$group_title_info = get_field('title_group');
$group_cta_link2 = get_field('cta_link_group2');
$group_cta_note_footer = get_field('cta_note_footer');

$gs_class = '';
$gs_anchor = '';
$gs_style = '';
if(!empty($gs_setting)){
    $settings = icw_gs_setting($gs_setting);
    $gs_anchor = $settings['gs_anchor'];
    $gs_style = $settings['gs_style'];
    $gs_class = $settings['gs_class'];
    $gs_public = $settings['gs_public'];
}
if(!empty($gs_public) && $gs_public == 'hide') {
    return;
}
?>
<section <?php echo $gs_anchor; ?> class="main-section agent-cta-section <?php echo $gs_class; ?>" <?php echo $gs_style; ?>>
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
                if(!empty($title_class)){
                    $h_title_class = $title_class;
                }

                $s_title_class = '';
                if(!empty($title_align)){
                    $s_title_class = $title_align;
                }
                
                echo '<div class="ai-section-title mb-0 '.$s_title_class.'">';
                if(!empty($tagline)){
                    echo '<div class="tag-line wow fadeInUp" data-wow-delay="150ms">'.$tagline.'</div>';
                }
                if(!empty($title)){
                    echo '<'.$title_tag.' class="title wow fadeInUp '.$h_title_class.'" data-wow-delay="300ms">'.$title.'</'.$title_tag.'>';
                }
                if(!empty($info)){
                    echo '<div class="sort-info wow fadeInUp" data-wow-delay="450ms">'.$info.'</div>';
                }
                if(!empty($link['btn'] && !empty($group_cta_link2['cta_group']))){
                    echo '<div class="action wow fadeInUp" data-wow-delay="600ms">';
                }
                    if(!empty($link['btn'])){
                        echo acfield_btn_group($link);
                    }
                    if(!empty($group_cta_link2['cta_group'])){
                        echo acfield_btn_group($group_cta_link2['cta_group']);
                    }
                if(!empty($link['btn'] && !empty($group_cta_link2['cta_group']))){
                    echo '</div>';
                }               

                if(!empty($group_cta_note_footer)) {
                    echo '<div class="footer-note wow fadeInUp" data-wow-delay="750ms">'.$group_cta_note_footer.'</div>';
                }
            echo '</div>';
            }
        ?>
    </div>
</section>