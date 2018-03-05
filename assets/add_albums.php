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

<script src="admin/includes/add_albums.js"></script>

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

         $q = $conn->prepare( "SELECT artist_id, artist_name FROM artists ORDER BY artist_name" );
         $q->bindParam( ":artist_id", $artist_id );
         $q->bindParam( ":artist_name", $artist_name );
         $q->execute();
         ?>
         <div class="">
            <!--   http://www.w3schools.com/php/php_file_upload.asp-->
            <!--   https://github.com/blueimp/jQuery-File-Upload/wiki/Setup-->
            <div class="col-sm-8">
               <h2>Add Album</h2>

               <form method="post" enctype="multipart/form-data" id="add-albums" name="add-albums" class="form-horizontal">

                  <!-- json response will be here -->
                  <div id="errorDiv"></div>
                  <!-- json response will be here -->

                  <div class="form-group">
                     <label for="artist_id" class="control-label">Album Artist</label>
                     <select class="form-control">
                        <option id="artist_id" name="artist_id" class="form-control">Select</option>
                        <?php while ( $row = $q->fetch( PDO::FETCH_OBJ ) ) { ?>
                           <option value="<?php echo $row->artist_id;
                           $artist_id   = $row->artist_id;
                           $artist_name = $row->artist_name; ?>"><?php echo $row->artist_name; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="album_name" class="control-label">Album Name</label>
                     <input type="text" name="album_name" id="album_name" value="<?php $album_name; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="album_release" class="control-label">Album Release Date</label>
                     <input type="date" name="album_release" id="album_release"  value="<?php $album_release; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                     <!-- https://github.com/blueimp/jQuery-File-Upload-->
                     <?php include 'admin/includes/file_upload.php'; ?>
                  </div>
                  <input name="artist_id" id="artist_id" type="hidden" value="<?= $artist_id; ?>">

                  <div class="form-group top-spacing">
                     <button type="submit" class="btn btn-info" id="btn-add">
                        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Register Now
                     </button>
<!--                     <input type="submit" value="Add Album" id="btn-add" name="btn-add" class="btn btn-info"/>-->
                  </div>
               </form>
            </div>
         </div>
         <?php

         // Only process the form if $_POST isn't empty
         //if ( !empty( $_POST ) ) {
         //   $conn = $database->dbConnection();
         //   $stmt = $conn->prepare( "INSERT INTO albums (album_name, artist_id, album_release, album_image) VALUE (:album_name, :artist_id, :album_release, :album_image)" );
         //   $stmt->bindParam( ":album_name",    $album_name );
         //   $stmt->bindParam( ":artist_id",     $artist_id );
         //   $stmt->bindParam( ":album_release", $album_release );
         //   $stmt->bindParam( ":album_image",   $album_image );
//
         //   // insert one row
         //   // http://php.net/manual/en/features.cookies.php
         //   $album_name    = strip_tags( trim( $_POST[ "album_name" ] ) );
         //   $album_release = strip_tags( trim( $_POST[ "album_release" ] ) );
         //   $album_image   = strip_tags( trim( $_COOKIE[ "dgs_cookie" ] ) );
         //   unset( $_COOKIE[ "dgs_cookie" ] );
         //   $stmt->execute();
         //}
         ?>
      </main>
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>


