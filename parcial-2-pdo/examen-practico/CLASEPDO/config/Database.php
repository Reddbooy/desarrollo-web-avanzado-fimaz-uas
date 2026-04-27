<!-- Jesus Eduardo Garcia Rojas -->
<?php
    class Database{
        private $host = "localhost:3307";
        private $db = "database";
        private $user = "root";
        private $password = "";
        private $charset = "utf8mb4";
        private $connection;

        public function __construct(){
            try{
                $dns = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
                
                $this->connection = new PDO($dns, $this->user, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function getConnection(){
            return $this->connection;
        }
    }
?>