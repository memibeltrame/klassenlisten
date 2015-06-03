<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/
include('core/protostrap.php');

/** Define VALUES  valid for this file **/
$activeNavigation = $aktiveListe;







$profilId = 0;
if(!empty($_REQUEST['id'])){
    $profilId = $_REQUEST['id'];
    $_SESSION['profilId'] = $profilId;
} else {
    $profilId = $_SESSION['profilId'];
}


// Check for Uploads
if(!empty($_POST['bildupload'])){
    $rowid = $profilId;
    include("./snippets/manageImageUpload.php");
}

if(!empty($_POST['profildaten'])){

    $fach = "";
    if(!empty($_POST['fach'])){
        $fach = $_POST['fach'];
    }

    if($is_admin){
        $sql = '
            update people set vorname = \''. $_POST['vorname'] .'\', name = \''. $_POST['name'] .'\', fach = \''. $fach .'\', arbeitgeber = \''. $_POST['arbeitgeber'] .'\', email = \''. $_POST['email'] .'\', mobile = \''. $_POST['mobile'] .'\', beruf = \''. $_POST['beruf'] .'\', adresse = \''. $_POST['adresse'] .'\', plz = \''. $_POST['plz'] .'\', ort = \''. $_POST['ort'] .'\' , zusatzinfo = \''. $_POST['zusatzinfo'] .'\' where id = \''. $_POST['id'] .'\'
         ';
    } else {
        $sql = '
        update people set fach = \''. $fach .'\', arbeitgeber = \''. $_POST['arbeitgeber'] .'\', email = \''. $_POST['email'] .'\', mobile = \''. $_POST['mobile'] .'\', beruf = \''. $_POST['beruf'] .'\', adresse = \''. $_POST['adresse'] .'\', plz = \''. $_POST['plz'] .'\', ort = \''. $_POST['ort'] .'\' where id = \''. $_POST['id'] .'\'
     ';
    }


    $stmt = $db->prepare($sql);

    //var_dump($sql);

    try {
        $result = $stmt->execute();
        $feedback = "true";
    } catch (Exception $e) {
        echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
        die();
    }


    // Log Schreiben

    $logpost = $_POST;
    unset($logpost['speicher']);
    unset($logpost['id']);
    unset($logpost['profildaten']);

    $stmt = $db->prepare("
        insert into logs ('user', 'username', 'post') values('".$user['id'] ."', '". $user['name'] ."', '". serialize($logpost) ."');
     ");

    $result = $stmt->execute();

}

if($is_admin && !empty($_GET['delete']) && md5($_GET['delete']) == $_GET['salt']){
    $sql = '
            update people set aktiv = 0 where id = \''. $_GET['delete'] .'\'
         ';
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();
    header("location: index.php");

}


    $stmt = $db->prepare('
        Select * from people where id = '. $profilId .';
 ');

    $results = $stmt->execute();
    $row = $results->fetchArray();

    $stmt = $db->prepare('
        Select * from klassen where id = \''. $aktiveListe .'\';
    ');

    $results = $stmt->execute();
    $klasse = $results->fetchArray();


    forceLogin();

?><!DOCTYPE html>
<html lang="de">
    <head>
        <title><?php echo $row['vorname'] . " " . $row['name'] . " - " . $klasse['kuerzel'] . " - " . $brand ;?></title>
        <?php
        // this includes all the markup that loads css files and similar stuff,
        // if you have to add more css, that's the place to do it.
        // DO NOT REMOVE
        include('./snippets/meta_headTag.php');?>

    </head>
<?php


?>

    <body class="">
        <div class="container">

            <?php
            // this includes the header
            include('./snippets/header.php');?>

            <div class="row">
                <span class="col-md-3 col-md-offset-3 col-xs-12">
                <br>
                <a href="index.php?aktiveListe=<?php echo $aktiveListe ;?>"><?php echo $klasse['kuerzel'] ;?></a>
                </span>
            </div>
             <div class="row">
                 <span class="col-xs-12 visible-xs">
                    <h1 ><?php echo $row['vorname'] . " " . $row['name'];?> </h1>
                 </span>
             </div>

            <div class="row">
                <span class="col-md-3 col-xs-12">
                    <div class="hidden-xs">
                        <br>
                    </div>
                    <?php
                        $bildname = "profilDummy";
                        if(strlen($row['bild']) > 0){
                            $bildname = $row['bild'];
                        } ?>
                    <img width="100%"src="assets/profilbilder/<?php echo $bildname ;?>.png ">
                    <br><br>
                    <a class=" " data-toggle="collapse" data-target="#collapse<?php echo getUniqueId();?>"><i class="fa fa-edit"></i> Bild ändern</a>
                    <div id="collapse<?php echo $lastUniqueId;?>" class="collapse">
                        <br>
                        <form name="fileupload" action="profil.php" method="POST"  enctype="multipart/form-data">
                            <input type="hidden"  name="bildupload" value="1">
                            <input type="hidden"  name="id" value="<?php echo $row['id'];?>">
                            <input name="bild" type="file" capture="camera" accept="image/*" title="Bild-Datei auswählen">
                            <br><br>
                            <input type="submit" name="speichern" class="btn btn-primary btn-block" value="Heraufladen">
                        </form>
                    </div>
                    <br><br>

                </span>
                <span class="col-md-9 col-xs-12 profil">
                    <div class="pull-right hidden-xs">
                        <?php if($is_admin){ ?>
                            <br>

                            <div class="btn-group">
                              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                Profil löschen <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="?delete=<?php echo $row['id'];?>&salt=<?php echo md5($row['id']);?>" class=""> <b>Ja</b>, Profil wirklich löschen</a></li>
                              </ul>
                            </div>
                    <?php } ?>
                    </div>
                    <h1 class="hidden-xs"><?php echo $row['vorname'] . " " . $row['name'];?> </h1>
                    <?php if(!empty($feedback)) { ?>
                        <div class="alert alert-success withfadeout"><i class="fa fa-check-circle"></i> Daten Aktualisiert</div>
                        <?php }?>
                        <form id="profildaten" action="profil.php" method="POST" >
                        <input type="hidden" value="1" name="profildaten" >
                        <input type="hidden" value="<?php echo $row['id'] ;?>" name="id" >
                            <?php
                            $name = $row['name'];
                            $vorname = $row['vorname'];
                            $mobile = $row['mobile'];
                            $email = $row['email'];
                            $beruf = $row['beruf'];
                            $adresse = $row['adresse'];
                            $plz = $row['plz'];
                            $ort = $row['ort'];
                            $arbeitgeber = $row['arbeitgeber'];
                            $fach = $row['fach'];
                            $zusatzinfo = $row['zusatzinfo'];
                            if($row['liste'] == "dozenten"){
                                $fachZeigen = true;
                            }
                            include("./snippets/profilForm.php");?>
                            <div class="row">
                                <span class="col-md-2 col-xs-12 combo-label">
                                    <a href="javascript:void(0);" class="toggleForm formElement hide">Abbrechen</a>
                                    <a href="javascript:void(0);" class="toggleForm formElement ">Bearbeiten</a>
                                </span>
                                <span class="col-md-4 col-xs-12 formElement hide">
                                    <a data-name="profildaten" class="btn btn-primary showSpinner" type="submit" class="form-control" name="speicher" >Änderungen speichern</a>
                                </span>
                            </div>
                        </form>


                </span>
            </div>


            <br>


            </div>
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

