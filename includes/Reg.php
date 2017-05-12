<?php

class Reg
{
    private $id;
    private $username;
    private $email;
    private $full_name;
    private $ip;

    public function __construct($id)
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM regs WHERE id='$id'");
        $reg_data = $query->fetch_assoc();

        $this->id = $reg_data['id'];
        $this->username = $reg_data['username'];
        $this->email = $reg_data['email'];
        $this->full_name = $reg_data['full_name'];
        $this->ip = $reg_data['ip'];
    }


}