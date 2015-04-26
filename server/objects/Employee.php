<?php 
    require_once('../server/db/database.php');
	
    class Employee{
        
        protected $data = array();
        
        private $id;
        private $permissions;
        
        private $firstName;
        private $middleName;
        private $lastName;
        private $userName;
        
        
        function __constructor($id, $firstName, $middleName=null, $lastName, $userName, $permissions){
            $this->id = $id;
			$this->firstName = $firstName;
			$this->middleName = $middleName;
			$this->lastName = $lastName;
			$this->userName = $userName;
			$this->permissions = $permissions;
        }
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function getPermissions(){
			return $this->permissions;
		}
		
		public function getFullName(){
			return $this->firstName . (isset($this->middleName) ? " {$this->middleName}" : "") . " {$this->lastName}";
		}
        
        public static function authenticate($username="", $password=""){
			global $database;
			
            $sql = "SELECT * FROM employee WHERE username = :uname";
            $stmt = $database->prepare($sql);
            
            $stmt->execute(array(':uname' => $username));
            
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($password, $employee["password_hash"])){
                $result = new Employee($employee["id"], $employee["firstname"], $employee["middlename"], $employee["lastname"], $employee["username"], $employee["permissions"]);
                return $result;            
            } else {
                return false;
            }
        }
    }
?>