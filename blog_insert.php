<?php
require_once( "admin/Classes/UserClass/session.php" );
require_once( "admin/Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

?>
<!DOCTYPE html>
<html lang="en-US">
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
   if (session_status() == PHP_SESSION_NONE) {
	   session_start( [
         'cookie_lifetime' => 86400,
      ] );
   }
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

<body class="page contact">

<!--[if lt IE 8]>
<div class="alert alert-warning">
   You are using an <strong>outdated</strong> browser. Please
   <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</div>
<![endif]-->

<?php require_once( $_SERVER[ 'DOCUMENT_ROOT' ] . "/admin/Classes/UserClass/class.user.php" ); ?>
<?php
$database   = new Database();
$user_is_me = new USER();

$my_user_row_in_header = $user_is_me->get_user_row();

$server_name = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

?>

<header class="banner">
   <!-- Bootstrap Navbar  [http://getbootstrap.com/components/#navbar] -->
   <nav class="navbar navbar-static-top navbar-inverse">
      <div class="container">
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-navbar-collapse" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand menu-bar-alert" href="//<?php echo $_SERVER[ 'SERVER_NAME' ] ?>/index.php">dgs CMS
               Starter &nbsp;
               <?php
               if ( $user_is_me->is_loggedin() ) { ?>
                  <span class="glyphicon glyphicon-lock"></span>
                  <?php
               } ?>
            </a>
         </div>

         <!-- Collect the nav links and other content for toggling -->
         <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
               <li><a href="//<?php echo $server_name ?>/index.php">Homepage</a></li>

               <?php if ( $user_is_me->is_loggedin() ) {
               ?>
               <li><a href="//<?php echo $server_name ?>/admin/about-us.php">About us</a></li>
               <li><a href="//<?php echo $server_name ?>/admin/register.php">Register</a></li>
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User Maintenance <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                     <li><a href="//<?php echo $server_name ?>/admin/user_list.php">User List</a></li>
                     <li><a href="//<?php echo $server_name ?>/admin/ip_list.php">Ip List </a></li>
                     <li><a href="//<?php echo $server_name ?>/admin/locked_list.php">Locked List</a></li>
                  </ul>
               </li>
               <?php } ?>


               <?php

               if ( $user_is_me->is_loggedin() ) {
                  ?>
                  <li><a href="//<?php echo $server_name ?>/admin/logout.php" name="logout">Logout</a></li>
                  <?php
               } else {
                  ?>
                  <li><a href="//<?php echo $server_name ?>/login.php">Login</a></li>
                  <?php
               }

               if ( $user_is_me->is_loggedin() ) {
                  ?>
                  <li class="menu-bar-alert"><a href="#">Howdy
                        &nbsp;<?php echo $my_user_row_in_header->user_first . ' ' . $my_user_row_in_header->user_last ?></a>
                  </li>
               <?php } ?>
            </ul>
         </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
   </nav>
</header><!-- /.banner -->

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         <?php
         /**
          * Created by IntelliJ IDEA.
          * User: riskiii
          * Date: 9/28/16
          * Time: 8:32 PM
          */
         ?>
         <div class="menu-container">

            <h1 class="title-area"><span class="pe"> PE</span><span class="nt"> NT</span><span class="at"> AT</span><span
               class="on"> ON</span><span
               class="ix"> IX</span>
            </h1>

            <nav class="navbar navbar-default">
               <div class="container-fluid">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                             data-target="#dgs-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                     </button>
                  </div>
                  <!-- Collect the nav links and other content for toggling -->
                  <div class="collapse navbar-collapse" id="dgs-navbar-collapse">
                     <ul class="nav navbar-nav">
                        <li><a href="/index.php"> Home</a></li>
                        <li><a href="/bio.php"> Bio</a></li>
                        <li><a href="/albums.php"> Albums</a></li>
                        <li><a href="/video.php"> Video</a></li>
                        <li><a href="/contact.php"> Contact</a></li>
                        <li><a href="/blog.php"> Blog</a></li>
                     </ul>
                  </div><!-- /.navbar-collapse -->
               </div>
            </nav>
         </div>
         <?php
         if ( $user_is_me->is_loggedin() ) {
            ?>
            <div class="sidebar col-sm-4">
               <nav class="nav-sidebar">
                  <ul>
                     <li><a href="/add_artists.php">Add Artists</a></li>
                     <li><a href="/add_albums.php">Add Albums</a></li>
                     <li><a href="/add_songs.php">Add Songs</a></li>
                     <li><a href="/blog_list.php">Blog List/Delete/Update</a></li>
                     <li><a href="/blog_insert.php">Blog Insert</a></li>
                  </ul>
               </nav>
            </div>
         <?php } ?>
         <?php


         if ( isset( $insert ) ) {
	         $insert = strip_tags( trim( $_POST[ 'insert' ] ) );
         } else {
	         $insert = '';
         }

         if ( $insert == "Insert New Blog Post" ) {
            // create database connection
            $conn  = $database->dbConnection();
            $conn2 = $database->dbConnection();
            $conn3 = $database->dbConnection();
            // initialize flag
            $OK = false;

            // create SQL
            $sql2 = "INSERT INTO images ( filename, caption )
                     VALUES( :filename, :caption )";

            $stmt2 = $conn2->prepare( $sql2 );

            // bind the parameters and execute the statement
            $stmt2->bindParam( ":filename", $filename );
            $stmt2->bindParam( ":caption", $caption );

            $filename = strip_tags( trim( $_COOKIE[ "dgs_cookie" ] ) );
            $caption  = strip_tags( trim( $_POST[   "caption" ] ) );
            unset( $_COOKIE[ "dgs_cookie" ] );

            // execute and get number of affected rows
            $stmt2->execute();

            $lastId = $conn2->lastInsertId();

            // create SQL
            $sql = "INSERT INTO blog (title, article, image_id )
                 VALUES(:title, :article, :image_id )";

            // prepare the statement
            $stmt = $conn->prepare( $sql );

            $title   = strip_tags( trim( $_POST[ 'title' ] ) );
            $article = strip_tags( trim( $_POST[ 'article' ] ) );

            // bind the parameters and execute the statement
            $stmt->bindParam( ":title",    $title,   PDO::PARAM_STR );
            $stmt->bindParam( ":article",  $article, PDO::PARAM_STR );
            $stmt->bindParam( ":image_id", $lastId );

            $stmt->execute();
         }

         ?>
         <div class="col-sm-8">
            <h2>Insert New Blog Entry</h2>

            <?php if ( isset( $error ) ) {
               echo "<p>Error: $error</p>";
            } ?>

            <form method="post" enctype="multipart/form-data" class="form-horizontal">
               <div class="form-group">
                  <label for="title" class="control-label">Title:</label>
                  <input name="title" type="text" id="title" class="form-control">
               </div>
               <div class="form-group">
                  <label for="filename" class="control-label">Filename:</label>
                  <!-- https://github.com/blueimp/jQuery-File-Upload-->
                  <?php require_once "admin/includes/file_upload.php"; ?>
               </div>
               <div class="form-group">
                  <label for="caption" class="control-label">Caption:</label>
                  <input name="caption" type="text" id="caption" class="form-control">
               </div>
               <div class="form-group">
                  <label for="article" class="control-label">Article:</label>
                  <textarea name="article" id="article" rows="10" class="form-control"></textarea>
               </div>
               <div class="form-group">
                  <input type="submit" name="insert"
                         value="Insert New Blog Post" id="insert" class="btn btn-info">
               </div>
            </form>

         </div>
      </main>
   </div>
</div>

<?php
$document_root = strip_tags( trim( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
include_once $document_root . "/admin/includes/misc-fonts.php";
?>
<footer class="content-info" style="background:#efefef; ">
   <div class="container">
      <small>&copy; <?php echo ( new \DateTime() )->format( 'Y' ); ?> <a
            href="http://campfirepixels.com">campfirepixels.com</a></small>
   </div>
</footer>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
   (function (b, o, i, l, e, r) {
      b.GoogleAnalyticsObject = l;
      b[l] || (b[l] =
         function () {
            (b[l].q = b[l].q || []).push(arguments)
         });
      b[l].l = +new Date;
      e = o.createElement(i);
      r = o.getElementsByTagName(i)[0];
      e.src = 'https://www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e, r)
   }(window, document, 'script', 'ga'));
   ga('create', 'UA-XXXXX-X', 'auto');
   ga('send', 'pageview');
</script>

<!-- use the code below to enabling Live Reload: -->
<!--<script src="//localhost:35729/livereload.js"></script>-->
<!-- read more on: https://github.com/gruntjs/grunt-contrib-watch#enabling-live-reload-in-your-html -->

</body>
</html>