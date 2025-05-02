<?php
/**
 * Plugin Name: Simple FAQ Accordion
 * Description: FAQ accordion with toggle icons, default-open option, and external asset files.
 * Version: 1.2.0
 * Author: Param Chandarana
 * Text Domain: sfaq-accordion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin paths
if ( ! defined( 'sfaq_PATH' ) ) define( 'sfaq_PATH', plugin_dir_path( __FILE__ ) );
if ( ! defined( 'sfaq_URL'  ) ) define( 'sfaq_URL',  plugin_dir_url( __FILE__ ) );

/**
 * Enqueue front-end CSS and JS from external files
 */
function sfaq_enqueue_assets() {
    if ( ! is_admin() ) {
        // Stylesheet
        wp_enqueue_style(
            'sfaq-accordion-style',
            sfaq_URL . 'css/accordion.css',
            array(),
            '1.3.0'
        );

        // Script
        wp_enqueue_script(
            'sfaq-accordion-script',
            sfaq_URL . 'js/accordion.js',
            array(),
            '1.3.0',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'sfaq_enqueue_assets' );

/**
 * Shortcode handler for [faq] with icons and default-open
 */
function sfaq_accordion_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title' => 'FAQ Title',
        'open'  => 'false',
    ), $atts, 'faq' );

    $is_open    = filter_var( $atts['open'], FILTER_VALIDATE_BOOLEAN );
    $icon_char  = $is_open ? '–' : '+';
    $title_cls  = $is_open ? 'sfaq-accordion-title active' : 'sfaq-accordion-title';
    $content_ds = $is_open ? ' style="display:block;"' : '';

    $html  = '<div class="sfaq-accordion-item">';
    $html .= '<div class="' . esc_attr( $title_cls ) . '">';
    $html .= '<span class="sfaq-icon">' . esc_html( $icon_char ) . '</span>' . esc_html( $atts['title'] );
    $html .= '</div>';
    $html .= '<div class="sfaq-accordion-content"' . $content_ds . '>' . do_shortcode( $content ) . '</div>';
    $html .= '</div>';

    return $html;
}
add_shortcode( 'faq', 'sfaq_accordion_shortcode' );
