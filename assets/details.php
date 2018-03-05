<?php
//require_once( "admin/Classes/UserClass/session.php" );
require_once( "admin/Classes/UserClass/class.user.php" );

// create database connection
$user     = new USER;
$database = new Database();
$conn     = $database->dbConnection();

$article_id = strip_tags( trim( $_GET[ 'article_id' ] ) );

// check for article_id in query string
if ( isset( $article_id ) && is_numeric( $article_id ) ) {
   $article_id = (int) strip_tags( trim( $_GET[ 'article_id' ] ) );
} else {
   $article_id = 0;
}

$sql = "SELECT title, article, article_id, DATE_FORMAT(updated, '%W, %M %D, %Y') AS updated, filename, caption
        FROM blog LEFT JOIN images USING (image_id)
        WHERE blog.article_id = $article_id";

$result = $conn->prepare( $sql );
$result->execute();
$row = $result->fetch( PDO::FETCH_OBJ );

?>
include "utility_funcs.php"
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body id="details" class="page details">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="main col-sm-8"> <?php } ?>
            <div class="details-group">

               <h2>Japan Journey </h2>

               <h3><?php if ( $row ) {
                     if ( $user->is_loggedin() == true ) {
                        echo $row->title .
                           '<a href="blog_update.php?article_id=' .
                           $row->article_id . '">' .
                           ' &nbsp;' .
                           '<span class="my-edit fa fa-pencil"></span></a></h3>';
                     } else {
                        echo $row->title . '</h3>';
                     }
                  } else {
                     echo 'No record found';
                  }
                  ?>
               <p><?php if ( $row ) {
                     echo $row->updated;
                  } ?></p>
               <?php
               if ( $row && !empty( $row->filename ) ) {
                  $filename  = "admin/files/" . $row->filename;
                  $imageSize = getimagesize( $filename )[ 3 ];
                  ?>
                  <figure>
                     <img src="<?= $filename; ?>" alt="<?= $row->caption; ?>" <?= $imageSize; ?>>
                  </figure>
               <?php }
               if ( $row ) {
                  echo convertToParas( $row->article );
               } ?>
               <p><a class="more" href="
                <?php
                  // check that browser supports $_SERVER variables
                  $http_referer = strip_tags( trim( $_SERVER[ 'HTTP_REFERER' ] ) );
                  $http_host    = strip_tags( trim( $_SERVER[ 'HTTP_HOST' ] ) );
                  if ( isset( $http_referer ) && isset( $http_host ) ) {
                     $url = parse_url( $http_referer );

                     // find if visitor was referred from a different domain
                     if ( $url[ 'host' ] == $http_host ) {

                        // if same domain, use referring URL
                        echo $http_referer;
                     }
                  } else {

                     // otherwise, send to main page
                     echo 'blog.php';
                  } ?>">Back to the blog</a>
               </p>
            </div>
            <?php if ( $user->is_loggedin() == true ) { ?>
         </div> <?php } ?>
      </main><!-- /.main -->
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>