<?php
/**
 * Plugin Name: Simple FAQ Accordion
 * Description: FAQ accordion with toggle icons, default-open option, external assets, and global settings.
 * Version: 1.3.0
 * Author: Param Chandarana
 * Text Domain: sfaq-accordion
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define constants for plugin path and URL.
if ( ! defined( 'sfaq_PATH' ) ) define( 'sfaq_PATH', plugin_dir_path( __FILE__ ) );
if ( ! defined( 'sfaq_URL'  ) ) define( 'sfaq_URL',  plugin_dir_url( __FILE__ ) );

// Include the settings file for admin configuration.
require_once sfaq_PATH . 'includes/settings.php';

/**
 * Enqueue front-end styles and scripts for accordion functionality.
 */
function sfaq_enqueue_assets() {
    if ( ! is_admin() ) {
        // Load options
        $opts = get_option( 'sfaq_accordion_options', [] );

        // Enqueue external stylesheet.
        wp_enqueue_style(
            'sfaq-accordion-style',
            sfaq_URL . 'css/accordion.css',
            array(),
            '1.2.0'
        );

        // Add inline CSS variables from settings.
        if ( ! empty( $opts ) ) {
            $vars = sprintf(
                ':root { --sfaq-title-bg: %1$s; --sfaq-content-bg: %2$s; }',
                esc_attr( $opts['title_bg'] ),
                esc_attr( $opts['content_bg'] )
            );
            wp_add_inline_style( 'sfaq-accordion-style', $vars );
        }

        // Enqueue external script with toggle logic.
        wp_enqueue_script(
            'sfaq-accordion-script',
            sfaq_URL . 'js/accordion.js',
            array(),
            '1.2.0',
            true
        );

        // Localize icons for open/closed state from settings.
        if ( ! empty( $opts ) ) {
            wp_localize_script( 'sfaq-accordion-script', 'sfaqSettings', array(
                'iconOpen'   => $opts['icon_open'],
                'iconClosed' => $opts['icon_closed'],
            ) );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'sfaq_enqueue_assets' );

/**
 * Shortcode handler for [faq] block.
 *
 * @param array  $atts    Shortcode attributes (title, open).
 * @param string $content Content within the shortcode.
 * @return string         Rendered HTML of accordion.
 */
function sfaq_accordion_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title' => 'FAQ Title',
        'open'  => 'false',
    ), $atts, 'faq' );

    $is_open    = filter_var( $atts['open'], FILTER_VALIDATE_BOOLEAN );
    $icon_char  = $is_open ? get_option( 'sfaq_accordion_options' )['icon_open'] : get_option( 'sfaq_accordion_options' )['icon_closed'];
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
