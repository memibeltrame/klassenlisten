<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/

include('core/protostrap.php');

/** Define VALUES  valid for this file **/
$activeNavigation = $aktiveListe;


// Daten holen: Personen aus aktiver Liste
$stmt = $db->prepare('
         Select * from people where liste = \''. $aktiveListe .'\' and aktiv = 1 order by name  COLLATE NOCASE;
 ');

    $people = $stmt->execute();

    $stmt = $db->prepare('
        Select * from klassen where id = \''. $aktiveListe .'\';
    ');

    $results = $stmt->execute();
    $klasse = $results->fetchArray();

    getRawText($people);
    getXls($aktiveListe, $people);
    getEtiketten($people);

    $dozentenPasswort = true;
    if(!empty($_SESSION['user']['is_dozent']) && $_SESSION['user']['is_dozent'] == true){
        $dozentenPasswort = false;
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $klasse['kuerzel'] . " - " . $brand ;?></title>
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
                <?php if(!empty($_GET['showLoginMessage'])){?>
                    <div class="row">
                        <div class=" col-md-6 col-xs-12">
                             <?php box("Du musst als Dozent eingeloggt sein um Absenzen eintragen oder anschauen zu können", "info", "inherit" , "boxid" , "dismiss" );?>
                        </div>
                    </div>
                <?php } ?>
            <div class="row">
                <span class="col-md-4 col-sm-4 col-xs-4">
                    <h1><?php echo $klasse['kuerzel'] ;?></h1>
                </span>

                <div class=" col-xs-8 visible-xs text-right text-bottom align-bottom">
                        <div class="btn-group servicelinks">
                          <button type="button" class="toggleListenView btn btn-default" disabled><i class=" fa fa-th"></i></button>
                          <button type="button" class="toggleListenView btn btn-default" ><i class=" fa fa-bars"></i></button>
                          <?php include("./snippets/absenzenButton.php");?>

                        </div><br><br>
                    </div>
                <span class="col-md-8 col-sm-8 text-right hidden-xs">
                    <div class="servicelinks">
                       <?php if($klasse['kuerzel'] != "Dozenten"){ ?>
                        <a href="<?php echo $klasse['facebook'] ;?>"><i class="fa fa-facebook-square"></i> Facebook</a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="<?php echo $klasse['dropbox'] ;?>"><i class="fa fa-dropbox"></i> Dropbox</a>
                        &nbsp;&nbsp;&nbsp;
                        <?php } ?>
                        <a id="toggleAdressliste" href="javascript:void(0)" class=""><i class="fa fa-building-o"></i> Adressliste</a>
                        &nbsp;&nbsp;&nbsp;

                        <span class="dropdown ">
                          <a class=" dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                            <i class="fa fa-download"></i> Export
                            <span class="caret"></span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                            <li role="presentation"><a href="?xls=true">Adressliste Excel Export</a></li>
                            <li role="presentation"><a href="?etiketten=true">Adress-Etiketten PDF</a></li>
                          </ul>
                        </span>

                    </div>
                </span>
            </div>
            <div class="row">
                <span class="col-md-6 col-xs-12">
                   <?php if($klasse['kuerzel'] != "Dozenten"){ ?>
                   <h1 class="subtitle"><small><?php echo $klasse['bezeichnung']. ", " . $klasse['von']."-".$klasse['bis'] ;?></small></h1>
                    <?php } ?>
                </span>
                <span class="col-sm-12 col-md-6  text-right  hidden-xs">

                          <?php include("./snippets/absenzenButton.php");?>

                </span>
            </div>


            <div class="pile">
                <div class="row visible-xs">

                    <div class=" col-xs-12">

                    <?php
                    $i = 0;

                    while ($row = $people->fetchArray()) {
                        $bildname = "profilDummy";
                        if(strlen($row['bild']) > 0 && file_exists("assets/profilbilder/".$row['bild']."_thumb.png")){
                            $bildname = $row['bild'];
                        }
                        ?>

                        <a class="pull-left pileimg" data-id="<?php echo $row['id'] ;?>" data-name="<?php echo $row['vorname']. " " .$row['name'] ;?>" href="javascript:void(0);">
                                    <img width="60"class="media-object " src="assets/profilbilder/<?php echo $bildname ;?>_thumb.png " alt="<?php echo $row['vorname']. " " .$row['name'] ;?>">
                                  </a>
                    <?php } ?>
                            <hr>
                    </div>
                </div>
                <div  class="row visible-xs">
                    <div id="" class="text-center col-xs-12">

                                <h3><a id="userinfo" href=""></a></h3>
                                <br><br><br>
                    </div>
                </div>
            </div>

            <div class="row hidden-xs pile">
                <br>
                <?php while ($row = $people->fetchArray()) {
                    $bildname = "profilDummy";
                    if(strlen($row['bild']) > 0 && file_exists("assets/profilbilder/".$row['bild']."_thumb.png")){
                        $bildname = $row['bild'];
                    }

                    ?>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 listenEintrag">
                            <div class="media">
                              <a class="pull-left" href="profil.php?id=<?php echo $row['id'] ;?>">
                                <img width="64"class="media-object" src="assets/profilbilder/<?php echo $bildname ;?>_thumb.png " alt="<?php echo $row['vorname']. " " .$row['name'] ;?>">
                              </a>
                              <div class="media-body">
                                  <h4 class="media-heading"><a href="profil.php?id=<?php echo $row['id'] ;?>"><?php echo $row['vorname']. " " .$row['name'] ;?></a></h4>
                                    <?php if(strlen($row['fach'])>0){ ?>
                                        <span class="inliner">Fach: <?php echo $row['fach'] ;?></span>
                                    <?php } ?>
                                    <span class="inliner"><?php echo $row['beruf'] ;?></span>
                                    <span class="inliner"><?php echo $row['arbeitgeber'] ;?></span>
                                    <?php if(strlen($row['zusatzinfo'])>0){ ?>
                                        <small class="inliner"> <?php echo $row['zusatzinfo'] ;?></small>
                                    <?php } ?>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-3  col-sm-4 col-xs-12 listenEintrag hide">
                            <?php echo $row['vorname']. " " .$row['name'] ;?><br>
                            <?php echo $row['adresse'] ;?><br>
                            <?php echo $row['plz'] . " " . $row['ort'] ;?>
                            <br>
                            <br>
                        </div>
                    <?php } ?>
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
<?php $db->close(); ?>
