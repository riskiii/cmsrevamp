<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
$user_is_me = new USER();

// create database connection
$database  = new Database();
$conn      = $database->dbConnection();
$sql       = 'SELECT * FROM blog ORDER BY created DESC';
$result    = $conn->query( $sql );
$errorInfo = $conn->errorInfo();

if ( isset( $errorInfo[ 2 ] ) ) {
   $error = $errorInfo[ 2 ];
}
?>
include "utility_funcs.php"
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body class="page blog">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="col-sm-8">  <?php } ?>
            <div class="blog-group">
               <h2>Japan Journey </h2>
               <?php
               if ( isset( $error ) ) {
                  echo "<p>$error</p>";

               } else {

                  while ( $row = $result->fetch( PDO::FETCH_OBJ ) ) {
                     if ( $user_is_me->is_loggedin() == true ) {
                        echo '<h3>'
                           . "<a href='details.php?article_id=" .
                           $row->article_id . "'>" . $row->title . '</a>' .
                           '<a href="blog_update.php?article_id=' .
                           $row->article_id . '">' . ' &nbsp;' .
                           '<span class="my-edit fa fa-pencil"></span></a></h3>';
                     } else {
                        echo '<h3>' . '<a href="details.php?article_id=' .
                           $row->article_id . '">' . $row->title . '</a></h3>';
                     }

                     $extract = getFirst( $row->article );

                     echo $extract[ 0 ];

                     if ( $extract[ 1 ] ) {
                        echo '<a class="more" href="details.php?article_id=' .
                           $row->article_id . '"> More</a>';
                     }
                  }
               }
               ?>
            </div>
         <?php if ( $user->is_loggedin() == true ) { ?>
         </div> <!-- .col-sm-8 --!> <?php } ?>

      </main><!-- /.main -->
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>
