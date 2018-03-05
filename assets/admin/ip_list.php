<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
require_once( "Classes/UserClass/class.ipaddress.php" );
$user_is_me = new USER();
$address    = new IpAddress();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

$rows = $address->get_all_ips();

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page user-list">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">
   <h2>IP Maintenance </h2>
   <div id="user-list">
      <table class="col-sm-12 table table-hover table-striped table-condensed cf">
         <thead class="cf">
         <tr>
            <th>IP ID</th>
            <th>Address</th>
            <th>Timestamp</th>
            <th>Delete</th>
         </tr>
         </thead>
         <tbody>
         <?php foreach ( $rows as $row ) { ?>
         <tr>
            <td data-title="IP ID"><?= $row->ip_id; ?></td>
            <td data-title="Address"><?= $row->address; ?></td>
            <td data-title="Timestamp"><?= $row->time_stamp; ?></td>
            <td data-title="Delete"><a class="more"
                  href="ip_delete.php?ip_id=<?= $row->ip_id; ?>">DELETE</a>
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

