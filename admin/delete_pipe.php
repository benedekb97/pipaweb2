<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Locations.php");
require_once("../includes/Pipes.php");
require_once("../includes/Log.php");

$users = new Users();
$locations = new Locations();
$pipes = new Pipes();

require_once("../includes/current_user.php");

if(!isset($current_user)){
    $log = new Log(0,"delete pipe","unauthenticated");
    header("Location: /?login=true");
    die("401 - unauthenticated");
}elseif(!$current_user->getSuperAdmin()){
    $log = new Log($current_user->getId(),"delete pipe","unauthorised");
    header("Location: /");
    die("403 - unauthorised");
}

if(isset($_POST['id'])){
    $id = $mysql->real_escape_string($_POST['id']);

    $pipes->deletePipe($id);

    $log = new Log($current_user->getId(),"delete pipe","$id");
}

header("Location: /admin/pipes");
die();