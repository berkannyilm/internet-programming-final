<?php

class Database
{
    private static $_instance;
    private $hostname, $dbname, $username, $password, $connection;

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    function __construct()
    {
        $this->hostname = "localhost";
        $this->dbname = "dbcoursex";
        $this->username = "root";
        $this->password = "12345678";
        try {

            $this->connection = new PDO('mysql:host=' . $this->hostname . ';charset=utf8;dbname=' . $this->dbname, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        } catch (PDOException $e) {
            echo 'PDO ERROR: ' . $e->getMessage();
        }
    }
}

$db = Database::getInstance();
$connection = $db->getConnection();
 
?>