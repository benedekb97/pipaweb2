<?php
session_start();

require_once("includes/init.php");
require_once("includes/Users.php");
require_once("includes/Log.php");
require_once("includes/Regs.php");

$users = new Users();
$regs = new Regs();

require_once("includes/current_user.php");

if (isset($current_user)) {
    die("403 - Not authorised!");
}

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['username'])) {
    $full_name = $mysql->real_escape_string($_POST['name']);
    $email = $mysql->real_escape_string($_POST['email']);
    $username = $mysql->real_escape_string($_POST['username']);
    setcookie("regged", "true");
    if ($_COOKIE['regged'] != "true") {
        $log = new Log(0,"register","New reg added");
        $regs->addReg($username, $email, $full_name);
    }
}
header("Location: /");