<?php

add_shortcode('ct_test_form', 'ct_test_form_display');
function ct_test_form_display() {
   ob_start();

   // Show success message if form was submitted
   if (isset($_GET['submission']) && $_GET['submission'] === 'success') {
       echo '<div class="ct-form-success">Thank you for your submission!</div>';
   }

   // Show spam message if form was submitted
   if (isset($_GET['submission']) && $_GET['submission'] === 'spam') {
       echo '<div class="ct-form-spam">Spam detected!</div>';
   }

   ?>
   <form method="post" class="ct-test-form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
       <div class="form-group">
           <label for="name">Name:</label>
           <input type="text" name="name" id="name" required>
       </div>
       
       <div class="form-group">
           <label for="email">Email:</label>
           <input type="email" name="email" id="email" required>
       </div>
       
       <div class="form-group">
           <label for="message">Message:</label>
           <textarea name="message" id="message" rows="4" required></textarea>
       </div>

       <input type="hidden" name="ct_test_nonce" value="<?php echo wp_create_nonce('ct_test_form'); ?>">
       <button type="submit" name="ct_test_submit">Submit</button>
   </form>
   <?php
   return ob_get_clean();
}

add_action('init', 'handle_ct_test_form_submission');
function handle_ct_test_form_submission() {
   if (isset($_POST['ct_test_submit'])) {
       if (!isset($_POST['ct_test_nonce']) || !wp_verify_nonce($_POST['ct_test_nonce'], 'ct_test_form')) {
           wp_die('Security check failed');
       }

       // check if form is spam
    //    $result = apply_filters('ct_wordpress_protect_from_spam', $_POST, ['redirect_to_block_page' => true]);
       $result = apply_filters('ct_wordpress_protect_from_spam', $_POST);
       if ($result['is_spam']) {
            wp_redirect(add_query_arg('submission', 'spam', wp_get_referer()));
            exit;
       }

       $name = sanitize_text_field($_POST['name']);
       $email = sanitize_email($_POST['email']);
       $message = sanitize_textarea_field($_POST['message']);

        // Basic validation
       if (empty($name) || empty($email) || empty($message)) {
           wp_die('Please fill in all required fields');
       }
        if (!is_email($email)) {
           wp_die('Please enter a valid email address');
       }

        // Process the form data (you can customize this part)
        // For example, send an email or save to database
        //    $to = get_option('admin_email');
        //    $subject = 'New Form Submission';
        //    $body = "Name: $name\n";
        //    $body .= "Email: $email\n";
        //    $body .= "Message: $message\n";
        //    wp_mail($to, $subject, $body);

        // Redirect after successful submission
        wp_redirect(add_query_arg('submission', 'success', wp_get_referer()));
        exit;
   }
}
