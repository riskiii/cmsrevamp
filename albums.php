<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
// This sends a persistent cookie that lasts a day.
if (session_status() == PHP_SESSION_NONE) {
	session_start( [
		               'cookie_lifetime' => 86400,
	               ] );
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


<body id="albums2" class="page albums2">

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
         <div class="col-sm-8"> <?php } ?>
            <div class="center-albums">

               <h2 class="page-header">Discography</h2>

               <?php
               $sql  = "SELECT `album_name`, 
                               `album_id`, 
                               `album_image` 
                        FROM   `albums` ORDER BY `album_name`";
               $conn = $database->dbConnection();
               $stmt = $conn->prepare( $sql );

               $stmt->bindParam( ":album_name",  $album_name );
               $stmt->bindParam( ":album_id",    $album_id );
               $stmt->bindParam( ":album_image", $album_image );

               $stmt->execute();

               $count       = 1;
               $album_count = 0;
               $fig         = 1;

               while ( $row = $stmt->fetch( PDO::FETCH_OBJ ) ) { ?>
                  <div class="albums  col-sm-4">
                  <figure id="album<?php echo $fig ?>" class="album">
                     <img class="-img-responsive -img-hover"
                          src="<?php echo 'http://' . $_SERVER[ 'SERVER_NAME' ] . '/admin/files/' . $row->album_image ?>"
                          alt=''>

                     <figcaption><?php echo $row->album_name ?></figcaption>
                     <?php
                     //error_reporting(E_ALL);
                     //ini_set('display_errors', 1);
                     $album_id = $row->album_id;
                     $sql3     = "SELECT songs.song_id, 
                                  songs.song_name, 
                                  songs.song_length, 
                                  songs.song_mp3, 
                                  songs.album_id
                           FROM  songs 
                           INNER JOIN albums 
                           ON       songs.album_id = albums.album_id
                           WHERE    songs.album_id = $album_id
                           ORDER BY songs.song_name";

                     $conn3 = $database->dbConnection();
                     $stmt3 = $conn3->prepare( $sql3 );

                     $stmt3->bindParam( ":songs.song_name",      $song_name );
                     $stmt3->bindParam( ":songs.song_length",    $song_length );
                     $stmt3->bindParam( ":songs.song_mp3",       $song_mp3 );
                     $stmt3->bindParam( ":albums.album_release", $album_release );

                     $stmt3->execute();?>

                  </figure>
                  <div id="album<?php echo $fig++ ?>p">
                     <ol>
                        <?php
                        while ( $row3 = $stmt3->fetch( PDO::FETCH_OBJ ) ) { ?>
                           <li>
                              <div class="song-name">  <?php echo $row3->song_name; ?> </div>
                              <audio id="player<?php echo $count; ?>"
                                     src="<?php echo 'http://' . strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) ) . '/admin/files/' . $row3->song_mp3; ?>"></audio>
                              <span class="song-length">   Length: </span> <?php echo $row3->song_length; ?><br>
                              <span class="my-buttons">
                                 <button class="btn btn-info"
                                         onclick='document.getElementById("player<?php echo $count ?>").play()'>Play
                                 </button>
                                 <button class="btn btn-info"
                                         onclick='document.getElementById("player<?php echo $count ?>").pause()'>Pause
                                 </button>
                              </span>
                              <?php $count++; ?>
                           </li>
                        <?php } ?>
                     </ol>
                  </div>
                  </div><?php
                  $album_count++;
                  if ( $album_count == 2 ) {
                     ?>
                     <div class="clear_both"></div><?php
                     $album_count = 0;
                  }
                  ?>
               <?php } ?>
            </div>
            <?php if ( $user->is_loggedin() == true ) { ?>
         </div> <!-- .col-sm-8 --> <?php } ?>
      </main><!-- /.main -->
   </div>
</div>

<script>
   jQuery(function () {
      $(function () {

         $('#album1p').hide();
         $('#album2p').hide();
         $('#album3p').hide();
         $('#album4p').hide();
         $('#album5p').hide();
         $('#album6p').hide();
         $('#album7p').hide();
         $('#album8p').hide();
         $('#album9p').hide();
         $('#album10p').hide();
      });

      $("#album1").click(function () {
         //getData( "#album1p", "data/album1.html" );
         $("#album1p").toggle(500);
      });

      $("#album2").click(function () {
         //getData( "#album2p", "data/album2.html" );
         $("#album2p").toggle(500);
      });

      $("#album3").click(function () {
         //getData( "#album3p", "data/album3.html" );
         $("#album3p").toggle(500);
      });

      $("#album4").click(function () {
         //getData( "#album4p", "data/album4.html" );
         $("#album4p").toggle(500);
      });
      $("#album5").click(function () {
         //getData( "#album1p", "data/album1.html" );
         $("#album5p").toggle(500);
      });

      $("#album6").click(function () {
         //getData( "#album2p", "data/album2.html" );
         $("#album6p").toggle(500);
      });

      $("#album7").click(function () {
         //getData( "#album3p", "data/album3.html" );
         $("#album7p").toggle(500);
      });

      $("#album8").click(function () {
         //getData( "#album4p", "data/album4.html" );
         $("#album8p").toggle(500);
      });

      $("#album9").click(function () {
         //getData( "#album3p", "data/album3.html" );
         $("#album9p").toggle(500);
      });

      $("#album10").click(function () {
         //getData( "#album4p", "data/album4.html" );
         $("#album10p").toggle(500);
      });
   });
</script>

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
