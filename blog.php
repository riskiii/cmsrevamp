<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
$user_is_me = new USER();
// This sends a persistent cookie that lasts a day.
if (session_status() == PHP_SESSION_NONE) {
	session_start( [
		               'cookie_lifetime' => 86400,
	               ] );
}

// create database connection
$database  = new Database();
$conn      = $database->dbConnection();
$sql       = 'SELECT * FROM blog ORDER BY created DESC';
$result    = $conn->query( $sql );
$errorInfo = $conn->errorInfo();

if ( isset( $errorInfo[ 2 ] ) ) {
   $error = $errorInfo[ 2 ];
}
?>
<?php
function convertToParas( $text ) {
   $text = trim( $text );

   return '<p>' . preg_replace( '/[\r\n]+/', "</p>\n<p>", $text ) . "</p>\n";
}

function getFirst( $text, $number = 2 ) {
   // use regex to split into sentences
   $sentences = preg_split( '/([.?!]["\']?\s)/', $text, $number + 1, PREG_SPLIT_DELIM_CAPTURE );
   if ( count( $sentences ) > $number * 2 ) {
      $remainder = array_pop( $sentences );
   } else {
      $remainder = '';
   }
   $result      = [];
   $result[ 0 ] = implode( '', $sentences );
   $result[ 1 ] = $remainder;

   return $result;
}

function convertDateToISO( $month, $day, $year ) {
   $month       = trim( $month );
   $day         = trim( $day );
   $year        = trim( $year );
   $result[ 0 ] = false;
   if ( empty( $month ) || empty( $day ) || empty( $year ) ) {
      $result[ 1 ] = 'Please fill in all fields';
   } elseif ( !is_numeric( $month ) || !is_numeric( $day ) || !is_numeric( $year ) ) {
      $result[ 1 ] = 'Please use numbers only';
   } elseif ( ( $month < 1 || $month > 12 ) || ( $day < 1 || $day > 31 ) || ( $year < 1000 || $year > 9999 ) ) {
      $result[ 1 ] = 'Please use numbers within the correct range';
   } elseif ( !checkdate( $month, $day, $year ) ) {
      $result[ 1 ] = 'You have used an invalid date';
   } else {
      $result[ 0 ] = true;
      $result[ 1 ] = sprintf( '%d-%02d-%02d', $year, $month, $day );
   }

   return $result;
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
         echo basename( $php_self, '.php' ) . PHP_EOL;
      }
      ?></title>
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Google CDN jQuery snippet with local fallback -->
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>

   <script src="/js/scripts.min.js"></script>

   <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
   <script>tinymce.init({selector: 'textarea',  // change this value according to your HTML
         content_css : '/css/styles.css'        // resolved to http://domain.mine/myLayout.css
         });
   </script>

<!--   <script src="/admin/includes/js.cookie.js"></script>-->


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

   <link rel="stylesheet" href="/css/styles.min.css">
</head>


<body class="page blog">

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

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="col-sm-8">  <?php } ?>
            <div class="blog-group">
               <h2>Japan Journey </h2>
               <?php
               if ( isset( $error ) ) {
                  echo "<p>$error</p>";

               } else {

                  while ( $row = $result->fetch( PDO::FETCH_OBJ ) ) {
                     if ( $user_is_me->is_loggedin() == true ) {
                        echo '<h3>'
                           . "<a href='details.php?article_id=" .
                           $row->article_id . "'>" . $row->title . '</a>' .
                           '<a href="blog_update.php?article_id=' .
                           $row->article_id . '">' . ' &nbsp;' .
                           '<span class="my-edit fa fa-pencil"></span></a></h3>';
                     } else {
                        echo '<h3>' . '<a href="details.php?article_id=' .
                           $row->article_id . '">' . $row->title . '</a></h3>';
                     }

                     $extract = getFirst( $row->article );

                     echo $extract[ 0 ];

                     if ( $extract[ 1 ] ) {
                        echo '<a class="more" href="details.php?article_id=' .
                           $row->article_id . '"> More</a>';
                     }
                  }
               }
               ?>
            </div>
         <?php if ( $user->is_loggedin() == true ) { ?>
         </div> <!-- .col-sm-8 --!> <?php } ?>

      </main><!-- /.main -->
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
