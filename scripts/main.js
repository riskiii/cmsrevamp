/* ========================================================================
 * DOM-based Routing
 * Based on article
 * http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
 * by Paul Irish
 * ======================================================================== */

(function ($) {

   // Use this variable to set up the common and page specific functions.
   var dgsPhpStarter = {
      // All pages
      'common': {
         init: function () {
            // JavaScript to be fired on all pages
         },
         finalize: function () {
            // JavaScript to be fired on all pages, after page specific JS is fired
         }
      },
      // Home page
      'home': {
         init: function () {
            // JavaScript to be fired on the home page
         }
      },
      // About us page, note the change from about-us to about_us.
      'about_us': {
         init: function () {
            // JavaScript to be fired on the about us page
            alert('about_us');
         }
      },
      // About us page, note the change from about-us to about_us.
      "user_update": {
         init: function () {
            // JavaScript to be fired on the about us page
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
                              }).delay(3000).slideUp('fast');

                              // similar behavior as an HTTP redirect
                              $(location).attr('href', 'user_list.php');

                              //window.location.href = "user_list.php";


                           } else {

                              $('#errorDiv').slideDown('fast', function () {
                                 $('#errorDiv').html('<div class="alert alert-danger">' + data.message + '</div>');
                                 $("#register-form").trigger('reset');
                                 $('input[type=text],input[type=email],input[type=password]').prop('disabled', false);
                                 $('#btn-signup').html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Update').prop('disabled', false);
                              }).delay(3000).slideUp('fast');
                           }

                        }, 3000);

                     })
                     .fail(function () {
                        $("#register-form").trigger('reset');
                        alert('An unknown error occoured, Please try again Later...');
                     });
               }

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

            });
         }
      }

   };

   UTIL = {

      fire: function (func, funcname, args) {

         var namespace = dgsPhpStarter;  // indicate your obj literal namespace here

         funcname = (funcname === undefined) ? 'init' : funcname;
         if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
            namespace[func][funcname](args);
         }
      },

      loadEvents: function () {

         var bodyId = document.body.id;

         // hit up common first.
         UTIL.fire('common');

         // do all the Classes too.
         $.each(document.body.className.split(/\s+/), function (i, classnm) {
            UTIL.fire(classnm);
            UTIL.fire(classnm, bodyId);
         });

         UTIL.fire('common', 'finalize');
      }
   };

   // kick it all off here
   $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
