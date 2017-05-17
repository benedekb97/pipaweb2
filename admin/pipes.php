<?php
session_start();
include("../includes/init.php");
include("../includes/Users.php");
include("../includes/Pipes.php");
include("../includes/Log.php");
include("../includes/Locations.php");

$users = new Users();
$pipes = new Pipes();
$locations = new Locations();

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
                        <th>Helyszín</th>
                        <th style="text-align:center;">Műveletek</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Azonosító</th>
                        <th>Íz</th>
                        <th>Létrehozta</th>
                        <th>Létrehozva</th>
                        <th>Helyszín</th>
                        <th style="text-align:center;">Műveletek</th>
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
                            <td><?= $pipe->getCreatedStatic(); ?></td>
                            <td><?= $locations->getLocationById($pipe->getLocation())->getName(); ?></td>
                            <td style="text-align:center;">
                                <span data-toggle="tooltip" data-placement="top" data-original-title="Pipa törlése">
                                    <button data-toggle="modal" data-target="#deletePipe<?= $pipe->getId(); ?>" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </td>
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
<?php
foreach($pipes->getPipes() as $pipe){
    ?>
    <div class="modal fade" id="deletePipe<?= $pipe->getId(); ?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pipa törlése</h4>
                </div>
                <div class="modal-body">
                    Biztosan törölni akarod a pipát?
                    <table class="table modal-table">
                        <tr>
                            <td>Azonosító</td>
                            <td><?= $pipe->getId(); ?></td>
                        </tr>
                        <tr>
                            <td>Dohány</td>
                            <td><?= $pipe->getType(); ?></td>
                        </tr>
                        <tr>
                            <td>Létrehozta</td>
                            <td><?= $users->getUserById($pipe->getCreatedBy())->getName(); ?></td>
                        </tr>
                        <tr>
                            <td>Létrehozva</td>
                            <td><?= $pipe->getCreatedStatic(); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <form action="delete_pipe" method="POST">
                        <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Nem">Mégse</button>
                        <input type="hidden" name="id" value="<?= $pipe->getId(); ?>">
                        <input type="submit" value="Igen" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php
}
?>
<?php include("../includes/footer.php"); ?>
<script type="text/javascript" language="javascript" src="/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#pipes').dataTable({"order": [[3, "desc"]]});
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
</body>
</html>
