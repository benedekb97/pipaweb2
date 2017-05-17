<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Locations.php");
require_once("../includes/Pipes.php");
require_once("../includes/Log.php");
require_once("../includes/Regs.php");

$users = new Users();
$pipes = new Pipes();
$locations = new Locations();
$regs = new Regs();

require_once("../includes/current_user.php");

if(!isset($current_user) || !$current_user->getSuperAdmin()){
    if(isset($current_user)){
        $log = new Log($current_user->getId(),"delete user","unauthorised");
    }else{
        $log = new Log(0,"delete user","unauthenticated");
    }
    header("Location: /?login=true");
    die("403 - unauthorised");
}

if(isset($_POST['id'])){
    $id = $mysql->real_escape_string($_POST['id']);

    $regs->deleteReg($id);

    $log = new Log($current_user->getId(),"delete reg",$id);
}
header("Location: /admin/registered_users");
die();