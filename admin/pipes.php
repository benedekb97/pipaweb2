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
    header("Location: /index?login=true");
    die("403 - Not authorised!");
}

$log = new Log($current_user->getId(), "admin pipes", "view");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pipa.ml - Pipák</title>
    <?php include("../includes/head.php"); ?>
    <link rel="stylesheet" type="text/css" href="/css/dataTables.min.css"/>
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
                    <h4 class="panel-title">Pipák</h4>
                </div>
                <table id="pipes" class="table">
                    <thead>
                    <tr>
                        <th>Azonosító</th>
                        <th>Íz</th>
                        <th>Létrehozta</th>
                        <th>Létrehozva</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Azonosító</th>
                        <th>Íz</th>
                        <th>Létrehozta</th>
                        <th>Létrehozva</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    foreach ($pipes->getPipes() as $pipe) {
                        ?>
                        <tr>
                            <td><?= $pipe->getId(); ?></td>
                            <td><?= $pipe->getType(); ?></td>
                            <td><?= $users->getUserById($pipe->getCreatedBy())->getName(); ?></td>
                            <td><?= $pipe->getCreatedAt(); ?></td>
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
<?php include("../includes/footer.php"); ?>
<script type="text/javascript" language="javascript" src="/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#pipes').dataTable( { "order": [[ 3, "desc" ]] } );
    })
</script>
</body>
</html>
