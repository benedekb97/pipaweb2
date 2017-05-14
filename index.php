<?php
session_start();

include("includes/init.php");

include("includes/Users.php");
include("includes/Locations.php");
include("includes/Pipes.php");
include("includes/Log.php");


$users = new Users();
$locations = new Locations();
$pipes = new Pipes();
$log = new Log(0, "index", "view");

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
        if(isset($current_user) && ($current_user->getAdmin() || $current_user->getSuperAdmin())){
        ?>
        <div class="col-lg-4">
            <form action="/new_pipe" method="POST">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Új pipa hozzáadása</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Dohány: </span>
                                <input class="form-control" name="type" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer" style="text-align:right;">
                        <input type="submit" class="btn btn-primary" value="Küldés">
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
