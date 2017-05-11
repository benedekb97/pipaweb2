<?php
session_start();

include("includes/init.php");

include("includes/Users.php");
include("includes/Locations.php");
include("includes/Pipes.php");
include("includes/Log.php");

//perperlol

$users = new Users();
$locations = new Locations();
$pipes = new Pipes();
$log = new Log(0, "index", "view");


include("includes/current_user.php");

if (isset($current_user)) {
    die("403 - Not authorized!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Felhasználónév igénylése</title>
    <?php include("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php include("includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-6 col-lg-push-3">
            <div class="panel panel-default">
                <form action="register_user" method="POST">
                    <div class="panel-heading">
                        <h4 class="panel-title">Regisztráció nem kollégistáknak</h4>
                    </div>
                    <!--
                    std::cout << "Beni melegeg"; //lol :o
                    Sándor hozzátett ennyit a kódhoz.
                    -->
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Teljes név</span>
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Email cím</span>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Kívánt felhasználónév</span>
                                <input type="text" class="form-control" name="username">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="submit" class="btn btn-default" value="Küldés">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include("includes/login_modal.php"); ?>
<?php include("includes/footer.php"); ?>
</body>
</html>
