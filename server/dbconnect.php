<?php 
    /*
     * This folder would include all the server-side scripts
     * Here would be a simple PHP page
     *
     * hostname: 
     * username: 
     * password: 
     * port: 3306
     */
     
     $username = "ravenhelm";
     $pass = "";
     
     //Using PDO here for more portability
     //Make sure DB is set-up before calling this method
     //If running from C9
     //$connection = new pdo('mysql:host=hostname;dbname=dbname',$username, $pass);
     try{
        
		$connection = new pdo('mysql:host=localhost;dbname=sample_db',$username);
	 } catch (Exception $ex) {
         echo $ex->getMessage();
     }
     //Else
     //$connection = new pdo('mysql:host=localhost;dbname=sample_db',$username, $pass);
	 //If there is no password in the database users for YOUR server,
	 //Do not add an argument for the password 
    
     
?>