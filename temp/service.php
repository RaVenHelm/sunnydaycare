<?php include("Temp.php");?>
<?php 
    //Simple Web Service with PHP
	//TODO: Maybe make the client id into a Regex Pattern?
    if(!isset($_GET["client_id"])){
        echo "Client id is not set";
    } else {
		$clientName = '';
		$clientInt = 0;
		
		//Split the client id into two parts
		$idSplit = explode("_", $_GET["client_id"]);
		
		//echo strlen($idSplit[1]);
		
		//Get the client id number (returns 0 if inval fails)
		//If the delimiter is not "_" then idSplit would be an array with the GET value
		//$clientInt = intval(substr($_GET["client_id"], -4));
		if(count($idSplit) == 2){
			$clientInt = intval($idSplit[1]);
		} else {
			echo 'Not a valid client ID';
		    return; 
		}
		
		//Make sure the last 4 digits are numeric
		//Only 4 digits allowed for num
		//Cannot be zero
		if(!is_numeric(substr($_GET["client_id"], -4)) || strlen($idSplit[1]) != 4 || $idSplit[0] ==  "" ||$clientInt == 0){
		    echo 'Not a valid client ID';
		    return;
		}
		
		
		if( $clientInt < 100 ){
		    $clientName = 'Jimmy';
		}
		elseif ($clientInt >= 100 && $clientInt <= 450){
		    $clientName = 'Mary';
		}
		elseif($clientInt > 450){
		    $clientName = 'Sure';
		}

		$result = array("ClientID"=>$_GET["client_id"], "Name"=>$clientName);
        echo json_encode($result, JSON_PRETTY_PRINT);    
    }
?>