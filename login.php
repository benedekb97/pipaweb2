<?php
session_start();
require_once("includes/authSch.php");
require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Log.php");

$users = new Users();
$authSch = new AuthSCHClient();
$data = $authSch->getData();
if(isset($data)){
    $internal_id = $data->internal_id;
    $name = $data->displayName;
    $schacc = $data->linkedAccounts->schacc;
    $email = $schacc."@sch.bme.hu";
    if($users->getUserByUuid($internal_id) == null) {
        $users->addUserOauth($schacc,$internal_id,$name,$email);
        $id = $users->getUserByUuid($internal_id)->getId();
        $users->getUserByUuid($internal_id)->setLastLogin();
        $log = new Log($id,"login","AuthSCH reg");
        $_SESSION['uuid'] = $internal_id;
        header("Location: /");
        die();
    }else{
        $id = $users->getUserByUuid($internal_id)->getId();
        $users->getUserByUuid($internal_id)->setLastLogin();
        $log = new Log($id, "login", "AuthSCH login");
        $_SESSION['uuid'] = $internal_id;
        header("Location: /");
        die();
    }
}