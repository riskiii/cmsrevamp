<?php
require_once( "admin/Classes/UserClass/class.user.php" );
$user = new USER();
?>
<!DOCTYPE html>
<html lang="en-US">
include "head.php"

<body id="contact" class="page contact">

include "ie-alert.php"
include "header.php"

<div class="wrap container" role="document">
   <div class="content row">
      <main class="main col-sm-12">
         include "menu.php"
         include "sidebar.php"

         <?php if ( $user->is_loggedin() == true ) { ?>
         <div class="contact col-sm-8"> <?php } ?>
            <div class="contact-group">
               <div class="contact-container">
                  <h2 class="cuh2">CONTACT US &nbsp;</h2>
                  <h3>Fill out the form below to learn more!</h3>
                  <form method="post" action="admin/mail-contact.php" class="form-horizontal">
                     <div class="form-group">
                        <label for="first_name" class="contact-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" placeholder="John" class="form-control"/>
                     </div>
                     <div class="form-group">
                        <label for="last_name" class="contact-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Smith" class="form-control"/>
                     </div>
                     <div class="form-group">
                        <label for="email" class="contact-label">Email <span class="req">*</span></label>
                        <input type="email" name="email" placeholder="john.smith@gmail.com" class="form-control"/>
                     </div>

                     <div class="form-group">
                        <label for="comments" class="contact-label">Comments</label>
                        <textarea rows="10" name="comments" class="form-control"></textarea>
                     </div>
                     <div class="form-group">
                        <label class="contact-label">*What is 2+2? (Anti-spam)</label>
                        <input name="human" placeholder="Type Here" class="form-control">
                     </div>
                     <div class="form-group">
                        <input id="submit" class="btn btn-info" name="submit" type="submit" value="Contact Us">
                     </div>
                  </form>
               </div>
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
