<?php include("Temp.php"); ?>
<?php 
	//TODO: Set up server and test code
	echo 'Hello?';
	//Get and sanitize input from a HTTP POST request
	//This request will most likely come from a $.ajax() JQuery call
	//TODO: Create it as a web service?
	//Ty: I know, not particularly efficient code, but it gets the point across.
	$input_sanitize = 'Johnny';

	//Create client object and set it's name to the sanitized input
	//TODO: Create constructors for Client obj
	//TODO: Validation of input server-side
	$client = new Client();
	$client->set_name($input_sanitize);
	
	//Double check if the name is not set
	if($client->get_name()){
		$name = $client->get_name();
		echo $name;
	}
	else{
		$name = NULL;
		echo 'Client\'s name not set';
	}
?>