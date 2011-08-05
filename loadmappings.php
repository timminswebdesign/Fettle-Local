<?php
header("Content-type: text/xml");
 echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n"; 
 echo "<rows>\n"; 
 
 
include_once('dbconnect.inc');



$templateid = $_POST['templateid'];


$query = "select * from mappings where templateid = ".$templateid;

	
$results = $db->query($query);

$row_cnt = $results->num_rows;



while ($row = $results->fetch_assoc()) {
	echo '<row>
			<ownertable>'.$row["ownertable"].'</ownertable>
			<original>'.$row["original"].'</original>
			<newname>'.$row["newname"].'</newname>
			<enabled>'.$row["enabled"].'</enabled>
			<isgl>'.$row["isgl"].'</isgl>
			<deftbl>'.$row["deftbl"].'</deftbl>
		 </row>';
}


	





	$results->close();

	



$db->close();


?>

</rows>