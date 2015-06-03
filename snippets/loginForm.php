            <?php if(empty($loginaction)){
                    $loginaction = "";
                } ?>

            <div class="row">
                <span class="col-xs-12 col-md-12">
                    <h3>Anmelden</h3>
                </span>
            </div>
            <div class="row">
                <span class="col-xs-12 col-md-3">
                    <form action='<?php echo $loginaction ;?>' method='post' id="loginform">
                        <div class="form-group"><input id="login" name='login' class='form-control' type='text' placeholder='Benutzername'></div>
                        <div class="input-group">
                              <input type="password" class="form-control" name="" placeholder="Passwort">
                              <span class="input-group-addon passwordToggle"><i class="fa fa-square-o"></i> Zeigen</span>
                        </div>
                        <br>
                        <button type='submit' class='btn-block btn btn-primary'>Anmelden</button>
                    </form>
                </span>
            </div>