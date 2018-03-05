<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

// create database connection
$sql = "SELECT user_id, 
              user_name, 
              user_email, 
              user_first, 
              user_last, 
              joining_date, 
              last_logon
        FROM users 
        ORDER BY user_last, user_first ASC";

$database = new Database();
$conn     = $database->dbConnection();
$stmt5    = $conn->prepare( $sql );

$stmt5->bindParam( ':user_name',    $user_name,    PDO::PARAM_STR, 15 );
$stmt5->bindParam( ':user_email',   $user_email,   PDO::PARAM_STR, 40 );
$stmt5->bindParam( ':user_first',   $user_first,   PDO::PARAM_STR, 40 );
$stmt5->bindParam( ':user_last',    $user_last,    PDO::PARAM_STR, 40 );
$stmt5->bindParam( ':joining_date', $joining_date, PDO::PARAM_STR, 20 );
$stmt5->bindParam( ':last_logon',   $last_logon,   PDO::PARAM_STR, 20 );

$stmt5->execute( array(
   ":user_name"    => $user_name,
   ":user_email"   => $user_email,
   ":user_first"   => $user_first,
   ":user_last"    => $user_last,
   ":joining_date" => $joining_date,
   ":last_logon"   => $last_logon
) );

$stmt5->execute();


?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page user-list">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">
   <h2>User Maintenance </h2>
   <div id="user-list">
      <table class="col-sm-12 table table-hover table-striped table-condensed cf">
         <thead class="cf">
         <tr>
            <th>User ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Joining Date</th>
            <th>Last Logon</th>
            <th>Edit</th>
            <th>Delete</th>
         </tr>
         </thead>
         <tbody>
         <?php while ( $row = $stmt5->fetch() ) { ?>
         <tr>
            <td data-title="User ID"><?= $row[ 'user_name' ]; ?></td>
            <td data-title="Email"><?= $row[ 'user_email' ]; ?></td>
            <td data-title="First Name"><?= $row[ 'user_first' ]; ?></td>
            <td data-title="Last Name"><?= $row[ 'user_last' ]; ?></td>
            <td data-title="Joining Date"><?= $row[ 'joining_date' ]; ?></td>
            <td data-title="Last Logon"><?= $row[ 'last_logon' ]; ?></td>
            <td data-title="Edit"><a class="more" href="user_update.php?user_id=<?= $row[ 'user_id' ]; ?>">EDIT</a></td>
            <td data-title="Delete"><a class="more" href="user_delete.php?user_id=<?= $row[ 'user_id' ]; ?>">DELETE</a>
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

