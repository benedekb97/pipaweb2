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
    if(isset($_POST['tobacco']) && isset($_POST['tobacco_type'])){
        $tobacco = $mysql->real_escape_string($_POST['tobacco']);
        $tobacco_type = $mysql->real_escape_string($_POST['tobacco_type']);

        $locations->getLocationById($location)->setTobacco($tobacco);
        $locations->getLocationById($location)->setTobaccoType($tobacco_type);

        $log = new Log($current_user->getId(),"change tobacco",$location." tobacco: ".$tobacco.", ".$tobacco_type);

        header("Location: /?location=$location");
        die();
    }
}
header("Location: /?login=true");
die();