<?php

class OldLog
{
    private $id;
    private $user_id;
    private $ip;
    private $page;
    private $data;
    private $timestamp;
    private $time;

    private $mysql;

    public function __construct($id)
    {
        global $mysql;
        $this->mysql = $mysql;

        $query = $this->mysql->query("SELECT * FROM logs WHERE id='$id'");
        $log_data = $query->fetch_assoc();

        $this->id = $id;
        $this->user_id = $log_data['user_id'];
        $this->timestamp = $log_data['timestamp'];
        $this->time = date("Y-m-d H:i:s",$this->timestamp);
        $this->page = $log_data['page'];
        $this->ip = $log_data['ip'];
        $this->data = $log_data['data_changed'];
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}