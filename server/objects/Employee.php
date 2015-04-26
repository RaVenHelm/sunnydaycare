<?php 
    require_once('../db/database.php');
    
    class Employee{
        
        protected $data = array();
        
        private $id;
        private $permissions;
        
        private $firstName;
        private $middleName;
        private $lastName;
        private $userName;
        
        
        function __constructor(){
            
        }
        
        function __get(){
            
        }
        
        function __set(){
            
        }
        
        public static function find_one($username, $password){
            $sql = "SELECT * FROM employee WHERE username = :uname";
            $stmt = $database->prepare($sql);
            
            $stmt->execute(array(':uname' => $username));
            
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($password, $employee["password_hash"])){
                return $employee;
            } else {
                return false;
            }
        }
    }
?>