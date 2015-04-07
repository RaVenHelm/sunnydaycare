<?php include("Temp.php");?>
<?php 
    //Simple Web Service with PHP
    if(!isset($_GET["client_id"])){
        echo "Client id is not set";
    } else {
        echo "{ClientId:" , $_GET["client_id"] , "}";    
    }
?>