<?php
/**
 * Plugin Name: Simple FAQ Accordion
 * Description: FAQ accordion with toggle icons and default-open option.
 * Version: 1.1.0
 * Author: Param Chandarana
 * Text Domain: sfaq-accordion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue front-end assets (inline for simplicity)
 */
function sfaq_enqueue_assets() {
    if ( ! is_admin() ) {
        // CSS
        wp_register_style( 'sfaq-accordion-style', false );
        wp_enqueue_style( 'sfaq-accordion-style' );
        $css = "
        .sfaq-accordion-item { border-bottom:1px solid #ddd; margin-bottom:10px; }
        .sfaq-accordion-title { cursor:pointer; padding:10px; background:#f1f1f1; display:flex; align-items:center; }
        .sfaq-accordion-title .sfaq-icon { font-weight:bold; margin-right:8px; }
        .sfaq-accordion-content { display:none; padding:10px; }
        .sfaq-accordion-title.active + .sfaq-accordion-content { display:block; }
        ";
        wp_add_inline_style( 'sfaq-accordion-style', $css );

        // JS
        wp_register_script( 'sfaq-accordion-script', false, array(), false, true );
        wp_enqueue_script( 'sfaq-accordion-script' );
        $js = "
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.sfaq-accordion-item').forEach(function(item) {
                var title = item.querySelector('.sfaq-accordion-title');
                var icon = title.querySelector('.sfaq-icon');
                var content = item.querySelector('.sfaq-accordion-content');
                title.addEventListener('click', function() {
                    var isActive = title.classList.toggle('active');
                    icon.textContent = isActive ? '–' : '+';
                    content.style.display = isActive ? 'block' : 'none';
                });
            });
        });";
        wp_add_inline_script( 'sfaq-accordion-script', $js );
    }
}
add_action( 'wp_enqueue_scripts', 'sfaq_enqueue_assets' );

/**
 * Shortcode handler for [faq]
 * Supports default-open via open="true" attribute
 */
function sfaq_accordion_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title' => 'FAQ Title',
        'open'  => 'false',
    ), $atts, 'faq' );

    $is_open = filter_var( $atts['open'], FILTER_VALIDATE_BOOLEAN );
    $icon_char = $is_open ? '–' : '+';
    $title_class = $is_open ? 'sfaq-accordion-title active' : 'sfaq-accordion-title';
    $content_style = $is_open ? ' style="display:block;"' : '';

    $html  = '<div class="sfaq-accordion-item">';
    $html .= '<div class="' . esc_attr( $title_class ) . '">';
    $html .= '<span class="sfaq-icon">' . $icon_char . '</span>' . esc_html( $atts['title'] );
    $html .= '</div>';
    $html .= '<div class="sfaq-accordion-content"' . $content_style . '>' . do_shortcode( $content ) . '</div>';
    $html .= '</div>';

    return $html;
}
add_shortcode( 'faq', 'sfaq_accordion_shortcode' );
