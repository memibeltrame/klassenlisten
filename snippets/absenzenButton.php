<?php if ($dozentenPasswort == true) {?>
                              <button type="button" data-html="true" data-placement="bottom" class="mypopover btn btn-default" data-toggle="popover" title="Dozenten Anmeldung" data-content='
                    <form action="absenzen.php" method="post" id="loginform">
                    <div class="alert alert-danger hide" id="loginError">
                        <ul class="fa-ul">
                          <li style="width:96%">
                            <i class="fa fa-info-circle fa-lg fa-li"></i>
                            <span id="errorMessage">Error</span>
                          </li>
                        </ul>
                      </div>
                        <input name="email" class="form-control" type="text" placeholder="Email"><br>
                        <input type="password" class="form-control" name="passwort" placeholder="Passwort">
                        <input type="hidden" class="form-control" name="dozentenLogin">
                        <br>
                        <button id="dozentenLogin" type="button" class="btn-block btn btn-primary">Anmelden</button>
                    </form>'>Absenzen erfassen</button>
                          <?php } else { ?>
                            <a href="absenzen.php" class="btn  btn-default">Absenzen erfassen</a>
                          <?php } ?>

