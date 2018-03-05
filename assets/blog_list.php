<?php
require_once( "admin/Classes/UserClass/session.php" );
require_once( "admin/Classes/UserClass/class.user.php" );
$user_is_me = new USER();

if ( $user_is_me->is_loggedin() == false ) {
   $user_is_me->redirect( '/login.php' );
}

?>
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body class="page blog-list">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php
         $conn = $database->dbConnection();
         $sql  = 'SELECT article_id, title,
        DATE_FORMAT(created, "%a, %b %D, %Y") AS date_created
        FROM blog ORDER BY created DESC';

         $result    = $conn->query( $sql );
         $errorInfo = $conn->errorInfo();

         if ( isset( $errorInfo[ 2 ] ) ) {
            $error = $errorInfo[ 2 ];
         }

         global $album_name; ?>

         <h2>Manage Blog Entries</h2>

         <p><a class="more" href="blog_insert.php">Insert New Entry</a></p>
         <?php if ( isset( $error ) ) {
            echo "<p>$error</p>";
         } else { ?>
            <div id="blog-list">
               <table class="col-sm-8 table-hover table-striped table-condensed cf">
                  <thead class="cf">
                  <tr>
                     <th>Created</th>
                     <th>Title</th>
                     <th>&nbsp;</th>
                     <th>&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while ( $row = $result->fetch( PDO::FETCH_OBJ ) ) { ?>
                  <tr>
                     <td data-title="Created"><?= $row->date_created; ?></td>
                     <td data-title="Title"><?= $row->title; ?></td>
                     <td data-title="&nbsp;"><a class="more"
                                                href="blog_update.php?article_id=<?= $row->article_id; ?>">EDIT</a>
                     </td>
                     <td data-title="&nbsp;"><a class="more"
                                                href="blog_delete.php?article_id=<?= $row->article_id; ?>">DELETE</a>
                     </td>
                  </tr>
                  <?php } ?>
                  </tbody>
               </table>
            </div> <!-- blog-list -->

         <?php } ?>
      </main> <!-- main col-sm-12 -->
   </div> <!-- content row -->
</div> <!-- wrap container -->

include "footer.php"
include "scripts-footer.php"
</body>
</html>