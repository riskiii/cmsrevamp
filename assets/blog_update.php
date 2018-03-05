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

<body class="page contact">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php

         // initialize flags
         $OK   = false;
         $done = false;

         // create database connection
         $conn = $database->dbConnection();

         $article_id = strip_tags( trim( $_GET[ 'article_id' ] ) );

         // get details of selected record
         if ( isset( $article_id ) && !$_POST ) {

            // prepare SQL query
            $sql = 'SELECT article_id, title, article FROM blog
            WHERE article_id = ?';

            $stmt = $conn->prepare( $sql );
            // pass the placeholder value to execute() as a single-element array
            $OK = $stmt->execute( [ $article_id ] );

            // bind the results
            $stmt->bindColumn( 1, $article_id );
            $stmt->bindColumn( 2, $title );
            $stmt->bindColumn( 3, $article );
            $stmt->fetch( PDO::FETCH_OBJ );
         }

         $update = strip_tags( trim( $_POST[ 'update' ] ) );

         // if form has been submitted, update record
         if ( isset( $update ) ) {

            // prepare update query
            $sql  = "UPDATE blog SET title = ?, article = ?
            WHERE article_id = ?";
            $stmt = $conn->prepare( $sql );

            // execute query by passing array of variables
            $done = $stmt->execute( [
               strip_tags( trim( $_POST[ 'title' ]      ) ),
               strip_tags( trim( $_POST[ 'article' ]    ) ),
               strip_tags( trim( $_POST[ 'article_id' ] ) )
            ] );
         }

         $article_id  = strip_tags( trim( $_GET[    'article_id' ] ) );
         $server_name = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );
         // redirect page on success or if $_GET['article_id'] not defined
         if ( !$done || !isset( $article_id ) ) {
            $user_is_me->redirect( "http://" . $server_name . "/blog_list.php" );
            exit;
         }

         // store error message if query fails
         if ( isset( $stmt ) && !$OK && !$done ) {
            $errorInfo = $stmt->errorInfo();
            if ( isset( $errorInfo[ 2 ] ) ) {
               $error = $errorInfo[ 2 ];
            }
         }

         ?>

         <h2>Update Blog Entry</h2>

         <div class="col-sm-8">
            <p><a class="more" href="blog_list.php">List all entries </a></p>
            <?php if ( isset( $error ) ) {
               echo "<p class='warning'>Error: $error</p>";
            }
            if ( $article_id == 0 ) { ?>
               <p class="warning">Invalid request: record does not exist.</p>
            <?php } else { ?>
               <form method="post" action="" class="form-horizontal">
                  <div class="form-group">
                     <label for="title"  class="control-label">Title:</label>
                     <input name="title" type="text" id="title" value="<?= htmlentities( $title ); ?>" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="article" class="control-label">Article:</label>
                     <textarea name="article" id="article" rows="10" class="form-control"><?= htmlentities( $article ); ?></textarea>
                  </div>
                  <div class="form-group">
                     <input type="submit" name="update" value="Update Entry" id="update" class="btn btn-info">
                     <input name="article_id" type="hidden"
                            value="<?= $article_id; ?>">
                  </div>
               </form>
            <?php } ?>
         </div>
      </main>
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>