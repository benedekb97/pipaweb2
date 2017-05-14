<?php
session_start();
include("includes/init.php");
include("includes/Users.php");
include("includes/Log.php");

$users = new Users();

include("includes/current_user.php");

if (!(isset($current_user))) {
    header("Location: /?login=true");
    die("403 - Not authorised!");
}

if ($current_user->getPassword()) {
    if (isset($_POST['old_password']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        $old_password = $mysql->real_escape_string($_POST['old_password']);
        $password1 = $mysql->real_escape_string($_POST['password1']);
        $password2 = $mysql->real_escape_string($_POST['password2']);

        if ($current_user->checkLogin($old_password) && $password1 == $password2) {
            $current_user->changePassword($password1);
        }
    }
} else {
    if (isset($_POST['password1']) && isset($_POST['password2'])) {
        $password1 = $mysql->real_escape_string($_POST['password1']);
        $password2 = $mysql->real_escape_string($_POST['password2']);

        if($password1 == $password2){
            $current_user->changePassword($password1);
        }
    }
}
header("Location: /profile");
