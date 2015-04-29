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
		
		private $pickupList;
		
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
		
		/* TODO: Make sure it returns a new child object
		 *
		 * @params: First, middle, and last name of child, with bool about details
		 * @returns: a child object
		 */
		public static function find_one($first, $middle=null, $last){
			global $database;
				if($middle == null || $middle == ""){
					$sql = "SELECT * FROM child WHERE firstname = :fname AND lastname = :lname AND isActive = TRUE ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => $first, ':lname' => $last));
				} else {
					$sql = "SELECT * FROM child WHERE firstname = :fname AND middlename = :mname AND lastname = :lname AND isActive = TRUE ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => $first, ':mname' => $middle,':lname' => $last));
				}
				//Should only return one child
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				
				//Find who can pick the child up and append it to the result
				if($result["id"]){
					$pickup = Child::retrievePickupList($result["id"]);
					array_push($result, $pickup);
				}
				return $result;
			}
		
		/*
		 *
		 *
		 * @returns: the full name of a child, as a string
		 */
		public function getFullName(){
			return $this->firstName . (isset($this->middleName) ? " {$this->middleName}" : "") . " {$this->lastName}";
		}
		
		public function getPickUpList(){
			return $this->pickupList;
		}
		//Private methods
		
		/*
		 *
		 * @params: Child ID
		 * @returns: An array with the name/id/isBillPayer of each person who can pick them
		 */
		private static function retrievePickupList($id){
			global $database;
			$sql = "SELECT client.id, client.firstname, client.middlename, client.lastname, billpayer FROM client LEFT JOIN client_has_child AS cc ON client.id = cc.Client_id LEFT JOIN child ON cc.Child_id = child.id WHERE child.id = :id ORDER BY billpayer DESC;";
			$stmt = $database->prepare($sql);
			$stmt->execute(array(':id' => $id));
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $result;
		}
	}
?>