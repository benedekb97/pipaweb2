<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Log.php");
require_once("../includes/Locations.php");

$users = new Users();
$locations = new Locations();

require_once("../includes/current_user.php");

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
        foreach($locations->getLocations() as $location){
            $asd = "admin".$location->getId();
            if(isset($_POST[$asd])){
                if($users->getUserById($id)->isAdminOf($location->getId()) != true) {
                    $users->getUserById($id)->addAdmin($location->getId());
                }
            }else{
                if($users->getUserById($id)->isAdminOf($location->getId())) {
                    $users->getUserById($id)->removeAdmin($location->getId());
                }
            }
        }
    }
    if($_POST['type'] == "superadmin") {
        $log = new Log($current_user->getId(),"change user","super admin: $id");
        $users->getUserById($id)->setSuperAdmin();
    }
    if($_POST['type'] == "delete") {
        $log = new Log($current_user->getId(),"change user","delete: $id");
        $users->removeUser($id);
    }
    if($_POST['type'] == "easter_egg" && isset($_POST['easter_egg_text'])){
        $easter_egg = $_POST['easter_egg_text'];

        $users->getUserById($id)->setEasterEgg($easter_egg);

        $log = new Log($current_user->getId(), "change user","easter-egg: $id, $easter_egg");
    }
}
header("Location: /admin/users");