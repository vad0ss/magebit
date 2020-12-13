<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 09.12.2020
 * Time: 9:43
 */

namespace App\Config;

class Database {

    private $host = "localhost";
    private $db_name = "pna";
    private $username = "pna";
    private $password = "Q7i8Q7h3";
    public $conn;

    public function getConnection() {

        $this->conn = null;

        try {
            $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}