<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Locations.php");
require_once("../includes/Pipes.php");
require_once("../includes/Log.php");

$users = new Users();
$pipes = new Pipes();
$locations = new Locations();

require_once("../includes/current_user.php");

if(!isset($current_user) || !$current_user->getSuperAdmin()){
    if(isset($current_user)){
        $log = new Log($current_user->getId(),"add location","unauthorised");
    }else{
        $log = new Log(0,"add location","unauthenticated");
    }
    header("Location: /?login=true");
    die("403 - unauthorised");
}

if(isset($_POST['name']) && isset($_POST['description'])){
    $name = $mysql->real_escape_string($_POST['name']);
    $description = $mysql->real_escape_string($_POST['description']);

    $locations->addLocation($name, $description);
    $log = new Log($current_user->getId(),"add location","$name, $description");
}
header("Location: /admin/locations");
