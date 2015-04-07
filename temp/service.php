<?php include("Temp.php");?>
<?php 
    //Simple Web Service with PHP
    if(!isset($_GET["client_id"])){
        echo "Client id is not set";
    } else {
		$result = "{ClientId:" . $_GET["client_id"] . "}";
        echo json_encode($result);    
    }
?>