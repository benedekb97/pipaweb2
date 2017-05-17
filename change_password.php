<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Log.php");

$users = new Users();

require_once("includes/current_user.php");

if (!(isset($current_user))) {
    header("Location: /?login=true");
    $log = new Log(0,"change_password","unauthorised password change attempt");
    die("403 - Not authorised!");
}

if ($current_user->getPassword()) {
    if (isset($_POST['old_password']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        $old_password = $mysql->real_escape_string($_POST['old_password']);
        $password1 = $mysql->real_escape_string($_POST['password1']);
        $password2 = $mysql->real_escape_string($_POST['password2']);

        if ($current_user->checkLogin($old_password) && $password1 == $password2) {
            $current_user->changePassword($password1);
            $log = new Log($current_user->getId(),"profile","password change");
        }
    }
} else {
    if (isset($_POST['password1']) && isset($_POST['password2'])) {
        $password1 = $mysql->real_escape_string($_POST['password1']);
        $password2 = $mysql->real_escape_string($_POST['password2']);

        if($password1 == $password2){
            $current_user->changePassword($password1);
            $log = new Log($current_user->getId(), "profile","added password");
        }
    }
}
header("Location: /profile");
