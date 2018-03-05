<?php
if ( $user_is_me->is_loggedin() ) {
   ?>
   <div id="wrapper">
      <div class="sidebar-wrapper">
         <ul class="sidebar-nav">
            <li><a href="/add_artists.php">Add Artists</a></li>
            <li><a href="/add_albums.php">Add Albums</a></li>
            <li><a href="/add_songs.php">Add Songs</a></li>
            <li><a href="/blog_list_pdo.php">Blog List/Delete/Update</a></li>
            <li><a href="/blog_insert_pdo.php">Blog Insert</a></li>
         </ul>
      </div>
<?php } ?>

<!-- Menu Toggle Script -->
<script>
   $("#menu-toggle").click(function (e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
   });
</script>

