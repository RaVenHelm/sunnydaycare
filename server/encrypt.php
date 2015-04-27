<?php 
	require_once('db/database.php');
	
	//Attempt at encrypting some data with Blowfish
	//@param should be a string
	function &encrypt($data){
		$key = pack('H*', "A2B50B9613BF979D304A1FF2CAACD528EC61C8FE57E90B7AF7F6AE654FBA0FBF");
		
		$key_size = strlen($key);
		
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$cipheredtext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_CBC, $iv);
		
		$cipheredtext = $iv . $cipheredtext;
		$ciphered_64 = base64_encode($cipheredtext);
		return $data =& $ciphered_64;
		//Store encrypted values after encryption
	}
	
	function &decrypt($encString){
		$ciphered_d64 = base64_decode($encString);
		$key = pack('H*', "A2B50B9613BF979D304A1FF2CAACD528EC61C8FE57E90B7AF7F6AE654FBA0FBF");
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
	
		$iv_d = substr($ciphered_d64, 0, $iv_size);
		
		$cipheredtext_d = substr($ciphered_d64, $iv_size);
		
		$text_d = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $cipheredtext_d, MCRYPT_MODE_CBC, $iv_d);
		
		return $encString =& $text_d;
	}
	
	//$data = "Here would be the child's medical records, for example.";
	$data = "He's deathly afraid of chickens";
	echo $data;
	echo "<br>";
	$data =& encrypt($data);
	echo $data; 
	
	/* $stmt = $database->prepare("INSERT INTO restriction VALUES (2, :type, :detail, 1)");
	$stmt->execute(array(':type' => 'personal', ':detail' => $data)); */
	echo "<br>";
	
	$result = $database->select("SELECT detail FROM restriction WHERE Child_id = 1;");
	$result = $result->fetch(PDO::FETCH_ASSOC);
	$data = $result["detail"];
	echo $data . "<br>";
	$data =& decrypt($data);
	echo $data;
?>