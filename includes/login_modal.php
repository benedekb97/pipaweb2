<div class="modal fade" id="login-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bejelentkezés</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-success" href="login_auth" onClick="window.location = '/login';">AuthSCH-val
                </button>
                <hr size="2px">
                <form action="/login_reg" method="POST">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Felhasználónév</span>
                            <input type="text" name="username" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Jelszó</span>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="submit" class="btn btn-primary" value="Bejelentkezés">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                Nem vagy VIKes? <a href="register">Igényelj felhasználót!</a>
            </div>
        </div>
    </div>
</div>