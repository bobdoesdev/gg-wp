<?php

/**
 * Plugin name: Wistia Video
 * Author: Bob O'Brien
 * Author URI: http://www.bobdoesdev.com/
 * Description:
 * Version: 1.0
 */

// Sanity check.
if (!defined('ABSPATH')) die('Direct access is not allowed.');

//cpt
include('backend/custom-post-type.php');
include('backend/login.php');

/**
 * Main init function.
 */
function boilerplate_init()
{

  if (is_admin()) {
    return;
  }

  // Start the session if it hasn't been started yet.
  if (!session_id()) {
    session_start();
  }

  // Add necessary scripts.
  // wp_enqueue_script('boilerplate-ajax-request', WP_PLUGIN_URL . '/wistia-video/frontend/assets/boilerplate.js', array('jquery'));

  wp_enqueue_script('ev-1', 'https://fast.wistia.com/assets/external/E-v1.js#asyncload');



  wp_enqueue_style('boilerplate-frontend-style', WP_PLUGIN_URL . '/wistia-video/frontend/assets/boilerplate-frontend.css', time());
  wp_enqueue_script('wistia-frontend-script', WP_PLUGIN_URL . '/wistia-video/frontend/assets/js/boilerplate-frontend.min.js#asyncload', array('jquery', 'ev-1'), time());

  wp_localize_script('wistia-frontend-script', 'localized', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('boilerplate-post-nonce'),
  ));

  // Hook our cron.
  if (!wp_next_scheduled('boilerplate_execute_cron')) {
    wp_schedule_event(current_time('timestamp'), 'every_minute', 'boilerplate_execute_cron');
  }
}

/**
 * Cron function.
 */
function boilerplate_cron()
{

  //

}

/**
 * Administrator init function.
 */
function boilerplate_admin_init()
{
  if (!is_admin()) {
    return;
  }
  // Add admin CSS and JS.
  wp_enqueue_style('boilerplate-style-admin', WP_PLUGIN_URL . '/wistia-video/backend/assets/boilerplate-backend.css');
  wp_enqueue_style('thickbox');
  wp_enqueue_script('boilerplate-script-admin', WP_PLUGIN_URL . '/wistia-video/backend/assets/js/boilerplate-backend.min.js', array('jquery'));

  wp_enqueue_script('media-upload');
}



/**
 * Actions.
 */
add_action('init', 'boilerplate_init');
add_action('admin_init', 'boilerplate_admin_init');
// add_action('wp_ajax_boilerplate_ajax', 'boilerplate_ajax');


