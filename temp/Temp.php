<?php 
	//Sample PHP file to show ease of PHP coding
	//TODO: Need a webserver (ie WAMP, LAMP, etc) to run this script
	
	//Uncomment line below to get phpinfo page
	/* phpinfo();*/
	
	class Client()
	{
		//Initialize to empty string 
		private $name = '';
		
		public get_name(){
			return $this->name;
		}
		
		public set_name($in){
			if(!is_string($in)){
				echo 'Input is not a string';
				return false;
			}
			$this->name = $in;
		}
	}
?>