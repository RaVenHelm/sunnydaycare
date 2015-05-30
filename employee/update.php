<?php
    require_once('../server/session.php');
    require_once('../server/functions.php');
    require_once('../server/objects/Employee.php');
    if (!$session->is_logged_in()) { redirect_to('../login.php'); }
    $self = $_SERVER["PHP_SELF"];
    if(isset($_GET["search"])){
    	$result = Employee::search($_GET["firstname"], $_GET["lastname"]);
        if(!$result) {$msg = "<ul><li>No employee found.</li></ul>";}
    }
    if (isset($_POST["update"])) {
        if(Employee::update($_POST["id"], $_POST["username"], $_POST["password"], $_POST["firstname"], $_POST["middlename"], $_POST["lastname"], $_POST["permissions"])){
        	$msg = "Successful Employee update";
        } else {
        	$msg = "Update not successful";
        }
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sunny Day Care | Employee Edit</title>
        <link rel="stylesheet" href="../public/scripts/jquery-ui.min.css" />
        <!-- Custom styles -->
        <link rel="Stylesheet" href="../public/styles/normalize.css" type="text/css"/>
        <link rel="Stylesheet" href="../public/styles/webpage.css" type="text/css" />
    </head>
    <body>
        <div class="header"><a href="../">Sunny Daycare</a></div>
        <div class="wrapper">
            <?php include('templates/userbar.php'); ?>
            <div id="search">
                <h2>Employee Search</h2>
                <form id="lookup" method="get" action="update.php">
                    <label for"firstname">First Name</label><br>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required><br>
                    <label for"firstname">Last Name</label><br>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required><br>
                    <input type="submit" name="search" id="lookupSubmit" value="Search" >
                </form>
            </div>
            <div id="error" title="Error"></div>
            <div id="result">
                <?php if(isset($result) && $result){ ?>
                <button class="employeeSingle" id="<?php echo $result["id"]; ?>" value="<?php echo $result["id"]; ?>"><?php echo $result["firstname"] . " " . $result["middlename"] . " " . $result["lastname"]; ?></button><br>
                <?php } ?>
                <div id="update" title="Employee Data">
                    <form id="updateForm" name="register" method="post" action="<?php echo $self; ?>">
	                    <label for"firstname">First Name</label><br>
	                    <input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php echo $result["firstname"]; ?>" required><br>
	                    <label for"middlename">Middle Name</label><br>
	                    <input type="text" name="middlename" id="middlename" placeholder="Middle Name" value="<?php echo $result["middlename"]; ?>" required><br>
	                    <label for"firstname">Last Name</label><br>
	                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo $result["lastname"]; ?>" required><br>
	                    <label for"username">Username</label><br>
	                    <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $result["username"]; ?>" required><br>
	                    <label for="permissions">Permissions</label><br>
                        <input type="number" min="1" max="4" id="permissions" name="permissions" value="<?php echo $result["permissions"]; ?>"><br>

	                    <label for"password">Password Reset</label><br>
	                    <input type="password" id="password" name="password"><br>

                        <label for="p_verify">Verify password</label><br>
                        <input type="password" id="p_verify" name="p_verify"><br>

	                    <input type="hidden" name="id" value="<?php echo $result["id"]; ?>">
	                    <input type="submit" name="update" id="update" value="Update" ><br>
                    </form>
                </div>
                <div id="msg" title="Message"><?php if(isset($msg)) echo $msg; ?></div>
            </div>
        </div>
    </body>
    <script src="../public/scripts/jquery-1.11.3.js"></script>
    <script src="../public/scripts/jquery-ui.min.js"></script>
    <script src="../public/scripts/employee.js"></script>
</html>