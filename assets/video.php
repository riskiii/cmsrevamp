<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
?>
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body id="video" class="page video">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="col-sm-8"> <?php } ?>
            <div class="video-group">

               <h2> Video </h2>

               <object style="width:100%;height:100%;width: 560px; height: 315px;
                              float: none; clear: both; margin: 2px auto;"
                       data="https://www.youtube.com/embed/Yc7-krRX8uA?list=PLIdPxD0zhZDNqp8Iy2WYe43mK16q1aH8J">
               </object>

            </div>
         <?php if ( $user->is_loggedin() == true ) { ?>
         </div>  <?php } ?>
      </main><!-- /.main -->
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>
