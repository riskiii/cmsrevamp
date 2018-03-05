<?php
require_once( "Classes/UserClass/session.php" );
require_once( "Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

$OK   = false;
$done = false;

$user_is_other = new USER();
$user_id       = strip_tags( trim( $_GET[ 'user_id' ] ) );

// get details of selected record
if ( isset( $user_id ) && !$_POST ) {

   try {
      // create database connection
      $stmt = $user_is_other->runQuery( "SELECT * FROM users WHERE user_id=:user_id" );
      $stmt->execute( array( ":user_id" => $user_id ) );

      $otherUserRow = $stmt->fetch( PDO::FETCH_ASSOC );

   } catch ( PDOException $e ) {

      echo $e->getMessage();

      return false;
   }
}

$update = strip_tags( trim( $_POST[ 'update' ] ) );

// if form has been submitted, update record
if ( $update != "" ) {

   try {
      // prepare update query
      // create database connection
      $database2 = new Database();
      $conn2     = $database2->dbConnection();
      $sql       = 'UPDATE users 
                    SET user_id    =  :user_id, 
                        user_name  =  :user_name, 
                        user_email =  :user_email, 
                        user_first =  :user_first, 
                        user_last  =  :user_last, 
                        user_pass  =  :user_pass
                    WHERE user_id  =  :user_id2';
      $stmt2     =  $conn2->prepare( $sql );

      // execute query by passing array of variables
      $done = $stmt2->execute( array(
         ":user_id"    => $user_id,
         ":user_name"  => $name,
         ":user_email" => $email,
         ":user_first" => $fname,
         ":user_last"  => $lname,
         ":user_pass"  => $password,
         ":user_id2"   => $user_id
      ) );

   } catch ( PDOException $e ) {

      echo $e->getMessage();

      return false;
   }
}

?>
<!DOCTYPE html>
<html lang="en-US">
<?php include_once "includes/head.php"; ?>

<script src="includes/user-update.js"></script>
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

<body id="user-update" class="page user-update">

<?php include_once "includes/ie-alert.php"; ?>
<?php include_once "includes/header.php"; ?>
<div class="container">

   <div class="signup-form-container">

      <!-- form start -->
      <form method="post" role="form" id="register-form" autocomplete="off">

         <div class="form-header">
            <h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Update
            </h3>

            <div class="pull-right">
               <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
            </div>

         </div>

         <div class="form-body">

            <!-- json response will be here -->
            <div id="errorDiv"></div>
            <!-- json response will be here -->

            <input name="user_id" type="hidden" id="user_id" class="form-control" placeholder="ID" maxlength="40"
                   autofocus="true" value="<?php echo $otherUserRow[ 'user_id' ] ?>">

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                  <input name="name" type="text" id="name" class="form-control" placeholder="Name" maxlength="40"
                         autofocus="true" value="<?php echo $otherUserRow[ 'user_name' ] ?>">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                  <input name="email" id="email" type="text" class="form-control"
                         placeholder="Email" maxlength="50" value="<?php echo $otherUserRow[ 'user_email' ] ?>">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                  <input name="fname" type="text" id="fname" class="form-control"
                         placeholder="First Name" maxlength="40" autofocus="true"
                         value="<?php echo $otherUserRow[ 'user_first' ] ?>">
               </div>
               <span class="help-block" id="error"></span>
            </div>

            <div class="form-group">
               <div class="input-group">
                  <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                  <input name="lname" type="text" id="lname" class="form-control" placeholder="Last Name"
                         maxlength="40"
                         autofocus="true" value="<?php echo $otherUserRow[ 'user_last' ] ?>">
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
            <button type="submit" class="btn btn-info" name="update" id="btn-signup">
               <span class="glyphicon glyphicon-log-in"></span> &nbsp; Update Now
            </button>
         </div>

      </form>

   </div>

</div>

<?php include_once "includes/footer.php"; ?>
<?php include_once "includes/scripts-footer.php"; ?>

</body>
</html>
