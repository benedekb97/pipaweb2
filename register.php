<?php
session_start();

include("includes/init.php");

include("includes/Users.php");
include("includes/Locations.php");
include("includes/Pipes.php");
include("includes/Log.php");


$users = new Users();
$locations = new Locations();
$pipes = new Pipes();
$log = new Log(0, "index", "view");


include("includes/current_user.php");

if(isset($current_user)){
    die("403 - Not authorized!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Felhasználónév igénylése</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php include("includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-6 col-lg-push-3">
            <div class="panel panel-default">
                <div class="panel-heading">

                </div>
                <div class="panel-body">

                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
