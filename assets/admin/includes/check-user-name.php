<?php

//require_once 'config.php';
require_once( '../Classes/UserClass/dbconfig.php' );

$name = trim( $_REQUEST[ 'name' ] );
$name = strip_tags( $name );

if ( isset( $name ) && !empty( $name ) ) {

   $database = new Database();
   $conn     = $database->dbConnection();

   $query = "SELECT user_name FROM users WHERE user_name=:name";
   $stmt  = $conn->prepare( $query );
   $stmt->execute( array( ':name' => $name ) );

   if ( $stmt->rowCount() >= 1 ) {
      echo 'false'; // name already taken
   } else {
      echo 'true';
   }
}
