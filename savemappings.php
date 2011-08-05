<?php
 
include_once('dbconnect.inc');

$templateid  = $_POST['templateid'];
$original = $_POST['original'];
$newname = $_POST['newname'];
$enabled = $_POST['enabled'];
$isgl = $_POST['isgl'];
$ownertable = $_POST['ownertable'];
$name = $_POST['name'];
$deftbl = $_POST['deftbl'];

if ($templateid == ""){

$query = "select max(templateid)+1 max FROM mappings";

	
$results = $db->query($query);


while ($row = $results->fetch_assoc()) {
		$templateid = $row['max'];
}

	$results->close();

	
}

$query = "insert into mappings(templateid,name,ownertable,original,newname,enabled,isgl,deftbl) values (".$templateid.",'"
.$name."','".$ownertable."','".$original."','".$newname."','".$enabled."','".$isgl."','".$deftbl."')";

$db->query($query);

$db->close();


?>

