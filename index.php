<?php
session_start();

require_once("includes/init.php");

require_once("includes/Users.php");
require_once("includes/Locations.php");
require_once("includes/Pipes.php");
require_once("includes/Log.php");
require_once("includes/Settings.php");

$users = new Users();
$locations = new Locations();
$pipes = new Pipes();
$settings = new Settings();

require_once("includes/current_user.php");
if(isset($current_user)){

    $log = new Log($current_user->getId(), "index", "view");
}else{

    $log = new Log(0, "index", "view");
}

if(!isset($_GET['location'])){
    $current_location = $locations->getLocationById(1);
}else{
    $current_location = $locations->getLocationById($_GET['location']);
}

if ($pipes->getCurrentPipe($current_location->getId()) != null) {
    $current_pipe = $pipes->getCurrentPipe($current_location->getId());
}

$statuses = [
        "ok"=>"Jó",
        "dying"=>"Haldoklik",
        "dead"=>"Halott",
        "starting"=>"Készül"
    ];
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Pipa.ml</title>
    <?php require_once("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php require_once("includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align:center;">
                    <a class="panel-title" data-toggle="collapse" href="#locations" style="text-align:center; width:100%; color:white;"><?= $current_location->getName()." - ".$current_location->getDescription(); ?> &#x25BC;</a>
                </div>
                <div class="panel-collapse collapse" id="locations">
                    <ul class="nav">
                        <?php
                        foreach($locations->getLocations() as $location){
                            ?>
                            <li style="text-align:center;">
                                <a href="<?= "/?location=".$location->getId(); ?>"><?= $location->getName(); ?> - <?= $location->getDescription(); ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        if (isset($current_user) && ($current_user->isAdminOf($current_location->getId()) || $current_user->getSuperAdmin())) {
            ?>
            <div class="col-lg-4">
                <form id="change_pipe" action="<?php if(isset($current_pipe)){ echo '/change_pipe'; }else{ echo '/new_pipe'; } ?>" method="POST">
                    <input type="hidden" name="location" value="<?= $current_location->getId(); ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php
                            if (isset($current_pipe)) {
                                ?>
                                <h3 class="panel-title">Pipa módosítása</h3>
                                <?php
                            } else {
                                ?>
                                <h3 class="panel-title">Új pipa hozzáadása</h3>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Dohány: </span>
                                    <input class="form-control" name="type" type="text" <?php if(isset($current_pipe)){ echo "value='".$current_pipe->getType()."'"; } ?> required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Állapot: </span>
                                    <select class="form-control" name="time" required>
                                        <option value="starting" <?php if(isset($current_pipe) && $current_pipe->getStatus()=="starting"){ echo "selected"; } if(!isset($current_pipe)){ echo "selected"; } ?>>Készül</option>
                                        <option value="ok" <?php if(isset($current_pipe) && $current_pipe->getStatus()=="ok"){ echo "selected"; } ?>>Jó</option>
                                        <option value="dying" <?php if(isset($current_pipe) && $current_pipe->getStatus()=="dying"){ echo "selected"; } ?>>Haldoklik</option>
                                        <option value="dead">Halott</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer" style="text-align:right;">
                            <input type="submit" name="submit" class="btn btn-primary" value="Küldés">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Jelenlegi pipa:</h3>
                    </div>
                    <?php
                    if(isset($current_pipe)){
                        ?>
                        <table class="table">
                            <tr>
                                <th>Dohány:</th>
                                <td><?= $current_pipe->getType(); ?></td>
                            </tr>
                            <tr>
                                <th>Állapot:</th>
                                <td><?= $statuses[$current_pipe->getStatus()]; ?></td>
                            </tr>
                        </table>
                    <?php
                    }else{
                        ?>
                        <div class="panel-body">
                            Nincs jelenleg pipa :(
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Jelenlegi állapot</h3>
                    </div>

                    <?php
                    if($current_user->isAdminOf($current_location->getId()) || $current_user->getSuperAdmin()) {
                        ?>
                        <div class="panel-body">
                            <form action="change_tobacco" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Dohány</span>
                                        <input type="hidden" name="location" value="<?= $current_location->getId(); ?>">
                                        <select name="tobacco" class="form-control">
                                            <option value="no" <?php if($current_location->getTobacco()=="no"){ echo "selected"; } ?>>Nincs</option>
                                            <option value="small" <?php if($current_location->getTobacco()=="small"){ echo "selected"; } ?>>Kevés</option>
                                            <option value="yes" <?php if($current_location->getTobacco()=="yes"){ echo "selected"; } ?>>Van</option>
                                        </select>
                                        <input type="text" placeholder="Íz" name="tobacco_type" class="form-control" <?php if($current_location->getTobaccoType()){ echo "value=".$current_location->getTobaccoType(); } ?>>
                                    </div>
                                </div>
                                <input type="submit" style="margin:auto; display:block;" class="btn btn-primary" value="Módosít">
                            </form>
                            <form style="margin-top:20px;" action="change_coal" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Szén</span>
                                        <input type="hidden" name="location" value="<?= $current_location->getId(); ?>">
                                        <select name="coal" class="form-control">
                                            <option value="no" <?php if($current_location->getCoal()=="no"){ echo "selected"; } ?>>Nincs</option>
                                            <option value="small" <?php if($current_location->getCoal()=="small"){ echo "selected"; } ?>>Kevés</option>
                                            <option value="yes" <?php if($current_location->getCoal()=="yes"){ echo "selected"; } ?>>Van</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" style="margin:auto; display:block;" class="btn btn-primary" value="Módosít">
                            </form>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Dohány: </td>
                                    <td>
                                        <?php
                                        switch($current_location->getTobacco()){
                                            case "no":
                                                echo "Nincs";
                                                break;
                                            case "small":
                                                echo "Kevés ".$current_location->getTobaccoType();
                                                break;
                                            case "yes":
                                                echo $current_location->getTobaccoType()." van";
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Szén: </td>
                                    <td>
                                        <?php
                                        switch($current_location->getCoal()){
                                            case "no":
                                                echo "Nincs";
                                                break;
                                            case "small":
                                                echo "Kevés";
                                                break;
                                            case "yes":
                                                echo "Van";
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }else {
            ?>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Jelenlegi pipa:</h3>
                    </div>
                    <?php
                    if (isset($current_pipe)) {
                        ?>
                        <table class="table">
                            <tr>
                                <th>Dohány:</th>
                                <td><?= $current_pipe->getType(); ?></td>
                            </tr>
                            <tr>
                                <th>Állapot:</th>
                                <td><?= $statuses[$current_pipe->getStatus()]; ?></td>
                            </tr>
                        </table>
                        <?php
                    } else {
                        ?>
                        <div class="panel-body">
                            Nincs jelenleg pipa :(
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Jelenlegi állapotok</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <td>Dohány: </td>
                                <td>
                                    <?php
                                    switch($current_location->getTobacco()){
                                        case "no":
                                            echo "Nincs";
                                            break;
                                        case "small":
                                            echo "Kevés ".$current_location->getTobaccoType();
                                            break;
                                        case "yes":
                                            echo $current_location->getTobaccoType()." van";
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Szén: </td>
                                <td>
                                    <?php
                                    switch($current_location->getCoal()){
                                        case "no":
                                            echo "Nincs";
                                            break;
                                        case "small":
                                            echo "Kevés";
                                            break;
                                        case "yes":
                                            echo "Van";
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php require_once("includes/login_modal.php"); ?>
<?php require_once("includes/footer.php"); ?>
<?php
if(isset($current_user) && $current_user->getEasterEgg() && isset($_GET['welcome'])){
    ?>
    <div class="modal fade" id="welcome" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <?= $current_user->getEasterEgg(); ?>
                </div>
                <div class="modal-footer">

                    <span id="welcome-timer">3</span>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#welcome').modal("show");
        setTimeout(function(){
            $('#welcome-timer').text("2");
        },1000);

        setTimeout(function(){
            $('#welcome-timer').text("1");
        },2000);
        setTimeout(function(){
            $('#welcome').modal("hide");
        },3000);
    </script>
    <?php
}
if (isset($_GET['login']) && $_GET['login'] == "true") {
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#change_pipe').validator();
        });
        <?php
        if(isset($_GET['password']) && $_GET['password'] == "true"){
        ?>
        $('#login-modal').modal("show");
        $('#login-username').val("<?= $_GET['username']; ?>");
        $('#login-password').focus();
        <?php
        }elseif(isset($_GET['username']) && $_GET['username'] == "true"){
        ?>
        $('#login-modal').modal("show");
        $('#login-username').focus();
        <?php
        }else{
        ?>
        $('#login-modal').modal("show");
        $('#login-username').focus();
        <?php
        }
        ?>
    </script>
    <?php
}
?>
</body>
</html>
