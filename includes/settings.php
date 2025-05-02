<?php
/**
 * Settings page for FAQ Accordion plugin.
 *
 * This file adds an admin settings page where users can customize
 * background colors and icons used in the accordion.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'sfaq_add_settings_page' );
add_action( 'admin_init', 'sfaq_register_settings' );

/**
 * Register submenu under Settings in WP Admin.
 */
function sfaq_add_settings_page() {
    add_options_page(
        'FAQ Accordion Settings',
        'FAQ Accordion',
        'manage_options',
        'sfaq-accordion',
        'sfaq_render_settings_page'
    );
}

/**
 * Register settings, sections, and fields for the plugin.
 */
function sfaq_register_settings() {
    register_setting( 'sfaq_accordion_group', 'sfaq_accordion_options', 'sfaq_sanitize_options' );
    add_settings_section( 'sfaq_main_section', 'Appearance Settings', '__return_null', 'sfaq-accordion' );

    $fields = [
        'title_bg'    => 'Title Background Color',
        'content_bg'  => 'Content Background Color',
        'icon_open'   => 'Open Icon',
        'icon_closed' => 'Closed Icon',
    ];

    // Register each field using a common rendering function.
    foreach ( $fields as $id => $label ) {
        add_settings_field(
            $id,
            $label,
            'sfaq_render_field',
            'sfaq-accordion',
            'sfaq_main_section',
            [ 'id' => $id ]
        );
    }

    // Set default options if not yet defined
    if ( false === get_option( 'sfaq_accordion_options' ) ) {
        update_option( 'sfaq_accordion_options', [
            'title_bg'    => '#f1f1f1',
            'content_bg'  => '#fff',
            'icon_open'   => '–',
            'icon_closed' => '+',
        ] );
    }
}

/**
 * Render a single settings input field.
 *
 * @param array $args Contains 'id' of the setting field.
 */
function sfaq_render_field( $args ) {
    $opts = get_option( 'sfaq_accordion_options' );
    printf(
        '<input type="text" id="%1$s" name="sfaq_accordion_options[%1$s]" value="%2$s" class="regular-text">',
        esc_attr( $args['id'] ),
        esc_attr( $opts[ $args['id'] ] )
    );
}

/**
 * Sanitize user input from settings form.
 *
 * @param array $input Raw input values.
 * @return array Cleaned and sanitized inputs.
 */
function sfaq_sanitize_options( $input ) {
    $clean = [];
    foreach ( $input as $key => $value ) {
        $clean[ $key ] = sanitize_text_field( $value );
    }
    return $clean;
}

/**
 * Render the plugin's settings page HTML.
 */
function sfaq_render_settings_page() { ?>
    <div class="wrap">
        <h1>FAQ Accordion Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'sfaq_accordion_group' );
            do_settings_sections( 'sfaq-accordion' );
            submit_button();
            ?>
        </form>
    </div>
<?php }
