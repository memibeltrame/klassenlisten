<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/
include('core/protostrap.php');

/** Define VALUES  valid for this file **/
$activeNavigation = "one";

if(!empty($_POST)){



    $db = new SQLite3('assets/db/default');
    $stmt = $db->prepare('
    INSERT INTO people (vorname, name, email, beruf, arbeitgeber, liste) VALUES (\''. $_POST['vorname'].'\', \''. $_POST['name'].'\', \''. $_POST['email'].'\', \''. $_POST['beruf'].'\', \''. $_POST['arbeitgeber'].'\', \''. $_POST['liste'].'\');
 ');

    $result = $stmt->execute();


    $rowid = $db->lastInsertRowid();
    include("./snippets/manageImageUpload.php");


}


?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $application . " - " . $brand ;?></title>
        <?php
        // this includes all the markup that loads css files and similar stuff,
        // if you have to add more css, that's the place to do it.
        // DO NOT REMOVE
        include('./snippets/meta_headTag.php');?>

    </head>
<?php

// uncomment the following function to force user to be logged in
// forceLogin(); ?>

    <body class="header-fixed">
        <div class="container">

            <?php
            // this includes the header
            include('./snippets/header.php');?>

            <h1>Neuer Eintrag </h1>
            <br>
            <form action="neu.php" method="POST"  enctype="multipart/form-data">
            <div class="row">
                <span class="col-md-2 combo-label">
                    Gruppe
                </span>
                <span class="col-md-6">
                    <div class="form-group">
                        <div class=" col-sm-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="liste" value="iad4"  checked="checked"> IAD 4
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="liste" value="iad3"> IAD 3
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="liste" value="iad2"> IAD 2
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="liste" value="dozenten"> Dozenten
                                </label>
                            </div>
                        </div>
                    </div>
                </span>
            </div>


            <div class="row form-group">
                <span class="col-md-2 combo-label">
                Vorname

                </span>
                <span class="col-md-4">
                    <input type="text" class="form-control" name="vorname" placeholder="">
                </span>
            </div>

            <div class="row form-group">
                <span class="col-md-2 combo-label">
                Name

                </span>
                <span class="col-md-4">
                    <input type="text" class="form-control" name="name" placeholder="">
                </span>
            </div>

            <?php
            $email = "";
            $beruf = "";
            $arbeitgeber = "";
            $mobile = "";
            $adresse = "";
            $plz = "";
            $ort = "";
            include("./snippets/profilForm.php");?>
            <div class="micropadding"></div>

            <div class="row form-group">
                <span class="col-md-2 combo-label">
                    Bild
                </span>
                <span class="col-md-6">
                    <input name="bild" type="file" title="Bild-Datei auswählen">
                </span>
            </div>
            <div class="micropadding"></div>
            <div class="row form-group">
                <span class="col-md-2">

                </span>
                <span class="col-md-4">
                    <input type="submit" name="speichern" class="btn btn-primary" value="Speichern">
                </span>
            </div>
            </form>
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
