<?php

class Log
{
    private $user_id;
    private $page;
    private $data_changed;
    private $timestamp;
    private $ip;

    public function __construct($user_id, $page, $data_changed=null)
    {
        global $mysql;
        $timestamp = time()-10;
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = $mysql->query("SELECT * FROM logs WHERE user_id='$user_id' AND ip='$ip' AND timestamp>'$timestamp'");
        /*if($query->num_rows == 0){
            $this->user_id = $user_id;
            $this->ip = $ip;
            $this->page = $page;
            $this->data_changed = $data_changed;
            $this->timestamp = time();
            $mysql->query("INSERT INTO logs (user_id, ip, page, data_changed, timestamp) VALUES ('$this->user_id','$this->ip','$this->page','$this->data_changed','$this->timestamp')");
        }*/
    }


}