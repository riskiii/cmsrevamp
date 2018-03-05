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
$ip_id = strip_tags( trim( $_GET[ 'ip_id' ] ) );

// if confirm deletion button has been clicked, delete record
if ( isset( $_POST[ 'delete' ] ) ) {

   $deleted = $address->ip_delete( $ip_id );

   if ( $deleted != true ) {
      $error = 'There was a problem deleting the record.';
   }
}

$cancel_delete = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

// redirect the page if deleted, cancel button clicked, or $_GET['user_id'] not defined
if ( $deleted || isset( $_POST[ 'cancel_delete' ] ) ) {
   header( "Location: http://" . $cancel_delete . "/admin/ip_list.php" );
}
?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page ip-delete">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">

   <h2>Delete Ip Address </h2>
   <div class="col-sm-12">
      <?php
      if ( isset( $error ) ) {
         echo "<p class='warning'>Error: $error</p>";
      } elseif ( !isset( $ip_id ) ) { ?>
         <p class="warning">Invalid request: record does not exist.</p>
      <?php } else { ?>
         <p class="warning">Please confirm that you want to delete the following item. This action cannot be undone.</p>
         <p><?= $ip_id ?></p>
      <?php } ?>
      <form method="post" action="">
         <p>
            <?php if ( isset( $ip_id ) ) { ?>
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
