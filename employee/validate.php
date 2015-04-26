<?php 
require_once('/sunnydaycare/server/objects/Employee.php');
$submit =  isset($_POST["submit"]);

if (true) { //Form has been submitted
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $found = Employee::authenticate($username, $password);
    
    echo "If";
    if ($found) {
        $session->login($found);
        redirect_to('index.php');
    }
    else {
        $msg = "Invalid credentials";
        print_r($_POST);
    }

}
else { //Form has not been submitted
    $username = "";
    $password = "";
    echo "else";
}

?>