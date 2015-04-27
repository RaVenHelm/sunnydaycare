<?php 
	require_once('../../server/db/database.php');
	
	class Child{
		private $id;
		
		private $firstName;
		private $middleName;
		private $lastName;
		
		private $dob;
		private $gender;
		
		private $isActive;
		private $isCheckedIn;
		private $hasStateAssistance;
		
		private $comments;
		private $allergies;
		private $incidents;
		private $restrictions;
		
		function __construct($id, $f, $m, $l, $dob, $g, $active, $checked, $state, $comments, $allergies, $restrictions){
			$this->id = $id;
			$this->firstName = $f;
			$this->middleName = $m;
			$this->lastName = $l;
			$this->dob = $dob;
			$this->gender = $g;
			$this->isActive = $active;
			$this->isCheckedIn = $checked;
			$this->hasStateAssistance = $state;
			$this->comments = $comments;
			$this->allergies = $allergies;
			$this->incidents = null;
			$this->restrictions = $restrictions;
		}
		
		/*
		 *
		 * @params: boolean options for active/detail
		 * @returns: an multi-dimensional array of all the children
		 */
		public static function get_all($areActive, $hasDetail){
			global $database;
			if($areActive !== null){
				$sql = "SELECT * FROM child WHERE isActive = :active;";
				$stmt = $database->prepare($sql);
				$stmt->execute(array(':active' => $areActive));
			} else {
				$sql = "SELECT * FROM child;";
				$stmt = $database->prepare($sql);
				$stmt->execute();
			}
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/*
		 *
		 * @params: First, middle, and last name of child, with bool about details
		 * @returns: a child object
		 */
		public static function find_one($first, $middle=null, $last){
			global $database;
				if($middle == null || $middle == ""){
					$sql = "SELECT * FROM child WHERE firstname = 'Jimmy' AND lastname = 'Smith' ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => $first, ':lname' => $last));
				} else {
					$sql = "SELECT * FROM child WHERE firstname = :fname AND middlename = :mname AND lastname = :lname ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => $first, ':mname' => $middle,':lname' => $last));
				}
				//print_r ($stmt->fetch());
				return $stmt->fetch(PDO::FETCH_ASSOC);
			}
		
		/*
		 *
		 *
		 * @returns: the full name of a child, as a string
		 */
		public function getFullName(){
			return $this->firstName . (isset($this->middleName) ? " {$this->middleName}" : "") . " {$this->lastName}";
		}
	}
?>