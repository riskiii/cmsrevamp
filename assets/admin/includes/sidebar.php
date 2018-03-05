<?php
if ( $user_is_me->is_loggedin() ) {
   ?>
   <div class="sidebar col-sm-4">
      <nav class="nav-sidebar">
         <ul>
            <li><a href="/add_artists.php">Add Artists</a></li>
            <li><a href="/add_albums.php">Add Albums</a></li>
            <li><a href="/add_songs.php">Add Songs</a></li>
            <li><a href="/blog_list.php">Blog List/Delete/Update</a></li>
            <li><a href="/blog_insert.php">Blog Insert</a></li>
         </ul>
      </nav>
   </div>
<?php } ?>