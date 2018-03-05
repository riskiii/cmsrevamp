<?php
session_start();
require_once( "Classes/UserClass/class.user.php" );
$user_is_me  = new USER();
$my_user_row = array();

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<body class="page forgot-password">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>

<div class="container">

   <form class="signup-form-container" role="form" action="mail.php" method="post" id="forgot-form">

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

      </div> <!-- .form-body -->

      <div class="form-footer">
         <div class="row">
            <div class="form-group  col-lg-6">
               <button type="submit" name="btn-reset" class="btn btn-info" id="btn-reset">
                  <span class="glyphicon glyphicon-log-in"></span> &nbsp; Get email to reset password
               </button>
            </div>
         </div>
      </div>  <!-- .form-footer -->

   </form>

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>
</body>
</html>