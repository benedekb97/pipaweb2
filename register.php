<?php
session_start();

require_once("includes/init.php");

require_once("includes/Users.php");
require_once("includes/Locations.php");
require_once("includes/Pipes.php");
require_once("includes/Log.php");

//perperlol

$users = new Users();
$locations = new Locations();
$pipes = new Pipes();
$log = new Log(0, "index", "view");


require_once("includes/current_user.php");

if (isset($current_user)) {
    die("403 - Not authorized!");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Felhasználónév igénylése</title>
    <?php require_once("includes/head.php"); ?>
</head>
<body>
<div class="container">
    <?php require_once("includes/nav.php"); ?>
    <div class="row">
        <div class="col-lg-6 col-lg-push-3">
            <div class="panel panel-default">
                <form role="form" data-toggle="validator" id="reg-form" action="register_user" method="POST">
                    <div class="panel-heading">
                        <h4 class="panel-title">Regisztráció nem VIKeseknek</h4>
                    </div>
                    <!--
                    std::cout << "Beni melegeg"; //lol :o
                    Sándor hozzátett ennyit a kódhoz.
                    -->
                    <div class="panel-body">
                        <?php
                        if (isset($_COOKIE['regged']) && $_COOKIE['regged'] == "true") {
                            ?>
                            <h3 class="panel-title">Már regisztráltál!</h3>
                            <?php
                        } else {
                            ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Teljes név</span>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Email cím</span>
                                    <input type="email" class="form-control" name="email"
                                           data-error="Ez nem egy email cím, te!">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Kívánt felhasználónév</span>
                                    <input type="text" class="form-control" name="username">
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="panel-footer">
                        <?php
                        if (!isset($_COOKIE['regged']) || $_COOKIE['regged'] != "true") {
                            ?>
                            <input type="submit" class="btn btn-default" value="Küldés">
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once("includes/login_modal.php"); ?>
<?php require_once("includes/footer.php"); ?>
</body>
</html>
