<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Locations.php");
require_once("../includes/Regs.php");
require_once("../includes/Pipes.php");
require_once("../includes/Log.php");
require_once("../includes/OldLogs.php");

$users = new Users();
$locations = new Locations();
$regs = new Regs();
$pipes = new Pipes();
$logs = new OldLogs();

require_once("../includes/current_user.php");

if(!isset($current_user)){
    $log = new Log(0,"admin log","unauthenticated");
    header("Location: /?login=true");
    die();
}elseif(!$current_user->getSuperAdmin()){
    $log = new Log($current_user->getId(),"admin log","unauthorised");
    header("Location: /");
    die();
}

$log = new Log($current_user->getId(),"admin log","view");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pipa.ml - Pipák</title>
    <?php require_once("../includes/head.php"); ?>
    <link rel="stylesheet" type="text/css" href="/css/dataTables.min.css"/>
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
                    <h4 class="panel-title">Pipák</h4>
                </div>
                <div class="table-responsive">
                    <table id="logs" class="table">
                        <thead>
                        <tr>
                            <th>Idő</th>
                            <th>Oldal</th>
                            <th>Művelet</th>
                            <th>Felhasználó</th>
                            <th>IP</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Idő</th>
                            <th>Oldal</th>
                            <th>Művelet</th>
                            <th>Felhasználó</th>
                            <th>IP</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        foreach ($logs->getLogs() as $current_log) {
                            ?>
                            <tr>
                                <td><?= $current_log->getTime(); ?></td>
                                <td><?= $current_log->getPage(); ?></td>
                                <td><?= strip_tags($current_log->getData()); ?></td>
                                <td><?= $users->getUserById($current_log->getUserId())->getName(); ?></td>
                                <td><?= $current_log->getIp(); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript" language="javascript" src="/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#logs').dataTable();
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
</body>
</html>

