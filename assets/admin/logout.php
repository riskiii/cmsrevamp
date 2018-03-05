<?php
require_once( 'Classes/UserClass/session.php' );
require_once( 'Classes/UserClass/class.user.php' );
$user_logout = new USER();

$user_logout->doLogout();
$user_logout->redirect( '/login.php' );

