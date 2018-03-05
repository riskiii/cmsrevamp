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
include "head2.php"

<body class="page contact">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"
         <?php
         $conn = $database->dbConnection();

         $q = $conn->prepare( "SELECT album_id, album_name FROM albums ORDER BY album_name" );
         $q->bindParam( ":album_id",   $album_id );
         $q->bindParam( ":album_name", $album_name );
         $q->execute();
         ?>
         <div class="main col-sm-8">
            <h2>Add Songs</h2>

            <form method="post" enctype="multipart/form-data">
               <div class="form-group">
                  <label for="album_name" class="control-label">Album Name</label>
                  <select name="album_id" id="album_id" class="form-control">
                     <option value "" >Select</option>
                     <?php while ( $row = $q->fetch( PDO::FETCH_OBJ ) ) { ?>
                        <option value="<?php echo $row->album_id; ?>">
                           <?php echo $row->album_name;
                           $album_id = $row->album_id; ?>
                        </option>
                     <?php } ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="song_name" class="control-label">Song Name</label>
                  <input type="text" name="song_name" value="<?php $song_name ?>" class="form-control"><br>
               </div>
               <div class="form-group">
                  <label for="song_length" class="control-label">Song Length</label>
                  <input type="text" name="song_length" value="<?php $song_length ?>" class="form-control"><br>
               </div>
               <div class="form-group">
                  <!-- https://github.com/blueimp/jQuery-File-Upload-->
                  include "file_upload.php"
               </div>
               <div class="form-group top-spacing">
                  <input type="submit" value="Add Song" class="btn btn-info"/>
               </div>
            </form>
         </div>

         <?php
         // Only process the form if $_POST isn't empty
         if ( !empty( $_POST ) ) {
            // var_dump( $_POST );
            $stmt = $conn->prepare( "INSERT INTO songs ( album_id,  song_name,  song_length,  song_mp3 ) 
                                     VALUE             (:album_id, :song_name, :song_length, :song_mp3 )" );
            $stmt->bindParam( ":album_id",    $album_id );
            $stmt->bindParam( "song_name",    $song_name );
            $stmt->bindParam( ":song_length", $song_length );
            $stmt->bindParam( "song_mp3",     $song_mp3 );

            // insert one row
            // http://php.net/manual/en/features.cookies.php
            $album_id    = strip_tags( trim( $_POST[   "album_id" ] ) );
            $song_name   = strip_tags( trim( $_POST[   "song_name" ] ) );
            $song_length = strip_tags( trim( $_POST[   "song_length" ] ) );
            $song_mp3    = strip_tags( trim( $_COOKIE[ "dgs_cookie" ] ) );

            unset( $_COOKIE[ "dgs_cookie" ] );
            $stmt->execute();
         }
         ?>
      </main>
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>


