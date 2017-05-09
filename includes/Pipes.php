<?php

require_once "Pipe.php";

class Pipes
{
    private $pipes;
    private $num_pipes;

    public function __construct()
    {
        global $mysql;

        if (!$this->checkTable()) {

            $this->pushTable();

            if (!$this->checkTable()) {
                die("Table not created, check MySQL database and credentials");
            }
        }
        if($this->checkTable()) {
            $query = $mysql->query("SELECT * FROM pipes");

            $this->num_pipes = 0;
            while ($row = $query->fetch_assoc()) {
                $this->pipes[] = new Pipe($row['id']);
                $this->num_pipes++;
            }
        }
    }

    public function checkTable()
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'pipes'");

        if ($query->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function pushTable()
    {
        global $mysql;

        $mysql->query("CREATE TABLE `pipaweb`.`pipes` ( `id` INT NOT NULL , `type` VARCHAR(256) NOT NULL , `created` DATETIME NOT NULL , `ready` INT NULL DEFAULT '0' , `dying` INT NULL DEFAULT '0' , `preparing` INT NULL DEFAULT '0' , `created_by` INT NOT NULL ) ENGINE = InnoDB;");
        echo "asd";
    }

    public function newPipe($type)
    {

    }
}