<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<script src="includes/register.js"></script>
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

<body class="page register">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">

   <div class="signup-form-container">

      <!-- form start -->
      <form method="post" role="form" name="register-form" id="register-form" autocomplete="off">

         <div class="form-header">
            <h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Register
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
                  <input name="name" type="text" id="name" class="form-control" placeholder="Name" maxlength="40"
                         autofocus="true">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                  <input name="email" id="email" type="text" class="form-control" placeholder="Email" maxlength="50">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                  <input name="fname" type="text" id="fname" class="form-control" placeholder="First Name"
                         maxlength="40"
                         autofocus="true">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                  <input name="lname" type="text" id="lname" class="form-control" placeholder="Last Name" maxlength="40"
                         autofocus="true">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="row">

               <div class="form-group form-group-zero col-lg-6">
                  <div class="input-group">
                     <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                     <input name="password" id="password" type="password" class="form-control" placeholder="Password">
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
               <span class="glyphicon glyphicon-log-in"></span> &nbsp; Register Now
            </button>
         </div>

      </form>

   </div>

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>

</body>
</html>
