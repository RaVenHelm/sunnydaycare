<?php 
    class Session{
        
        private $logged_in = false;
		private $log_in_time;
        public $user_id;
        
        function __construct(){
            session_start();
            $this->check_login();
            //Can do other actions here
        }
        
        public function is_logged_in(){
            return $this->logged_in;
        }
        
		/*
		 *
		 *
		 *
		 * @param = an Employee object
		 */
        public function login($employee){
            if($employee){
				$this->user_id = $_SESSION["user_id"] = $employee->getId();
				$_SESSION["permissions"] = $employee->getPermissions();
				$_SESSION["name"] = $employee->getFullName();
				$_SESSION["logInTime"] = time();
				$this->logged_in = true;
			} else {
			    echo "Bang!";
			}
        }
		
		public function logout(){
			session_unset();
			session_destroy();
			unset($this->user_id);
			$this->logged_in = false;
		}
		
		public static function regen(){
			session_regenerate_id();
		}
		
		public function end(){
			session_unset();
			session_destroy();
			unset($this->user_id);
			$this->logged_in = false;
		}
        
        private function check_login(){
            if(isset($_SESSION["user_id"])){
                $this->user_id = $_SESSION["user_id"];
                $this->logged_in = true;
            } else {
                unset($this->user_id);
                $this->logged_in = false;
            }
        }        
    }

    $session = new Session();
?>