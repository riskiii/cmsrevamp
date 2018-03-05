<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
?>
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body id="home" class="page home">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="col-sm-8">  <?php } ?>
            <div class="home-group">
               <h2> Home </h2>

               <p class="p1">Pentatonix (often abbreviated as PTX) is an American a cappella group consisting of five
                  vocalists
                  originating from Arlington, Texas.[2] The members in this group are Avi Kaplan, Scott Hoying,
                  Kirstin
                  Maldonado, Kevin Olusola, and Mitch Grassi. Their work, which is mostly in the pop style, consists
                  of
                  covers
                  of
                  existing songs, sometimes in the form of medleys, along with original material. Their music is
                  defined by
                  their
                  own arrangement style, tight vocal harmonies, extensive vocal riffing, deep and steady vocal
                  basslines,
                  and
                  a
                  diverse range of vocal percussion and beatboxing.
               </p>

            </div> <!-- .home-group -->

            <div class="home-vid">
               <h3 class="fv"> Featured Video </h3><br>
               <p class="vidw">This Month&#39;s featured video is sing</p><br>

               <object style="width:100%;height:100%;width: 380px; height: 214px;
                              float: none; clear: both; margin: 2px auto;"
                       data="https://www.youtube.com/embed/Yc7-krRX8uA">
               </object>
            </div>
            <?php if ( $user->is_loggedin() == true ) { ?>
         </div> <!-- .col-sm-8 --> <?php } ?>
      </main><!-- /.main -->
   </div>
</div>

include "footer.php"
include "scripts-footer.php"
</body>
</html>
