<?php


class dbHelper{


    public $serverName = 'localhost';
    public $userName = 'root';
    public $password = '';
    public $dbName = "mydatabase";
    public $connection ;

    function __construct()
    {
        if(!isset($this->connection)){
            $this->connection = new \mysqli($this->serverName,$this->userName,$this->password,$this->dbName);
            if(!$this->connection){
                echo "Error! Couldn't connect to database";
                exit;
            }
        }

        return $this->connection;
    }

    function disconnect(){
        \mysqli_close($this->connection);
        echo "Disconnected";
    }
}