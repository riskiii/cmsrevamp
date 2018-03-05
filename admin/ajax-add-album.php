<?php

header( 'Content-type: application/json' );

require_once( 'Classes/UserClass/dbconfig.php' );
require_once( 'Classes/UserClass/class.user.php' );

$response = array();
$user     = new USER();

if ( !empty( $_POST ) ) {
   $database = new Database();
   $conn     = $database->dbConnection();
   $stmt     = $conn->prepare( "INSERT INTO albums (album_name, artist_id, album_release, album_image) VALUE (:album_name, :artist_id, :album_release, :album_image)" );
   $stmt->bindParam( ":album_name", $album_name );
   $stmt->bindParam( ":artist_id", $artist_id );
   $stmt->bindParam( ":album_release", $album_release );
   $stmt->bindParam( ":album_image", $album_image );

   // insert one row
   // http://php.net/manual/en/features.cookies.php
   $album_name    = strip_tags( trim( $_POST[ "album_name" ] ) );
   $album_release = strip_tags( trim( $_POST[ "album_release" ] ) );
   $artist_id     = strip_tags( trim( $_POST[ "artist_id" ] ) );
   $album_image   = strip_tags( trim( $_COOKIE[ "dgs_cookie" ] ) );
   unset( $_COOKIE[ "dgs_cookie" ] );
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