<?php
/**
 * Enqueue parent styles
 */
function my_theme_enqueue_styles() { 
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Remove gutenberg block library
 */
function caringmedic_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'caringmedic_remove_wp_block_library_css', 100 );

/**
 * Remove WP give styles for all pages except donate page
 */
function caringmedic_remove_give_css(){
  if (!(is_page('donate'))) {
    wp_dequeue_style( 'give-styles' );
    wp_dequeue_style( 'give_recurring_css' );
  }
} 
add_action( 'wp_enqueue_scripts', 'caringmedic_remove_give_css', 100 );

/**
 * Remove wp-page navi styles since we have our own styles for the pagination
 */
function caringmedic_remove_pagenavi_css(){
    wp_dequeue_style( 'wp-pagenavi' );
} 
add_action( 'wp_enqueue_scripts', 'caringmedic_remove_pagenavi_css', 100 );

/**
 * Remove search and filter plugin styles since we have our own styles for the searched elements
 */
function caringmedic_remove_searchfilter_css(){
    wp_dequeue_style( 'search-filter-plugin-styles' );
} 
add_action( 'wp_enqueue_scripts', 'caringmedic_remove_searchfilter_css', 100 );


/**
 * Remove dashicons for non admins
 */
function caringmedic_dequeue_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'caringmedic_dequeue_dashicon' );

/**
 * Defer JS
 */
function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    if ( strpos( $url, 'jquery.min.js' ) ) return $url;
    if ( strpos( $url, 'jquery-migrate.min.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );