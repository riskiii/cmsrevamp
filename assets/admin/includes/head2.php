<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <?php $php_self = strip_tags( trim( $_SERVER[ 'PHP_SELF' ] ) );
      $php_self = ucfirst( trim( basename( $php_self, ".php" ) . PHP_EOL ) );
   ?>
   <title><?php if ( $php_self  == 'Index' ) {
         echo 'Home';
      } else {
         echo $php_self;
      }
      ?></title>
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <?php
   // This sends a persistent cookie that lasts a day.
   session_start( [
      'cookie_lifetime' => 86400,
   ] );
   ?>

   <!-- Google CDN jQuery snippet with local fallback -->
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
   <script src="/js/scripts.min.js"></script>

   <!-- Load the necessary widget JS files to enable file upload -->
   <script src="admin/includes/jquery.ui.widget.js"></script>
   <script src="admin/includes/jquery.iframe-transport.js"></script>
   <script src="admin/includes/jquery.fileupload.js"></script>
<!--   <script src="admin/includes/js.cookie.js"></script>-->

   <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
   <script>tinymce.init({selector: 'textarea',  // change this value according to your HTML
         content_css : '/css/styles.css',       // resolved to http://domain.mine/myLayout.css
         });
   </script>

   <!-- JavaScript used to call the fileupload widget to upload files -->
   <script>
      // When the server is ready...
      jQuery(function () {
         'use strict';

         // Define the url to send the image data to
         var url = 'admin/includes/files.php';

         // Call the fileupload widget and set some parameters
         $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
               // Add each uploaded file name to the #files list
               $.each(data.result.files, function (index, file) {
                  $('<span/>').text(file.name).appendTo('#files');

                  // https://github.com/js-cookie/js-cookie/tree/v2.1.2#readme
                  Cookies.set('dgs_cookie', decodeURIComponent(file.name), {expires: 7});

                  $.post('file_upload.php', 'val=' + $.text(file.name), function (response) {
                     alert(response);
                  });
               });
            },
            progressall: function (e, data) {
               // Update the progress bar while files are being uploaded
               var progress = parseInt(data.loaded / data.total * 100, 10);
               $('#progress .bar').css(
                  'width',
                  progress + '%'
               );
            }
         });
      });
   </script>

   <!--   https://css-tricks.com/favicon-quiz/-->
   <link rel="icon" type="image/png" href="http://<?php echo $_SERVER[ 'SERVER_NAME' ] ?>/images/favicon-16x16.png"
         sizes="16x16">
   <link rel="icon" type="image/png" href="http://<?php echo $_SERVER[ 'SERVER_NAME' ] ?>/images/favicon-32x32.png"
         sizes="32x32">
   <link rel="icon" type="image/png" href="http://<?php echo $_SERVER[ 'SERVER_NAME' ] ?>/images/favicon-96x96.png"
         sizes="96x96">

   <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/images/apple-icon-57x57-precomposed.png"/>
   <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/apple-icon-72x72-precomposed.png"/>
   <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/apple-icon-114x114-precomposed.png"/>
   <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/apple-icon-144x144-precomposed.png"/>

<!--   --><?php //include_once $_SERVER[ 'DOCUMENT_ROOT' ] . "/admin/includes/misc-fonts.php"; ?>
   <link rel="stylesheet" href="/css/styles.min.css">
</head>