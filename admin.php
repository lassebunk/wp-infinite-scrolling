<?php
add_action( 'admin_menu', 'wpifs_add_admin_menu' );
add_action( 'admin_init', 'wpifs_settings_init' );
add_filter( 'plugin_action_links_' . wpifs_plugin_basename(), 'wpifs_plugin_action_links' );

function wpifs_plugin_action_links ( $links ) {
  $mylinks = array(
    '<a href="' . admin_url( 'options-general.php?page=wp-infinite-scrolling' ) . '">Settings</a>',
  );
  return array_merge( $links, $mylinks );
}

function wpifs_add_admin_menu() {
  add_options_page( 'Infinite scrolling', 'Infinite scrolling', 'manage_options', 'wp-infinite-scrolling', 'wpifs_options_page' );
}

function wpifs_settings_init() {
  register_setting( 'wpifs-settings', 'wpifs_container_selector' );
  register_setting( 'wpifs-settings', 'wpifs_post_selector' );
  register_setting( 'wpifs-settings', 'wpifs_enabled' );
  register_setting( 'wpifs-settings', 'wpifs_pagination_selector' );
  register_setting( 'wpifs-settings', 'wpifs_next_selector' );
  register_setting( 'wpifs-settings', 'wpifs_loading_html' );

  // Settings section

  add_settings_section(
    'wpifs_settings_section',
    __( 'Settings', 'wpifs' ),
    'wpifs_settings_section_render',
    'wpifs-settings'
  );

  add_settings_field(
    'wpifs_enabled',
    __( 'Enable infinite scrolling', 'wpifs' ),
    'wpifs_enabled_render',
    'wpifs-settings',
    'wpifs_settings_section'
  );

  add_settings_field(
    'wpifs_container_selector',
    __( 'Post container selector', 'wpifs' ),
    'wpifs_container_selector_render',
    'wpifs-settings',
    'wpifs_settings_section'
  );

  add_settings_field(
    'wpifs_post_selector',
    __( 'Post selector', 'wpifs' ),
    'wpifs_post_selector_render',
    'wpifs-settings',
    'wpifs_settings_section'
  );

  add_settings_field(
    'wpifs_pagination_selector',
    __( 'Pagination selector', 'wpifs' ),
    'wpifs_pagination_selector_render',
    'wpifs-settings',
    'wpifs_settings_section'
  );

  add_settings_field(
    'wpifs_next_selector',
    __( 'Next link selector', 'wpifs' ),
    'wpifs_next_selector_render',
    'wpifs-settings',
    'wpifs_settings_section'
  );

  add_settings_field(
    'wpifs_loading_html',
    __( 'Loading HTML', 'wpifs' ),
    'wpifs_loading_html_render',
    'wpifs-settings',
    'wpifs_settings_section'
  );
}


function wpifs_enabled_render() {
  ?>
  <label>
    <input type='checkbox' name='wpifs_enabled' <?php checked(wpifs_option('enabled'), 1); ?> value='1'>
    Enable infinite scrolling
  </label>
  <?php
}

function wpifs_container_selector_render() {
  ?>
  <input type='text' name='wpifs_container_selector' value='<?php echo wpifs_option('container_selector'); ?>'>
  <?php
}


function wpifs_post_selector_render() {
  ?>
  <input type='text' name='wpifs_post_selector' value='<?php echo wpifs_option('post_selector'); ?>'>
  <?php
}

function wpifs_pagination_selector_render() {
  ?>
  <input type='text' name='wpifs_pagination_selector' value='<?php echo wpifs_option('pagination_selector'); ?>'>
  <?php
}


function wpifs_next_selector_render() {
  ?>
  <input type='text' name='wpifs_next_selector' value='<?php echo wpifs_option('next_selector'); ?>'>
  <?php
}


function wpifs_loading_html_render() {
  ?>
  <?php wp_editor(wpifs_option('loading_html'), 'wpifs_loading_html'); ?>
  <?php
}

function wpifs_settings_section_render() {
  ?>
  <p>
    <a href="<?php echo plugins_url( 'img/admin-mockup.png', __FILE__ ) ?>" class="thickbox" target="_blank">See how selectors are defined</a>
  </p>
  <?php
}


function wpifs_options_page() {
  ?>
  <form action='options.php' method='post'>
   
    <h2>WP Infinite Scrolling</h2>

    <p>
      Here you can adjust settings for infinite scrolling on your blog.
    </p>

    <?php
    settings_fields( 'wpifs-settings' );
    do_settings_sections( 'wpifs-settings' );
    submit_button();
    ?>
   
  </form>
  <?php

}