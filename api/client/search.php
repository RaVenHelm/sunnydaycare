<?php 
	if(isset($_GET["firstname"]) || isset($_GET["lastname"])){
		echo print_r($_GET);
	} else {
		echo "First or last name cannot be blank.";
	}
?>