<?php

/*
Plugin Name: CT Test Form
Description: Test form for Cleantalk Spam Protect plugin.
Version: 1.0
Author: Cleantalk
*/

add_action('wp_enqueue_scripts', 'ct_test_form_styles');
function ct_test_form_styles() 
{
    wp_enqueue_style('ct-test-form', plugin_dir_url(__FILE__) . 'css/ct-test-form.css');
}

add_action('wp_enqueue_scripts', 'ct_test_form_scripts');
function ct_test_form_scripts()
{
   wp_enqueue_script(
       'ct-test-form-js',
       plugin_dir_url(__FILE__) . 'js/ct-test-form.js',
       array('jquery'),
       '1.0.0',
       true
   );
}

require_once plugin_dir_path(__FILE__) . 'inc/ct-test-form.php';
require_once plugin_dir_path(__FILE__) . 'inc/ct-test-form-ajax.php';
