<?php

require_once("OldLog.php");

class OldLogs
{
    private $logs = array();
    private $num_logs = 0;

    private $mysql;

    public function __construct()
    {
        global $mysql;
        $this->mysql = $mysql;

        $query = $this->mysql->query("SELECT * FROM logs ORDER BY timestamp DESC");
        while($row = $query->fetch_assoc()){
            $this->logs[] = new OldLog($row['id']);
            $this->num_logs++;
        }

    }

    public function getLogs()
    {
        return $this->logs;
    }
}