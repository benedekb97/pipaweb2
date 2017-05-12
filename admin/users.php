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
    die("403 - Not authorised!");
}

$log = new Log($current_user->getId(), "admin users", "view");

$users->addUserReg("csicska","meleg");

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
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Felhasználók</h4>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Felhasználónév</th>
                        <th>Név</th>
                        <th style="text-align:center;">AuthSCH</th>
                        <th style="text-align:center;">Sima jelszó</th>
                        <th style="text-align:center;">Admin</th>
                        <th style="text-align:center;">Super-admin</th>
                        <th style="text-align:center;">Műveletek</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $users->getUserNum(); $i++) {
                        ?>
                        <tr>
                            <td><?= $users->getUsers()[$i]->getUsername(); ?></td>
                            <td><?= $users->getUsers()[$i]->getName(); ?></td>
                            <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getUuid()) { ?><span
                                        class="fa fa-check"></span><?php } else { ?><span
                                        class="fa fa-times"></span><?php } ?></td>
                            <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getPassword()) { ?><span
                                        class="fa fa-check"></span><?php } else { ?><span
                                        class="fa fa-times"></span><?php } ?></td>
                            <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getAdmin()) { ?><span
                                        class="fa fa-check"></span><?php } else { ?><span
                                        class="fa fa-times"></span><?php } ?></td>
                            <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getSuperAdmin()) { ?><span
                                        class="fa fa-check"></span><?php } else { ?><span
                                        class="fa fa-times"></span><?php } ?></td>
                            <td style="text-align:center;">
                                <a role="button" class="btn btn-default" data-toggle="modal"
                                   data-target="#userPw<?= $users->getUsers()[$i]->getId(); ?>"><span
                                            class="fa fa-star"></span>
                                </a>
                                <?php
                                if ($users->getUsers()[$i]->getAdmin()) {
                                    ?>
                                    <form style="display:inline-block;" action="/admin/change_user"
                                          method="POST">
                                        <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                                        <input type="hidden" name="type" value="admin"/>
                                        <button type="submit" class="btn btn-primary" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Admin jogosultság megvonása">
                                            <span class="fa fa-user"></span>
                                        </button>
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <form style="display:inline-block;" action="/admin/change_user"
                                          method="POST">
                                        <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                                        <input type="hidden" name="type" value="admin"/>
                                        <button type="submit" class="btn btn-default" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Admin jogosultság megadása">
                                            <span class="fa fa-user-o"></span>
                                        </button>
                                    </form>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($users->getUsers()[$i]->getSuperAdmin()) {
                                    ?>
                                    <form style="display:inline-block;" action="/admin/change_user"
                                          method="POST">
                                        <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                                        <input type="hidden" name="type" value="superadmin"/>
                                        <button type="submit" class="btn btn-primary" data-toggle="tooltop"
                                                data-placement="top"
                                                data-original-title="Superadmin jogosultság megvonása">
                                            <span class="fa fa-user"></span>
                                        </button>
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <form style="display:inline-block;" action="/admin/change_user"
                                          method="POST">
                                        <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                                        <input type="hidden" name="type" value="superadmin"/>
                                        <button type="submit" class="btn btn-default" data-toggle="tooltop"
                                                data-placement="top"
                                                data-original-title="Superadmin jogosultság megadása">
                                            <span class="fa fa-user-o"></span>
                                        </button>
                                    </form>
                                    <?php
                                }
                                ?>
                                <form style="display:inline-block;" action="/admin/change_user" method="POST">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>">
                                    <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Felhasználó törlése">
                                        <span class="fa fa-user-times"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
for ($i = 0; $i < $users->getUserNum(); $i++) {
    ?>
    <div class="modal fade" id="userPw<?= $users->getUsers()[$i]->getId(); ?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/change_user" method="POST">
                    <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                    <input type="hidden" name="type" value="password"/>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Jelszó változtatás</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Jelszó</span>
                                <input id="input<?= $users->getUsers()[$i]->getId(); ?>" type="password"
                                       name="password1" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Mégegyszer</span>
                                <input id="inputMatch<?= $users->getUsers()[$i]->getId(); ?>" type="password"
                                       name="password2" class="form-control"/>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button role="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                        <input type="submit" class="btn btn-primary" value="Küldés">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

?>
<?php include("../includes/footer.php"); ?>
<script>

    $(document).ready(function () {
        <?php
        foreach($users->getUsers() as $user) {
        ?>
        function checkPassword<?= $user->getId(); ?>() {
            if ($('#input<?= $user->getId(); ?>').val() != $('#inputMatch<?= $user->getid(); ?>').val() && $('#input<?= $user->getId(); ?>').val()!="" && $('#inputMatch<?= $user->getid(); ?>').val()!="") {
                $('#inputMatch<?= $user->getId(); ?>').css("background", "#ff3f4c");
            } else {
                $('#inputMatch<?= $user->getId(); ?>').css("background", "white");
            }
            if ($('#input<?= $user->getId(); ?>').val().length < 6 && $('#input<?= $user->getId(); ?>').val().length!=0) {
                $('#input<?= $user->getId(); ?>').css("background","#ff3f4c");
            }else{
                $('#input<?= $user->getId(); ?>').css("background","white");
            }
        }

        <?php
        }

        ?>
        $('[data-toggle="tooltip"]').tooltip();
        <?php
        foreach($users->getUsers() as $user) {
        ?>
        setInterval(checkPassword<?= $user->getId(); ?>, 10);
        <?php
        }

        ?>
    });
</script>
</body>
</html>
