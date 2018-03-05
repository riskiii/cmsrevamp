<?php

//require_once 'config.php';
require_once( '../Classes/UserClass/dbconfig.php' );

$email = trim( $_REQUEST[ 'email' ] );
$email = strip_tags( $email );

if ( isset( $email ) && !empty( $email ) ) {

   $database = new Database();
   $conn     = $database->dbConnection();

   $query = "SELECT user_email FROM users WHERE user_email=:email";
   $stmt  = $conn->prepare( $query );
   $stmt->execute( array( ':email' => $email ) );

   if ( $stmt->rowCount() >= 1 ) {
      echo 'false'; // email already taken
   } else {
      echo 'true';
   }
}