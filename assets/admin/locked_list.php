<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
require_once( "Classes/UserClass/class.ipaddress.php" );
$user_is_me = new USER();
$address    = new IpAddress();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

$rows = $address->get_all_locked();

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page user-list">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">
   <h2>Locked IP Maintenance </h2>
   <div id="user-list">
      <table class="col-sm-12 table table-hover table-striped table-condensed cf">
         <thead class="cf">
         <tr>
            <th>Locked ID</th>
            <th>Address</th>
            <th>User Name</th>
            <th>Timestamp</th>
            <th>Delete</th>
         </tr>
         </thead>
         <tbody>
         <?php foreach ( $rows as $row ) { ?>
         <tr>
            <td data-title="Locked ID"><?= $row->locked_id; ?></td>
            <td data-title="Address"><?=   $row->address; ?></td>
            <td data-title="User Name"><?= $row->user_name; ?></td>
            <td data-title="Timestamp"><?= $row->time_stamp; ?></td>
            <td data-title="Delete"><a class="more"
                  href="locked_delete.php?locked_id=<?= $row->locked_id; ?>">DELETE</a>
            </td>
         </tr>
         <tbody>
         <?php } ?>
      </table>
   </div> <!-- user-list -->

</div> <!-- container -->

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>

</body>
</html>

