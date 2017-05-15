<?php

require_once "Pipe.php";

class Location
{
    private $id;
    private $name;
    private $description;
    private $pipe_id;

    public function __construct($id)
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM locations WHERE id='$id'");
        $location_data = $query->fetch_assoc();

        $this->id = $id;
        $this->name = $location_data['name'];
        $this->description = $location_data['description'];
        $this->pipe_id = $location_data['pipe_id'];

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }
}