<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Log.php");
$users = new Users();

require_once("includes/current_user.php");

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $mysql->real_escape_string($_POST['username']);
    $password = $mysql->real_escape_string($_POST['password']);
    if($users->getUserByUsername($username) != null) {
        if($users->getUserByUsername($username)->checkLogin($password)) {
            $_SESSION['uuid'] = $users->getUserByUsername($username)->getId();
            $log = new Log($users->getUserByUsername($username)->getId(), "login","reg login");
            $users->getUserByUsername($username)->setLastLogin();
            header("Location: /?welcome=true");
            die();
        }
        header("Location: /?login=true&password=true&username=$username");
        die();
    }
    header("Location: /?login=true&username=true");
    die();
}
header("Location: /?login=true");
die();