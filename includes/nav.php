<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Pipa.ml</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">Anyád</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (!isset($current_user)) {
                    ?>
                    <li>
                        <a href="#" role="button" data-toggle="modal" data-target="#login-modal">Bejelentkezés</a>
                    </li>
                    <?php
                } else {
                    if($current_user->getSuperAdmin()){
                        ?>
                        <li>
                            <a href="/admin">Admin</a>
                        </li>
                        <?php
                    }
                    ?>

                    <li>
                        <a href="/profile">Profilom</a>
                    </li>
                    <li>
                        <a href="/logout">Kijelentkezés</a>
                    </li>
                    <?php
                }
                ?>

            </ul>
        </div>
    </div>
</nav>