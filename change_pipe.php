<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Pipes.php");

$users = new Users();
$pipes = new Pipes();

require_once("includes/current_user.php");

if(!isset($current_user) || !($current_user->getAdmin() && $current_user->getSuperAdmin())){
    header("Location: /?login=true");
    die();
}

if(isset($_POST['type']) && isset($_POST['time'])){
    $new_type = $mysql->real_escape_string($_POST['type']);
    $new_time = $mysql->real_escape_string($_POST['time']);

    $pipes->getCurrentPipe()->setType($new_type);
    $pipes->getCurrentPipe()->setCreatedAt($new_time);
}
header("Location: /redirect");
die();