<?php
require_once( "Classes/UserClass/class.user.php" );
$user = new USER();

$first_name = strip_tags( trim( $_POST[ 'first_name' ] ) );
$last_name  = strip_tags( trim( $_POST[ 'last_name' ]  ) );
$email      = strip_tags( trim( $_POST[ 'email' ]      ) );
$comments   = strip_tags( trim( $_POST[ 'comments' ]   ) );
$human      = strip_tags( trim( $_POST[ 'human' ]      ) );

$from    = 'From: ' . $first_name . ' ' . $last_name;
$to      = $email . ',dgs@riskiii.com';
$subject = $_SERVER[ 'SERVER_NAME' ] . ' - Hello from Contact Form';

$headers = 'From: ' . $first_name . ' ' . $last_name . "\r\n";
$headers .= "Reply-To: " . $email . ",dgs@riskiii.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message .= "<!DOCTYPE html>";
$message .= "<html lang='en'>";
$message .= "<head>";
$message .= "   <meta charset='UTF-8'>";
$message .= "   <title>Title</title>";
$message .= "</head>";
$message .= "<body>";
$message .= $comments;
$message .= '<br><br>';
$message .= "</body>";
$message .= "</html>";


//var_dump( $_POST );

$server_name = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );
$submit      = strip_tags( trim( $_POST[ 'submit' ] ) );

if ( $submit != "" ) {
   if ( $last_name != '' && $first_name != '' && $email != '' ) {
      if ( $human == '4' ) {
         if ( mail( $to, $subject, $comments, $from ) ) {

            //echo '<p>Your message has been sent!</p>';
            $user->redirect( 'http://' . $server_name . '/contact.php' );
         } else {
            echo '<p>Something went wrong, go back and try again!</p>';
         }
      } else {
         if ( ( $submit != "" ) && $human != '4' ) {
            echo '<p>You answered the anti-spam question incorrectly!</p>';
         }
      }
   } else {
      echo '<p>You need to fill in all required fields!!</p>';
   }
}