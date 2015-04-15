<?php 
    
    class Error
    {
        private $message;
        
        /*
         * Error constructor
         * Needs to have a parameter
         * $error can be an Exception object, or custom message
         */
        public function __construct($error){
            if(gettype($error) == "object"){
                $this->message = $error->getMessage();
            }
            else{
                $this->message = $error;
            }
        }
        
        /*
         * Prints out object's message
         * No parameters
         * returns void, echos out a string
         */
        public function print_message(){
            echo $this->message;
        }
    }
?>