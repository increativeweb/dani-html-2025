<?php
/**
 * Block - Cards slider
 *
 * @package WP-rock
 * @since   4.4.0
 */

/** @var array $args Passed block arguments from ACF render_template */
$attrs = WP_Rock_Blocks::prepare_attrs($args);

$block_fields = $attrs['block_fields'];

$carousel = get_field_value($block_fields, 'slider');
$slider_titles = get_field_value($block_fields, 'slider_titles');
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
    <div class="block-cards-slider__slider-container">
        <?php if ($carousel) { ?>
            <!-- Mobile combined slider -->
            <div class="block-cards-slider__mobile">
                <div class="swiper block-cards-slider__carousel overflow-visible js--cards-carousel">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($carousel as $index => $item) :
                            $i = $index + 1; // Start numbering from 1
                        ?>
                            <div class="swiper-slide block-cards-slider__carousel-item">
                                <div class="swiper-slide block-cards-slider__carousel-wrapper">
                                    <div class="swiper-slide block-cards-slider__carousel-content-area">
                                        <?php if ($item['subtitle']) { ?>
                                            <div class="swiper-slide block-cards-slider__carousel-content-subtitle">
                                                <?php echo wp_kses_post($item['subtitle']); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($item['title']) { ?>
                                            <div class="swiper-slide block-cards-slider__carousel-content-title">
                                                <?php echo '0'.$i; ?>. <?php echo wp_kses_post($item['title']); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($item['description']) { ?>
                                            <div class="swiper-slide block-cards-slider__carousel-content-description">
                                                <?php echo wp_kses_post($item['description']); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="swiper-slide block-cards-slider__carousel-image-area">
                                        <div class="swiper-slide block-cards-slider__carousel-image-inner">
                                            <?php echo wp_get_attachment_image($item['image'], 'large', false, ['class' => 'block-cards-slider__carousel-img']); ?>
                                            <?php if($index == 0) { ?>
                                                <div class="decor-element element-<?php echo $index; ?>-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none">
                                                        <path d="M31.0156 8.83521C31.1505 8.83521 31.2612 8.94259 31.2656 9.07739C31.6542 20.8928 41.1425 30.3805 52.958 30.7688C53.0927 30.7733 53.1991 30.8841 53.1992 31.0188C53.1992 31.1536 53.0927 31.2643 52.958 31.2688C41.1424 31.6571 31.654 41.1455 31.2656 52.9612C31.2611 53.0959 31.1504 53.2024 31.0156 53.2024C30.8809 53.2023 30.7702 53.0958 30.7656 52.9612C30.3773 41.1457 20.8897 31.6573 9.07422 31.2688C8.93942 31.2644 8.83203 31.1537 8.83203 31.0188C8.83213 30.884 8.93948 30.7732 9.07422 30.7688C20.8895 30.3803 30.3771 20.8927 30.7656 9.07739C30.7701 8.94265 30.8808 8.8353 31.0156 8.83521Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                        <path d="M15.3326 15.3329C15.428 15.2375 15.5822 15.2352 15.6806 15.3273C24.3102 23.4074 37.7282 23.4069 46.3576 15.3267C46.456 15.2347 46.6096 15.2377 46.705 15.3329C46.8003 15.4282 46.8032 15.5818 46.7112 15.6802C38.6308 24.3097 38.6308 37.7284 46.7112 46.3579C46.8032 46.4563 46.8003 46.6099 46.705 46.7052C46.6096 46.8004 46.456 46.8034 46.3576 46.7114C37.7282 38.6312 24.3102 38.6307 15.6806 46.7107C15.5822 46.8029 15.428 46.8006 15.3326 46.7052C15.2374 46.6098 15.2349 46.4556 15.3271 46.3572C23.407 37.7278 23.407 24.3103 15.3271 15.6809C15.2349 15.5825 15.2374 15.4283 15.3326 15.3329Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="51" height="56" viewBox="0 0 51 56" fill="none">
                                                        <path d="M6.75891 17.5072L15.9562 42.683C16.9969 45.5315 21.0304 45.5176 22.0513 42.662L25.5721 32.8146C25.8756 31.9658 26.5188 31.2818 27.3474 30.9268L36.1798 27.143C38.9507 25.9559 38.7415 21.96 35.8618 21.0687L10.7608 13.2996C8.19998 12.5071 5.83906 14.9893 6.75891 17.5072Z" fill="black" stroke="black" stroke-width="0.5"/>
                                                        <path d="M2.17348 21.597L11.0846 46.8755C12.0929 49.7356 16.1263 49.7674 17.1796 46.9236L20.8118 37.1167C21.1249 36.2715 21.7759 35.5948 22.6084 35.2493L31.4831 31.5659C34.2673 30.4103 34.1035 26.4123 31.2341 25.4884L6.22283 17.4351C3.67118 16.6135 1.28225 19.0688 2.17348 21.597Z" fill="#2EAD87" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="41" viewBox="0 0 34 41" fill="none">
                                                        <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 9.13525 10.4973)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 21.3345 0.25)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 33.5337 5.57031)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="157" height="119" viewBox="0 0 157 119" fill="none">
                                                        <path d="M127.434 26.8469V110.237C127.434 114.685 123.829 118.29 119.382 118.29H99.332" stroke="black" stroke-width="0.5"/>
                                                        <path d="M127.195 72.5684L210.383 72.5686" stroke="black" stroke-width="0.5"/>
                                                        <path d="M18.5742 47.4745V26.6687C18.5742 22.2214 22.1794 18.6162 26.6267 18.6162H233.569C238.016 18.6162 241.621 22.2214 241.621 26.6687V34.6092" stroke="black" stroke-width="0.5"/>
                                                        <path d="M13.2549 0.25C13.379 0.250041 13.484 0.341103 13.502 0.463867L14.1982 5.23535C14.7326 8.89899 17.6098 11.7771 21.2734 12.3115L26.0459 13.0078C26.1686 13.0258 26.2598 13.1308 26.2598 13.2549C26.2597 13.3789 26.1686 13.4839 26.0459 13.502L21.2734 14.1982C17.61 14.7327 14.7327 17.61 14.1982 21.2734L13.502 26.0459C13.4839 26.1686 13.3789 26.2597 13.2549 26.2598C13.1308 26.2598 13.0258 26.1686 13.0078 26.0459L12.3115 21.2734C11.7771 17.6098 8.89899 14.7326 5.23535 14.1982L0.463867 13.502C0.341103 13.484 0.250041 13.379 0.25 13.2549C0.25 13.1308 0.341087 13.0258 0.463867 13.0078L5.23535 12.3115C8.89911 11.7772 11.7772 8.89911 12.3115 5.23535L13.0078 0.463867L13.0186 0.419922C13.0523 0.320051 13.1462 0.25 13.2549 0.25Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                        <rect x="101.52" y="10.6233" width="33.7657" height="15.9844" rx="7.9922" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <rect x="119.043" y="10.6233" width="16.2417" height="15.9844" rx="7.9922" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="127.432" cy="18.6162" r="5.36134" fill="black"/>
                                                    </svg>
                                                </div>
                                            <?php  } elseif ($index == 1) { ?>
                                                <div class="decor-element element-<?php echo $index; ?>-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="61" height="56" viewBox="0 0 61 56" fill="none">
                                                        <path d="M38.3027 8.47351L14.1719 20.1402C11.4416 21.4602 11.8585 25.4721 14.8018 26.2027L24.9517 28.722C25.8265 28.9391 26.5714 29.5108 27.0073 30.2997L31.6547 38.7099C33.1127 41.3483 37.0677 40.7409 37.6668 37.7866L42.8891 12.035C43.4219 9.40778 40.7161 7.30669 38.3027 8.47351Z" fill="black" stroke="black" stroke-width="0.5"/>
                                                        <path d="M33.7826 4.31964L9.52091 15.7118C6.77585 17.0008 7.14713 21.0172 10.082 21.7811L20.2027 24.4153C21.075 24.6424 21.8133 25.2225 22.2403 26.0163L26.7919 34.4787C28.2199 37.1334 32.1816 36.571 32.8142 33.6236L38.3282 7.9329C38.8908 5.31193 36.209 3.18028 33.7826 4.31964Z" fill="#2EAD87" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="242" height="119" viewBox="0 0 242 119" fill="none">
                                                        <path d="M127.195 72.5684L210.383 72.5686" stroke="black" stroke-width="0.5"/>
                                                        <path d="M18.5742 47.4745V26.6687C18.5742 22.2214 22.1794 18.6162 26.6267 18.6162H233.569C238.016 18.6162 241.621 22.2214 241.621 26.6687V34.6092" stroke="black" stroke-width="0.5"/>
                                                        <path d="M13.2549 0.25C13.379 0.250041 13.484 0.341103 13.502 0.463867L14.1982 5.23535C14.7326 8.89899 17.6098 11.7771 21.2734 12.3115L26.0459 13.0078C26.1686 13.0258 26.2598 13.1308 26.2598 13.2549C26.2597 13.3789 26.1686 13.4839 26.0459 13.502L21.2734 14.1982C17.61 14.7327 14.7327 17.61 14.1982 21.2734L13.502 26.0459C13.4839 26.1686 13.3789 26.2597 13.2549 26.2598C13.1308 26.2598 13.0258 26.1686 13.0078 26.0459L12.3115 21.2734C11.7771 17.6098 8.89899 14.7326 5.23535 14.1982L0.463867 13.502C0.341103 13.484 0.250041 13.379 0.25 13.2549C0.25 13.1308 0.341087 13.0258 0.463867 13.0078L5.23535 12.3115C8.89911 11.7772 11.7772 8.89911 12.3115 5.23535L13.0078 0.463867L13.0186 0.419922C13.0523 0.320051 13.1462 0.25 13.2549 0.25Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                                                        <circle cx="18.8882" cy="18.8882" r="18.6382" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="18.8897" cy="18.8882" r="9.31937" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="4.90897" cy="18.888" r="4.65897" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="79" height="17" viewBox="0 0 79 17" fill="none">
                                                        <path d="M0.25 15.8983V8.30249C0.25 3.85522 3.85522 0.25 8.30249 0.25H19.6478M77.8413 16.243V8.30249C77.8413 3.85522 74.2361 0.25 69.7888 0.25H58.4435M39.0457 0.25V15.8983M39.0457 0.25H19.6478M39.0457 0.25H58.4435M19.6478 0.25V15.8983M58.4435 0.25V15.8983" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-5">
                                                    <svg class="d-lg-none" xmlns="http://www.w3.org/2000/svg" width="232" height="112" viewBox="0 0 232 112" fill="none">
                                                        <path d="M189.973 110.861L166.826 110.861C162.379 110.861 158.773 107.256 158.773 102.809L158.773 82.3847M189.973 53.9082L166.826 53.9082C162.379 53.9082 158.773 57.5135 158.773 61.9607L158.773 82.3847M158.773 82.3847L193.329 82.3847M158.773 82.3847L51.0273 82.3847" stroke="black" stroke-width="0.5"/>
                                                        <path d="M50.1875 58.9751L82.7372 58.9749" stroke="black" stroke-width="0.5"/>
                                                        <path d="M230.8 27.6684L230.8 11.6121C230.8 7.16481 227.195 3.55959 222.747 3.55959L8.30249 3.55958C3.85522 3.55958 0.25 7.1648 0.25 11.6121L0.25 27.6684" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="86.0826" cy="58.9749" r="3.34428" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="177.505" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="193.275" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="209.056" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                    <svg class="d-lg-block d-none" xmlns="http://www.w3.org/2000/svg" width="268" height="241" viewBox="0 0 268 241" fill="none">
                                                        <path d="M424.599 240.354L372.856 240.354C362.915 240.354 354.856 232.296 354.856 222.354L354.856 176.7M424.599 113.046L372.856 113.046C362.915 113.046 354.856 121.105 354.856 131.046L354.856 176.7M354.856 176.7L432.099 176.7M354.856 176.7L114.008 176.7" stroke="black"/>
                                                        <path d="M112.125 124.372L184.884 124.371" stroke="black"/>
                                                        <path d="M515.856 54.3912L515.856 18.5C515.856 8.55892 507.797 0.500045 497.856 0.500044L18.5 0.500024C8.55887 0.500024 0.5 8.5589 0.5 18.5L0.5 54.3912" stroke="black"/>
                                                        <circle cx="192.358" cy="124.371" r="7.47559" stroke="black"/>
                                                    </svg>
                                                </div>
                                            <?php } elseif ($index == 2) { ?>
                                                <div class="decor-element element-<?php echo $index; ?>-1">
                                                    <svg class="d-lg-none" xmlns="http://www.w3.org/2000/svg" width="232" height="112" viewBox="0 0 232 112" fill="none">
                                                        <path d="M189.973 110.861L166.826 110.861C162.379 110.861 158.773 107.256 158.773 102.809L158.773 82.3847M189.973 53.9082L166.826 53.9082C162.379 53.9082 158.773 57.5135 158.773 61.9607L158.773 82.3847M158.773 82.3847L193.329 82.3847M158.773 82.3847L51.0273 82.3847" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="177.505" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="193.275" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <path d="M230.8 27.6684L230.8 11.6121C230.8 7.16481 227.195 3.55959 222.747 3.55959L8.30249 3.55958C3.85522 3.55958 0.25 7.1648 0.25 11.6121L0.25 27.6684" stroke="black" stroke-width="0.5"/>
                                                        <circle cx="209.056" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                    <svg class="d-lg-block d-none"  xmlns="http://www.w3.org/2000/svg" width="517" height="249" viewBox="0 0 517 249" fill="none">
                                                        <path d="M424.599 247.752L372.856 247.752C362.915 247.752 354.856 239.693 354.856 229.752L354.856 184.098M424.599 120.443L372.856 120.443C362.915 120.443 354.856 128.502 354.856 138.443L354.856 184.098M354.856 184.098L432.099 184.098M354.856 184.098L114.008 184.098" stroke="black"/>
                                                        <path d="M515.856 61.7892L515.856 25.898C515.856 15.9569 507.797 7.89799 497.856 7.89799L18.5 7.89797C8.55887 7.89797 0.5 15.9568 0.5 25.898L0.5 61.7892" stroke="black"/>
                                                        <circle cx="396.727" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                        <circle cx="431.992" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                        <circle cx="467.258" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="57" height="51" viewBox="0 0 57 51" fill="none">
                                                      <path d="M22.3635 47.1128L47.1744 36.9723C49.9816 35.8249 49.8155 31.7948 46.9234 30.8823L36.9502 27.7355C36.0906 27.4643 35.3828 26.8473 34.9969 26.0328L30.8825 17.3494C29.5917 14.6253 25.6066 14.985 24.8245 17.8963L18.0079 43.2725C17.3125 45.8614 19.8821 48.127 22.3635 47.1128Z" fill="black" stroke="black" stroke-width="0.5"/>
                                                      <path d="M18.7935 44.5005L43.7178 34.642C46.5379 33.5266 46.4175 29.4949 43.536 28.5496L33.5991 25.2899C32.7426 25.009 32.0419 24.384 31.6652 23.5651L27.6496 14.8356C26.3898 12.097 22.4008 12.4115 21.5858 15.3137L14.4818 40.611C13.7571 43.1918 16.3008 45.4864 18.7935 44.5005Z" fill="#2EAD87" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                                        <path d="M13.5944 18.173C9.77236 21.6579 4.95252 28.5051 12.4186 30.9572C14.643 31.6877 17.1055 31.6878 19.3297 30.957C26.7932 28.5049 21.9641 21.6578 18.1421 18.173M13.5944 18.173C10.0323 22.0799 2.95684 27.0391 0.653671 18.8452M13.5944 18.173C13.0985 18.6252 12.5858 19.1339 12.0853 19.6824M13.5944 18.173C13.1423 18.6689 12.6337 19.1817 12.0853 19.6824M18.1421 18.173C22.049 21.7352 27.0081 28.8106 18.8142 31.1138C16.8999 31.6519 14.8485 31.6518 12.9341 31.1139C5.7784 29.1031 8.64282 23.4546 12.0853 19.6824M18.1421 18.173C21.7043 22.08 28.78 27.0294 31.0831 18.8333C31.6211 16.919 31.5466 14.808 31.0085 12.8937C28.9976 5.73971 23.349 8.61201 19.5768 12.0565M0.653671 18.8452C0.115585 16.9308 0.115662 14.8794 0.653599 12.9651C2.95669 4.76898 10.0323 9.71845 13.5944 13.6254C9.68756 10.0632 4.72839 2.98777 12.9223 0.684605C14.8366 0.146519 16.8136 0.0870324 18.728 0.624969C25.8837 2.63572 23.0193 8.28428 19.5768 12.0565M0.653671 18.8452C2.66453 25.9991 8.31317 23.1268 12.0853 19.6824M19.5768 12.0565C19.0763 12.6049 18.5636 13.1137 18.0677 13.5658C18.5198 13.07 19.0285 12.5572 19.5768 12.0565Z" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="51" height="54" viewBox="0 0 51 54" fill="none">
                                                    <path d="M26.4869 53.2095L42.5432 53.2095C46.9905 53.2095 50.5957 49.6043 50.5957 45.157L50.5957 8.30249C50.5957 3.85522 46.9905 0.25 42.5432 0.25L26.4869 0.249999L8.30265 0.249999C3.85538 0.249999 0.250164 3.85522 0.250164 8.30249L0.250163 20.8944" stroke="black" stroke-width="0.5"/>
                                                    <path d="M35.2561 31.6616L42.5432 31.6616C46.9905 31.6616 50.5957 28.0563 50.5957 23.6091L50.5957 8.30249C50.5957 3.85522 46.9905 0.25 42.5432 0.25L36.2962 0.25L28.787 0.25C24.3398 0.25 20.7346 3.85522 20.7346 8.30249L20.7346 15.6416" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                                <div class="decor-element element-<?php echo $index; ?>-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="41" viewBox="0 0 34 41" fill="none">
                                                        <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 9.13525 10.4973)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 21.3345 0.25)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 33.5337 5.57031)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                    </svg>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="block-cards-slider__navigation">
                    <div class="block-cards-slider__slider">
                        <div class="block-cards-slider__progress"></div>
                        <div class="block-cards-slider__handle"></div>
                    </div>
                    <div class="block-cards-slider__labels">
                        <?php
                        $total_items = count($carousel);
                        foreach ($carousel as $index => $item) :
                        ?>
                            <div class="block-cards-slider__label" data-slide="<?php echo $index; ?>">
                                <?php echo esc_html($item['title']); ?>
                            </div>
                            <?php if ($index < $total_items - 1) : ?>
                                <span class="block-cards-slider__separator">&gt;</span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Desktop split sliders -->
            <div class="block-cards-slider__desktop">
                <div class="swiper block-cards-slider__content-swiper overflow-visible js--cards-content">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($carousel as $index => $item) :
                            $i = $index + 1; // Start numbering from 1
                        ?>
                            <div class="swiper-slide block-cards-slider__carousel-item">
                                <div class="swiper-slide block-cards-slider__carousel-wrapper">
                                    <div class="swiper-slide block-cards-slider__carousel-content-area">
                                        <?php if ($item['subtitle']) { ?>
                                            <div class="swiper-slide block-cards-slider__carousel-content-subtitle">
                                                <?php echo wp_kses_post($item['subtitle']); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($item['title']) { ?>
                                            <div class="swiper-slide block-cards-slider__carousel-content-title">
                                                <?php echo '0'.$i; ?>. <?php echo wp_kses_post($item['title']); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($item['description']) { ?>
                                            <div class="swiper-slide block-cards-slider__carousel-content-description">
                                                <?php echo wp_kses_post($item['description']); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="block-cards-slider__navigation-container">
                    <div class="swiper block-cards-slider__image-swiper overflow-visible js--cards-images">
                        <div class="swiper-wrapper">
                            <?php foreach ($carousel as $index => $item) : ?>
                                <div class="swiper-slide block-cards-slider__carousel-item">
                                    <div class="block-cards-slider__carousel-wrapper">
                                        <div class="block-cards-slider__carousel-image-area">
                                            <div class="block-cards-slider__carousel-image-inner">
                                                <?php if($index == 0) { ?>
                                                    <div class="decor-element element-<?php echo $index; ?>-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63" fill="none">
                                                            <path d="M31.0156 8.83521C31.1505 8.83521 31.2612 8.94259 31.2656 9.07739C31.6542 20.8928 41.1425 30.3805 52.958 30.7688C53.0927 30.7733 53.1991 30.8841 53.1992 31.0188C53.1992 31.1536 53.0927 31.2643 52.958 31.2688C41.1424 31.6571 31.654 41.1455 31.2656 52.9612C31.2611 53.0959 31.1504 53.2024 31.0156 53.2024C30.8809 53.2023 30.7702 53.0958 30.7656 52.9612C30.3773 41.1457 20.8897 31.6573 9.07422 31.2688C8.93942 31.2644 8.83203 31.1537 8.83203 31.0188C8.83213 30.884 8.93948 30.7732 9.07422 30.7688C20.8895 30.3803 30.3771 20.8927 30.7656 9.07739C30.7701 8.94265 30.8808 8.8353 31.0156 8.83521Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                            <path d="M15.3326 15.3329C15.428 15.2375 15.5822 15.2352 15.6806 15.3273C24.3102 23.4074 37.7282 23.4069 46.3576 15.3267C46.456 15.2347 46.6096 15.2377 46.705 15.3329C46.8003 15.4282 46.8032 15.5818 46.7112 15.6802C38.6308 24.3097 38.6308 37.7284 46.7112 46.3579C46.8032 46.4563 46.8003 46.6099 46.705 46.7052C46.6096 46.8004 46.456 46.8034 46.3576 46.7114C37.7282 38.6312 24.3102 38.6307 15.6806 46.7107C15.5822 46.8029 15.428 46.8006 15.3326 46.7052C15.2374 46.6098 15.2349 46.4556 15.3271 46.3572C23.407 37.7278 23.407 24.3103 15.3271 15.6809C15.2349 15.5825 15.2374 15.4283 15.3326 15.3329Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="51" height="56" viewBox="0 0 51 56" fill="none">
                                                            <path d="M6.75891 17.5072L15.9562 42.683C16.9969 45.5315 21.0304 45.5176 22.0513 42.662L25.5721 32.8146C25.8756 31.9658 26.5188 31.2818 27.3474 30.9268L36.1798 27.143C38.9507 25.9559 38.7415 21.96 35.8618 21.0687L10.7608 13.2996C8.19998 12.5071 5.83906 14.9893 6.75891 17.5072Z" fill="black" stroke="black" stroke-width="0.5"/>
                                                            <path d="M2.17348 21.597L11.0846 46.8755C12.0929 49.7356 16.1263 49.7674 17.1796 46.9236L20.8118 37.1167C21.1249 36.2715 21.7759 35.5948 22.6084 35.2493L31.4831 31.5659C34.2673 30.4103 34.1035 26.4123 31.2341 25.4884L6.22283 17.4351C3.67118 16.6135 1.28225 19.0688 2.17348 21.597Z" fill="#2EAD87" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="41" viewBox="0 0 34 41" fill="none">
                                                            <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 9.13525 10.4973)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 21.3345 0.25)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 33.5337 5.57031)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="157" height="119" viewBox="0 0 157 119" fill="none">
                                                            <path d="M127.434 26.8469V110.237C127.434 114.685 123.829 118.29 119.382 118.29H99.332" stroke="black" stroke-width="0.5"/>
                                                            <path d="M127.195 72.5684L210.383 72.5686" stroke="black" stroke-width="0.5"/>
                                                            <path d="M18.5742 47.4745V26.6687C18.5742 22.2214 22.1794 18.6162 26.6267 18.6162H233.569C238.016 18.6162 241.621 22.2214 241.621 26.6687V34.6092" stroke="black" stroke-width="0.5"/>
                                                            <path d="M13.2549 0.25C13.379 0.250041 13.484 0.341103 13.502 0.463867L14.1982 5.23535C14.7326 8.89899 17.6098 11.7771 21.2734 12.3115L26.0459 13.0078C26.1686 13.0258 26.2598 13.1308 26.2598 13.2549C26.2597 13.3789 26.1686 13.4839 26.0459 13.502L21.2734 14.1982C17.61 14.7327 14.7327 17.61 14.1982 21.2734L13.502 26.0459C13.4839 26.1686 13.3789 26.2597 13.2549 26.2598C13.1308 26.2598 13.0258 26.1686 13.0078 26.0459L12.3115 21.2734C11.7771 17.6098 8.89899 14.7326 5.23535 14.1982L0.463867 13.502C0.341103 13.484 0.250041 13.379 0.25 13.2549C0.25 13.1308 0.341087 13.0258 0.463867 13.0078L5.23535 12.3115C8.89911 11.7772 11.7772 8.89911 12.3115 5.23535L13.0078 0.463867L13.0186 0.419922C13.0523 0.320051 13.1462 0.25 13.2549 0.25Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                            <rect x="101.52" y="10.6233" width="33.7657" height="15.9844" rx="7.9922" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <rect x="119.043" y="10.6233" width="16.2417" height="15.9844" rx="7.9922" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="127.432" cy="18.6162" r="5.36134" fill="black"/>
                                                        </svg>
                                                    </div>
                                                <?php  } elseif ($index == 1) { ?>
                                                    <div class="decor-element element-<?php echo $index; ?>-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="61" height="56" viewBox="0 0 61 56" fill="none">
                                                            <path d="M38.3027 8.47351L14.1719 20.1402C11.4416 21.4602 11.8585 25.4721 14.8018 26.2027L24.9517 28.722C25.8265 28.9391 26.5714 29.5108 27.0073 30.2997L31.6547 38.7099C33.1127 41.3483 37.0677 40.7409 37.6668 37.7866L42.8891 12.035C43.4219 9.40778 40.7161 7.30669 38.3027 8.47351Z" fill="black" stroke="black" stroke-width="0.5"/>
                                                            <path d="M33.7826 4.31964L9.52091 15.7118C6.77585 17.0008 7.14713 21.0172 10.082 21.7811L20.2027 24.4153C21.075 24.6424 21.8133 25.2225 22.2403 26.0163L26.7919 34.4787C28.2199 37.1334 32.1816 36.571 32.8142 33.6236L38.3282 7.9329C38.8908 5.31193 36.209 3.18028 33.7826 4.31964Z" fill="#2EAD87" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="242" height="119" viewBox="0 0 242 119" fill="none">
                                                            <path d="M127.195 72.5684L210.383 72.5686" stroke="black" stroke-width="0.5"/>
                                                            <path d="M18.5742 47.4745V26.6687C18.5742 22.2214 22.1794 18.6162 26.6267 18.6162H233.569C238.016 18.6162 241.621 22.2214 241.621 26.6687V34.6092" stroke="black" stroke-width="0.5"/>
                                                            <path d="M13.2549 0.25C13.379 0.250041 13.484 0.341103 13.502 0.463867L14.1982 5.23535C14.7326 8.89899 17.6098 11.7771 21.2734 12.3115L26.0459 13.0078C26.1686 13.0258 26.2598 13.1308 26.2598 13.2549C26.2597 13.3789 26.1686 13.4839 26.0459 13.502L21.2734 14.1982C17.61 14.7327 14.7327 17.61 14.1982 21.2734L13.502 26.0459C13.4839 26.1686 13.3789 26.2597 13.2549 26.2598C13.1308 26.2598 13.0258 26.1686 13.0078 26.0459L12.3115 21.2734C11.7771 17.6098 8.89899 14.7326 5.23535 14.1982L0.463867 13.502C0.341103 13.484 0.250041 13.379 0.25 13.2549C0.25 13.1308 0.341087 13.0258 0.463867 13.0078L5.23535 12.3115C8.89911 11.7772 11.7772 8.89911 12.3115 5.23535L13.0078 0.463867L13.0186 0.419922C13.0523 0.320051 13.1462 0.25 13.2549 0.25Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                                                            <circle cx="18.8882" cy="18.8882" r="18.6382" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="18.8897" cy="18.8882" r="9.31937" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="4.90897" cy="18.888" r="4.65897" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="79" height="17" viewBox="0 0 79 17" fill="none">
                                                            <path d="M0.25 15.8983V8.30249C0.25 3.85522 3.85522 0.25 8.30249 0.25H19.6478M77.8413 16.243V8.30249C77.8413 3.85522 74.2361 0.25 69.7888 0.25H58.4435M39.0457 0.25V15.8983M39.0457 0.25H19.6478M39.0457 0.25H58.4435M19.6478 0.25V15.8983M58.4435 0.25V15.8983" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-5">
                                                        <svg class="d-lg-none" xmlns="http://www.w3.org/2000/svg" width="232" height="112" viewBox="0 0 232 112" fill="none">
                                                            <path d="M189.973 110.861L166.826 110.861C162.379 110.861 158.773 107.256 158.773 102.809L158.773 82.3847M189.973 53.9082L166.826 53.9082C162.379 53.9082 158.773 57.5135 158.773 61.9607L158.773 82.3847M158.773 82.3847L193.329 82.3847M158.773 82.3847L51.0273 82.3847" stroke="black" stroke-width="0.5"/>
                                                            <path d="M50.1875 58.9751L82.7372 58.9749" stroke="black" stroke-width="0.5"/>
                                                            <path d="M230.8 27.6684L230.8 11.6121C230.8 7.16481 227.195 3.55959 222.747 3.55959L8.30249 3.55958C3.85522 3.55958 0.25 7.1648 0.25 11.6121L0.25 27.6684" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="86.0826" cy="58.9749" r="3.34428" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="177.505" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="193.275" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="209.056" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                        <svg class="d-lg-block d-none" xmlns="http://www.w3.org/2000/svg" width="517" height="249" viewBox="0 0 517 249" fill="none">
                                                            <path d="M112.125 131.77L184.884 131.769" stroke="black"/>
                                                            <circle cx="192.358" cy="131.769" r="7.47559" stroke="black"/>
                                                            <path d="M424.599 247.752L372.856 247.752C362.915 247.752 354.856 239.693 354.856 229.752L354.856 184.098M424.599 120.443L372.856 120.443C362.915 120.443 354.856 128.502 354.856 138.443L354.856 184.098M354.856 184.098L432.099 184.098M354.856 184.098L114.008 184.098" stroke="black"/>
                                                            <path d="M515.856 61.7892L515.856 25.898C515.856 15.9569 507.797 7.89799 497.856 7.89799L18.5 7.89797C8.55887 7.89797 0.5 15.9568 0.5 25.898L0.5 61.7892" stroke="black"/>
                                                            <circle cx="396.727" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                            <circle cx="431.992" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                            <circle cx="467.258" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                        </svg>
                                                    </div>
                                                <?php } elseif ($index == 2) { ?>
                                                    <div class="decor-element element-<?php echo $index; ?>-1">
                                                        <svg class="d-lg-none" xmlns="http://www.w3.org/2000/svg" width="232" height="112" viewBox="0 0 232 112" fill="none">
                                                            <path d="M189.973 110.861L166.826 110.861C162.379 110.861 158.773 107.256 158.773 102.809L158.773 82.3847M189.973 53.9082L166.826 53.9082C162.379 53.9082 158.773 57.5135 158.773 61.9607L158.773 82.3847M158.773 82.3847L193.329 82.3847M158.773 82.3847L51.0273 82.3847" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="177.505" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="193.275" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <path d="M230.8 27.6684L230.8 11.6121C230.8 7.16481 227.195 3.55959 222.747 3.55959L8.30249 3.55958C3.85522 3.55958 0.25 7.1648 0.25 11.6121L0.25 27.6684" stroke="black" stroke-width="0.5"/>
                                                            <circle cx="209.056" cy="3.55977" r="3.30977" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                        <svg class="d-lg-block d-none"  xmlns="http://www.w3.org/2000/svg" width="517" height="249" viewBox="0 0 517 249" fill="none">
                                                            <path d="M424.599 247.752L372.856 247.752C362.915 247.752 354.856 239.693 354.856 229.752L354.856 184.098M424.599 120.443L372.856 120.443C362.915 120.443 354.856 128.502 354.856 138.443L354.856 184.098M354.856 184.098L432.099 184.098M354.856 184.098L114.008 184.098" stroke="black"/>
                                                            <path d="M515.856 61.7892L515.856 25.898C515.856 15.9569 507.797 7.89799 497.856 7.89799L18.5 7.89797C8.55887 7.89797 0.5 15.9568 0.5 25.898L0.5 61.7892" stroke="black"/>
                                                            <circle cx="396.727" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                            <circle cx="431.992" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                            <circle cx="467.258" cy="7.89844" r="7.39844" fill="#FFFF78" stroke="black"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="57" height="51" viewBox="0 0 57 51" fill="none">
                                                          <path d="M22.3635 47.1128L47.1744 36.9723C49.9816 35.8249 49.8155 31.7948 46.9234 30.8823L36.9502 27.7355C36.0906 27.4643 35.3828 26.8473 34.9969 26.0328L30.8825 17.3494C29.5917 14.6253 25.6066 14.985 24.8245 17.8963L18.0079 43.2725C17.3125 45.8614 19.8821 48.127 22.3635 47.1128Z" fill="black" stroke="black" stroke-width="0.5"/>
                                                          <path d="M18.7935 44.5005L43.7178 34.642C46.5379 33.5266 46.4175 29.4949 43.536 28.5496L33.5991 25.2899C32.7426 25.009 32.0419 24.384 31.6652 23.5651L27.6496 14.8356C26.3898 12.097 22.4008 12.4115 21.5858 15.3137L14.4818 40.611C13.7571 43.1918 16.3008 45.4864 18.7935 44.5005Z" fill="#2EAD87" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                                            <path d="M13.5944 18.173C9.77236 21.6579 4.95252 28.5051 12.4186 30.9572C14.643 31.6877 17.1055 31.6878 19.3297 30.957C26.7932 28.5049 21.9641 21.6578 18.1421 18.173M13.5944 18.173C10.0323 22.0799 2.95684 27.0391 0.653671 18.8452M13.5944 18.173C13.0985 18.6252 12.5858 19.1339 12.0853 19.6824M13.5944 18.173C13.1423 18.6689 12.6337 19.1817 12.0853 19.6824M18.1421 18.173C22.049 21.7352 27.0081 28.8106 18.8142 31.1138C16.8999 31.6519 14.8485 31.6518 12.9341 31.1139C5.7784 29.1031 8.64282 23.4546 12.0853 19.6824M18.1421 18.173C21.7043 22.08 28.78 27.0294 31.0831 18.8333C31.6211 16.919 31.5466 14.808 31.0085 12.8937C28.9976 5.73971 23.349 8.61201 19.5768 12.0565M0.653671 18.8452C0.115585 16.9308 0.115662 14.8794 0.653599 12.9651C2.95669 4.76898 10.0323 9.71845 13.5944 13.6254C9.68756 10.0632 4.72839 2.98777 12.9223 0.684605C14.8366 0.146519 16.8136 0.0870324 18.728 0.624969C25.8837 2.63572 23.0193 8.28428 19.5768 12.0565M0.653671 18.8452C2.66453 25.9991 8.31317 23.1268 12.0853 19.6824M19.5768 12.0565C19.0763 12.6049 18.5636 13.1137 18.0677 13.5658C18.5198 13.07 19.0285 12.5572 19.5768 12.0565Z" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="51" height="54" viewBox="0 0 51 54" fill="none">
                                                        <path d="M26.4869 53.2095L42.5432 53.2095C46.9905 53.2095 50.5957 49.6043 50.5957 45.157L50.5957 8.30249C50.5957 3.85522 46.9905 0.25 42.5432 0.25L26.4869 0.249999L8.30265 0.249999C3.85538 0.249999 0.250164 3.85522 0.250164 8.30249L0.250163 20.8944" stroke="black" stroke-width="0.5"/>
                                                        <path d="M35.2561 31.6616L42.5432 31.6616C46.9905 31.6616 50.5957 28.0563 50.5957 23.6091L50.5957 8.30249C50.5957 3.85522 46.9905 0.25 42.5432 0.25L36.2962 0.25L28.787 0.25C24.3398 0.25 20.7346 3.85522 20.7346 8.30249L20.7346 15.6416" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                    <div class="decor-element element-<?php echo $index; ?>-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="41" viewBox="0 0 34 41" fill="none">
                                                            <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 9.13525 10.4973)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 21.3345 0.25)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                            <rect width="8.88539" height="29.4032" rx="4.4427" transform="matrix(-1 0 0 1 33.5337 5.57031)" fill="#FFFF78" stroke="black" stroke-width="0.5"/>
                                                        </svg>
                                                    </div>
                                                <?php } ?>
                                                <?php echo wp_get_attachment_image($item['image'], 'large', false, ['class' => 'block-cards-slider__carousel-img']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="block-cards-slider__navigation">
                        <div class="block-cards-slider__slider">
                            <div class="block-cards-slider__progress"></div>
                            <div class="block-cards-slider__handle"></div>
                        </div>
                        <div class="block-cards-slider__labels">
                            <?php
                            $total_items = count($carousel);
                            foreach ($carousel as $index => $item) :
                            ?>
                                <div class="block-cards-slider__label" data-slide="<?php echo $index; ?>">
                                    <?php echo esc_html($item['title']); ?>
                                </div>
                                <?php if ($index < $total_items - 1) : ?>
                                    <span class="block-cards-slider__separator">&gt;</span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
