<?php
session_start();

include("includes/init.php");

include("includes/Users.php");
include("includes/Locations.php");
include("includes/Pipes.php");
include("includes/Log.php");
require_once("includes/Settings.php");

$users = new Users();
$locations = new Locations();
$pipes = new Pipes();
$log = new Log(0, "index", "view");
$settings = new Settings();

if ($pipes->getCurrentPipe() != null) {
    $current_pipe = $pipes->getCurrentPipe();
}


include("includes/current_user.php");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Pipa.ml</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php include("includes/nav.php"); ?>
    <div class="row">
        <?php
        if (isset($current_user) && ($current_user->getAdmin() || $current_user->getSuperAdmin())) {
            ?>
            <div class="col-lg-4">
                <form id="change_pipe" action="<?php if(isset($current_pipe)){ echo '/change_pipe'; }else{ echo '/new_pipe'; } ?>" method="POST">
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
            <?php
        }
        ?>
    </div>
</div>
<?php include("includes/login_modal.php"); ?>
<?php include("includes/footer.php"); ?>
<?php
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
