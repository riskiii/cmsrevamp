<?php

header( 'Content-type: application/json' );

require_once( 'Classes/UserClass/dbconfig.php' );
require_once( 'Classes/UserClass/class.user.php' );

$response = array();
$user     = new USER();

// Only process the form if $_POST isn't empty
if ( !empty( $_POST ) ) {
   $artist_name = strip_tags( trim( $_POST[ "artist_name" ] ) );

   $database = new Database();
   $conn     = $database->dbConnection();

   $conn = $database->dbConnection();
   $stmt = $conn->prepare( "INSERT INTO artists ( artist_name ) VALUE ( :artist_name )" );
   $stmt->bindParam( ":artist_name", $artist_name );

   // insert one row
   $registered = $stmt->execute();

   if ( $registered === true ) {
      $response[ 'status' ]  = 'success';
      $response[ 'message' ] = '<span class="glyphicon glyphicon-ok"></span> &nbsp; added artist sucessfully';
   } else {
      $response[ 'status' ]  = 'error'; // could not register
      $response[ 'message' ] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp; could not register, try again later';
   }
}

echo json_encode( $response );