<?php
session_start();
require_once("../includes/init.php");
require_once("../includes/Users.php");
require_once("../includes/Pipes.php");
require_once("../includes/Log.php");
require_once("../includes/Locations.php");
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

$log = new Log($current_user->getId(), "admin users", "view");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pipa.ml - Felhasználók</title>
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
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Felhasználók</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr style="font-size:10pt;">
                            <th>Felhasználónév</th>
                            <th>Név</th>
                            <th style="text-align:center;">AuthSCH</th>
                            <th style="text-align:center;">Sima jelszó</th>
                            <th style="text-align:center;">Adminja</th>
                            <th style="text-align:center;">Super-admin</th>
                            <th style="text-align:center;">Vicc</th>
                            <th style="text-align:center;">Műveletek</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < $users->getUserNum(); $i++) {
                            ?>
                            <tr>
                                <td><?= $users->getUsers()[$i]->getUsername(); ?></td>
                                <td><?= $users->getUsers()[$i]->getName(); ?></td>
                                <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getUuid()) { ?><span
                                            class="fa fa-check" style="font-size:9pt;"></span><?php } else { ?><span
                                            class="fa fa-times" style="font-size:9pt;"><?php } ?></td>
                                <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getPassword()) { ?>
                                        <span class="fa fa-check" style="font-size:9pt;"></span><?php } else { ?><span
                                            class="fa fa-times" style="font-size:9pt;"><?php } ?></td>
                                <td style="text-align:center;">
                                    <?php
                                    if ($users->getUsers()[$i]->getAdmin() == false) {
                                        ?>
                                        <i>Nem admin</i>
                                        <?php
                                    } else {
                                        $first = true;
                                        foreach ($locations->getLocations() as $location) {
                                            if ($users->getUsers()[$i]->isAdminOf($location->getId())) {
                                                if ($first == false) {
                                                    echo ", ";
                                                }
                                                echo $location->getName();
                                                $first = false;
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td style="text-align:center;"><?php if ($users->getUsers()[$i]->getSuperAdmin()) { ?>
                                        <span
                                                class="fa fa-check" style="font-size:9pt;"></span><?php } else { ?><span
                                            class="fa fa-times" style="font-size:9pt;"><?php } ?></td>

                                <td style="text-align:center;">
                                    <?php
                                    if($users->getUsers()[$i]->getEasterEgg()){
                                        ?>
                                        <span class="fa fa-check" style="font-size:9pt;"></span><?php } else { ?><span
                                            class="fa fa-times" style="font-size:9pt;"><?php } ?>
                                </td>
                                <td style="text-align:center;">
                                <span data-target="#userPw<?= $users->getUsers()[$i]->getId(); ?>"
                                      title="Jelszó módosítás" data-toggle="modal">
                                    <a role="button" class="btn btn-xs btn-default" data-toggle="tooltip"
                                       data-original-title="Jelszó módisítása" data-placement="top">
                                        <i class="fa fa-star"></i>
                                    </a>
                                </span>
                                    <span data-target="#userAdmin<?= $users->getUsers()[$i]->getId() ?>"
                                          title="Admin jogosultságok módosítása" data-toggle="modal">
                                    <a role="button" class="btn btn-xs btn-default" data-toggle="tooltip"
                                       data-original-title="Admin jogosultságok módosítása" data-placement="top">
                                        <i class="fa fa-user-circle"></i>
                                    </a>
                                </span>
                                    <span data-target="#userEasterEgg<?= $users->getUsers()[$i]->getId() ?>"
                                          title="Easter-egg módosítása" data-toggle="modal">
                                    <a role="button" class="btn btn-xs btn-default" data-toggle="tooltip"
                                       data-original-title="Easter-egg módosítása" data-placement="top">
                                        <i class="fa fa-smile-o"></i>
                                    </a>
                                </span>
                                    <?php
                                    if ($users->getUsers()[$i]->getSuperAdmin()) {
                                        ?>
                                        <form style="display:inline-block;" action="/admin/change_user"
                                              method="POST">
                                            <input type="hidden" name="id"
                                                   value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                                            <input type="hidden" name="type" value="superadmin"/>
                                            <button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip"
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
                                            <input type="hidden" name="id"
                                                   value="<?= $users->getUsers()[$i]->getId(); ?>"/>
                                            <input type="hidden" name="type" value="superadmin"/>
                                            <button type="submit" class="btn btn-xs btn-default" data-toggle="tooltip"
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
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip"
                                                data-placement="top" data-original-title="Felhasználó törlése">
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
</div>
<?php
for ($i = 0; $i < $users->getUserNum(); $i++) {
    ?>
    <div class="modal fade" id="userAdmin<?= $users->getUsers()[$i]->getId(); ?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/change_user" method="POST">
                    <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>" role="dialog">
                    <input type="hidden" name="type" value="admin">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Admin jogosultságok megváltoztatása</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table modal-table">
                            <tr>
                                <th>Helyszín</th>
                                <th>Admin jogosultság</th>
                            </tr>
                            <?php
                            foreach ($locations->getLocations() as $location) {
                                ?>
                                <tr>
                                    <td>
                                        <label for="<?= $users->getUsers()[$i]->getId() . "." . $location->getId(); ?>"><?= $location->getName(); ?></label>
                                    </td>
                                    <td style="width:90%;">
                                        <input name="admin<?= $location->getId(); ?>"
                                               id="<?= $users->getUsers()[$i]->getId() . "." . $location->getId(); ?>"
                                               type="checkbox" <?php if ($users->getUsers()[$i]->isAdminOf($location->getId())) {
                                            echo "checked";
                                        } ?>>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Küldés" role="button">
                        <button role="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userEasterEgg<?= $users->getUsers()[$i]->getId(); ?>" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/change_user" method="POST">
                    <input type="hidden" name="id" value="<?= $users->getUsers()[$i]->getId(); ?>" role="dialog">
                    <input type="hidden" name="type" value="easter_egg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Easter-egg módosítása</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Easter egg</span>
                                <textarea class="form-control" name="easter_egg_text"><?= $users->getUsers()[$i]->getEasterEgg(); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Küldés" role="button">
                        <button role="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
<?php require_once("../includes/footer.php"); ?>
<script>

    $(document).ready(function () {
        <?php
        foreach($users->getUsers() as $user) {
        ?>
        function checkPassword<?= $user->getId(); ?>() {
            if ($('#input<?= $user->getId(); ?>').val() != $('#inputMatch<?= $user->getid(); ?>').val() && $('#input<?= $user->getId(); ?>').val() != "" && $('#inputMatch<?= $user->getid(); ?>').val() != "") {
                $('#inputMatch<?= $user->getId(); ?>').css("background", "#ff3f4c");
            } else {
                $('#inputMatch<?= $user->getId(); ?>').css("background", "white");
            }
            if ($('#input<?= $user->getId(); ?>').val().length < 6 && $('#input<?= $user->getId(); ?>').val().length != 0) {
                $('#input<?= $user->getId(); ?>').css("background", "#ff3f4c");
            } else {
                $('#input<?= $user->getId(); ?>').css("background", "white");
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
