<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

$my_user_row = $user_is_me->get_user_row();
//$user_is_me->my_var_dump( $my_user_row );

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page home">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>

<div class="signin-form">

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>
</body>
</html>