<?php

class Pipe
{
    private $id;
    private $type;
    private $created;
    private $ready;
    private $dying;
    private $preparing;
    private $created_by;

    public function __construct($id)
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM pipes WHERE id='$id'");
        $pipe_data = $query->fetch_assoc();

        $this->id =$id;
        $this->type = $pipe_data['type'];
        $this->created = $pipe_data['created'];
        $this->ready = $pipe_data['ready'];
        $this->dying = $pipe_data['dying'];
        $this->preparing = $pipe_data['preparing'];
        $this->created_by = $pipe_data['created_by'];

    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCreatedBy()
    {
        return $this->created_by;
    }
}