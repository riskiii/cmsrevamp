<?php
$document_root = strip_tags( trim( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
include_once $document_root . "/admin/includes/misc-fonts.php";
?>
<footer class="content-info" style="background:#efefef; ">
   <div class="container">
      <small>&copy; <?php echo ( new \DateTime() )->format( 'Y' ); ?> <a
            href="http://campfirepixels.com">campfirepixels.com</a></small>
   </div>
</footer>
