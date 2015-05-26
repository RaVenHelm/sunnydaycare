<?php 
	require_once('../../server/db/database.php');
	require_once('../../server/functions.php');

	/**
	*  Class for Medical Records:
	*  Stores Allergies, and other records as arrays
	*/
	class Medical  
	{
		private $medical;
		private $allergies;
		private $restrictions;

		function __construct($medical, $allergies, $restrictions)
		{
			$this->medical = $medical;
			$this->allergies = $allergies;
			$this->restrictions = $restrictions;
		}

		public function getMedical()
		{
			return $this->medical;
		}

		public function setMedical($val)
		{
			$this->medical = $val;
		}

		public function getAllergies()
		{
			return $this->allergies;
		}

		public function setAllergies($val)
		{
			$this->allergies = $val;
		}

		public function getRestrictions()
		{
			return $this->restrictions;
		}

		public function setRestrictions($val)
		{
			$this->restrictions = $val;
		}

		public function decryptMembers()
		{
			$med = $this->getMedical();
			$allg = $this->getAllergies();
			$rest = $this->getRestrictions();

			for ($i=0; $i < count($med); $i++) { 
				$med[$i]["section"] = decryptNonRef($med[$i]["section"]);
				$med[$i]["description"] = decryptNonRef($med[$i]["description"]);
			}
			for ($j=0; $j < count($allg); $j++) { 
				$allg[$j]["type"] =& decrypt($allg[$j]["type"]);
			}
			for ($k=0; $k < count($rest); $k++) { 
				$rest[$k]["detail"] =& decrypt($rest[$k]["detail"]);
			}

			$this->setMedical($med);
			$this->setAllergies($allg);
			$this->setRestrictions($rest);
			return $this;
		}

		public function toArray()
		{
			return array('medical' => $this->medical, 'allergies' => $this->allergies, 'restrictions' => $this->restrictions);
		}

		/**
		 *
		 * Method for getting the child records, based on his/her id
		 * Should return a medical record object
		 */
		public static function getRecord($id)
		{
			$medical = null;
			$allergies = null;
			$restrictions = null;

			// Get the medical records
			$tmp = Medical::retrieveMedical($id);
			if(!$tmp && !is_array($tmp)){
				return array("error" => "Could not find medical records");
			} else {
				$medical = $tmp;
			}

			// Get list of allergies
			$tmp = Medical::retrieveAllergies($id);
			if (!$tmp && !is_array($tmp)) {
				return array("error" => "Could not find allergies");
			} else {
				$allergies = $tmp;
			}
			
			// Get list of restrictions 
			$tmp = Medical::retrieveRestrictions($id);
			if (!$tmp && !is_array($tmp)) {
				return array("error" => "Could not find restrictions");
			} else {
				$restrictions = $tmp;
			}

			// Return new object
			return new Medical($medical, $allergies, $restrictions);
		}

		private static function retrieveMedical($id)
		{
			global $database;

			// Since there is only one param to bind
			// It's fine to use anon placeholder
			$sql = "SELECT * FROM `medical` WHERE Child_id = ?;";
			$sth = $database->prepare($sql);

			if($sth->execute(array($id))){
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		}

		private static function retrieveAllergies($id)
		{
			global $database;

			// Since there is only one param to bind
			// It's fine to use anon placeholder
			$sql = "SELECT * FROM `allergy` WHERE Child_id = ?;";
			$sth = $database->prepare($sql);

			if($sth->execute(array($id))){
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		}

		private static function retrieveRestrictions($id)
		{
			global $database;

			// Since there is only one param to bind
			// It's fine to use anon placeholder
			$sql = "SELECT * FROM `restriction` WHERE Child_id = ?;";
			$sth = $database->prepare($sql);

			if($sth->execute(array($id))){
				return $sth->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		}
	}
?>