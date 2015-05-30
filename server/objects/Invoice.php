<?php
require_once('../../server/db/database.php');
require_once('Child.php');
require_once('Client.php');
date_default_timezone_set('America/Denver');

class Invoice {

    public static function create($id, $start, $end){
    	$invoice = [];
    	$logs = [];
    	$diffs = [];

    	$rates = Invoice::getRates();

    	// Get List of children client has to pay for
    	$childList = Invoice::getChildList($id);

    	if (count($childList) == 0) {
    		return false;
    	}

    	// For each Child id, search for logs, within start->end
    	for ($i=0; $i < count($childList); $i++) { 
			$log = Invoice::getLog($childList[$i]["ChildId"], $start, $end);
    		if($log !== []){
	    		array_push($logs, Invoice::getLog($childList[$i]["ChildId"], $start, $end));
			}
    	}

    	// Calculate time difference for each log
    	foreach ($logs as $log) {
    		for ($i=0; $i < count($log); $i++) { 

    			$in = new DateTime($log[$i]["CheckIn"]);
    			$out = new DateTime($log[$i]["CheckOut"]);

    			$interval = $in->diff($out);

    			array_push($diffs, array('hours' => $interval->h, 'mins' => $interval->i, 'id' => $log[$i]["Child_id"], 'in' => $in, 'out' => $out));
    		}
    	}

    	// Calculate the charge for each log
    	$invoice['charges'] = Invoice::calculateCharges($diffs, $rates);
    	

    	// If a previous bill is not paid, add a charge
    	$invoice['latePayments'] = Invoice::getLatePayments($id, $rates);


    	// Add total charges, set due date to next month
    	$invoice['total'] = $invoice['charges'] + $invoice['latePayments'];

    	$dateMade = new DateTime();

    	$invoice['dateMade'] = $dateMade->format('Y-m-d');
    	
    	$dueDate = $dateMade->modify('+1 month');

    	$invoice['dueDate'] = $dueDate->format('Y-m-d');

    	if(!Invoice::add($invoice, $id)) {
    		return false;
    	}

        $invoice['id'] = Invoice::getId($id, $invoice['dueDate']);

        return $invoice;

    }

    public static function add($invoice, $clientId) {
    	global $database;

    	$sql = "INSERT INTO `billing` VALUES(NULL, :made, :due, :total, NULL, :id, NULL, FALSE);";

    	$sth = $database->prepare($sql);

    	$result =  $sth->execute(array(':id' => $clientId, ':made' => $invoice["dateMade"], ':due' => $invoice["dueDate"], ':total' => $invoice["total"]));
    
        return $result;
    }

    public static function pay($invoiceId, $amtDue, $toPay, $paidOff)
    {
        global $database;

        $amtDue = round($amtDue, 2);
        $toPay = round($toPay, 2);
        $paidOff = round($paidOff, 2);

        if ($toPay < $amtDue) {
            $sql = "UPDATE `billing` SET amountPaid = ?, paymentdate = CURDATE() WHERE id = ?;";

            $sth = $database->prepare($sql);

            $result = $sth->execute(array($paidOff + $toPay, $invoiceId));

            return ($result) ? array("success" => "Payment Successful") : array("error" => "Could not update billing") ;
        } else if ($toPay > $amtDue){
            return array("error" => "Payment cannot be greater than amount due");
        } else {
            $sql = "UPDATE `billing` SET amountPaid = ?, paymentdate = CURDATE(), isFullyPaid = TRUE WHERE id = ?;";

            $sth = $database->prepare($sql);

            $result = $sth->execute(array($toPay, $invoiceId));

            return ($result) ? array("success", "Payment Successful") : array("error", "Could not update billing") ;
        }
        
    }

    public static function getAll($clientId){
    	global $database;

    	$sql = "SELECT * FROM `billing` WHERE Client_id = :id;";

    	$sth = $database->prepare($sql);

    	if(!$sth->execute(array(':id' => $clientId))) {
    		return false;
    	} else {
    		return $sth->fetchAll(PDO::FETCH_ASSOC);
    	}
    }

    public static function getAllUnpaid($id)
    {
        global $database;

        $sql = "SELECT * FROM `billing` WHERE Client_id = :id AND isFullyPaid = FALSE";

        $sth = $database->prepare($sql);

        if(!$sth->execute(array(':id' => $id))) {
            return false;
        } else {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function getId($clientId, $date) {
        global $database;

        $sql = "SELECT `billing`.id FROM `billing` WHERE Client_id = :id AND datemade = :date;";

        $sth = $database->prepare($sql);

        if(!$sth->execute(array(':id' => $clientId, ':date' => $date))) {
            return false;
        } else {
            return $sth->fetch(PDO::FETCH_ASSOC);
        }
    }

    private static function getRates() {
		global $database;

    	// Get charge rates
    	$result = $database->select("SELECT * FROM rate");
    	return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function calculateCharges($diffs, $charges) {
    	global $database;

    	$total = 0.0;

    	// Get charge rates
    	$result = $database->select("SELECT * FROM rate");
    	$charges = $result->fetchAll(PDO::FETCH_ASSOC);

    	$closing = new DateTime("18:00:00");

    	for ($i=0; $i < count($diffs) ; $i++) { 
    		$charge = 0.0;
    		if ($diffs[$i]["out"] > $closing) {
    			//echo "Late<br>";
    			$difference = $closing->diff($diffs[$i]["out"])->h;

    			$late = 0.0;

    			$normal = floatval($charges[0]["val"]) * ($diffs[$i]["hours"] - $difference);


    			for ($j=0; $j < $difference; $j++) { 
    				$late += $normal * floatval($charges[2]["val"]);
    			}

    			$charge = $late + $normal;
    		} else {
    			$charge = floatval($charges[0]["val"]) * $diffs[$i]["hours"];
    		}

    		$total += $charge;
    	}

    	return $total;
    }

    public static function getLatePayments($clientId, $charges) {
    	global $database;
    	$sql = "SELECT * FROM billing WHERE Client_id = :id";

    	$sth = $database->prepare($sql);

    	$sth->execute(array(':id' => $clientId));

    	$bills = $sth->fetchAll(PDO::FETCH_ASSOC);

    	$count = 0.0;

    	for ($i=0; $i < count($bills); $i++) { 
    		if($bills[$i]["isFullyPaid"] != "1"){
    			$count += $bills[$i]["total"] * $charges[1]["val"];
    		}
    	}

    	return $count;
    }

    public static function getChildList($clientId)
    {
    	global $database;

    	$sql = "SELECT client.id AS 'ClientId', child.id as 'ChildId', child.firstname AS  'childFirst', child.lastname AS 'childLast' FROM  `client` AS client LEFT JOIN  `client_has_child` AS cc ON client.id = cc.Client_id LEFT JOIN  `child` AS child ON cc.Child_id = child.id WHERE `cc`.Child_id IS NOT NULL AND client.billpayer = TRUE AND client.id = :id ORDER BY ChildId ASC";

    	$sth = $database->prepare($sql);

    	$sth->execute(array(':id' => $clientId));

    	return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLog($childId, $start, $end)
    {
    	global $database;

    	$sql = "SELECT `id`, `Day`, `CheckIn`, `CheckOut`, `Child_id` FROM `log` WHERE `Child_id` = :id AND `Day`>= :start AND `Day` <= :end ORDER BY `Day` ASC;";

    	$sth = $database->prepare($sql);

    	$sth->execute(array(':id' => $childId, ':start' => $start, ':end' => $end));

    	return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}