<?php
//require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

// http://stackoverflow.com/questions/6585649/php-forgot-password-function
// eg url to send http://yourdomain.com/resetpassword.php?code=md5codesentviaemail
// http://html.net/tutorials/php/lesson10.php

$doubleHashedPW = !empty( trim( $_GET[ 'code'  ] ) )               ?             trim( $_GET[ 'code' ] ) : '';
$email          = !empty( strip_tags( trim( $_GET[ 'email' ] ) ) ) ? strip_tags( trim( $_GET[ 'email' ] ) ) : '';
$uname          = !empty( strip_tags( trim( $_GET[ 'uname' ] ) ) ) ? strip_tags( trim( $_GET[ 'uname' ] ) ) : '';

$thePassword    = '';
$other_user_row = array();

if ( empty( $doubleHashedPW ) || empty( $email ) || empty( $uname ) ) {
   die();
}

$user_is_other  = new USER();
$other_user_row = $user_is_other->get_user( $uname, $email );

if ( !empty( $other_user_row->user_pass ) ) {
   $thePassword = $other_user_row->user_pass;

} else {

   die();
}

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<script src="includes/reset_password.js"></script>
<script type="text/javascript">

   $(function () {
      $("#password").keyup(function () {
         initializeStrengthMeter();
      });

      $("#cpassword").keyup(function () {
         initializeStrengthMeter();
      });
   });

   function initializeStrengthMeter() {
      $("#pass_meter").PasswordStrengthManager({
         password: $("#password").val(),
         confirm_pass: $("#cpassword").val(),
         blackList: ["efewf"],
         minChars: '8',
         maxChars: '15',
         advancedStrength: true
      });
   }

</script>

<body class="page reset-password">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">

   <div class="signup-form-container">

      <?php if ( password_verify( $thePassword, $doubleHashedPW ) == true ) { ?>

         <!-- form start -->
         <form method="post" role="form" id="reset-form" autocomplete="off">

            <div class="form-header">
               <h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Choose
                  new
                  password
               </h3>

               <div class="pull-right">
                  <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
               </div>

            </div>

            <div class="form-body">

               <!-- json response will be here -->
               <div id="errorDiv"></div>
               <!-- json response will be here -->

               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                     <input name="name" type="hidden" id="name" class="form-control" placeholder="Name" maxlength="40"
                            autofocus="true" value="<?php echo $uname ?>">
                  </div>
                  <span class="help-block" id="error"></span>
               </div>

               <div class="form-group">
                  <div class="input-group">
                     <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                     <input name="email" id="email" type="hidden" class="form-control"
                            placeholder="Email" maxlength="50" value="<?php echo $email ?>">
                  </div>
                  <span class="help-block" id="error"></span>
               </div>

               <div class="row">

                  <div class="form-group form-group-zero col-lg-6">
                     <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input name="password" id="password" type="password" class="form-control"
                               placeholder="Password">
                     </div>
                     <span class="help-block" id="error"></span>
                  </div>

                  <div class="form-group form-group-zero col-lg-6">
                     <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input name="cpassword" id="cpassword" type="password" class="form-control"
                               placeholder="Retype Password">
                     </div>
                     <span class="help-block" id="error"></span>
                  </div>

                  <div class='clear_both'></div>
                  <div id='pass_meter'></div>

               </div>

            </div>

            <div class="form-footer">
               <button type="submit" class="btn btn-info" id="btn-signup">
                  <span class="glyphicon glyphicon-log-in"></span> &nbsp; Reset Password Now
               </button>
            </div>

         </form>

      <?php } else { ?>

         <p><span class="alert-danger"> &nbsp; could not reset password, try again later</span></p>

      <?php } ?>

   </div>

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>

</body>
</html>
