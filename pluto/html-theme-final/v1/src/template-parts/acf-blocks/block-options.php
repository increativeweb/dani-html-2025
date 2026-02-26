<?php
/**
 * Block - Options
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
$hide_section   = get_field_value($block_fields, 'hide_section');
$title          = get_field_value($block_fields, 'title');
$subtitle       = get_field_value($block_fields, 'subtitle');
$description    = get_field_value($block_fields, 'description');
$options        = get_field_value($block_fields, 'options');
$monkey_element = get_field_value($block_fields, 'monkey_element');
?>

<?php if ( ! $hide_section ) { ?>
    <section <?php echo $attrs['id_attr'] . ' ' . $attrs['class_attr'] . $attrs['disabled_attr']; ?>>
        <div class="container">
            <div class="text-center d-flex flex-column">
                <?php if ( $subtitle ) { ?>
                    <h3 class="block-options__sub-title"><?php echo esc_html( $subtitle ); ?></h3>
                <?php } ?>
                <?php if ( $title ) { ?>
                    <h2 class="block-options__title"><?php echo wp_kses_post( $title ); ?></h2>
                <?php } ?>

                <?php if ( $description ) { ?>
                    <div class="block-options__description"><?php echo wp_kses_post( $description ); ?></div>
                <?php } ?>
            </div>

            <?php if ( $options ) { ?>
                <?php
                // First two options grouped together, third (marked as 3rd_section) rendered separately.
                $first_two  = array_slice( $options, 0, 2 );
                $third_item = null;

                foreach ( $options as $opt ) {
                    if ( ! empty( $opt['3rd_section'] ) ) {
                        $third_item = $opt;
                        break;
                    }
                }
                ?>

                <div class="block-options__options">
                    <?php if ( $first_two ) { ?>
                        <div class="block-options__options-top flex">
                            <?php foreach ( $first_two as $index => $option ) { ?>
                                <?php
                                $opt_title   = $option['title'] ?? '';
                                $opt_sub     = $option['subtitle'] ?? '';
                                $opt_image   = $option['image'] ?? 0;
                                $opt_content = $option['content'] ?? '';
                                ?>
                                <div class="block-options__option<?php echo 0 === (int) $index ? ' first' : ''; ?>">                                    
                                    <div class="text-center d-flex flex-column">
                                        <?php if ( $opt_title ) { ?>
                                            <div class="block-options__option-title"><?php echo esc_html( $opt_title ); ?></div>
                                        <?php } ?>
                                        <?php if ( $opt_sub ) { ?>
                                            <h3 class="block-options__option-subtitle"><?php echo esc_html( $opt_sub ); ?></h3>
                                        <?php } ?>
                                    </div>
                                    <?php if ( $opt_image ) { ?>
                                        <figure class="block-options__option-image">
                                            <?php echo wp_get_attachment_image( $opt_image, 'medium', false, array( 'class' => 'block-options__img' ) ); ?>
                                        </figure>
                                    <?php } ?>

                                    <div class="block-options__option-body">
                                        <?php if ( $opt_content ) { ?>
                                            <div class="block-options__option-content"><?php echo wp_kses_post( $opt_content ); ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ( $monkey_element ) { ?>
                                <div class="block-options__monkey-element">
                                     <img src="<?php echo esc_url( $monkey_element ); ?>" alt="Monkey-element" />
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ( $third_item ) { ?>
                        <?php
                        $third_title   = $third_item['title'] ?? '';
                        $third_sub     = $third_item['subtitle'] ?? '';
                        $third_content = $third_item['content'] ?? '';
                        $third_text    = $third_item['additional_text'] ?? '';
                        $third_btn     = $third_item['button_text'] ?? '';
                        ?>
                        <div class="block-options__third">
                            <div class="block-options__third-inner">
                                <div class="text-center d-flex flex-column">
                                    <?php if ( $third_title ) { ?>
                                        <div class="block-options__option-title"><?php echo esc_html( $third_title ); ?></div>
                                    <?php } ?>
                                    <?php if ( $third_sub ) { ?>
                                        <h3 class="block-options__option-subtitle"><?php echo esc_html( $third_sub ); ?></h3>
                                    <?php } ?>
                                </div>

                                <div class="block-options__third-body">
                                    <?php if ( $third_text ) { ?>
                                        <div class="block-options__third-extra"><?php echo wp_kses_post( $third_text ); ?></div>
                                    <?php } ?>

                                    <?php if ( $third_btn ) { ?>
                                        <div class="block-options__element-container">
                                            <div class="block-options__element-wrapper">
                                                <div class="block-options__element-text" data-text="<?php echo esc_attr( $third_btn ); ?>"></div>
                                                <div class="block-options__element first-element">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="87" height="105" viewBox="0 0 87 105" fill="none">
                                                        <path d="M12.0706 14.6134V74.5274C12.0706 81.3063 20.5501 84.371 24.8841 79.1585L39.8297 61.1833C41.1179 59.634 42.9931 58.6913 45.005 58.5816L66.452 57.4117C73.1803 57.0447 75.8061 48.4944 70.4436 44.4142L23.7004 8.84873C18.9317 5.22034 12.0706 8.62121 12.0706 14.6134Z" fill="black" stroke="black" stroke-width="3.21938"/>
                                                        <path d="M1.6097 24.2716V84.1856C1.6097 90.9645 10.0891 94.0292 14.4231 88.8167L29.3688 70.8415C30.6569 69.2922 32.5322 68.3495 34.5441 68.2398L55.991 67.0699C62.7193 66.7029 65.3452 58.1526 59.9827 54.0724L13.2395 18.5069C8.47071 14.8785 1.6097 18.2794 1.6097 24.2716Z" fill="#C1F174" stroke="black" stroke-width="3.21938"/>
                                                    </svg>
                                                </div>
                                                <div class="block-options__element second-element">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="129" height="125" viewBox="0 0 129 125" fill="none">
                                                        <path d="M67.409 15.5866L23.5355 56.3886C18.5715 61.0051 22.1019 69.3015 28.8703 68.9254L52.2112 67.6284C54.223 67.5167 56.1904 68.2478 57.6408 69.6463L73.1031 84.5547C77.9539 89.2318 86.0033 85.3318 85.3392 78.6263L79.5503 20.177C78.9597 14.214 71.797 11.5059 67.409 15.5866Z" fill="black" stroke="black" stroke-width="3.21938"/>
                                                        <path d="M58.5497 9.95185L14.6761 50.7539C9.71209 55.3704 13.2425 63.6667 20.0109 63.2906L43.3518 61.9937C45.3636 61.8819 47.331 62.6131 48.7815 64.0116L64.2437 78.92C69.0945 83.597 77.1439 79.697 76.4798 72.9915L70.6909 14.5422C70.1004 8.57925 62.9376 5.87112 58.5497 9.95185Z" fill="#FFCBCB" stroke="black" stroke-width="3.21938"/>
                                                    </svg>
                                                </div>
                                                <div class="block-options__element third-element">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="106" height="113" viewBox="0 0 106 113" fill="none">
                                                        <path d="M101.339 78.8194L85.3652 21.0741C83.5578 14.5406 74.5682 13.8477 71.7808 20.027L62.1687 41.3363C61.3403 43.173 59.7842 44.5816 57.8745 45.2237L37.5157 52.0694C31.1288 54.217 30.8777 63.158 37.134 65.6607L91.6676 87.4761C97.2312 89.7017 102.937 84.5947 101.339 78.8194Z" fill="black" stroke="black" stroke-width="3.21938"/>
                                                        <path d="M92.6832 77.0616L76.7089 19.3163C74.9015 12.7828 65.9119 12.0899 63.1246 18.2692L53.5125 39.5785C52.684 41.4152 51.128 42.8238 49.2182 43.4659L28.8595 50.3116C22.4726 52.4592 22.2214 61.4001 28.4777 63.9029L83.0114 85.7183C88.5749 87.9439 94.2808 82.8369 92.6832 77.0616Z" fill="#FA673A" stroke="black" stroke-width="3.21938"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ( $third_content ) { ?>
                                        <div class="block-options__third-content"><?php echo wp_kses_post( $third_content ); ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>
