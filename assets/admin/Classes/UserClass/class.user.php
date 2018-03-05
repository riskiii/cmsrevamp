<?php

require_once( 'dbconfig.php' );


/**
 * Class USER
 */
class USER {

   /**
    * @var null|PDO
    */
   private $conn;


   /**
    * USER constructor.
    */
   public function __construct() {
      $database   = new Database();
      $db         = $database->dbConnection();
      $this->conn = $db;
   }

   /**
    * @param $uname
    * @param $umail
    * @param $upass
    * @param $ufirst
    * @param $ulast
    * @return bool|PDOStatement
    */
   public function register( $uname, $umail, $upass, $ufirst, $ulast ) {
      try {

         //$new_password = password_hash( $upass, PASSWORD_DEFAULT );
         ini_set( "date.timezone", "America/Chicago" );
         $joining_date = date( 'Y-m-d G:i:s' );;

         $stmt = $this->conn->prepare( 'INSERT INTO users( user_name, user_email, user_pass, user_first, user_last, joining_date ) 
		                                             VALUES( :uname, :umail, :upass, :ufirst, :ulast, :udate )' );

         $stmt->bindParam( ":uname",  $uname );
         $stmt->bindParam( ":umail",  $umail );
         $stmt->bindParam( ":ufirst", $ufirst );
         $stmt->bindParam( ":ulast",  $ulast );
         $stmt->bindParam( ":upass",  $upass );
         $stmt->bindParam( ":udate",  $joining_date );

         $stmt->execute();

         return $stmt;
      } catch ( PDOException $e ) {
         echo $e->getMessage();

         return ( false );
      }
   }

   /**
    * @param $user_id
    * @param $uname
    * @param $umail
    * @param $upass
    * @param $ufirst
    * @param $ulast
    * @return bool|PDOStatement
    */
   public function update( $user_id, $uname, $umail, $upass, $ufirst, $ulast ) {
      try {

         $new_password = password_hash( $upass, PASSWORD_DEFAULT );
         ini_set( "date.timezone", "America/Chicago" );
         $joining_date = date( 'Y-m-d G:i:s' );;

         $stmt = $this->conn->prepare( "UPDATE users
                                        SET `user_id`      = :user_id,
                                            `user_name`    = :uname,
                                            `user_email`   = :umail,
                                            `user_pass`    = :upass,
                                            `user_first`   = :ufirst,
                                            `user_last`    = :ulast
                                        WHERE
                                            `user_id`      = :user_id"
         );

         $stmt->bindParam( ":user_id", $user_id );
         $stmt->bindParam( ":uname", $uname );
         $stmt->bindParam( ":umail", $umail );
         $stmt->bindParam( ":ufirst", $ufirst );
         $stmt->bindParam( ":ulast", $ulast );
         $stmt->bindParam( ":upass", $new_password );
         $stmt->bindParam( ":udate", $joining_date );

         $stmt->execute();

         return $stmt;

      } catch ( PDOException $e ) {
         echo $e->getMessage();

         return ( false );
      }
   }

   /**
    * @param $user_id
    * @param $uname
    * @param $umail
    * @param $upass
    * @return bool|PDOStatement
    */
   public function reset( $user_id, $uname, $umail, $upass ) {
      try {

         $new_password = password_hash( $upass, PASSWORD_DEFAULT );
         ini_set( "date.timezone", "America/Chicago" );
         $joining_date = date( 'Y-m-d G:i:s' );

         $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

         $stmt = $this->conn->prepare( "UPDATE users
                                        SET `user_id`      = :user_id,
                                            `user_name`    = :uname,
                                            `user_email`   = :umail,
                                            `user_pass`    = :upass
                                        WHERE
                                            `user_name`    = :uname
                                        OR  `user_email`   = :umail"
         );

         $stmt->bindParam( ":user_id", $user_id );
         $stmt->bindParam( ":uname", $uname );
         $stmt->bindParam( ":umail", $umail );
         $stmt->bindParam( ":upass", $new_password );
         $stmt->bindParam( ":udate", $joining_date );

         $stmt->execute();

         return $stmt;

      } catch ( PDOException $e ) {
         echo $e->getMessage();

         return ( false );
      }
   }

   /**
    * @param $uname
    * @param $umail
    * @param $upass
    * @return bool
    */
   public function doLogin( $uname, $umail, $upass ) {
      try {
         $stmt = $this->conn->prepare( 'SELECT user_id, user_name, user_email, user_pass 
                                        FROM users 
                                        WHERE user_name=:uname 
                                        OR user_email=:umail ' );

         $stmt->execute( array( ':uname' => $uname, ':umail' => $umail ) );
         $userRow = $stmt->fetch( PDO::FETCH_OBJ );

         if ( $stmt->rowCount() == 1 ) {
            if ( password_verify( $upass, $userRow->user_pass ) ) {

               $_SESSION[ 'user_session' ] = $userRow->user_id;

               ini_set( "date.timezone", "America/Chicago" );
               $login_date = date( 'Y-m-d G:i:s' );;

               $stmt2 = $this->conn->prepare( 'UPDATE `users` 
                                                  SET `last_logon` = :ulogon
		                                          WHERE `user_name`  = :uname 
		                                             OR `user_email` = :umail' );

               $stmt2->execute( array( ':uname' => $uname, ':umail' => $umail, ':ulogon' => $login_date ) );
               try {
                  return true;

               } catch ( PDOException $e ) {
                  echo $e->getMessage();

                  return false;
               }

            } else {

               return false;
            }
         }
      } catch ( PDOException $e ) {

         echo $e->getMessage();

         return false;
      }
   }

   /**
    * @param $uname
    * @param $umail
    * @return bool
    */
   public function get_UID( $uname, $umail ) {
      try {
         $stmt = $this->conn->prepare( 'SELECT user_id, user_name, user_email 
                                        FROM users 
                                        WHERE user_name=:uname OR user_email=:umail ' );

         $stmt->execute( array( ':uname' => $uname, ':umail' => $umail ) );
         $userRow = $stmt->fetch( PDO::FETCH_OBJ );

         if ( $stmt->rowCount() == 1 ) {

            return $userRow->user_id;

         } else {

            return false;
         }

      } catch ( PDOException $e ) {

         echo $e->getMessage();

         return false;
      }
   }

   /**
    * @param $my_var
    * @return bool
    */
   public function my_var_dump( $my_var ) {
      try {

         echo "<pre><code>";
         var_dump( $my_var );
         echo "</code></pre>";

      } catch ( PDOException $e ) {
         echo $e->getMessage();

         return false;
      }
   }

   /**
    * @param $uname
    * @param $umail
    * @return bool|mixed
    */
   public function get_user( $uname, $umail ) {
      try {
         $stmt = $this->conn->prepare( 'SELECT * 
                                        FROM users 
                                        WHERE user_name=:uname 
                                        OR user_email=:umail ' );
         $stmt->execute( array( ':uname' => $uname, ':umail' => $umail ) );
         $userRow = $stmt->fetch( PDO::FETCH_OBJ );

         if ( $stmt->rowCount() == 1 ) {

            return $userRow;

         } else {

            return false;
         }

      } catch ( PDOException $e ) {
         echo $e->getMessage();

         return false;
      }
   }

   /**
    * @return bool|mixed
    */
   public function get_user_row() {

      try {

         $my_user_id = $_SESSION[ 'user_session' ];

         $stmt = $this->runQuery( "SELECT * FROM users WHERE user_id=:user_id" );
         $stmt->execute( array( ":user_id" => $my_user_id ) );

         $userRow = $stmt->fetch( PDO::FETCH_OBJ );

         return ( $userRow );

      } catch ( PDOException $e ) {
         echo $e->getMessage();

         return false;
      }
   }

   /**
    * @param $sql
    * @return PDOStatement
    */
   public function runQuery( $sql ) {
      $stmt = $this->conn->prepare( $sql );

      return $stmt;
   }

   /**
    * @return bool
    */
   public function is_loggedin() {
      if ( isset( $_SESSION[ 'user_session' ] ) ) {
         return true;
      }
   }


   /**
    * @param $url
    */
   public function redirect( $url ) {
      $string = '<script type="text/javascript">';
      $string .= 'window.location = "' . $url . '"';
      $string .= '</script>';

      echo $string;
   }


   /**
    * @return bool
    */
   public function doLogout() {
      session_destroy();
      unset( $_SESSION[ 'user_session' ] );

      return true;
   }
}

