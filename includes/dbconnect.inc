<?php

@$db = new mysqli('localhost','fettle','fettle','fettle');

if (mysqli_connect_errno()){
	
	echo "Database Connection Error has Occured";
	
	exit;
	
}


?>