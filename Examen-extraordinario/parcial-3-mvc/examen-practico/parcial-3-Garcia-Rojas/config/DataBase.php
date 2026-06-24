<?php
class DataBase {
    private $host = "localhost";
    private $db = "mvc";
    private $user = "root";
    private $password = "";

    public function __construct()
    {

    }

    public function connect(){
        try {
            $PDO = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db,$this->user,$this->password);
            return $PDO;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>
