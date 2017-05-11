<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Pipa.ml v<?= $version; ?>.r<?= $revision; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">Anyád</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php
                    if(!isset($current_user)){
                        ?>
                        <a href="#" role="button" data-toggle="modal" data-target="#login-modal">Bejelentkezés</a>
                    <?php
                    }else{
                        ?>
                        <a href="logout">Kijelentkezés</a>
                    <?php
                    }
                    ?>

                </li>
            </ul>
        </div>
    </div>
</nav>