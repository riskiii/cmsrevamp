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

<body class="page blog-delete">

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

         // initialize flags
         $OK      = false;
         $deleted = false;

         $article_id = strip_tags( trim( $_GET[ 'article_id' ] ) );
         // get details of selected record
         if ( isset( $article_id ) && !$_POST ) {

            // prepare SQL query
            $sql  = 'SELECT article_id, title, created FROM blog WHERE article_id = ?';
            $stmt = $conn->prepare( $sql );

            // pass the placeholder value to execute() as a single-element array
            $OK = $stmt->execute( [ strip_tags( trim( $_GET[ 'article_id' ] ) ) ] );

            // assign result array to variables
            $stmt->bindColumn( 1, $article_id );
            $stmt->bindColumn( 2, $title );
            $stmt->bindColumn( 3, $created );

            // fetch the result
            $stmt->fetch();
         }

         $delete = strip_tags( trim( $_POST[ 'delete' ] ) );

         // if confirm deletion button has been clicked, delete record
         if ( $delete != "" ) {

            $sql  = 'DELETE FROM blog WHERE article_id = ?';
            $stmt = $conn->prepare( $sql );
            $stmt->execute( [ strip_tags( trim( $_POST[ 'article_id' ] ) ) ] );

            // get number of affected rows
            $deleted = $stmt->rowCount();

            if ( !$deleted ) {
               $error = 'There was a problem deleting the record.';
            }
         }

         $article_id    = strip_tags( trim( $_GET[    'article_id' ] ) );
         $cancel_delete = strip_tags( trim( $_POST[   'cancel_delete' ] ) );
         $server_name   = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

         // redirect the page if deleted, cancel button clicked, or $_GET['article_id'] not defined
         if ( $deleted || $cancel_delete != "" || !isset( $article_id ) ) {
            $user_is_me->redirect( "http://" . $server_name . "/blog_list.php" );
         }
         ?>
         <h2>Delete Blog Entry </h2>
         <div class="col-sm-8">
            <?php
            if ( isset( $error ) ) {
               echo "<p class='warning'>Error: $error</p>";
            } elseif ( isset( $article_id ) && $article_id == 0 ) { ?>
               <p class="warning">Invalid request: record does not exist.</p>
            <?php } else { ?>
               <p class="warning">Please confirm that you want to delete the following item. This action cannot be
                  undone.</p>
               <p><?= $created . ' :&nbsp;&nbsp;&nbsp;&nbsp;' . htmlentities( $title ); ?></p>
            <?php } ?>
            <form method="post" action="" class="form-horizontal">
               <p>
                  <?php if ( isset( $article_id ) && $article_id > 0 ) { ?>
                     <input type="submit" name="delete" value="Confirm Deletion" class="btn btn-info">
                  <?php } ?>
                  <input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel" class="btn btn-info">
                  <?php if ( isset( $article_id ) && $article_id > 0 ) { ?>
                     <input name="article_id" type="hidden" value="<?= $article_id; ?>">
                  <?php } ?>
               </p>
            </form>
         </div>
      </main>
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>