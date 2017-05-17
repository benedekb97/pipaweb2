<?php
session_start();
include("../includes/init.php");
include("../includes/Users.php");
include("../includes/Pipes.php");
include("../includes/Locations.php");
include("../includes/Log.php");

$users = new Users();
$pipes = new Pipes();
$locations = new Locations();

include("../includes/current_user.php");

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
                    <h4 class="panel-title">Helyszínek</h4>
                </div>
                <table id="locations" class="table">
                    <thead>
                    <tr>
                        <th>Azonosító</th>
                        <th>Szoba</th>
                        <th>Leírás</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Azonosító</th>
                        <th>Szoba</th>
                        <th>Leírás</th>
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
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
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
<?php include("../includes/footer.php"); ?>
<script type="text/javascript" language="javascript" src="/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#locations').dataTable();
    })
</script>
</body>
</html>
