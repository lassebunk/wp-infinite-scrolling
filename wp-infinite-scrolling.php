<?php
/**
 * Plugin Name: WP Infinite Scrolling
 * Plugin URI: https://github.com/lassebunk/wp-infinite-scrolling
 * Description: Enable infinite scrolling on your WordPress blog.
 * Version: 1.0.2
 * Author: Lasse Bunk
 * Author URI: https://github.com/lassebunk
 * License: GPLv2 or later
 */

function wpifs_defaults() {
  return array(
    'enabled'             => 1,
    'container_selector'  => '.posts',
    'post_selector'       => '.post',
    'pagination_selector' => '.pagination',
    'next_selector'       => 'a.next',
    'loading_html'        => '<div style="text-align: center;"><img src="' . plugins_url( 'img/spinner.gif', __FILE__ ) . '" width="32" height="32" /></div>'
  );
}

function wpifs_option( $key ) {
  return get_option( "wpifs_{$key}", wpifs_defaults()[$key] );
}

function wpifs_plugin_basename() {
  return plugin_basename(__FILE__);
}

function wpifs_add_scripts() {
  wp_register_script( 'jquery.sifs', plugins_url( 'js/jquery.sifs.js', __FILE__ ), array( 'jquery' ) );
  wp_register_script( 'wpifs', plugins_url( 'js/wpifs.js', __FILE__ ), array( 'jquery.sifs' ) );
  wp_localize_script(
    'wpifs', 'wpifs_options',
    array(
      'container'  => wpifs_option( 'container_selector' ),
      'post'       => wpifs_option( 'post_selector' ),
      'pagination' => wpifs_option( 'pagination_selector' ),
      'next'       => wpifs_option( 'next_selector' ),
      'loading'    => wpifs_option( 'loading_html' )
    )
  );
  wp_enqueue_script( 'jquery.sifs' );
  wp_enqueue_script( 'wpifs' );
}

if ( is_admin() ) {
  require_once( dirname(__FILE__) . '/admin.php' );
}

if ( wpifs_option('enabled') ) {
  add_action( 'wp_enqueue_scripts', 'wpifs_add_scripts' );
}