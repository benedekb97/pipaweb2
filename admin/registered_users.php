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

if (!isset($current_user) || !$current_user->getSuperAdmin()) {
    if (isset($current_user)) {
        $log = new Log($current_user->getId(), "admin regs", "unauthorised");
        header("Location: /");
    } else {
        $log = new Log($current_user->getId(), "admin regs", "unauthoenticated");
        header("Location:?login=true");
    }
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pipa.ml - Regisztrációk</title>
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
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Regisztrált felhasználók</h4>
                </div>
                <div class="table-responsive">
                    <table id="regs" class="table">
                        <thead>
                        <tr>
                            <th>Azonosító</th>
                            <th>Kívánt felhasználónév</th>
                            <th>Teljes név</th>
                            <th>Email cím</th>
                            <th>IP cím</th>
                            <th>Műveletek</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Azonosító</th>
                            <th>Kívánt felhasználónév</th>
                            <th>Teljes név</th>
                            <th>Email cím</th>
                            <th>IP cím</th>
                            <th>Műveletek</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        foreach ($regs->getRegs() as $reg) {
                            ?>
                            <tr>
                                <td><?= $reg->getId(); ?></td>
                                <td><?= $reg->getUsername(); ?></td>
                                <td><?= $reg->getFullName() ?></td>
                                <td><?= $reg->getEmail(); ?></td>
                                <td><?= $reg->getIp(); ?></td>
                                <td style="text-align:center;">
                                    <span data-toggle="tooltip" data-placement="top"
                                          data-original-title="Regisztráció feldolgozása">
                                        <button data-toggle="modal" data-target="#addUser<?= $reg->getId(); ?>"
                                                class="btn btn-default">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </span>
                                    <span data-toggle="tooltip" data-placement="top"
                                          data-original-title="Regisztráció törlése">
                                        <button data-toggle="modal" data-target="#deleteReg<?= $reg->getId(); ?>"
                                                class="btn btn-danger">
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
</div>
<?php
foreach ($regs->getRegs() as $reg) {
    ?>
    <div class="modal fade" id="addUser<?= $reg->getId(); ?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="add_user" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Felhasználó hozzáadása</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Felhasználónév:</span>
                                <input id="newUser<?= $reg->getId(); ?>" class="form-control" type="text" placeholder="<?= $reg->getUsername(); ?>" name="username">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?= $reg->getId(); ?>">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" role="button" type="button" class="btn btn-default">Mégse</button>
                        <input id="submit<?= $reg->getId(); ?>" class="btn btn-primary" value="Küldés" type="submit">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="modal fade" id="deleteReg<?= $reg->getId(); ?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Regisztráció törlése</h4>
                </div>
                <div class="modal-body">
                    Biztosan törölni akarod a regisztrációt?
                    <table class="table modal-table">
                        <tr>
                            <td>Azonosító</td>
                            <td><?= $reg->getId(); ?></td>
                        </tr>
                        <tr>
                            <td>Kívánt felhasználónév</td>
                            <td><?= $reg->getUsername(); ?></td>
                        </tr>
                        <tr>
                            <td>Teljes név</td>
                            <td><?= $reg->getFullName(); ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= $reg->getEmail(); ?></td>
                        </tr>
                        <tr>
                            <td>IP</td>
                            <td><?= $reg->getIp(); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <form action="delete_reg" method="POST">
                        <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Nem">Mégse
                        </button>
                        <input type="hidden" name="id" value="<?= $reg->getId(); ?>">
                        <input type="submit" value="Igen" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php require_once("../includes/footer.php"); ?>
<script type="text/javascript" language="javascript" src="/js/dataTables.min.js"></script>
<script>
    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }
    function checkData(id){
        var users = new Array(""<?php foreach($users->getUsers() as $user){ echo ',"'.$user->getUsername().'"'; } ?>);
        if(inArray($('#newUser' + id).val(),users)){
            $('#submit' + id).attr('disabled','disabled');
        }else{
            $('#submit' + id).removeAttr('disabled');
        }
    }
    <?php
    foreach($regs->getRegs() as $reg){
    ?>
    setInterval(function() { checkData(<?= $reg->getId(); ?>); },50);
    <?php
    }
    ?>
    $(document).ready(function () {

        $('#regs').dataTable();
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
</body>
</html>

