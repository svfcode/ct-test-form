<?php

add_shortcode('ct_test_form_ajax', 'ct_test_form_display_ajax');
function ct_test_form_display_ajax()
{
   ob_start();
   ?>
   <form id="ct-test-form" class="ct-test-form">
       <div class="form-group">
           <input type="text" name="name" placeholder="Your Name" required>
       </div>
       <div class="form-group">
           <input type="email" name="email" placeholder="Your Email" required>
       </div>
       <div class="form-group">
           <textarea name="message" placeholder="Your Message" required></textarea>
       </div>
       <div class="form-response"></div>
       <button type="submit">Submit</button>
   </form>
   <?php
   return ob_get_clean();
}

add_action('wp_ajax_ct_test_form_submit', 'ct_test_form_ajax');
add_action('wp_ajax_nopriv_ct_test_form_submit', 'ct_test_form_ajax');
function ct_test_form_ajax()
{
   // Process form data here
   $name = sanitize_text_field($_POST['name']);
   $email = sanitize_email($_POST['email']);
   $message = sanitize_textarea_field($_POST['message']);
   
    // check if form is spam
    $result = apply_filters('ct_wordpress_protect_from_spam', $_POST);
    if ($result['is_spam']) {
        wp_send_json_error([
            'status' => 'error',
            'message' => $result['message'],
            'is_spam' => $result['is_spam']
        ]);
    }

    // do something with form data
    // ...

    wp_send_json_success([
        'status' => 'success',
        'message' => 'Form submitted successfully!',
        'is_spam' => $result['is_spam']
    ]);
}