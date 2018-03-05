<?php

// This sends a persistent cookie that lasts a day.
session_start( [
   'cookie_lifetime' => 86400,
] );

require_once 'class.user.php';
$session = new USER();

// if user session is not active(not loggedin) this page will help 'home.php and profile.php' to redirect to login page
// put this file within secured pages that users (users can't access without login)
$my_home = getenv( "HOME" );

if ( !$session->is_loggedin() && ( $_SERVER[ 'SCRIPT_FILENAME' ] != ( $my_home . '/Sites/cmsrevamp.dev/admin/reset_password.php' ) ) ) {
   // session no set redirects to login page
   $session->redirect( '/index.php' );
}