<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Log.php");
$users = new Users();

$users->getUserByUsername("benedekb97")->changePassword("thestump2010");

require_once("includes/current_user.php");

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $mysql->real_escape_string($_POST['username']);
    $password = $mysql->real_escape_string($_POST['password']);
    if($users->getUserByUsername($username) != null) {
        if($users->getUserByUsername($username)->checkLogin($password)) {
            $_SESSION['uuid'] = $users->getUserByUsername($username)->getId();
            $log = new Log($users->getUserByUsername($username)->getId(), "login","reg login");
            $users->getUserByUsername($username)->setLastLogin();
            header("Location: /");
            die();
        }
        header("Location: /");
    }
    header("Location: /");
}
header("Location: /");
die();