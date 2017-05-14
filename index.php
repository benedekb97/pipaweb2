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

    </div>
</div>
<?php include("includes/login_modal.php"); ?>
<?php include("includes/footer.php"); ?>
<?php
if(isset($_GET['login']) && $_GET['login']=="true"){
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
