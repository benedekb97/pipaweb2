<?php
session_start();
include("../includes/init.php");
include("../includes/Users.php");
include("../includes/Log.php");

$users = new Users();

include("../includes/current_user.php");

if(!(isset($current_user) && $current_user->getSuperAdmin())){
    die("403 - Not authorised!");
}

if(isset($_POST['id']) && isset($_POST['type'])) {
    if($_POST['type'] == "password") {
        if(!isset($_POST['password1']) || !isset($_POST['password2'])) {
            header("Location: /admin/users");
            die();
        }
        if($_POST['password1'] == $_POST['password2']) {
            $users->getUserById($_POST['id'])->changePassword($_POST['password1']);
        }
    }
    if($_POST['type'] == "admin") {
        $users->getUserById($_POST['id'])->setAdmin();
    }
    if($_POST['type'] == "superadmin") {
        $users->getUserById($_POST['id'])->setSuperAdmin();
    }
    if($_POST['type'] == "delete") {
        $users->removeUser($_POST['id']);
    }
}
header("Location: /admin/users");