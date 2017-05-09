<?php

$mysql_username = "mysql_username";
$mysql_password = "mysql_password";
$mysql_host = "mysql_host";
$mysql_database = "mysql_database";

$mysql = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

if($mysql->error){
    die($mysql->error);
}