<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Pipes.php");
require_once("includes/Log.php");

$users = new Users();
$pipes = new Pipes();

require_once("includes/current_user.php");

if(!isset($current_user) || !($current_user->getAdmin() && $current_user->getSuperAdmin())){
    header("Location: /?login=true");
    if(isset($current_user)){
        $log = new Log($current_user->getId(),"change_pipe","unauthorised");
    }else{
        $log = new Log(0,"change_pipe","unauthenticated");
    }
    die();
}

if(isset($_POST['type']) && isset($_POST['time'])){
    $new_type = $mysql->real_escape_string($_POST['type']);
    $new_time = $mysql->real_escape_string($_POST['time']);
    $location = $mysql->real_escape_string($_POST['location']);

    $pipes->getCurrentPipe($location)->setType($new_type);
    $pipes->getCurrentPipe($location)->setCreatedAt($new_time);

    $log = new Log($current_user->getId(),"pipe","Type = $new_type; Time = $new_time");
}
header("Location: /redirect?location=$location");
die();