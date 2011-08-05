<?php

include_once('header.inc');

?>



<div class="row">

<form id="uploadForm" enctype="multipart/form-data" action="upload.php" method="post">
<div class="column grid_10">


  <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
  Choose a CSV File to Upload <input name="userfile" type="file">



</div>

<div class="column grid_2 nav">

<div id="btnUpload">Continue</div>


</div>

</form>
</div>



<?php

include_once('footer.inc');

?>