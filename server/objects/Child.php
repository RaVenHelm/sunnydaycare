<?php 
	require_once('../../server/db/database.php');
	require_once('../../server/functions.php');
    date_default_timezone_set('America/Denver');
	
	class Child{
		private $data = array();

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
        private $medical;

        private $clientList;

		
		function __construct($f, $m, $l, $dob, $g, $active, $checked, $state, $comments, $allergies, $restrictions, $medical, $clientList){
			$this->id = null;
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
            $this->medical = $medical;
            $this->clientList = $clientList;
		}

		public function __set($name, $val){
	        $this->data[$name] = $val;
	    }

	    public function  __get($name){
	        if(array_key_exists($name, $this->data)){
	            return $this->data[$name];
	        }
	        return null;
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
					$sql = "SELECT * FROM child WHERE firstname LIKE :fname AND lastname LIKE :lname AND isActive = TRUE ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => '%' . $first . '%', ':lname' => '%' . $last . '%'));
				} else {
					$sql = "SELECT * FROM child WHERE firstname LIKE :fname AND middlename LIKE :mname AND lastname LIKE :lname AND isActive = TRUE ;";
					$stmt = $database->prepare($sql);
					$stmt->execute(array(':fname' => '%' . $first . '%', ':mname' => '%' . $middle . '%' ,':lname' => '%' . $last . '%'));
				}
				//TODO: Should return a child
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$return = [];
				//Find who can pick the child up and append it to the result
				if(count($result) != 0){
					for ($i = 0; $i < count($result); $i++) {
						$child = [];
						$childRaw = $result[$i];
						$childObj = new Child($childRaw["firstname"], $childRaw["middlename"], $childRaw["lastname"], $childRaw["birthday"], $childRaw["gender"], $childRaw["isactive"], $childRaw["checkedIn"], $childRaw["stateassistance"], $childRaw["comments"], null, null, null, null);
						$childObj->setId($childRaw["id"]);
						$childObj->setClientList(Child::retrievePickupList($result[$i]["id"]));
						$child["child"] = $childObj;
						$child["log"] = Child::retrieveTodaysLog($result[$i]["id"]);
						$return[$i] = $child;
					}
				}
				return $return;
		}

		public function setClientList($value){
			if(is_array($value)){
				$this->clientList = $value;
			}
		}

        /*
         * Find a child in the records by ID
         * @param $id : child id
         * @return array with child details
         */
        public static function find_one_id($id){
			global $database;

                $sql = "SELECT * FROM child WHERE id LIKE :id AND isActive = TRUE ;";
                $stmt = $database->prepare($sql);
                $stmt->execute(array(':id' => $id));

				//TODO: Should return a child
				$result = $stmt->fetch(PDO::FETCH_ASSOC);

				//Find who can pick the child up and append it to the result
				if($result["id"] && $result["id"] == $id){
					$pickup = Child::retrievePickupList($id);
					$log = Child::retrieveTodaysLog($id);
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
			$date = date('Y-m-d');
			$time = date('H:i:s');
			if(!$childId || !$clientId){
				return "Could not checkin/checkout: A client or child was not specified.";
			} else {
				//See if operation is checkin
				if(!$isCheckIn){
					//Create new log table
					$sql = "INSERT INTO log (Day, CheckIn, Child_id, In_Client_id) VALUES (DATE(:date), :time, :childId, :clientId);";
					$sth = $database->prepare($sql);
					
					//Bind params
					$params = array(':date' => date('Y-m-d'), ':time' => date('H:i:s'), ':childId' => $childId, ':clientId' => $clientId);
					
					//Success on updating log
					$result = $sth->execute($params);
					
					if($result){
						//Set child record to checked in
						$sql = "UPDATE child SET checkedIn = TRUE WHERE id = :id ;";
						$sth = $database->prepare($sql);
						//Success on checking in
						if($sth->execute(array(':id' => $childId))){
							return "Checked In on {$date} at {$time}";
						} else {
							return "Error updating child record, please contact webmaster";
						}
					} else { //Failure to update log
						return "There was an error checking in, please try again.";
					}
				} else {
					//Check for log on that day
					//Check if there is a checkout time
					$sql = "SELECT id FROM log WHERE DATE(Day) = CURDATE() AND Child_id = :childId AND CheckOut IS NULL;";
					$sth = $database->prepare($sql);
					
					if($sth->execute(array(':childId' => $childId))){

						//Check out is null, go ahead and checkout
						$log = $sth->fetch(PDO::FETCH_ASSOC);
						$logId = $log["id"];
						
						//Update the log file with checkout time
						$sql = "UPDATE log SET CheckOut = :time, Out_Client_Id = :clientId WHERE id = :id";
						$sth = $database->prepare($sql);
						
						//Bind Params
						$params = array(':time' => date('H:i:s'), ':clientId' => $clientId, ':id' => $logId);

						if($sth->execute($params)){
							//Update child record
							$sql = "UPDATE child SET checkedIn = FALSE WHERE id = :id ;";
							$sth = $database->prepare($sql);
						
							if($sth->execute(array(':id' => $childId))){
								return "Checked Out on {$date} at {$time}";
							} else {
								return "Error updating child record, please contact webmaster";
							}
						}
					} else { 
						//No logs found for child on that day
						//Create a new one
						$sql = "INSERT INTO log (Day, CheckIn, Child_id, In_Client_id) VALUES (DATE(:date), :time, :childId, :clientId);";
						$sth = $database->prepare($sql);
						
						//Bind params
						$params = array(':date' => date('Y-m-d'), ':time' => date('H:i:s'), ':childId' => $childId, ':clientId' => $clientId);
						
						//Success on updating log
						$result = $sth->execute($params);
						
						if($result){
							//Set child record to checked in
							$sql = "UPDATE child SET checkedIn = TRUE WHERE id = :id ;";
							$sth = $database->prepare($sql);
							//Success on checking in
							if($sth->execute(array(':id' => $childId))){
								return "Checked In on {$date} at {$time}";
							} else {
								return "Error updating child record, please contact webmaster";
							}
						} else { //Failure to update log
							return "There was an error checking in, please try again.";
						}
					}
				}
			}
		}

        public static function getIncidents($id){
            global $database;

            $sql = "SELECT * FROM `child incident` WHERE Child_id = :id;";

            $sth = $database->prepare($sql);
            if($sth->execute(array(':id' => $id))){
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
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

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getClientList(){
			return $this->clientList;
		}

		public function getCheckedIn(){
			return $this->isCheckedIn;
		}

		public function add(){
			global $database;

			$sql = "INSERT INTO child VALUES(NULL, :bday, :gender, :link, :checkedIn, :comments, :state, :active, :fname, :mname, :lname); ";
	        
	        $sth = $database->prepare($sql);

	        $params = array(':bday' => $this->dob, ':gender' => $this->gender, ':link' => $this->picLink, ':checkedIn' => $this->isCheckedIn, ':comments' => $this->comments, ':active' => $this->isActive, ':state' => $this->hasStateAssistance, ':fname' => $this->firstName, ':mname' => $this->middleName, ':lname' => $this->lastName);

	        $res = $sth->execute($params);
	        if(!$res){
	        	return false;
	        }


	        // Get ID of the child
	        $child = Child::find_one($this->firstName, $this->middleName, $this->lastName);
	        $this->id = $child["child"]->getId();

	        //Create Medical record
	        for ($i=0; $i < count($this->medical); $i++) { 
	        	if (!$this->insertMedical($this->medical[$i])) {
	        		return false;
	        	}
	        }

	        // Create Allergy Record(s)
	        for ($i=0; $i < count($this->allergies); $i++) { 
	        	if (!$this->insertAllergy($this->allergies[$i])) {
	        		return false;
	        	}
	        }

	        // Create Restriction Record(s)
	        for ($i=0; $i < count($this->restrictions); $i++) { 
	        	if (!$this->insertRestriction($this->restrictions[$i])) {
	        		return false;
	        	}
	        }

	        //Create Client-Child Relation
	        for ($i=0; $i < count($this->clientList); $i++) { 
	        	if(!$this->insertClient($this->clientList[$i])){
	        		return false;
	        	}
	        }

	        return $this;
		}

		public function save()
		{
			global $database;

			$sql = "UPDATE child SET firstname = ?, middlename = ?, lastname = ?, birthday = ?, gender = ?, comments = ?, stateassistance = ?, isactive = ? WHERE id = ?;";
			$sth = $database->prepare($sql);

			if (!$sth->execute(array($this->firstName, $this->middleName, $this->lastName, $this->dob, $this->gender, $this->comments, $this->hasStateAssistance, $this->isActive, $this->id))) {
				return array("error" => "There was an error saving the record.");
			}
		}
		
		/*
		 *
		 * @params: search query params, with an optional 
		 * @returns: an array with with all possible names in a wildcard search
		 */
		public static function search($firstname, $middlename, $lastname){
			global $database;

			$wcFirst = "%{$firstname}%";
			$wcMiddle = "%{$middlename}%";
			$wcLast = "%{$lastname}%";

			
			$sql = "SELECT * FROM child ";
			if(!isset($firstname) && !isset($middlename)){
				$sql .= "WHERE lastname LIKE :lname ORDER BY lastname;";
				$stmt = $database->prepare($sql);
				$stmt->execute(array(':lname' => $wcLast));
			} elseif(!isset($middlename)) {
				$sql .= "WHERE firstname LIKE :fname AND lastname LIKE :lname ORDER BY lastname;";
				$stmt = $database->prepare($sql);
				$stmt->execute(array(':fname' => $wcFirst, ':lname' => $wcLast));
			} elseif(!isset($lastname)) {
				$sql .= "WHERE firstname LIKE :fname AND middlename LIKE :mname ORDER BY lastname;";
				$stmt = $database->prepare($sql);
				$stmt->execute(array(':fname' => $wcFirst, ':mname' => $wcMiddle));
			} elseif(!isset($firstname)) {
				$sql .= "WHERE middlename LIKE :mname AND lastname LIKE :lname ORDER BY lastname;";
				$stmt = $database->prepare($sql);
				$stmt->execute(array(':mname' => $wcMiddle, ':lname' => $wcLast));
			} else {
				$sql .= "WHERE firstname LIKE :fname AND middlename LIKE :mname AND lastname LIKE :lname ORDER BY lastname;";
				$stmt = $database->prepare($sql);
				$stmt->execute(array(':fname' => $wcFirst, ':mname' => $wcMiddle, ':lname' => $wcLast));
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		//Private methods
		
		/*
		 *
		 * @params: Child ID
		 * @returns: An array with the name/id/isBillPayer of each person who can pick them
		 */
		private static function retrievePickupList($id){
			global $database;
			$sql = "SELECT client.id, client.firstname, client.middlename, client.lastname, billpayer, primarycontact FROM client LEFT JOIN client_has_child AS cc ON client.id = cc.Client_id LEFT JOIN child ON cc.Child_id = child.id WHERE child.id = :id ORDER BY billpayer DESC;";
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
	
		/*
		 *
		 *
		 */
		private function insertMedical($medical){
			global $database;

			$sql = "INSERT INTO medical VALUES(NULL, :id, :section, :description);";
	        $sth = $database->prepare($sql);

	        $section = isset($medical["section"]) ? encrypt($medical["section"]) : null;
	        $description = isset($medical["description"]) ? encrypt($medical["description"]) : null;

	        $params = (array(':id' => $this->id, ':section' => $section, ':description' => $description));

	        return $sth->execute($params);
		}

		private function insertAllergy($allergy){
			global $database;

			$sql = "INSERT INTO allergy VALUES(NULL, :type, :id);";
	        $sth = $database->prepare($sql);

	        $type = isset($allergy["type"]) ? encrypt($allergy["type"]) : null;
	        $params = array(':type' => $type, ':id' => $this->id);

	        return $sth->execute($params);
		}

		private function insertRestriction($restr){
			global $database;

			$sql = "INSERT INTO restriction VALUES(NULL, :type, :detail, :id);";
	        $sth = $database->prepare($sql);

	        $type = isset($restr["type"]) ? $restr["type"] : null;
	        $detail = isset($restr["detail"]) ? encrypt($restr["detail"]) : null;
	        $params = array(':type' => $type, ':detail' => $detail, ':id' => $this->id);

	        return $sth->execute($params);
		}

		private function insertClient($client){
			global $database;

			$sql = "INSERT INTO `client_has_child` VALUES(:Client, :Child);";
			$sth = $database->prepare($sql);

			$params = array(':Client' => $client, ':Child' => $this->id);

			return $sth->execute($params);
		}
	}
?>