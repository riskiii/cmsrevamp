<?php

require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

$my_user_row = $user_is_me->get_user_row();
//$user_is_me->my_var_dump( $my_user_row );

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page profile">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>

<div class="clearfix"></div>

<div class="container-fluid" style="margin-top:80px;">

   <div class="container">

      <label class="h5">welcome : <?php print( $my_user_row[ 'user_name' ] ); ?></label>
      <hr/>

      <h1>
         <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp;
         <a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1>
      <hr/>

      <p class="h4">Another Secure Profile Page</p>

      <p class="blockquote-reverse" style="margin-top:200px;">
         Programming Blog Featuring Tutorials on PHP, MySQL, Ajax, jQuery, Web Design and More...<br/><br/>
         <a href="http://www.codingcage.com/2015/04/php-login-and-registration-script-with.html">tutorial link</a>
      </p>

   </div>

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>
</body>
</html>