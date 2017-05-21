<?php

require_once "Pipe.php";

class Location
{
    private $id;
    private $name;
    private $description;
    private $pipe_id;
    private $tobacco;
    private $coal;
    private $tobacco_type;

    public function __construct($id)
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM locations WHERE id='$id'");
        $location_data = $query->fetch_assoc();

        $this->id = $id;
        $this->name = $location_data['name'];
        $this->description = $location_data['description'];
        $this->pipe_id = $location_data['pipe_id'];
        $this->tobacco = $location_data['tobacco'];
        $this->coal = $location_data['coal'];
        $this->tobacco_type = $location_data['tobacco_type'];

    }

    public function getTobacco()
    {
        return $this->tobacco;
    }

    public function getCoal()
    {
        return $this->coal;
    }

    public function getTobaccoType()
    {
        return $this->tobacco_type;
    }

    public function setTobacco($tobacco)
    {
        global $mysql;

        $mysql->query("UPDATE locations SET tobacco='$tobacco' WHERE id='$this->id'");
    }

    public function setCoal($coal)
    {
        global $mysql;

        $mysql->query("UPDATE locations SET coal='$coal' WHERE id='$this->id'");
    }

    public function setTobaccoType($tobacco_type)
    {
        global $mysql;

        $mysql->query("UPDATE locations set tobacco_type='$tobacco_type' WHERE id='$this->id'");
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