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

         $insert = strip_tags( trim( $_POST[ 'insert' ] ) );

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

include "footer.php"
include "scripts-footer.php"
</body>
</html>