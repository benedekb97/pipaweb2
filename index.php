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
$log = new Log(0,"index", "view");