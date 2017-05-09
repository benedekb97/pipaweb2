<?php

class Pipe
{
    private $id;
    private $type;
    private $created;
    private $ready;
    private $dying;
    private $preparing;

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

    }
}