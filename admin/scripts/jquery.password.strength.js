;(function ($, window, document, undefined) {

   var pluginName = "PasswordStrengthManager",
      defaults = {
         password: "",
         confirm_pass: "",
         blackList: [],
         minChars: "",
         maxChars: "",
         advancedStrength: false
      };

   function Plugin(element, options) {
      this.element = element;
      this.settings = $.extend({}, defaults, options);
      this._defaults = defaults;
      this._name = pluginName;
      this.init();

      this.info = '';
   }

   Plugin.prototype = {
      init: function () {


         var errors = this.customValidators();
         if ('' == this.settings.password || '' == this.settings.confirm_pass) {

            this.info = 'Password fields cannot be empty';
         }

         else if (this.settings.password != this.settings.confirm_pass) {
            this.info = 'Passwords don\'t match';
         } else if (errors == 0) {
            var strength = '';
            strength = zxcvbn(this.settings.password, this.settings.blackList);

            // console.log(strength);
            switch (strength.score) {
               case 0:
                  this.info = 'Very Weak';
                  $('#pass_meter').css('background-color', 'red');
                  $('#pass_meter').css('text-shadow', '1px 1px 2px white');
                  break;
               case 1:
                  this.info = 'Very Weak';
                  $('#pass_meter').css('background-color', 'red');
                  $('#pass_meter').css('text-shadow', '1px 1px 2px white');
                  break;
               case 2:
                  this.info = 'Weak';
                  $('#pass_meter').css('background-color', 'red');
                  $('#pass_meter').css('text-shadow', '1px 1px 2px white');

                  break;
               case 3:
                  this.info = 'Medium';
                  $('#pass_meter').css('background-color', 'yellow');
                  $('#pass_meter').css('color', 'black');
                  $('#pass_meter').css('text-shadow', '1px 1px 2px white');

                  break;
               case 4:

                  if (this.settings.advancedStrength) {
                     var crackTime = String(strength.crack_time_display);

                     if (crackTime.indexOf("years") != -1) {

                        this.info = 'Very Strong';
                        $('#pass_meter').css('background-color', 'green');
                        $('#pass_meter').css('text-shadow', '1px 1px 2px black');


                     } else if (crackTime.indexOf("centuries") != -1) {
                        this.info = 'Perfect';
                        $('#pass_meter').css('background-color', 'green');
                        $('#pass_meter').css('text-shadow', '1px 1px 2px black');


                     }
                  } else {
                     this.info = 'Strong';
                     $('#pass_meter').css('background-color', 'green');
                     $('#pass_meter').css('text-shadow', '1px 1px 2px black');

                  }
                  break;
            }

         }

         $(this.element).html(this.info);

      },
      minChars: function () {
         if (this.settings.password.length < this.settings.minChars) {
            this.info = 'Password should have at least ' + this.settings.minChars + ' characters';
            return false;
         } else {
            return true;
         }
      },
      maxChars: function () {
         if (this.settings.password.length > this.settings.maxChars) {
            this.info = 'Password should have maximum of ' + this.settings.maxChars + ' characters';
            return false;
         } else {
            return true;
         }
      },
      customValidators: function () {

         var err = 0;
         if (this.settings.minChars != '') {
            if (!(this.minChars())) {
               err++;
            }
         }

         if (this.settings.maxChars != '') {
            if (!(this.maxChars())) {
               err++;
            }
         }

         return err;
      }

   };

   $.fn[pluginName] = function (options) {
      this.each(function () {
         //if ( !$.data( this, "plugin_" + pluginName ) ) {
         $.data(this, "plugin_" + pluginName, new Plugin(this, options));
         //}
      });
      return this;
   };

})(jQuery, window, document);
