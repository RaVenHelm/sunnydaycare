<?php 
    require_once('../server/objects/Employee.php');
    require_once('../server/functions.php');
    require_once('../server/session.php');
    
    if(!$session->is_logged_in()){
        redirect_to('login.php');
    } else {
        echo "You're in!";
		print_r($_SESSION);
    }
?>

<a href="logout.php">Logout</a>