<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
?>
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body id="albums2" class="page albums2">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

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

include "footer.php"
include "scripts-footer.php"
</body>
</html>
