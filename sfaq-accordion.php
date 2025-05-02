<?php
/**
 * Plugin Name: Simple FAQ Accordion
 * Description: Provides a shortcode [faq] to create an accessible accordion for FAQs.
 * Version: 1.0.0
 * Author: Param Chandarana
 * Text Domain: sfaq-accordion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Enqueue scripts and styles
function sfaq_enqueue_assets() {
    wp_register_style( 'sfaq-accordion-style', false );
    wp_enqueue_style( 'sfaq-accordion-style' );
    $css = "
    .sfaq-accordion-item { border-bottom: 1px solid #ddd; margin-bottom: 10px; }
    .sfaq-accordion-title { cursor: pointer; padding: 10px; background: #f1f1f1; }
    .sfaq-accordion-content { display: none; padding: 10px; }
    .sfaq-accordion-title.active + .sfaq-accordion-content { display: block; }";
    wp_add_inline_style( 'sfaq-accordion-style', $css );

    wp_register_script( 'sfaq-accordion-script', false, array(), false, true );
    wp_enqueue_script( 'sfaq-accordion-script' );
    $js = "
    document.addEventListener('DOMContentLoaded', function() {
        var titles = document.querySelectorAll('.sfaq-accordion-title');
        titles.forEach(function(title) {
            title.addEventListener('click', function() {
                this.classList.toggle('active');
                var content = this.nextElementSibling;
                if (content.style.display === 'block') {
                    content.style.display = 'none';
                } else {
                    content.style.display = 'block';
                }
            });
        });
    });";
    wp_add_inline_script( 'sfaq-accordion-script', $js );
}
add_action( 'wp_enqueue_scripts', 'sfaq_enqueue_assets' );

// Shortcode handler
function sfaq_accordion_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title' => 'FAQ Title',
    ), $atts, 'faq' );

    $output  = '<div class="sfaq-accordion-item">';
    $output .= '<div class="sfaq-accordion-title">' . esc_html( $atts['title'] ) . '</div>';
    $output .= '<div class="sfaq-accordion-content">' . do_shortcode( $content ) . '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode( 'faq', 'sfaq_accordion_shortcode' );

// Uninstall
register_uninstall_hook( __FILE__, 'sfaq_uninstall' );
function sfaq_uninstall() {
    // No cleanup needed
}
