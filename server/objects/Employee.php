<?php 
    require_once('..//server/db/database.php');
	
    class Employee{
        
        private $id;
        private $permissions;
        
        private $firstName;
        private $middleName;
        private $lastName;
        private $userName;
        
        
        function __construct($id, $firstName, $middleName=null, $lastName, $userName, $permissions){
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
		public function setPermissions($val){
			$this->permissions = $val;
		}
		
		public function getFullName(){
			return $this->firstName . " {$this->lastName}";
		}
        
        public static function authenticate($username="", $password=""){
			global $database;
			
            $sql = "SELECT * FROM employee WHERE username = :uname";
            $stmt = $database->prepare($sql);
            
            $stmt->execute(array(':uname' => $username));
            
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($password, $employee["password_hash"])){
                return new Employee($employee["id"], $employee["firstname"], $employee["middlename"], $employee["lastname"], $employee["username"], $employee["permissions"]);            
            } else {
                return false;
            }
        }

        public function add($pass)
        {
        	global $database;
	
			$password = password_hash($pass, PASSWORD_BCRYPT);
			
			$sql = "INSERT INTO employee VALUES (NULL, :user, :pass, :first, :middle, :last, :perm)";
			
			$sth = $database->prepare($sql);
			
			return $sth->execute(array(':pass' => $password, ':user' => $this->userName, ':first' => $this->firstName, ':middle' =>  $this->middleName, ':last' => $this->lastName, ':perm' => $this->permissions));
        }
    }
?>