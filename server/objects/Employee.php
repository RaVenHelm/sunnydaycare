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

        public static function search($firstname, $lastname) 
        {
        	global $database;

        	$sql = "SELECT `id`, `firstname`, `middlename`, `lastname`, `username`,`permissions` FROM `employee` WHERE `firstname` LIKE ? AND `lastname` LIKE ?;";
        	$stmt = $database->prepare($sql);

        	if($stmt->execute(array(("%" . $firstname . "%"), ("%" . $lastname . "%")))){
        		return $stmt->fetch(PDO::FETCH_ASSOC);
        	} else {
        		return array("error" => $stmt->errorInfo());
        	}
        }

        public static function update($id, $user, $pass, $first, $middle, $last, $perm)
        {
        	global $database;

        	$password = password_hash($pass, PASSWORD_BCRYPT);

        	$sql = "UPDATE `employee` SET username = ?, password_hash = ?, firstname = ?, middlename = ?, lastname = ?, permissions = ? WHERE id = ?;";
        	$sth = $database->prepare($sql);

        	$params = array($user, $password, $first, $middle, $last, $perm, $id);
        	return $sth->execute($params);
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