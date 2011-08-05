<?php
 
include_once('dbconnect.inc');




$query =  $_POST['query'];
$db->query($query);


$db->close();


?>

