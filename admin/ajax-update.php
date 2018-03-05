<?php

header( 'Content-type: application/json' );

require_once( 'Classes/UserClass/dbconfig.php' );
require_once( 'Classes/UserClass/class.user.php' );

$response = array();
$user     = new USER();

if ( $_POST ) {

   $database = new Database();
   $conn     = $database->dbConnection();

   $uid   = trim( $_POST[ 'user_id' ] );
   $name  = trim( $_POST[ 'name' ] );
   $email = trim( $_POST[ 'email' ] );
   $pass  = trim( $_POST[ 'cpassword' ] );
   $fname = trim( $_POST[ 'fname' ] );
   $lname = trim( $_POST[ 'lname' ] );

   $user_id    = strip_tags( $uid );
   $user_name  = strip_tags( $name );
   $user_email = strip_tags( $email );
   $user_pass  = strip_tags( $pass );
   $user_first = ucwords( strip_tags( $fname ) );
   $user_last  = ucwords( strip_tags( $lname ) );

   $updated = $user->update( $user_id, $user_name, $user_email, $user_pass, $user_first, $user_last );

   if ( $updated ) {
      $response[ 'status' ]  = 'success';
      $response[ 'message' ] = '<span class="glyphicon glyphicon-ok"></span> &nbsp; updated sucessfully, you may login now';
   } else {
      $response[ 'status' ]  = 'error'; // could not register
      $response[ 'message' ] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp; could not register, try again later';
   }
}

echo json_encode( $response );