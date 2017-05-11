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
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php include("includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Anyád</h3>
                </div>
                <div class="panel-body">
                    Buzi vagy
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default">Anyád</button>
                    <button type="button" class="btn btn-primary">Anyád</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Anyád</h3>
                </div>
                <div class="panel-body">
                    Buzi vagy
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default">Anyád</button>
                    <button type="button" class="btn btn-primary">Anyád</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
