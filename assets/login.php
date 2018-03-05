<?php
session_start();
require_once( "admin/Classes/UserClass/class.user.php" );
require_once( "admin/Classes/UserClass/class.ipaddress.php" );
$login   = new USER();
$address = new IpAddress();

if ( isset( $_POST[ 'btn-login' ] ) ) {

   $ip = strip_tags( trim( strip_tags( trim( $_SERVER[ "REMOTE_ADDR" ] ) ) ) );

   $address->delete_old_ips();

   $rows = $address->get_all_locked();

   $address->delete_locked_ip( $ip );

   if ( $address->ip_is_locked( $ip ) ) {

      $error = "User is locked out";
      //?> <script> alert(" User is locked out");</script> <?php

   } else {

      $uname = strip_tags( trim( $_POST[ 'txt_uname_email' ] ) );
      $umail = strip_tags( trim( $_POST[ 'txt_uname_email' ] ) );
      $upass = strip_tags( trim( $_POST[ 'txt_password' ] ) );

      if ( $login->doLogin( $uname, $umail, $upass ) ) {

         $login->redirect( '/index.php' );

      } else {  // failed login attempt

         try {
            $ip = strip_tags( trim( $_SERVER[ "REMOTE_ADDR" ] ) );

            $address->add_ip( $ip );
            $failed_logins = $address->count_ip( $ip );

            if ( $failed_logins > 5 ) {
               // Add lock into locked table
               //?> <script> alert(" User has failed logins");</script> <?php

               $address->lock_ip( $ip, $uname );
            }

         } catch ( PDOException $e ) {

            echo $e->getMessage();

         }

         $error = "Wrong Details !";
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "admin/includes/head.php"; ?>

<body class="page login">

<?php include_once "admin/includes/ie-alert.php"; ?>
<?php include_once "admin/includes/header.php"; ?>

<div class="container">

   <form class="signup-form-container" role="form" method="post" id="login-form" name="login-form">

      <div class="form-header">
         <h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> dgs
            PHP Starter</h3>

         <div class="pull-right">
            <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
         </div>

         <div id="error">
            <?php
            if ( isset( $error ) ) {
               ?>
               <div class="alert alert-danger">
                  <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
               </div>
               <?php
            }
            ?>
         </div>
      </div>  <!-- .form-header -->

      <div class="form-body">

         <div class="form-group">
            <div class="input-group">
               <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
               <input name="txt_uname_email" type="text" id="name" class="form-control"
                      placeholder="User ID or Email Address" maxlength="40"
                      autofocus="true">
            </div>
            <span class="help-block" id="check-e"></span>
         </div>

         <div class="form-group form-group-zero">
            <div class="input-group">
               <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
               <input name="txt_password" id="password" type="password" class="form-control" placeholder="Password">
            </div>
            <span class="help-block" id="error"></span>
         </div>

      </div> <!-- .form-body -->

      <div class="form-footer">
         <div class="row">
            <div class="form-group  col-lg-6">
               <button type="submit" name="btn-login" class="btn btn-info" id="btn-signup">
                  <span class="glyphicon glyphicon-log-in"></span> &nbsp; Login Now
               </button>
            </div>

            <div class="form-group  col-lg-6">
               <a href="admin/forgot_password.php">Forgot password?</a>
            </div>
         </div>
      </div>  <!-- .form-footer -->


   </form>

</div>

<?php include_once "admin/includes/footer.php"; ?>
<?php include_once "admin/includes/scripts-footer.php"; ?>
</body>
</html>