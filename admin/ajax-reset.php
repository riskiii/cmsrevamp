<?php

header( 'Content-type: application/json' );

require_once( 'Classes/UserClass/dbconfig.php' );
require_once( 'Classes/UserClass/class.user.php' );

$response = array();
$user     = new USER();

if ( $_POST ) {

   $database = new Database();
   $conn     = $database->dbConnection();

   $name  = trim( $_POST[ 'name' ] );
   $email = trim( $_POST[ 'email' ] );
   $pass  = trim( $_POST[ 'cpassword' ] );

   $user_name  = strip_tags( $name );
   $user_email = strip_tags( $email );
   $user_pass  = strip_tags( $pass );

   $user_id = $user->get_UID( $user_name, $user_email );

   if ( $user_id > 0 ) {

      $updated = $user->reset( $user_id, $user_name, $user_email, $user_pass );

   } else {

      $updated = false;
   }

   if ( $updated ) {
      $response[ 'status' ]  = 'success';
      $response[ 'message' ] = '<span class="glyphicon glyphicon-ok"></span> &nbsp; updated sucessfully, you may login now';
   } else {
      $response[ 'status' ]  = 'error'; // could not register
      $response[ 'message' ] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp; could not register, try again later';
   }
}

echo json_encode( $response );