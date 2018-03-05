<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
require_once( "Classes/UserClass/class.ipaddress.php" );
$user_is_me = new USER();
$address    = new IpAddress();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

// initialize flags
$deleted = false;

// Get get variable
$locked_id = strip_tags( trim( $_GET[ 'locked_id' ] ) );
$delete    = strip_tags( trim( $_POST[ 'delete' ] ) );

// if confirm deletion button has been clicked, delete record
if ( ( $delete  != "" ) ) {

   $deleted = $address->delete_locked_ip( $locked_id );

   if ( $deleted != true ) {
      $error = 'There was a problem deleting the record.';
   }
}
$cancel_delete = strip_tags( trim( $_POST[ 'cancel_delete' ] ) );
$server_name   = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

// redirect the page if deleted, cancel button clicked, or $_GET['user_id'] not defined
if ( $deleted || ( $cancel_delete != "" ) || $locked_id == "" ) {
   header( "Location: http://" . $server_name . "/admin/locked_list.php" );
   exit;
}
?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page locked-delete">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">

   <h2>Delete Locked Ip Address </h2>
   <div class="col-sm-12">
      <?php
      if ( isset( $error ) ) {
         echo "<p class='warning'>Error: $error</p>";
      } elseif ( $locked_id == "" ) { ?>
         <p class="warning">Invalid request: record does not exist.</p>
      <?php } else { ?>
         <p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
         <p><?= $locked_id ?></p>
      <?php } ?>
      <form method="post" action="">
         <p>
            <?php if ( $locked_id != "" ) { ?>
               <input type="submit" name="delete" value="Confirm Deletion">
            <?php } ?>
            <input name="cancel_delete" type="submit" id="cancel_delete" value="Cancel">
         </p>
      </form>
   </div> <!-- .col-sm-12 -->

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>

</body>
</html>
