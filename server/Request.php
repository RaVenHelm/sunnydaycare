<?php 
    class Request{
        private $type;
        private $params = [];
        
        public function __construct($type, $params){
            $this->$type = $type;   
            $this->$params = $params;
        }
        
        public function get_type(){
            return $this->$type;
        }
        
        public function set_type($newType){
            $this->$type = $newType;
        }
        
        public function get_params(){
            return $this->$params;
        }
        
        public function set_params($args){
            $this->$params = $args;
        }
        
        public function get($params){
            //TODO: Validate parameters
            //Parameters should be passed as a Associative Array (HASH)
            
            $param_arr = build_param_array($params);  
            for($i = 0; $i < count($params); ++$i){
                
            }
        }
        
        private function build_param_array($params){
            $result = [];
            foreach($params as $key=> $val){
               array_push($result,(urldecode($key) . "=" . urldecode($val)));
            }
            
            return $result;
        }
    }
?>