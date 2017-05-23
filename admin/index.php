<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Pipes.php");
require_once("../includes/Log.php");
require_once("../includes/Regs.php");

$users = new Users();
$pipes = new Pipes();
$regs = new Regs();

require_once("../includes/current_user.php");

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
    <?php require_once("../includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php require_once("../includes/nav.php"); ?>
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
                    <li>
                        <a href="/admin/registered_users">Regisztrációk
                            <?php
                            if($regs->getRegNum()!=0){
                                echo "(".$regs->getRegNum().")";
                            }
                            ?></a>
                    </li>
                    <li>
                        <a href="/admin/logs">Eseménynapló</a>
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
<?php require_once("../includes/footer.php"); ?>
</body>
</html>
