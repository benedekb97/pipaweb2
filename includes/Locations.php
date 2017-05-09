<?php

require "Location.php";

class Locations
{
    private $locations;
    private $num_locations;

    public function __construct()
    {
        global $mysql;

        if (!$this->checkTable()) {

            $this->pushTable();

            if (!$this->checkTable()) {
                die("Table not created, check MySQL database and credentials");
            }
        }
        if ($this->checkTable()) {

            $query = $mysql->query("SELECT * FROM locations");
            $this->num_locations = 0;
            while ($row = $query->fetch_assoc()) {
                $this->locations[] = new Location($row['id']);
                $this->num_locations++;
            }
        }
    }

    public function checkTable()
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'locations'");

        if ($query->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getLocationById($id)
    {
        for($i = 0; $i < $this->num_locations; $i++){
            if($this->locations[$i]->getId() == $id){
                return $this->locations[$i];
            }
        }
        return null;
    }

    public function pushTable()
    {
        global $mysql;

        $mysql->query("CREATE TABLE `pipaweb`.`locations` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(256) NOT NULL , `description` VARCHAR(256) NOT NULL , `pipe_id` INT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    public function addLocation($name,$description)
    {
        global $mysql;
        $query = $mysql->query("SELECT * FROM locations WHERE name='$name' OR description='$description'");
        if($query->num_rows==0){
            $query = $mysql->query("INSERT INTO locations (name, description) VALUES ('$name','$description')");
            if($query){
                $query = $mysql->query("SELECT * FROM locations WHERE name='$name'");
                $id = $query->fetch_assoc()['id'];
                $this->locations[] = new Location($id);
            }
        }
    }
}