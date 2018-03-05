<?php

require_once( 'dbconfig.php' );

/**
 * Created by IntelliJ IDEA.
 * User: riskiii
 * Date: 10/5/16
 * Time: 7:20 PM
 */
class IpAddress {

   /**
    * @var null|PDO
    */
   private $conn;

   /**
    * IpAddress constructor.
    */
   public function __construct() {
      $database   = new Database();
      $this->conn = $database->dbConnection();
   }

   /**
    * @param $ip
    * @return bool|int
    */
   public function ip_is_locked( $ip ) {

      try {

         $ip = strip_tags( trim( $ip ) );

         $sql = "SELECT address, user_name, time_stamp, is_locked 
                  FROM  locked 
                  WHERE address    =  '$ip'";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":ip",    $ip );
         $stmt->bindParam( ":uname", $user_name );
         $stmt->bindParam( ":utime", $timestamp );
         $stmt->bindParam( ":is_locked", $is_locked );

         $result   = $stmt->execute();
         $rows     = $stmt->fetchAll( PDO::FETCH_OBJ );
         $ip_count = count( $rows );

         if ( $ip_count > 0 ) {
            return ( true );
         } else {
            return ( false );
         }

      } catch ( PDOException $e ) {

         echo $e->getMessage();

         return -1;
      }
   }


   /**
    * @param $ip
    * @return bool
    */
   public function add_ip( $ip ) {

      try {

         $ip = strip_tags( trim( $ip ) );

         $sql = "INSERT INTO `ip` ( `address`, `time_stamp` ) VALUES ('$ip', now() )";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":address", $ip );

         $result = $stmt->execute();

      } catch ( PDOException $e ) {

         echo $e->getMessage();

         return( false );

      }

      return( $result );
   }


   /**
    * @param $ip
    * @return bool|int
    */
   public function count_ip( $ip ) {

      try {

         $ip = strip_tags( trim( $ip ) );

         $sql = "SELECT `address` FROM `ip` WHERE `address` = '$ip' AND `time_stamp` > (now() - interval 90 minute)";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":address", $ip );

         $result        = $stmt->execute();
         $rows          = $stmt->fetchAll( PDO::FETCH_OBJ );
         $failed_logins = count( $rows );

         return ( $failed_logins );

      } catch ( PDOException $e ) {

         echo $e->getMessage();

         return( false );
      }
   }


   /**
    * @param $ip
    * @param $user_name
    * @return bool
    */
   public function lock_ip( $ip, $user_name ) {

      try {

         $ip        = strip_tags( trim( $ip ) );
         $user_name = strip_tags( trim( $user_name ) );

         $sql = "INSERT INTO `locked` ( `address`, `user_name`, `time_stamp`, `is_locked` ) 
                 VALUES ('$ip', '$user_name', now(), true )";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":address",   $ip );
         $stmt->bindParam( ":user_name", $user_name );

         $result = $stmt->execute();

         return( $result );

      } catch ( PDOException $e ) {

         echo $e->getMessage();
         return( false );

      }
   }


   /**
    * @return bool
    */
   public function delete_old_ips() {

      try {

         $sql = "DELETE FROM ip WHERE time_stamp < DATE_SUB(NOW(), INTERVAL 90 minute)";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":address", $ip );

         $result = $stmt->execute();
         return( $result );

      } catch ( PDOException $e ) {

         echo $e->getMessage();
         return( false );

      }
   }


   /**
    * @param $ip_id
    * @return bool
    */
   public function ip_delete( $ip_id ) {

      try {

         $ip_id = strip_tags( trim( $ip_id ) );

         $sql = "DELETE FROM ip WHERE ip_id = '$ip_id'";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":ip_id", $ip_id );

         $result = $stmt->execute();
         return( $result );

      } catch ( PDOException $e ) {

         echo $e->getMessage();
         return( false );

      }
   }


   /**
    * @return array|bool
    */
   public function get_all_locked() {

      try {
         $sql = "SELECT locked_id, `address`, user_name, time_stamp, is_locked 
                  FROM  locked
                  ORDER BY `address` ASC";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":locked_id",  $locked_id );
         $stmt->bindParam( ":address",    $address );
         $stmt->bindParam( ":user_name",  $user_name );
         $stmt->bindParam( ":time_stamp", $timestamp );
         $stmt->bindParam( ":is_locked",  $is_locked );

         $result = $stmt->execute();
         $rows   = $stmt->fetchAll( PDO::FETCH_CLASS, "IpAddress" );

         return ( $rows );

      } catch ( PDOException $e ) {

         echo $e->getMessage();

         return ( false );
      }
   }


   /**
    * @param $locked_id
    * @return bool
    */
   public function delete_locked_ip( $locked_id ) {

      try {

         $locked_id = strip_tags( trim( $locked_id ) );

         $sql = "DELETE FROM locked WHERE locked_id = '$locked_id'";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":locked_id", $locked_id );

         $result = $stmt->execute();
         return ( $result );

      } catch ( PDOException $e ) {

         echo $e->getMessage();
         return ( false );

      }
   }


   /**
    * @return array|bool
    */
   public function get_all_ips() {

      try {
         $sql = "SELECT `ip_id`, `address`, `time_stamp` 
                  FROM  `ip`
                  ORDER BY `address` ASC";

         $stmt = $this->conn->prepare( $sql );

         // bind the parameters and execute the statement
         $stmt->bindParam( ":ip_id",      $ip_id );
         $stmt->bindParam( ":address",    $address );
         $stmt->bindParam( ":time_stamp", $time_stamp );

         $result = $stmt->execute();
         $rows   = $stmt->fetchAll( PDO::FETCH_CLASS, "IpAddress" );

         return ( $rows );

      } catch ( PDOException $e ) {

         echo $e->getMessage();
         return ( false );
      }
   }
}