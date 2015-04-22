<?php 
    include("../../server/functions.php");
    if(!isset($_SESSION["user_id"])){
        redirect_to("../../login.html");
    } else {
        unset($_SESSION);
        redirect_to("../../login.html");
    }
?>