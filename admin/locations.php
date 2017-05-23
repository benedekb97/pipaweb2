<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Pipes.php");
require_once("../includes/Locations.php");
require_once("../includes/Log.php");
require_once("../includes/Regs.php");

$users = new Users();
$pipes = new Pipes();
$locations = new Locations();
$regs = new Regs();

require_once("../includes/current_user.php");

if (!(isset($current_user) && $current_user->getSuperAdmin())) {
    header("Location: /index?login=true");
    die("403 - Not authorised!");
}

$log = new Log($current_user->getId(), "admin locations", "view");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pipa.ml - Helyszínek</title>
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
                    <h4 class="panel-title">Helyszínek</h4>
                </div>
                <div class="table-responsive">
                <table id="locations" class="table">
                    <thead>
                    <tr>
                        <th>Azonosító</th>
                        <th>Szoba</th>
                        <th>Leírás</th>
                        <th style="text-align:center;">Műveletek</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Azonosító</th>
                        <th>Szoba</th>
                        <th>Leírás</th>
                        <th style="text-align:center;">Műveletek</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    foreach ($locations->getLocations() as $location) {
                        ?>
                        <tr>
                            <td><?= $location->getId(); ?></td>
                            <td><?= $location->getName(); ?></td>
                            <td><?= $location->getDescription(); ?></td>
                            <?php
                            if ($location->getId() != "1") {
                                ?>
                                <td style="text-align:center;">
                                <span data-toggle="tooltip" data-placement="top" data-original-title="Helyszín törlése">
                                    <button data-toggle="modal" data-target="#deleteLocation<?= $location->getId(); ?>"
                                            class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                    </button>
                                </span>
                                </td>
                                <?php
                            }else{
                                ?>
                                <td></td>
                            <?php
                            }
                            ?>
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
    <div class="row">
        <div class="col-lg-9 col-lg-push-3">
            <div class="panel panel-default">
                <form action="add_location" method="POST">
                    <div class="panel-heading">
                        <h3 class="panel-title">Új helyszín hozzáadása</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Helyszín neve (szobaszám): </span>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Helyszín leírása: </span>
                                <input type="text" class="form-control" name="description" required>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input class="btn btn-primary" type="submit" value="Küldés">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
foreach ($locations->getLocations() as $location) {
    if ($location->getID() != "1") {
        ?>
        <div class="modal fade" id="deleteLocation<?= $location->getId(); ?>" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Helyszín törlése</h4>
                    </div>
                    <div class="modal-body">
                        Biztosan törölni akarod a helyszínt?
                        <table class="table modal-table">
                            <tr>
                                <td>Azonosító</td>
                                <td><?= $location->getId(); ?></td>
                            </tr>
                            <tr>
                                <td>Dohány</td>
                                <td><?= $location->getName(); ?></td>
                            </tr>
                            <tr>
                                <td>Leírás</td>
                                <td><?= $location->getDescription(); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <form action="delete_location" method="POST">
                            <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Nem">Mégse
                            </button>
                            <input type="hidden" name="id" value="<?= $location->getId(); ?>">
                            <input type="submit" value="Igen" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }
}
?>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript" language="javascript" src="/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#locations').dataTable();
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
</body>
</html>
