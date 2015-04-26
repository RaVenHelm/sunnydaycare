<?php 
require_once('../server/objects/Employee.php');
require_once('../server/session.php');
require_once('../server/functions.php');

if (isset($_POST["submit"])) { //Form has been submitted
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

	//Authenticate the user and set the response to a new Employee object
    $found = Employee::authenticate($username, $password);
    
    if ($found) {
        $session->login($found);
		//If making a copy of an object, use a dereference operator
		//$employee =& $found;
        redirect_to('index.php');
    }
    else {
        $msg = "Invalid credentials";
		redirect_to('index.php');
    }

}
else { //Form has not been submitted
    $username = "";
    $password = "";
    echo "else";
}

?>