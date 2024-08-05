<?php
// Enable theme support for block styles
add_action('after_setup_theme', 'jms_studio_setup');
function jms_studio_setup() {
    add_theme_support('wp-block-styles');
}

// CSS embed
if ( ! function_exists( 'jms_studio_locale_css' ) ) :
    function jms_studio_locale_css( $uri ) {
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
            $uri = get_template_directory_uri() . '/rtl.css';
        }
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'jms_studio_locale_css' );

// Ensure the theme's CSS overrides plugin CSS
if ( ! function_exists( 'jms_studio_configurator_css' ) ) :
    function jms_studio_configurator_css() {
        // Enqueue the theme's main stylesheet
        // Adjust the version number as needed, e.g., '1.0.0' or use file modification time for automatic cache busting
        wp_enqueue_style( 'jms_studio_cfg_separate', get_template_directory_uri() . '/css/jms-studio-style.css', array(), filemtime( get_template_directory() . '/css/jms-studio-style.css' ) );    
    }
endif;
add_action( 'wp_enqueue_scripts', 'jms_studio_configurator_css', 100 );

// Enqueue the back-to-top JavaScript file
if ( ! function_exists( 'jms_studio_javascript' ) ) :
    function jms_studio_javascript() {
        wp_enqueue_script( 'jms_studio-back-to-top', get_template_directory_uri() . '/js/jms-studio-back-to-top.js', array(), null, true );
    }
endif;
add_action( 'wp_enqueue_scripts', 'jms_studio_javascript' );

// Localize script to pass dynamic data to the JavaScript file
if ( ! function_exists( 'jms_studio_localize_script' ) ) :
    function jms_studio_localize_script() {
        wp_localize_script( 'jms_studio-back-to-top', 'jms_studio_vars', array(
            'back_to_top_icon' => esc_url( get_template_directory_uri() . '/assets/images/up-arrow.svg' )
        ));
    }
endif;
add_action( 'wp_enqueue_scripts', 'jms_studio_localize_script' );
?>