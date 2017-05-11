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

    </div>
</div>
<div class="modal modal-dialog fade" id="login-modal" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Bejelentkezés</h4>
        </div>
        <div class="modal-body">
            <button class="btn btn-success" href="login_auth" onClick="window.location = 'login';">AuthSCH-val</button>
            <hr size="2px">
            <form action="login" method="POST">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Felhasználónév</span>
                        <input type="text" name="username" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Jelszó</span>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="submit" class="btn btn-primary" value="Bejelentkezés">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            Nem vagy kolis? <a href="register">Igényelj felhasználót!</a>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
