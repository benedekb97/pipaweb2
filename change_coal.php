<?php
session_start();
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Locations.php");
require_once("includes/Log.php");

$users = new Users();
$locations = new Locations();

require_once("includes/current_user.php");

$location = $_POST['location'];

if(isset($current_user) && ($current_user->isAdminOf($location) || $current_user->getSuperAdmin())){
    if(isset($_POST['coal'])){
        $coal = $mysql->real_escape_string($_POST['coal']);

        $locations->getLocationById($location)->setCoal($coal);

        $log = new Log($current_user->getId(),"change tobacco",$location." coal: ".$coal);

        header("Location: /?location=$location");
        die();
    }
}
header("Location: /?login=true");
die();