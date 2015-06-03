<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/
include('core/protostrap.php');


/** Define VALUES  valid for this file **/
$activeNavigation = $aktiveListe;
$klasseZeigen = false;
$feedback = "";

if(!empty($_POST['neueKlasse'])){

    $kuerzel = $_POST['kuerzel'];
    $id = preg_replace('/\s+/', '', strtolower($kuerzel));

    $typ = "";
    if(strpos($id, "iad")){
        $typ = "IAD";
    }
    if(strpos($id, "tsm")){
        $typ = "TSM";
    }

    $sql = '
        INSERT INTO klassen (id, kuerzel, typ, von, aktiv) VALUES (\''. $id.'\',\''. $kuerzel.'\',\''. $typ.'\',' . date("Y") .', 0);
    ';
    $stmt = $db->prepare($sql);

    $result = $stmt->execute();
    $feedback = "create";
}


if(!empty($_POST['updateKlasse'])){
    $sql = '
        update klassen set bezeichnung = \''. $_POST['bezeichnung'] .'\', von = \''. $_POST['von'] .'\', bis = \''. $_POST['bis'] .'\', facebook = \''. $_POST['facebook'] .'\', dropbox = \''. $_POST['dropbox'] .'\' where id = \''. $_POST['id'] .'\'
     ';
    $stmt = $db->prepare($sql);

    $result = $stmt->execute();
    $feedback = "update";
}



$stmt = $db->prepare('
         Select * from klassen where (aktiv =  \'1\' or von =  \'' . date("Y") . '\') and id != \'dozenten\' order by kuerzel ASC;
 ');

    $klassenResult = $stmt->execute();

if(!empty($_POST)){
    var_dump($_POST);
}






?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin <?php echo " - " . $brand ;?></title>
        <?php
        // this includes all the markup that loads css files and similar stuff,
        // if you have to add more css, that's the place to do it.
        // DO NOT REMOVE
        include('./snippets/meta_headTag.php');?>

    </head>
<?php

// uncomment the following function to force user to be logged in



forceLogin();

?>

    <body class="">
        <div class="container">

            <?php
            // this includes the header
            include('./snippets/header.php');?>


            <div class="row">
                <span class="col-md-6">
                    <h1>Admin</h1>
                    <br><br>
                    <a href="absenzenliste.php">Absenzenliste</a><br><br>
                </span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Dozenten</h3>
                    <a href="dozenten.php">Dozenten hinzufügen</a>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row">
                <span class="col-md-4">
                <br>
                <h3>Klassen</h3>
                <br>
                <a type="button" data-html="true" data-placement="bottom" class="mypopover" data-toggle="popover" title="Erfassung einer Klasse" data-content='
                    <form action="admin.php" method="post" id="neueKlasse">
                        Kürzel
                        <input name="kuerzel" class="form-control" type="text" placeholder="zb IAD 12"><br>
                        <input type="hidden" class="form-control" name="neueKlasse" value="true">
                        <button id="dozentenLogin" type="submit" class="btn-block btn btn-primary">Anlegen</button>
                    </form>'>Neue Klasse erfassen</a><br><br>
                <?php
                $i = 0;
                while ($row = $klassenResult->fetchArray()) {

                    $klassen[$row['id']] = $row; ?>
                                <?php echo $row['kuerzel'] ;?><br>
                                <a href="admin.php?aktiveKlasse=<?php echo $row['id'] ;?>">bearbeiten</a> &nbsp;|&nbsp;<a href="<?php echo $row['id'] ;?>.php"> Schüler hinzufügen</a><br>
                                <hr>





                    <div class="micropadding"></div>



                 <?php } ?>
                </span>
                <span class="col-md-8">
                    <?php switch($feedback) {
                        case 'create': ?>
                            <br>
                            <div class="alert alert-success withfadeout"><i class="fa fa-check-circle"></i> Neue Klasse erfasst</div>
                            <?php   break;
                        case 'udate': ?>
                            <br>
                            <div class="alert alert-success withfadeout"><i class="fa fa-check-circle"></i> Daten für <?php echo $klassen[$_POST['id']]['kuerzel'] ;?> Aktualisiert</div>
                            <?php   break;
                        default:
                            break;
                }


                    if (!empty($_GET['aktiveKlasse'])){
                        $klasseZeigen = true;
                        $klasse = $klassen[$_GET['aktiveKlasse']];
                    }



                    if (!empty($_POST['neueKlasse'])){
                        $klasseZeigen = true;
                        $klasse = $klassen[$id];
                    }
                    if ($klasseZeigen == true ):
                    ?>
                        <div class="row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3">
                                <h3><?php echo $klasse['kuerzel'] ;?></h3>
                            </div>
                        </div>
                        <form action="admin.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $klasse['id'] ;?>">
                        <input type="hidden" name="updateKlasse" value="1">
                        <div class="form-group row">
                            <label for="bezeichnung" class="col-md-3 text-right control-label">Bezeichnung</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $klasse['bezeichnung'];?>" name="bezeichnung" placeholder="Bezeichnung">
                            </div>
                            <div class="col-md-3 text-right">&nbsp;</div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 text-right control-label">von</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $klasse['von'];?>" name="von" placeholder="Jahr">
                            </div>
                            <div class="col-md-3 text-right">&nbsp;</div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 text-right control-label">bis</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $klasse['bis'];?>" name="bis" placeholder="Jahr">
                            </div>
                            <div class="col-md-3 text-right">&nbsp;</div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 text-right control-label">Facebook Link</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $klasse['facebook'];?>" name="facebook" placeholder="URL">
                            </div>
                            <div class="col-md-3 text-right">&nbsp;</div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 text-right control-label">Dropbox Link</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $klasse['dropbox'];?>" name="dropbox" placeholder="URL">
                            </div>
                            <div class="col-md-3 text-right">&nbsp;</div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-3 text-right control-label"></label>
                            <div class="col-md-4">
                                <input type="submit" class="form-control btn btn-primary" value="Speichern" name="send">
                            </div>
                            <div class="col-md-3 text-right">&nbsp;</div>
                        </div>

                        </form>
                    <?php endif ?>
                </span>
            </div>
                 <br><br><br>

            <?php // this includes the footer
            include('./snippets/footer.php');?>

        </div> <!-- /container -->

        <?php
        // JAVASCRIPT
        // This includes the needed javascript files
        // DO NOT REMOVE
        include ('./snippets/meta_javascripts.php');?>
  </body>
</html>
<?php $db->close(); ?>
