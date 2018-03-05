<?php
require_once( "Classes/UserClass/class.user.php" );
$user    = new USER();
$userRow = array();

$uname = strip_tags( trim( $_POST[ 'txt_uname_email' ] ) );
$umail = strip_tags( trim( $_POST[ 'txt_uname_email' ] ) );

$userRow = $user->get_user( $uname, $umail );

$user_name  = $userRow->user_name;
$user_email = $userRow->user_email;
$user_pass  = $userRow->user_pass;
$user_first = $userRow->user_first;
$user_last  = $userRow->user_last;

//$user->my_var_dump( $user );

$server_name = strip_tags( trim( $_SERVER[ 'SERVER_NAME' ] ) );

if ( !empty( $userRow->user_pass ) ) {
   $doubleHashedPW = password_hash( $userRow->user_pass, PASSWORD_DEFAULT );
   $resetUrl       = 'http://' . $server_name .
      '/admin/reset_password.php' . "?" .
      'code=' . $doubleHashedPW .
      '&email=' . $user_email .
      '&uname=' . $user_name;

   $from    = 'From: ' . $user_first . ' ' . $user_last;
   $to      = $userRow->user_email . ', dgs@riskiii.com';
   $subject = $_SERVER[ 'SERVER_NAME' ] . '  Password Reset';

   $headers = 'From: ' . $user_first . ' ' . $user_last . "\r\n";
   $headers .= "Reply-To: " . $userRow->user_email . "\r\n";
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

   $message .= "<!DOCTYPE html>";
   $message .= "<html lang='en'>";
   $message .= "<head>";
   $message .= "   <meta charset='UTF-8'>";
   $message .= "   <title>Title</title>";
   $message .= "</head>";
   $message .= "<body>";
   $message .= 'Someone has requested a password reset for the following account:<br><br>';
   $message .= '<a href="http://' . $server_name . '">http://' . $server_name . '/</a><br><br>';
   $message .= 'Username: ' . $user_name . '<br><br>';
   $message .= 'If this was a mistake, just ignore this email and nothing will happen.<br>';
   $message .= 'To reset your password, visit the following address:<br><br>';
   $message .= '<a href="' . $resetUrl . '">' . $resetUrl . '</a><br>';
   $message .= '<br><br>';
   $message .= "</body>";
   $message .= "</html>";

   // keep a list of password reset on laptop since email does not work
   $my_home = getenv( "HOME" );
   $file = $my_home . '/mail_resets.txt';

   // Open the file to get existing content
   $current = file_get_contents( $file );

   // Append date/time
   date_default_timezone_set('America/Chicago');
   $current .= date("F j, Y, g:i a") . "\n";

   // Append the reset url to file
   $current .= $to . "\n" . $resetUrl  . "\n\n";

   // Write the contents back to the file
   file_put_contents($file, $current);

} else {

   echo "No user found!";
}

if ( $_POST ) {
   if ( $user_last != '' && $user_first != '' && $user_email != '' ) {
      if ( mail( $to, $subject, $message, $headers ) ) {
         //echo '<p>Your message has been sent!</p>';
         $user->redirect( 'http://' . $_SERVER[ 'SERVER_NAME' ] . '/login.php' );

      } else {
         echo '<p>Something went wrong, go back and try again!</p>';
      }

   } else {
      echo '<p>You need to fill in all required fields!!</p>';
   }
}