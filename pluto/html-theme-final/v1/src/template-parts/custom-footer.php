<?php
/**
 * Custom footer template
 *
 * @package WP-rock
 */

global $global_options;
$footer_bg_color = get_field_value( $global_options, 'footer_bg_color' );
$footer_logo = get_field_value( $global_options, 'footer_logo' );
$footer_socials = get_field_value( $global_options, 'footer_socials' );
$copyright = get_field_value( $global_options, 'copyright' );

$bg_color_style = ' site-footer__color-' . $footer_bg_color;
?>
<footer id="site-footer" class="site-footer<?php echo esc_html( $bg_color_style ) ?>">
    <div class="container site-footer__container">
        <div class="site-footer__wrapper">
            <div class="site-footer__top-wrapper">
                <div class="site-footer__info">
                    <div class="site-footer__logo">
                        <?php if ( $footer_logo ) { ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <?php echo wp_get_attachment_image( $footer_logo, 'full', false, array( 'alt' => esc_attr( get_bloginfo( 'name' ) ) ) ); ?>
                            </a>
                        <?php } ?>
                    </div>
                    <?php if ( $footer_socials ) { ?>
                        <div class="site-footer__socials">
                            <?php foreach ( $footer_socials as $social ) { ?>
                                <a href="<?php echo esc_url( $social['url'] ); ?>" class="site-footer__social-link" target="_blank" rel="noopener">
                                    <?php if ( ! empty( $social['icon'] ) ) { ?>
                                        <img src="<?php echo esc_url( $social['icon']['url'] ); ?>" alt="<?php echo esc_attr( $social['icon']['alt'] ); ?>" />
                                    <?php } ?>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="site-footer__menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_menu',
                            'menu_id'        => 'footer-menu',
                            'container'      => false,
                            'menu_class'     => 'footer-menu',
                        )
                    );
                    ?>
                </div>
            </div>

            <div class="site-footer__bottom-wrapper">
                <div class="site-footer__copyright">
                    <?php echo wp_kses_post( $copyright ); ?>
                </div>

                <div class="site-footer__policies">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer_policies_menu',
                            'menu_id'        => 'footer-policies-menu',
                            'container'      => false,
                            'menu_class'     => 'footer-policies-menu',
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>
