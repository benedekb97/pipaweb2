<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Log.php");

$users = new Users();

require_once("includes/current_user.php");

sleep(1);

if(isset($current_user)) {
    $log = new Log($current_user->getId(),"anyád","anyád");
}else{
    $log = new Log(0,"anyád","anyád");
}

header("Location: /");
die();