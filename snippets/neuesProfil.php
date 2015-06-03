<?php
if(!empty($_POST)){
    $stmt = $db->prepare('
    INSERT INTO people (vorname, name, email, beruf, arbeitgeber, mobile, adresse, plz, ort, liste) VALUES (\''. $_POST['vorname'].'\', \''. $_POST['name'].'\', \''. $_POST['email'].'\', \''. $_POST['beruf'].'\', \''. $_POST['arbeitgeber'].'\', \''. $_POST['mobile'].'\', \''. $_POST['adresse'].'\', \''. $_POST['plz'].'\', \''. $_POST['ort'].'\', \''. $klasse .'\');
 ');

    $result = $stmt->execute();


    $rowid = $db->lastInsertRowid();

    $dontlog = true;
    include("./snippets/manageImageUpload.php");


}

$stmt = $db->prepare('
         Select * from klassen where id = \''. $klasse .'\' ;
 ');

    $klassenresult = $stmt->execute();
    $klasse = $klassenresult->fetchArray();

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

    <body class="">
        <div class="container">

            <?php
            // this includes the header
            include('./snippets/header.php');?>

            <h1><?php echo $klasse['kuerzel'] ;?>: Neuer Eintrag </h1>
            <br>
            <form action="<?php echo $klasse['id'] ;?>.php" method="POST"  enctype="multipart/form-data">


            <?php
            $vorname = "";
            $name = "";
            $email = "";
            $beruf = "";
            $arbeitgeber = "";
            $mobile = "";
            $adresse = "";
            $plz = "";
            $ort = "";
            $zusatzinfo = "";
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
<?php $db->close();