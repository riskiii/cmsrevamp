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
include "head.php"

<script src="admin/includes/add_artists.js"></script>


<body id="home" class="page add-artists">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <div class="col-sm-8">
            <h2>Add Artists</h2>
            <form method="POST" enctype="multipart/form-data" id="add-artists" name="add-artists" class="form-horizontal">

               <!-- json response will be here -->
               <div id="errorDiv"></div>
               <!-- json response will be here -->

               <div class="form-group">
                  <label for="artist_name" class="control-label">Artist Name</label>
                  <input type="text" id="artist_name" name="artist_name"  value="<?php $artist_name ?>" class="form-control">
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-info" id="btn-add">
                     <span class="glyphicon glyphicon-log-in"></span> &nbsp; Add Artist Now
                  </button>
<!--                  <input type="submit" id="btn-add" value="Add Artist Now" class="btn btn-info"/>-->
               </div>
            </form>
         </div>

      </main><!-- /.main -->
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>

