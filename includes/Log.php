<?php

class Log
{
    public function __construct($user_id, $page, $data_changed=null)
    {
        global $mysql;
        $timestamp = time()-10;
        $ip = $_SERVER['REMOTE_ADDR'];
        $query = $mysql->query("SELECT * FROM logs WHERE user_id='$user_id' AND ip='$ip' AND timestamp>'$timestamp'");
        if($query->num_rows == 0){
            $timestamp = time();
            $mysql->query("INSERT INTO logs (user_id, ip, page, data_changed, timestamp) VALUES ('$user_id','$ip','$page','$data_changed','$timestamp')");
        }
    }


}