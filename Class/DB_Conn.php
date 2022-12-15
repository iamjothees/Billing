<?php
    class DB_conn{

        private $db_host;
        private $db_name;
        private $db_user;
        private $db_pass;
        protected $conn;
    
        function __construct(){
            $this->db_host = "localhost:3306";
            $this->db_name = "billing";
            $this->db_user = "joe";
            $this->db_pass = "";
    
            try {
                $this->conn = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                //echo 'Connected';
            } catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }
        }
        
        /* $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if ($this->conn->connect_errno) {
            echo "Error connecting to database ";
        }else {
            echo "Connected to database <br<br><br>";
        } */
    
        
    }
    
?>