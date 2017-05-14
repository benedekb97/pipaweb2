<?php

class Settings
{
    private $ready_time;
    private $dying_time;
    private $end_time;

    public function __construct()
    {
        global $mysql;

        if(!$this->checkTable()){
            $this->pushTable();
            if(!$this->checkTable()){
                die("Push table failed, check configuration");
            }
        }
        $query = $mysql->query("SELECT * FROM settings WHERE id='1'");
        $settings_data = $query->fetch_assoc();
        $this->ready_time = $settings_data['ready_time'];
        $this->dying_time = $settings_data['dying_time'];
        $this->end_time = $settings_data['end_time'];
    }

    public function getReadyTime()
    {
        return (int)$this->ready_time;
    }

    public function getDyingTime()
    {
        return (int)$this->dying_time;
    }

    public function getEndTime()
    {
        return (int)$this->end_time;
    }

    public function pushTable()
    {
        global $mysql;

        $mysql->query("CREATE TABLE `pipaweb`.`settings` ( `id` INT NOT NULL AUTO_INCREMENT , `ready_time` INT NOT NULL DEFAULT '780' , `dying_time` INT NOT NULL DEFAULT '3160' , `end_time` INT NOT NULL DEFAULT '4080' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    public function checkTable()
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'settings'");

        if ($query->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

}