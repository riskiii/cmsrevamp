<?php
/**
 * Created by IntelliJ IDEA.
 * User: riskiii
 * Date: 9/30/16
 * Time: 9:56 PM
 */
?>

<div class="container2">
   <!-- Button to select & upload files -->
   <span class="btn btn-info fileinput-button">
<!--      <i class="glyphicon glyphicon-plus"></i>-->
      <span>Select Image</span>
      <!-- The file input field used as target for the file upload widget -->
    <input id="fileupload" type="file" name="files[]">
  </span>

   <span class="progress-text">
      <!-- The global progress bar -->
      <span>File uploaded:</span>
      <span id="files"></span>
   </span>

   <div id="progress" class="progress">
      <div class="bar progress-bar progress-bar-info progress-bar-striped active"
           role="progressbar">
      </div>
   </div>

</div>