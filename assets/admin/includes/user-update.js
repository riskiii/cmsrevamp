// JavaScript Validation For Registration Page

$('document').ready(function () {

   // name validation
   var nameregex = /^[a-zA-Z0-9]+$/;

   $.validator.addMethod("validname", function (value, element) {
      return this.optional(element) || nameregex.test(value);
   });

   // valid email pattern
   var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

   $.validator.addMethod("validemail", function (value, element) {
      return this.optional(element) || eregex.test(value);
   });

   $("#register-form").validate({

      rules: {
         name: {
            required: true,
            validname: true,
            minlength: 3
         },
         email: {
            required: true,
            validemail: true
         },
         password: {
            required: true,
            minlength: 8,
            maxlength: 15
         },
         cpassword: {
            required: true,
            equalTo: '#password'
         },
      },
      messages: {
         name: {
            required: "Name is required",
            validname: "Name must contain only alphanumerics",
            minlength: "your name is too short"
         },
         email: {
            required: "Email is required",
            validemail: "Please enter valid email address"
         },
         password: {
            required: "Password is required",
            minlength: "Password at least have 8 characters"
         },
         cpassword: {
            required: "Retype your password",
            equalTo: "Password did not match !"
         }
      },
      errorPlacement: function (error, element) {
         $(element).closest('.form-group').find('.help-block').html(error.html());
      },
      highlight: function (element) {
         $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
      },
      unhighlight: function (element, errorClass, validClass) {
         $(element).closest('.form-group').removeClass('has-error');
         $(element).closest('.form-group').find('.help-block').html('');
      },
      submitHandler: submitForm
   });

   function submitForm() {

      $.ajax({
         url: 'ajax-update.php',
         type: 'POST',
         data: $('#register-form').serialize(),
         dataType: 'json'
      })
         .done(function (data) {

            $('#btn-signup').html('<img src="includes/ajax-loader.gif" /> &nbsp; updating...').prop('disabled', true);
            $('input[type=text],input[type=email],input[type=password]').prop('disabled', true);

            setTimeout(function () {

               if (data.status === 'success') {

                  $('#errorDiv').slideDown('fast', function () {
                     $('#errorDiv').html('<div class="alert alert-info">' + data.message + '</div>');
                     $("#register-form").trigger('reset');
                     $('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
                     $('#btn-signup').html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Update').prop('disabled', false);
                  }).delay(6000).slideUp('fast');

                  // similar behavior as an HTTP redirect
                  $(location).attr('href', 'user_list.php');

                  //window.location.href = "user_list.php";

               } else {

                  $('#errorDiv').slideDown('fast', function () {
                     $('#errorDiv').html('<div class="alert alert-danger">' + data.message + '</div>');
                     $("#register-form").trigger('reset');
                     $('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
                     $('#btn-signup').html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Update').prop('disabled', false);
                  }).delay(6000).slideUp('fast');
               }

            }, 6000);

         })
         .fail(function () {
            $("#register-form").trigger('reset');
            alert('An unknown error occoured, Please try again Later...');
         });
   }
});