<?php // options page

/**
 * custom option and settings
 */
function fs_wp_settings_init() {
    // register a new setting for "fs_wp" page
    register_setting( 
        'fs_wp',                                // Option Group
        'fs_wp_options',                        // Option Name
        'fs_wp_sanitize_inputs'                 // Sanitize callback
    );
     
    // Flexslider Settings section
    add_settings_section(
        'fs_wp_section_choose_features',        // ID
        __( 'Flexslider Settings', 'fs_wp' ),   // Title
        'fs_wp_section_choose_features_cb',     // Callback
        'fs_wp'                                 // Page
    );

    // Flexslider Settings fields
    add_settings_field(
        'fs_wp_field_enqueue_flexslider',
        // use $args' label_for to populate the id inside the callback
        __( 'Enqueue Flexslider Script?', 'fs_wp' ),
        'fs_wp_field_enqueue_flexslider_cb',
        'fs_wp',
        'fs_wp_section_choose_features',
        [
            'label_for' => 'fs_wp_field_enqueue_flexslider',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'fs_wp_field_enqueue_css',
        // use $args' label_for to populate the id inside the callback
        __( 'Include default Flexslider CSS?', 'fs_wp' ),
        'fs_wp_field_enqueue_css_cb',
        'fs_wp',
        'fs_wp_section_choose_features',
        [
            'label_for' => 'fs_wp_field_enqueue_css',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'fs_wp_field_enable_gallery',
        // use $args' label_for to populate the id inside the callback
        __( 'Convert WordPress Galleries to Flexsliders?', 'fs_wp' ),
        'fs_wp_field_enable_gallery_cb',
        'fs_wp',
        'fs_wp_section_choose_features',
        [
            'label_for' => 'fs_wp_field_enable_gallery',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );

    // Flexslider Options section
    add_settings_section(
        'fs_wp_section_flexslider_options',         // ID
        __( 'Flexslider Options', 'fs_wp' ),        // Title
        'fs_wp_section_flexslider_options_cb',      // Callback
        'fs_wp'                                     // Page
    );

    // Flexslider Options fields
    add_settings_field(
        'fs_wp_field_animation_type',
        // use $args' label_for to populate the id inside the callback
        __( 'Animation Type', 'fs_wp' ),
        'fs_wp_field_animation_type_cb',
        'fs_wp',
        'fs_wp_section_flexslider_options',
        [
            'label_for' => 'fs_wp_field_animation_type',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'fs_wp_field_animation_autoplay',
        // use $args' label_for to populate the id inside the callback
        __( 'Autoplay', 'fs_wp' ),
        'fs_wp_field_animation_autoplay_cb',
        'fs_wp',
        'fs_wp_section_flexslider_options',
        [
            'label_for' => 'fs_wp_field_animation_autoplay',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'fs_wp_field_animation_speed',
        // use $args' label_for to populate the id inside the callback
        __( 'Animation Speed', 'fs_wp' ),
        'fs_wp_field_animation_speed_cb',
        'fs_wp',
        'fs_wp_section_flexslider_options',
        [
            'label_for' => 'fs_wp_field_animation_speed',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );

    add_settings_field(
        'fs_wp_field_slider_height',
        // use $args' label_for to populate the id inside the callback
        __( 'Adjust Slider Height', 'fs_wp' ),
        'fs_wp_field_slider_height_cb',
        'fs_wp',
        'fs_wp_section_flexslider_options',
        [
            'label_for' => 'fs_wp_field_slider_height',
            'class' => 'fs_wp_row',
            'fs_wp_custom_data' => 'custom',
        ]
    );
}
add_action( 'admin_init', 'fs_wp_settings_init' );
 
/**
 * custom option and settings:
 * callback functions
 */
 
// sanitization function
// see https://tommcfarlin.com/sanitizing-arrays-the-wordpress-settings-api/

function fs_wp_sanitize_inputs( $input ) {
    
    // Initialize the new array that will hold the sanitize values
    $new_input = array();
    // Loop through the input and sanitize each of the values
    foreach ( $input as $key => $val ) {
        
        $new_input[ $key ] = ( isset( $input[ $key ] ) ) ? sanitize_text_field( $val ) : '';
    }
    return $new_input;
}
 
// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function fs_wp_section_choose_features_cb( $args ) { ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Settings for the flexslider plugin', 'fs_wp' ); ?></p>
 <?php }

 function fs_wp_section_flexslider_options_cb( $args ) { ?>
 <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Common settings for all flexsliders used on your site, if you are using Enqueue Flexslider Script above', 'fs_wp' ); ?></p>
 <?php }
 
// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function fs_wp_field_enqueue_flexslider_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="yes" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'yes', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Yes', 'fs_wp' ); ?>
        </option>
        <option value="no" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'no', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'No', 'fs_wp' ); ?>
        </option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Default: Yes. Select no if another plugin or theme source already includes Flexslider.', 'fs_wp' ); ?>
    </p>
<?php }

function fs_wp_field_enqueue_css_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="yes" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'yes', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Yes', 'fs_wp' ); ?>
        </option>
        <option value="no" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'no', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'No', 'fs_wp' ); ?>
        </option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Default: Yes. Select no if you want to include the CSS another way, or write your own.', 'fs_wp' ); ?>
    </p>
<?php }

function fs_wp_field_enable_gallery_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="yes" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'yes', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Yes', 'fs_wp' ); ?>
        </option>
        <option value="no" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'no', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'No', 'fs_wp' ); ?>
        </option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Default: Yes. Select no if you would like to use standard WordPress galleries instead of converting them to Flexsliders', 'fs_wp' ); ?>
    </p>
<?php }

function fs_wp_field_animation_type_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="fade" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'fade', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Fade', 'fs_wp' ); ?>
        </option>
        <option value="slide" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'slide', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Slide', 'fs_wp' ); ?>
        </option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Select whether you want slider transition to Fade or Slide. Default: Fade. ', 'fs_wp' ); ?>
    </p>
<?php }

function fs_wp_field_animation_autoplay_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="true" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'true', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Yes', 'fs_wp' ); ?>
        </option>
        <option value="false" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'false', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'No', 'fs_wp' ); ?>
        </option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Select whether you want to autoplay the slider animation. Default: Yes. ', 'fs_wp' ); ?>
    </p>
<?php }

function fs_wp_field_slider_height_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="true" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'true', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'Yes', 'fs_wp' ); ?>
        </option>
        <option value="false" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'false', false ) ) : ( '' ); ?>>
        <?php esc_html_e( 'No', 'fs_wp' ); ?>
        </option>
    </select>
    <p class="description">
    <?php esc_html_e( 'Select whether you want the height of the slider to automatically adjust based on the content. Default: Yes.', 'fs_wp' ); ?>
    </p>
<?php }

function fs_wp_field_animation_speed_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'fs_wp_options' );
    // output the field
    ?>
    <input type="number" value="<?php echo $options['fs_wp_field_animation_speed'] ? esc_attr( $options['fs_wp_field_animation_speed'] ) : 5000; ?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['fs_wp_custom_data'] ); ?>" name="fs_wp_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
    </input>
    <p class="description">
    <?php esc_html_e( 'Input the speed you want the slider pause between slides, in milliseconds, if your slider is set to Autoplay. Default: 3000.', 'fs_wp' ); ?>
    </p>
<?php }
 
/**
 * Add to Settings Menu
 */
function fs_wp_options_page() {
    // add sublevel menu page
    add_submenu_page(
        'options-general.php',
        'Flexslider Options',
        'Flexslider Options',
        'manage_options',
        'fs_wp',
        'fs_wp_options_page_html'
    );
}
add_action( 'admin_menu', 'fs_wp_options_page' );
 
/**
 * Output HTML on Settings page
 */
function fs_wp_options_page_html() {
     // check user capabilities
     if ( ! current_user_can( 'manage_options' ) ) {
        return;
     }
     
     // add error/update messages
     
     // check if the user have submitted the settings
     // wordpress will add the "settings-updated" $_GET parameter to the url
     // if ( isset( $_GET['settings-updated'] ) ) {
     // // add settings saved message with the class of "updated"
     //    add_settings_error( 'fs_wp_messages', 'fs_wp_message', __( 'Settings Saved', 'fs_wp' ), 'updated' );
     // }
     
     // show error/update messages
     settings_errors( 'fs_wp_messages' ); ?>

     <div class="wrap">
         <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
         <form action="options.php" method="post">
             <?php
             // output security fields for the registered setting "fs_wp"
             settings_fields( 'fs_wp' );
             // output setting sections and their fields
             // (sections are registered for "fs_wp", each field is registered to a specific section)
             do_settings_sections( 'fs_wp' );
             // output save settings button
             submit_button( 'Save Settings' );
             ?>
         </form>
     </div>
<?php }