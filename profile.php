<?php
session_start();

require_once("includes/init.php");

require_once("includes/Users.php");
require_once("includes/Locations.php");
require_once("includes/Pipes.php");
require_once("includes/Log.php");


$users = new Users();
$locations = new Locations();
$pipes = new Pipes();

require_once("includes/current_user.php");

if (isset($current_user)) {
    $log = new Log($current_user->getId(), "profile", "view");
} else {
    $log = new Log(0, "profile", "view_attempt");
    header("Location: /?login=true");
    die("403: Not authorised");
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Profilom</title>
    <?php require_once("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php require_once("includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Profilkép</h3>
                </div>
                <div class="panel-body">
                    < insert profile pic later >
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Adataim</h3>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Név</th>
                        <th>Felhasználónév</th>
                        <th style="text-align:center;">AuthSCH</th>
                        <th style="text-align:center;">Sima jelszó</th>
                    </tr>
                    <tr>
                        <td><?= $current_user->getName(); ?></td>
                        <td><?= $current_user->getUsername(); ?></td>
                        <td style="text-align:center;"><?php if ($current_user->getUuid()) { ?><span
                                    class="fa fa-check"></span><?php } else { ?><span
                                    class="fa fa-times"></span><?php } ?></td>
                        <td style="text-align:center;"><?php if ($current_user->getPassword()) { ?><span
                                    class="fa fa-check"></span><?php } else { ?><span
                                    class="fa fa-times"></span><?php } ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Műveletek</h3>
                </div>
                <ul class="nav">
                    <li>
                        <a role="button" data-toggle="modal" data-target="#chg-pw" href="#">Jelszó
                            módosítás/hozzáadás</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="chg-pw" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/change_password" method="POST" id="password_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Bejelentkezés</h4>
                </div>
                <div class="modal-body">
                    <?php
                    if ($current_user->getPassword()) {
                        ?>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Régi jelszó:</span>
                                <input type="password" name="old_password" class="form-control" required/>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Új jelszó:</span>
                            <input type="password" name="password1" id="password" class="form-control" data-minlength="6" data-error="Minimum 6 karakter te!" required/>
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Jelszó megint:</span>
                            <input type="password" name="password2" id="password" class="form-control" data-match="#password" data-match-error="Nem egyezik vaze!" required/>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Mégse</button>
                    <input class="btn btn-primary" type="submit" value="Mentés" name="submit">
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once("includes/footer.php"); ?>
<script type="text/javascript">
    $('#password_form').validator();
</script>
</body>
</html>
