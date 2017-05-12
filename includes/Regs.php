<?php

require "Reg.php";

class Regs
{
    private $regs;
    private $reg_num;

    public function __construct()
    {
        global $mysql;

        if (!$this->checkTable()) {

            $this->pushTable();

            if (!$this->checkTable()) {
                die("Table not created, check MySQL database and credentials");
            }
        }
        if ($this->checkTable()) {

            $query = $mysql->query("SELECT * FROM regs");
            $this->reg_num = 0;
            while ($row = $query->fetch_assoc()) {
                $this->regs[] = new Reg($row['id']);
                $this->reg_num++;
            }
        }
    }

    public function checkTable()
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'regs'");

        if ($query->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function pushTable()
    {
        global $mysql;

        $mysql->query("CREATE TABLE `pipaweb`.`regs` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(256) NOT NULL , `email` VARCHAR(256) NOT NULL , `full_name` VARCHAR(256) NOT NULL , `ip` VARCHAR(16) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    public function addReg($username, $email, $full_name)
    {
        global $mysql;
        $ip = $_SERVER['REMOTE_ADDR'];

        $mysql->query("INSERT INTO regs (username, email, full_name, ip) VALUES ('$username','$email','$full_name','$ip')");
    }
}