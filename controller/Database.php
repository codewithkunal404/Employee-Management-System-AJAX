<?php

namespace App\DB;
class Database{
    private $hostname="localhost";
    private $username="root";
    private $password="";
    private $db_name="employee_management";
    private $conn;
    public function getConn(){
        $this->conn=mysqli_connect($this->hostname,$this->username,$this->password,$this->db_name);
        if(!$this->conn){
            die('Connection Failed'.mysqli_connect_error());
        }
        return $this->conn;
    }
}



?>