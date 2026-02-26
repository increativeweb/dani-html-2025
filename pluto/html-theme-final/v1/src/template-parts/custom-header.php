<?php
/**
 * Custom header template
 *
 * @package WP-rock
 */

global $global_options;
$logo = get_field_value( $global_options, 'logo' );
$book_a_demo_link = get_field_value( $global_options, 'book_a_demo_link' );
?>

<header id="site-header" class="site-header js-site-header">
    <div class="container h-100">
        <div class="row justify-content-between align-items-center h-100">
            <?php if ( $logo ) { ?>
                 <div class="col col-6 col-lg-3">
                     <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo">
                         <?php echo wp_get_attachment_image( $logo, 'full', false, ['class' => 'responsive-media'], array( 'alt' => esc_attr( get_bloginfo( 'name' ) ) ) ); ?>
                     </a>
                 </div>
            <?php } ?>
            <div class="site-header__main-menu col col-6 col-lg-9 d-flex justify-content-end text-left pl-0">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary_menu',
                            'menu_class' => 'main-menu__list list-reset d-flex justify-content-between align-items-center js-menu-wrapper',
                            'container' => 'nav',
                            'container_class' => 'site-header__menu d-none d-lg-flex',
                        )
                    );
                ?>
                <?php if ( $book_a_demo_link ) : ?>
					<?php
					    $book_a_demo_target = ! empty( $book_a_demo_link['target'] ) ? $book_a_demo_link['target'] : '_self';
					?>
                    <a href="<?php echo esc_url( $book_a_demo_link['url'] ); ?>" class="btn btn-secondary_black d-none d-lg-block" target="<?php echo esc_attr( $book_a_demo_target ); ?>" rel="noopener">
                         <?php echo esc_html( $book_a_demo_link['title'] ); ?>
                    </a>
                    <a href="<?php echo esc_url( $book_a_demo_link['url'] ); ?>" class="site-header__link d-flex d-lg-none justify-content-end" target="<?php echo esc_attr( $book_a_demo_target ); ?>" rel="noopener">
                         <?php echo esc_html( $book_a_demo_link['title'] ); ?>
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                               <circle cx="12" cy="12" r="11.25" stroke="#39BF97" stroke-width="1.5"/>
                               <path d="M8.58921 14.5892C8.36233 14.8161 8.36233 15.1839 8.58921 15.4108C8.81608 15.6377 9.18392 15.6377 9.41079 15.4108L9 15L8.58921 14.5892ZM15.5809 9C15.5809 8.67915 15.3208 8.41905 15 8.41905L9.77147 8.41905C9.45062 8.41905 9.19052 8.67915 9.19052 9C9.19052 9.32085 9.45062 9.58095 9.77147 9.58095H14.4191V14.2285C14.4191 14.5494 14.6792 14.8095 15 14.8095C15.3208 14.8095 15.5809 14.5494 15.5809 14.2285L15.5809 9ZM9 15L9.41079 15.4108L15.4108 9.41079L15 9L14.5892 8.58921L8.58921 14.5892L9 15Z" fill="#39BF97"/>
                         </svg>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>
