<?php

function ajax_check_user_logged_in()
{
    echo is_user_logged_in() ? 'yes' : 'no';
    die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');


function ajax_login()
{
    parse_str($_POST['form_data'], $form_data);
    // First check the nonce, if it fails the function will break
    if (!wp_verify_nonce($form_data['ajax-login-nonce'], 'ajax-login-nonce')) {
        wp_send_json_error('Sorry, we could not validate your security token. Please refresh the page and try again.');
    };

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $form_data['username'];
    $info['user_password'] = $form_data['password'];
    $info['remember'] = true;

    $user_signon = wp_signon($info, false);
    if (is_wp_error($user_signon)) {
        wp_send_json_success(array('loggedin' => false, 'message' => __('Wrong username or password. Please try again.')));
    } else {
        wp_send_json_success(array('loggedin' => true, 'message' => __('Thanks for logging in!')));
    }
}

add_action('wp_ajax_ajax_login', 'ajax_login');
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');

//utility function
if (!function_exists('write_log')) {
    function write_log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}
