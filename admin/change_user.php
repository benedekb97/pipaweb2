<?php
session_start();
include("../includes/init.php");
include("../includes/Users.php");
include("../includes/Log.php");

$users = new Users();

include("../includes/current_user.php");

if(!(isset($current_user) && $current_user->getSuperAdmin())){
    if(isset($current_user)){
        $log = new Log($current_user->getId(),"change user","unauthorised");
    }else{
        $log = new Log(0,"change user","unauthenticated");
    }
    header("Location: /?login=true");
    die("403 - Not authorised!");
}

if(isset($_POST['id']) && isset($_POST['type'])) {
    $id = $mysql->real_escape_string($_POST['id']);
    if($_POST['type'] == "password") {
        if(!isset($_POST['password1']) || !isset($_POST['password2'])) {
            header("Location: /admin/users");
            die();
        }
        if($_POST['password1'] == $_POST['password2']) {
            $log = new Log($current_user->getId(), "change user","password: $id");
            $users->getUserById($id)->changePassword($_POST['password1']);
        }
    }
    if($_POST['type'] == "admin") {
        $log = new Log($current_user->getId(), "change user","admin: $id");
        $users->getUserById($id)->setAdmin();
    }
    if($_POST['type'] == "superadmin") {
        $log = new Log($current_user->getId(),"change user","super admin: $id");
        $users->getUserById($id)->setSuperAdmin();
    }
    if($_POST['type'] == "delete") {
        $log = new Log($current_user->getId(),"change user","delete: $id");
        $users->removeUser($id);
    }
}
header("Location: /admin/users");