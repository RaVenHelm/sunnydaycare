<?php 
    include("../../server/functions.php");
    if(!isset($_SESSION["user_id"])){
        redirect_to("../../login.html");
    } else {
        unset($_SESSION);
		foreach ($_SESSION as $sessVar){
			unset($sessVar);
		}
        redirect_to("../../login.html");
    }
?>