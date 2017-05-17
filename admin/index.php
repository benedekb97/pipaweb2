<?php
session_start();
include("../includes/init.php");
include("../includes/Users.php");
include("../includes/Pipes.php");
include("../includes/Log.php");

$users = new Users();
$pipes = new Pipes();

include("../includes/current_user.php");

if (!(isset($current_user) && $current_user->getSuperAdmin())) {
    header("Location: /?login=true");
    die("403 - Not authorised!");
}

$log = new Log($current_user->getId(), "admin", "view");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pipa.ml - Admin</title>
    <?php include("../includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php include("../includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Oldalak</h4>
                </div>
                <ul class="nav">
                    <li>
                        <a href="/admin/users">Felhasználók</a>
                    </li>
                    <li>
                        <a href="/admin/pipes">Pipák</a>
                    </li>
                    <li>
                        <a href="/admin/locations">Helyszínek</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Általános adatok</h4>
                </div>
                <div class="panel-body">
                    Anyád
                </div>
                <div class="panel-footer">
                    Kurva
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>
