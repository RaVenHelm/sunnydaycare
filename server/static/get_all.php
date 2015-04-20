<?php 
        require('../../server/db/database.php');
        include('../../server/objects/Error.php');
        
        
        /*
         * Method for getting all a type of object in the database
         * Takes in a string of the type of object to retrieve
         * Returns an array of the type of object
         *
         *
         */
        function get_all($type){
            $type = strtolower($type);
            $all = [];
			
			$sql = 'SELECT * FROM ';
			$database = new database();
            
            switch($type){
                case 'child':
                    $sql .= 'child;';
                    break;
                case 'client':
                    $sql .= 'client;';
                    break;
                case 'employee':
                    $sql .= 'employee;';
                    break;
                case 'event':
                    $sql .= 'event;';
                    break;
                case 'report':
                    $sql .= 'report;';
                    break;
                case 'incident':
                    $sql .= 'incident;';
                    break;
                case 'rate':
                    $sql .= 'rate;';
                    break;
                default:
                    throw new Error("Invalid Table Name");
                    break;
            }
            
            try{
                $result = $database->select($sql);
                
                while($row = $result->fetch()){
                    array_push($all, $row);
                }
                
                return $all;
                
            } catch (Exception $ex) {
                $error = new Error($ex);
            }
        }
?>