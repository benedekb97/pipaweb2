<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Pipes.php");
require_once("includes/Log.php");

$users = new Users();
$pipes = new Pipes();

require_once("includes/current_user.php");

$location = $mysql->real_escape_string($_POST['location']);

$current_pipe = $pipes->getCurrentPipe($location);

if($current_pipe!=null){
    header("Location: /");
}

if (isset($current_user) && ($current_user->isAdminOf($location) || $current_user->getSuperAdmin())) {
    if(isset($_POST['type']) && isset($_POST['time'])){
        $new_type = $mysql->real_escape_string($_POST['type']);
        $new_time = $mysql->real_escape_string($_POST['time']);
        $new_id = $pipes->newPipe($new_type,$current_user->getId(),$location);
        $pipes->getPipeById($new_id)->setCreatedAt($_POST['time']);
        $log = new Log($current_user->getId(),"pipe","Type = $new_type; Time = $new_time");
    }
    header("Location: /redirect?location=$location");
    die();
}else{
    if(isset($current_user)){
        $log = new Log($current_user->getId(),"new_pipe","unauthorised new pipe add attempt");
    }else{
        $log = new Log(0,"new_pipe","unauthorised new pipe add attempt");
    }
    header("Location: /?login=true");
    die();
}