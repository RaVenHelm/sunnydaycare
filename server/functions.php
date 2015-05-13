<?php 

    function redirect_to( $location = null ){
        if( $location != null ){
            header("Location: {$location}");
            exit;
        }
    }
    
    function __autoload($class_name){
        $class_name = strtolower($class_name);
        $path = "objects/{$class_name}.php";
        if(file_exists($path)){
            require_once($path);
        } else {
            die("The file {$path} could not be found.");
        }
    }
	//@param should be a string
	function encrypt($data){
		$key = pack('H*', "A2B50B9613BF979D304A1FF2CAACD528EC61C8FE57E90B7AF7F6AE654FBA0FBF");
		
		$key_size = strlen($key);
		
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$cipheredtext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_CBC, $iv);
		
		$cipheredtext = $iv . $cipheredtext;
		$ciphered_64 = base64_encode($cipheredtext);
		return $ciphered_64;
		//Store encrypted values after encryption
	}
	
	//Usage: $var =& decrypt($var);
	//@param a base-64 encoded string stored in the DB
	function &decrypt($encString){
		$ciphered_d64 = base64_decode($encString);
		$key = pack('H*', "A2B50B9613BF979D304A1FF2CAACD528EC61C8FE57E90B7AF7F6AE654FBA0FBF");
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
	
		$iv_d = substr($ciphered_d64, 0, $iv_size);
		
		$cipheredtext_d = substr($ciphered_d64, $iv_size);
		
		$text_d = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $cipheredtext_d, MCRYPT_MODE_CBC, $iv_d);
		
		return $encString =& $text_d;
	}
?>