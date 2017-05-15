<?php

require_once "Pipe.php";

class Pipes
{
    private $pipes;
    private $num_pipes;

    public function getCurrentPipe()
    {
        for($i = 0; $i < $this->num_pipes; $i ++){
            if($this->pipes[$i]->getStatus()!="dead"){
                return $this->pipes[$i];
            }
        }
        return null;
    }

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
            $query = $mysql->query("SELECT * FROM pipes ORDER BY created DESC");
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

        $mysql->query("CREATE TABLE `pipaweb`.`pipes` ( `id` INT NOT NULL AUTO_INCREMENT , `type` VARCHAR(256) NOT NULL , `created` DATETIME NOT NULL , `ready` INT NULL DEFAULT '0' , `dying` INT NULL DEFAULT '0' , `preparing` INT NULL DEFAULT '0' , `created_by` INT NOT NULL , `location_id` INT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    public function newPipe($type, $user_id)
    {
        global $mysql;

        $mysql->query("INSERT INTO pipes (type,created,created_by) VALUES ('$type',NOW(),'$user_id')");

        $query = $mysql->query("SELECT * FROM pipes WHERE id=(SELECT max(id) FROM pipes)");
        $data = $query->fetch_assoc();
        $this->pipes[] = new Pipe($data['id']);
        return $data['id'];
    }

    public function getPipes()
    {
        return $this->pipes;
    }

    public function getPipeById($id)
    {
        foreach($this->pipes as $pipe){
            if($pipe->getId() == $id){
                return $pipe;
            }
        }
        return null;
    }
}