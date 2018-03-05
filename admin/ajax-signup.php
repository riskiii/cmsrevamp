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
   $fname = trim( $_POST[ 'fname' ] );
   $lname = trim( $_POST[ 'lname' ] );

   $user_name  = strip_tags( $name );
   $user_email = strip_tags( $email );
   $user_pass  = strip_tags( $pass );
   $user_first = ucwords( strip_tags( $fname ) );
   $user_last  = ucwords( strip_tags( $lname ) );

   $server_name = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

   if ( !empty( $user_pass ) ) {
      $checkPW = password_hash( $user_pass, PASSWORD_DEFAULT );
      if ( $checkPW ) {
         $doubleHashedPW = password_hash( $checkPW, PASSWORD_DEFAULT );
         if ( !$doubleHashedPW ) {
            $response[ 'status' ]  = 'error'; // could not register
            $response[ 'message' ] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp; could not register, try again later';
            die();
         } else {
            $resetUrl = 'http://' . $server_name .
               '/admin/reset_password.php' . "?" .
               'code=' . $doubleHashedPW .
               '&email=' . $user_email .
               '&uname=' . $user_name;

            $from    = 'From: ' . $user_first . ' ' . $user_last;
            $to      = $user_email . ', dgs@riskiii.com';
            $subject = '[' . $_SERVER[ 'SERVER_NAME' ] . ']  Your username and password info';

            $headers = 'From: ' . $user_first . ' ' . $user_last . "\r\n";
            $headers .= "Reply-To: " . $user_email . "]\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $message .= "<!DOCTYPE html>";
            $message .= "<html lang='en'>";
            $message .= "<head>";
            $message .= "   <meta charset='UTF-8'>";
            $message .= "   <title>[" . $server_name . "] Your username and password info</title>";
            $message .= "</head>";
            $message .= "<body>";
            $message .= 'Username: ' . $user_name . '<br><br>';
            $message .= 'To set your password, visit the following address:<br><br>';
            $message .= '<a href="' . $resetUrl . '">' . $resetUrl . '</a><br><br>';
            $message .= 'To login, visit the following address:<br><br>';
            $message .= '<a href="http://' . $server_name . '/login.php">http://' .
               $server_name . '/login.php</a><br><br>';

            $message .= '<br><br>';
            $message .= "</body>";
            $message .= "</html>";

            if ( $user_last != '' && $user_first != '' && $user_email != '' ) {
               mail( $to, $subject, $message, $headers );

               // keep a list of password reset on laptop since email does not work
               $my_home = getenv( "HOME" );
               $file    = $my_home . '/mail_resets.txt';

               // Open the file to get existing content
               $current = file_get_contents( $file );

               // Append date/time
               date_default_timezone_set( 'America/Chicago' );
               $current .= date( "F j, Y, g:i a" ) . "\n";

               // Append the reset url to file
               $current .= $to . "\n" . $resetUrl . "\n\n";

               // Write the contents back to the file
               file_put_contents( $file, $current );

            }
         }

      }
   }

   $registered = $user->register( $user_name, $user_email, $checkPW, $user_first, $user_last );

   if ( $registered ) {
      $response[ 'status' ]  = 'success';
      $response[ 'message' ] = '<span class="glyphicon glyphicon-ok"></span> &nbsp; registered sucessfully, you may login now';
   } else {
      $response[ 'status' ]  = 'error'; // could not register
      $response[ 'message' ] = '<span class="glyphicon glyphicon-info-sign"></span> &nbsp; could not register, try again later';
   }
}

echo json_encode( $response );