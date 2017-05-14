<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Pipes.php");

$users = new Users();
$pipes = new Pipes();

require_once("includes/current_user.php");

if (isset($current_user) && ($current_user->getAdmin() || $current_user->getSuperAdmin())) {
    if(isset($_POST['type']) && isset($_POST['time'])){
        $new_id = $pipes->newPipe($_POST['type'],$current_user->getId());
        $pipes->getPipeById($new_id)->setCreatedAt($_POST['time']);
    }
    header("Location: /redirect");
    die();
}else{
    header("Location: /?login=true");
    die();
}