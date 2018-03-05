<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

// initialize flags
$OK      = false;
$deleted = false;

$other_user_id = strip_tags( trim( $_GET[ 'user_id' ] ) );
// get details of selected record
if ( ( $other_user_id != "" ) && !$_POST ) {

   $database = new Database();
   $conn     = $database->dbConnection();

   // prepare SQL query
   $sql  = 'SELECT user_id, 
                   user_name, 
                   user_first, 
                   user_last 
            FROM  users 
            WHERE user_id = ?';
   $stmt = $conn->prepare( $sql );

   // assign result array to variables
   $stmt->bindColumn( 1, $other_user_id );
   $stmt->bindColumn( 2, $user_name );
   $stmt->bindColumn( 3, $user_first );
   $stmt->bindColumn( 4, $user_last );

   // pass the placeholder value to execute() as a single-element array
   $OK = $stmt->execute( [ $other_user_id ] );

   // fetch the result
   $stmt->fetch();
}

$delete = strip_tags( trim( $_POST[ 'delete' ] ) );

// if confirm deletion button has been clicked, delete record
if ( ( $delete != "" ) && !( $my_user_id == $other_user_id ) ) {

   $database2 = new Database();
   $conn2     = $database2->dbConnection();

   $sql2  = 'DELETE FROM users WHERE user_id = ?';
   $stmt2 = $conn2->prepare( $sql2 );
   $stmt2->execute( array( $other_user_id ) );

   // get number of affected rows
   $deleted = $stmt2->rowCount();

   if ( $deleted != '' ) {
      $error = 'There was a problem deleting the record.';
   }
}

if ( $other_user_row[ 'user_id' ] == $other_user_id ) {
   $error = "You can't delete yourself.";

} elseif ( $deleted != '' ) {
   $error = 'There was a problem deleting the record number: >' . $deleted . '<';
}

$cancel_delete = strip_tags( trim( $_POST[ 'cancel_delete' ] ) );
$server_name   = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

// redirect the page if deleted, cancel button clicked, or $_GET['user_id'] not defined
if ( $deleted || ( $cancel_delete != "" ) || !isset( $other_user_id ) ) {
   header( "Location: http://" . $server_name . "/admin/user_list.php" );
   exit;
}
?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page user-delete">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">

   <h2>Delete User </h2>
   <div class="two-thirds last">
      <?php
      if ( isset( $error ) ) {
         echo "<p class='warning'>Error: $error</p>";
      } elseif ( isset( $other_user_id ) && $other_user_id == 0 ) { ?>
         <p class="warning">Invalid request: record does not exist.</p>
      <?php } else { ?>
         <p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
         <p><?= $user_name; ?></p>
      <?php } ?>
      <form method="post" action="">
         <p>
            <?php if ( isset( $other_user_id ) && $other_user_id > 0 ) { ?>
               <input type="submit" name="delete" class="btn btn-info" value="Confirm Deletion">
            <?php } ?>
            <input name="cancel_delete" class="btn btn-info" type="submit" id="cancel_delete" value="Cancel">
            <?php if ( isset( $other_user_id ) && $other_user_id > 0 ) { ?>
               <input name="user_id" type="hidden" value="<?= $other_user_id; ?>">
            <?php } ?>
         </p>
      </form>
   </div> <!-- .two-third -->

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>

</body>
</html>
