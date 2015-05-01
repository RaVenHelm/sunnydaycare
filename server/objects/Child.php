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
					$sql = "SELECT * FROM child WHERE firstname LIKE :fname AND middlename LIKE :mname AND lastname LIKE :lname AND isActive = TRUE ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => '%' . $first . '%', ':mname' => '%' . $middle . '%' ,':lname' => '%' . $last . '%'));
				}
				//TODO: Should return a child
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				//Find who can pick the child up and append it to the result
				if($result["id"]){
					$pickup = Child::retrievePickupList($result["id"]);
					$log = Child::retrieveTodaysLog($result["id"]);
					array_push($result, $pickup, $log);
				}
				return $result;
			}
		/*
		 * TODO: Change from static method to instance method?
		 *
		 * @params: Child and Client Id, and whether of not it is a check in operation
		 * @return: Success or error message
		 */
		public static function checkInOut($childId, $clientId, $isCheckIn){
			global $database;
			if(!$childId || !$clientId){
				return "Could not checkin/checkout: A client or child was not specified.";
			} else {
				//See if operation is checkin
				if($isCheckIn){
					//Create new log table
					$sql = "INSERT INTO log (Day, CheckIn, Child_id, In_Client_id) VALUES (DATE(:date), :time, :childId, :clientId);";
					$sth = $database->prepare($sql);
					
					echo date('Y-M-D');
					
					//Bind params
					$params = array(':date' => date('Y-m-d'), ':time' => date('H:i:s'), ':childId' => $childId, ':clientId' => $clientId);
					
					//Success on updating log
					if($sth->execute($params)){
						//Set child record to checked in
						$sql = "UPDATE child SET checkedIn = TRUE WHERE id = :id ;";
						$sth = $database->prepare($sql);
						
						//Success on checking in
						if($sth->execute(array(':id' => $childId))){
							return "Checked In";
						} else {
							return "Error updating child record, please contact webmaster";
						}
					} else { //Failure to update log
						return "There was an error checking in, please try again.";
					}
				} else {
					//Check for log on that day
					$sql = "SELECT id FROM log WHERE DATE(Day) = CURDATE() AND Child_id = :childId ;";
					$sth = $database->prepare($sql);
					
					if($sth->execute(array(':childId' => $childId))){
						//Get the log id
						$logId = $sth->fetch(PDO::FETCH_ASSOC);
						$logId = $logId["id"];
						
						//Update the log file with checkout time
						$sql = "UPDATE log SET CheckOut = :time, Out_Client_Id = :clientId WHERE id = :id";
						$sth = $database->prepare($sql);
						
						echo date('H:i:s');
						
						//Bind Params
						$params = array(':time' => date('H:i:s'), ':clientId' => $clientId, ':id' => $logId);

						if($sth->execute($params)){
							//Update child record
							$sql = "UPDATE child SET checkedIn = FALSE WHERE id = :id ;";
							$sth = $database->prepare($sql);
						
							if($sth->execute(array(':id' => $childId))){
								return "Checked Out";
							} else {
								return "Error updating child record, please contact webmaster";
							}
						}
					} else { //No logs found for child on that day
						return "There are no logs for the child today.";
					}
				}
			}
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
		
		/* TODO: Make instance method
		 *
		 * @params: Child Id
		 * @returns: an array with the log for the current day
		 */
		 private static function retrieveTodaysLog($id){
			global $database;
			$result = [];
			//First get checkIn data
			$sql = "SELECT log.id, CheckIn, client.firstname, client.lastname FROM log JOIN client ON log.In_Client_id = client.id WHERE log.Child_id = :childId AND DATE(log.Day) = CURDATE();";
			
			$sth = $database->prepare($sql);
			
			$sth->execute(array(':childId' => $id));
			//Should be an array
			if($sth->columnCount()){
				array_push($result, $sth->fetch(PDO::FETCH_ASSOC));
			}
			
			//Now check for the checkout time
			$sql = "SELECT log.id, CheckOut, client.firstname, client.lastname FROM log JOIN client ON log.Out_Client_Id = client.id WHERE log.Child_id = :childId AND DATE(log.Day) = CURDATE()";
			
			$sth = $database->prepare($sql);
			
			$sth->execute(array(':childId' => $id));
			
			//Should be an array
			if($sth->columnCount()){
				array_push($result, $sth->fetch(PDO::FETCH_ASSOC));
			}
			
			return $result;
		 }
	}
?>