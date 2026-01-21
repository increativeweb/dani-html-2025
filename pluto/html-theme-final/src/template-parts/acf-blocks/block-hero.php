<?php
/**
 * Block - Hero
 *
 * @package WP-rock
 * @since   4.4.0
 */

// Get block HTML attributes: ID, class list, disabled status, and all ACF fields
/** @var array $args Passed block arguments from ACF render_template */
$attrs = WP_Rock_Blocks::prepare_attrs($args);

// Get all ACF fields associated with this block
$block_fields = $attrs['block_fields'];

// Define individual ACF fields for use in the template
$title               = get_field_value($block_fields, 'section_title');
$section_description = get_field_value($block_fields, 'section_description');
$button              = get_field_value($block_fields, 'cta_button');
?>

<section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
    <div class="container"></div>
    <div class="block-hero__monkey-container">
        <div class="block-hero__monkey">
            <div class="block-hero__monkey-inner">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/public/images/monkey-transparent.svg' ); ?>" alt="">
                <div class="block-hero__monkey-elements-wrap">
                    <div class="block-hero__monkey-elements element-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="145" height="145" viewBox="0 0 145 145" fill="none">
                            <path d="M72.3278 143.66C111.717 143.66 143.648 111.729 143.648 72.34C143.648 32.9511 111.717 1.02002 72.3278 1.02002C32.9388 1.02002 1.00781 32.9511 1.00781 72.34C1.00781 111.729 32.9388 143.66 72.3278 143.66Z" fill="#C1F174"/>
                            <path d="M72.35 143.7C111.755 143.7 143.7 111.756 143.7 72.35C143.7 32.9445 111.755 1 72.35 1C32.9445 1 1 32.9445 1 72.35C1 111.756 32.9445 143.7 72.35 143.7Z" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <path d="M89.9321 89.9284C117.796 62.0645 132.511 31.603 122.798 21.8906C113.086 12.1783 82.6246 26.893 54.7606 54.7569C26.8967 82.6208 12.182 113.082 21.8943 122.795C31.6067 132.507 62.0682 117.792 89.9321 89.9284Z" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <path d="M122.798 122.795C132.511 113.083 117.796 82.6211 89.9321 54.7572C62.0682 26.8932 31.6067 12.1785 21.8943 21.8908C12.182 31.6032 26.8968 62.0647 54.7607 89.9286C82.6246 117.793 113.086 132.507 122.798 122.795Z" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M87.049 86.7803C78.049 81.5103 66.7789 81.6104 57.8789 87.1104C63.3589 78.2004 63.459 66.9203 58.189 57.9203C67.209 63.1803 78.4789 63.0703 87.3889 57.5903C81.8989 66.4903 81.7889 77.7603 87.049 86.7803Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-elements element-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="157" height="149" viewBox="0 0 157 149" fill="none">
                            <path d="M125.227 2.32092L37.6868 14.7709L1.88672 99.5909L54.4167 136.161L139.237 146.671L154.407 57.9609L125.227 2.32092Z" fill="white"/>
                            <path d="M101.105 102.321L119.395 27.6111L124.455 2.71106L37.3046 13.9911L1.89453 98.8111L101.115 102.311L101.105 102.321Z" fill="#FFBC65"/>
                            <path d="M125.745 2.32092L102.375 101.901L138.675 146.101" stroke="black" stroke-width="2.49" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M2.96484 98.5812L102.375 101.901" stroke="black" stroke-width="2.49" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M68.0664 99.7309L78.9064 63.4509L110.606 62.3409" stroke="black" stroke-width="2.49" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M38.3164 14.5211L78.9064 63.4511" stroke="black" stroke-width="2.49" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M126.325 1.3512L155.325 57.9112L140.215 146.671L54.6152 136.051L1.53516 99.2712L37.0352 13.3612L126.325 1.3512Z" stroke="black" stroke-width="2.49" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M104.335 62.3113L95.3945 101.221L102.375 101.901L111.085 61.9313L104.335 62.3113Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-elements element-4">
                        <svg width="118" height="118" viewBox="0 0 118 118" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M58.63 116.26C90.4582 116.26 116.26 90.4582 116.26 58.63C116.26 26.8018 90.4582 1 58.63 1C26.8018 1 1 26.8018 1 58.63C1 90.4582 26.8018 116.26 58.63 116.26Z" fill="#FFFF78" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <path d="M89.8177 31.79C91.6925 29.2405 90.1105 24.8927 86.2841 22.0789C82.4577 19.265 77.8359 19.0506 75.9611 21.6001C74.0863 24.1495 75.6683 28.4974 79.4948 31.3113C83.3212 34.1251 87.9429 34.3394 89.8177 31.79Z" fill="#F9F871" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <path d="M98.9984 42.8089C100.571 41.8665 100.7 39.1899 99.2866 36.8306C97.873 34.4714 95.4519 33.3228 93.8791 34.2653C92.3062 35.2077 92.1772 37.8842 93.5909 40.2435C95.0046 42.6027 97.4256 43.7514 98.9984 42.8089Z" fill="#F9F871" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <path d="M33.1821 85.9232C34.7549 84.9807 34.884 82.3041 33.4703 79.9448C32.0566 77.5856 29.6356 76.437 28.0627 77.3795C26.4899 78.3219 26.3608 80.9985 27.7745 83.3577C29.1882 85.717 31.6092 86.8656 33.1821 85.9232Z" fill="#F9F871" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                            <mask id="mask0_3046_11411" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="5" y="5" width="107" height="107">
                                <path d="M58.6289 111.88C88.0381 111.88 111.879 88.039 111.879 58.6299C111.879 29.2207 88.0381 5.37988 58.6289 5.37988C29.2197 5.37988 5.37891 29.2207 5.37891 58.6299C5.37891 88.039 29.2197 111.88 58.6289 111.88Z" fill="white"/>
                            </mask>
                            <g mask="url(#mask0_3046_11411)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M39.8378 95.8298C39.8378 95.8298 45.2778 88.0198 51.2778 90.8098C57.2778 93.5998 57.9778 102.67 65.7878 100.44C73.5978 98.2098 89.6478 83.5598 91.7378 91.2298C93.8278 98.8998 107.088 72.5298 106.668 79.0898L104.638 88.4798L95.2278 97.9298L83.9778 105.18L71.4178 110.62C69.4378 111.15 64.9578 112.71 62.9578 112.24L50.3278 113L31.0078 106.56L39.8478 95.8298H39.8378Z" fill="black" stroke="black" stroke-width="1.68" stroke-miterlimit="10"/>
                            </g>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-elements element-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="69" height="69" viewBox="0 0 69 69" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M39.1275 39.1275C77.2575 77.2575 -8.5325 77.2575 29.5975 39.1275C-8.5325 77.2575 -8.5325 -8.5325 29.5975 29.5975C-8.5325 -8.5325 77.2575 -8.5325 39.1275 29.5975C77.2575 -8.5325 77.2575 77.2575 39.1275 39.1275Z" fill="#FA673A"/>
                            <path d="M39.1275 39.1275C77.2575 77.2575 -8.5325 77.2575 29.5975 39.1275C-8.5325 77.2575 -8.5325 -8.5325 29.5975 29.5975C-8.5325 -8.5325 77.2575 -8.5325 39.1275 29.5975C77.2575 -8.5325 77.2575 77.2575 39.1275 39.1275Z" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-elements element-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="88" height="47" viewBox="0 0 88 47" fill="none">
                            <path d="M78.4183 0.73999H9.42822C4.62887 0.73999 0.738281 4.63064 0.738281 9.42999V11.72C0.738281 16.5193 4.62887 20.41 9.42822 20.41H78.4183C83.2177 20.41 87.1083 16.5193 87.1083 11.72V9.42999C87.1083 4.63064 83.2177 0.73999 78.4183 0.73999Z" fill="white" stroke="black" stroke-width="1.48" stroke-miterlimit="10"/>
                            <path d="M78.4298 4.49976H64.1898C61.6493 4.49976 59.5898 6.55925 59.5898 9.09976V12.0498C59.5898 14.5903 61.6493 16.6498 64.1898 16.6498H78.4298C80.9703 16.6498 83.0299 14.5903 83.0299 12.0498V9.09976C83.0299 6.55925 80.9703 4.49976 78.4298 4.49976Z" fill="black"/>
                            <path d="M9.42932 45.9202L78.4194 45.9202C83.2188 45.9202 87.1094 42.0295 87.1094 37.2302V34.9402C87.1094 30.1408 83.2188 26.2502 78.4194 26.2502L9.42932 26.2502C4.62997 26.2502 0.73938 30.1408 0.73938 34.9402V37.2302C0.73938 42.0295 4.62997 45.9202 9.42932 45.9202Z" fill="black" stroke="black" stroke-width="1.48" stroke-miterlimit="10"/>
                            <path d="M9.41772 42.1599H23.6577C26.1982 42.1599 28.2578 40.1004 28.2578 37.5599V34.6099C28.2578 32.0694 26.1982 30.0099 23.6577 30.0099H9.41772C6.87721 30.0099 4.81775 32.0694 4.81775 34.6099V37.5599C4.81775 40.1004 6.87721 42.1599 9.41772 42.1599Z" stroke="black" stroke-width="1.48" stroke-miterlimit="10"/>
                            <path d="M24.3478 30.01H10.1078C7.56728 30.01 5.50781 32.0695 5.50781 34.61V37.56C5.50781 40.1005 7.56728 42.16 10.1078 42.16H24.3478C26.8883 42.16 28.9478 40.1005 28.9478 37.56V34.61C28.9478 32.0695 26.8883 30.01 24.3478 30.01Z" fill="#FFFF78"/>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-elements element-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="51" height="51" viewBox="0 0 51 51" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M26.2464 50.1914C25.8364 51.2414 25.1364 51.2514 24.6964 50.2114L18.2664 35.0814C17.8264 34.0414 16.6064 32.8314 15.5664 32.4014L0.796352 26.2914C-0.253648 25.8614 -0.263626 25.1114 0.756374 24.6214L15.4163 17.6814C16.4363 17.2014 17.6664 15.9614 18.1364 14.9314L24.6563 0.761364C25.1263 -0.268636 25.8664 -0.248637 26.3064 0.791363L32.4964 15.7314C32.9264 16.7814 34.1364 17.9914 35.1764 18.4214L50.2263 24.7014C51.2663 25.1414 51.2564 25.8314 50.2064 26.2314L35.0064 32.1114C33.9464 32.5214 32.7464 33.7114 32.3364 34.7714L26.2664 50.1914H26.2464Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-elements element-7">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.45996 16.92C13.1323 16.92 16.9199 13.1323 16.9199 8.45999C16.9199 3.78766 13.1323 0 8.45996 0C3.78763 0 0 3.78766 0 8.45999C0 13.1323 3.78763 16.92 8.45996 16.92Z" fill="black"/>
                        </svg>
                    </div>
                </div>
                <div class="block-hero__monkey-curves-wrap">
                    <div class="block-hero__monkey-curves element-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="180" height="153" viewBox="0 0 180 153" fill="none">
                            <path d="M179.339 151.713C156.999 133.663 187.169 96.3227 164.829 78.2727C142.489 60.2227 112.319 97.5628 89.9889 79.5128C67.6489 61.4628 97.8189 24.1227 75.4789 6.07274C53.1389 -11.9773 22.9689 25.3528 0.628906 7.30275" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                        </svg>
                    </div>
                    <div class="block-hero__monkey-curves element-9">
                        <svg xmlns="http://www.w3.org/2000/svg" width="195" height="220" viewBox="0 0 195 220" fill="none">
                            <path d="M0.628906 218.618C22.9689 200.568 -7.20108 163.238 15.1389 145.188C37.4789 127.138 67.6489 164.468 89.9789 146.418C112.319 128.368 82.1489 91.0379 104.489 72.9879C126.829 54.9379 156.999 92.2678 179.339 74.2178C201.679 56.1678 171.509 18.8278 193.849 0.777832" stroke="black" stroke-width="2" stroke-miterlimit="10"/>
                        </svg>
                    </div>
                </div>
                <div class="block-hero__elements-container">
                    <div class="block-hero__decoration decoration-2">
                         <svg xmlns="http://www.w3.org/2000/svg" width="64" height="30" viewBox="0 0 64 30" fill="none">
                             <path d="M33.2652 25.6057C47.074 23.4436 55.5626 18.0447 56.4714 10.2152C53.6926 16.5541 50.0575 18.8473 41.5112 21.3781C25.9615 25.1379 19.3555 23.141 14.8966 21.3781C6.46549 18.0447 10.5783 10.1542 15.8566 6.87317C9.61384 9.96937 5.84995 14.1134 6.46549 18.0447C7.45782 24.3826 19.4565 27.7677 33.2652 25.6057Z" fill="#FFED78"/>
                             <path d="M56.4714 10.2152L56.6206 10.1337C56.5851 10.0687 56.5116 10.0342 56.4389 10.0483C56.3662 10.0625 56.3111 10.122 56.3025 10.1956L56.4714 10.2152ZM56.4714 10.2152L56.3025 10.1956C55.8554 14.0477 53.5442 17.3147 49.6126 19.8936C45.6782 22.4743 40.1297 24.3588 33.2389 25.4377L33.2652 25.6057L33.2915 25.7736C40.2094 24.6905 45.8097 22.7946 49.799 20.1779C53.7911 17.5594 56.1786 14.2122 56.6403 10.2348L56.4714 10.2152ZM33.2652 25.6057L33.2389 25.4377C26.3531 26.5159 19.9266 26.2093 15.1054 24.8491C10.2684 23.4844 7.11309 21.0818 6.63344 18.0184L6.46549 18.0447L6.29754 18.071C6.81022 21.3454 10.1504 23.8044 15.013 25.1763C19.8913 26.5526 26.3686 26.8576 33.2915 25.7736L33.2652 25.6057ZM6.46549 18.0447L6.63344 18.0184C6.33604 16.1189 7.09301 14.1486 8.71814 12.2565C10.343 10.3648 12.8237 8.56717 15.9321 7.02547L15.8566 6.87317L15.7811 6.72087C12.6468 8.27538 10.1241 10.0979 8.46023 12.035C6.79661 13.9718 5.9794 16.0391 6.29754 18.071L6.46549 18.0447ZM56.4714 10.2152L56.3222 10.2967C56.6643 10.9228 57.3571 11.9109 58.3316 12.8603C59.3061 13.8097 60.5707 14.7287 62.0575 15.2033L62.1092 15.0413L62.1609 14.8794C60.7399 14.4258 59.5194 13.5428 58.5689 12.6167C57.6183 11.6906 56.9462 10.7296 56.6206 10.1337L56.4714 10.2152Z" fill="black"/>
                             <path d="M6.96947 14.6401C6.03852 16.4762 4.91047 21.9149 0.0727539 24.2033" stroke="black" stroke-width="0.34"/>
                         </svg>
                    </div>
                    <div class="block-hero__decoration decoration-3">
                         <svg xmlns="http://www.w3.org/2000/svg" width="44" height="22" viewBox="0 0 44 22" fill="none">
                             <path d="M12.3042 1.10791C8.673 1.96645 6.19704 3.67712 5.86865 5.94385C5.27745 10.0268 11.876 14.3616 20.6069 15.6265C29.3381 16.8914 36.8953 14.6069 37.4868 10.5239C37.8157 8.25242 35.9193 5.90387 32.6685 4.04834C37.6365 6.36533 40.6825 9.58968 40.2329 12.6938C39.5295 17.5495 30.5421 20.2664 20.1587 18.7622C9.77517 17.2579 1.9279 12.1023 2.63135 7.24658C3.08018 4.14885 6.90065 1.92398 12.3042 1.10791Z" fill="#FFED78"/>
                             <path d="M32.1829 3.93866C37.1513 6.22563 40.3349 9.41109 40.1732 12.5194C39.9155 17.4717 31.2639 20.3527 20.8493 18.9545C10.4347 17.5563 2.20081 12.4082 2.45844 7.45599C2.58573 5.00922 4.76205 3.06803 8.18767 1.89875" stroke="black" stroke-width="0.34"/>
                             <path d="M40.0688 11.2266C40.5059 13.2555 40.818 16.0064 42.9572 18.8104" stroke="black" stroke-width="0.34"/>
                             <path d="M2.56512 6.7041C2.1779 8.25743 1.60009 10.0607 0.0922852 11.0365" stroke="black" stroke-width="0.34"/>
                         </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-hero__monkey-container-content">
            <?php if (!empty($title)) :
                // Disallow automatic <p> wrappers while still sanitizing content
                $title_allowed_tags = wp_kses_allowed_html('post');
                unset($title_allowed_tags['p']);
                ?>
                <h1 class="block-hero__title text-center">
                    <?php echo wp_kses($title, $title_allowed_tags); ?>
                </h1>
            <?php endif; ?>
            <?php if (!empty($section_description)) : ?>
                <div class="block-hero__description text-center">
                    <?php echo wp_kses_post($section_description); ?>
                </div>
            <?php endif; ?>
            <?php if ($button):?>
                <div class="block-hero__button text-center">
                    <a class="btn btn-secondary_black" href="<?php echo esc_url($button['url']); ?>"
                       target="<?php echo esc_attr($button['target']); ?>"><?php echo esc_html($button['title']); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <div class="block-hero__rounded-element">
            <div class="block-hero__rounded-element-inner"></div>
        </div>
    </div>
    <div class="block-hero__decoration-small">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/public/images/acf-blocks/dec-sm.svg' ); ?>" alt="<?php esc_attr_e( 'Monkey illustration', 'wp-rock' ); ?>">
    </div>
    <div class="block-hero__decoration-big">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/public/images/acf-blocks/dec-big.svg' ); ?>" alt="<?php esc_attr_e( 'Monkey illustration', 'wp-rock' ); ?>">
    </div>
</section>
