jQuery(document).ready(function($) {
   $('#ct-test-form').on('submit', function(e) {
       e.preventDefault();
       
       $.ajax({
           url: '/wp-admin/admin-ajax.php',
           type: 'POST',
           data: {
               action: 'ct_test_form_submit',
               formData: $(this).serialize()
           },
           success: function(response) {
                console.log(response);
               if (response.success) {
                   $('.form-response').html(response.data.message);
               } else {
                   $('.form-response').html(response.data.message);
               }
           },
           error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
           }
       });
   });
});