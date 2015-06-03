<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/

include('core/protostrap.php');

/* Handle login */
if(empty($_SESSION['user']['is_dozent']) OR $_SESSION['user']['is_dozent'] != true){
        header('Location: index.php?showLoginMessage=true');

}





/** Define VALUES  valid for this file **/
$activeNavigation = $aktiveListe;


$stmt = $db->prepare('
         Select * from people where liste = \''. $aktiveListe .'\' and aktiv = 1 order by name  COLLATE NOCASE;
 ');

    $people = $stmt->execute();

    $stmt = $db->prepare('
        Select * from klassen where id = \''. $aktiveListe .'\';
    ');

    $results = $stmt->execute();
    $klasse = $results->fetchArray();
    $typ = $klasse['typ'];
    $absenzenEingetragen = false;

if(!empty($_POST['abwesend'])){

    foreach ($_POST['abwesend'] as $key => $value) {
        if(strlen($value)<1){
            continue;
        }
        $grund = ": " . $_POST['grund'.$key];
        if($value == "Abwesend"){
            $grund = "";
        }
        switch($_POST['dauer'][$key]){
            case 0:
                $dauer = "Keine Angabe";
                break;
            case 1:
                $dauer = "Morgen";
                break;
            case 2:
                $dauer = "Nachmittag";
                break;
            case 4:
                $dauer = "Abend";
                break;
            default:
                $dauer = "Ganzer Tag";
                break;
        }
        $datum = substr($_POST['datum'],6,4) . "-" . substr($_POST['datum'],3,2) . "-" . substr($_POST['datum'],0,2);
        $absenzen[]= array("id" => $key, "datum"=>$datum,  "name"=>$_POST['name'][$key], "typ"=> $value .$grund, "dauer" => $dauer, "fach" => $_POST['fach'], "lehrperson" => $_POST['lehrperson'], "erfasser" => $_POST['erfasser'], "klasse" => $_POST['klasse']);

    }

    foreach ($absenzen as $absenz) {
        $stmt = $db->prepare('

         INSERT INTO absenzen (FK_people, name, datum, dauer, fach, typ, lehrperson, erfasser, klasse) VALUES (\''. $absenz['id'].'\',\''. $absenz['name'].'\',\''. $absenz['datum'].'\',\''. $absenz['dauer'].'\',\''. $absenz['fach'].'\',\''. $absenz['typ'].'\',\''. $absenz['lehrperson'].'\',\''. $absenz['erfasser'].'\',\''. $absenz['klasse'].'\');
    ');
        $done = $stmt->execute();
    }
    $absenzenEingetragen = true;
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


            <div class="row">
                <span class="col-md-12 col-sm-12 col-xs-12">
                    <?php if($absenzenEingetragen){
                         box("Absenzen wurden erfasst", "info", "inherit" , "boxid" , "dismiss" );
                        } ?>
                    <h1><?php echo $klasse['kuerzel'] ;?> <br class="visible-xs">Absenzen erfassen</h1>
                </span>


            </div>
            <br>
            <form action="absenzen.php" method="Post">
            <div class="row">
                <div class="col-md-1 col-xs-3">
                    Datum:
                </div>
                <div class="col-md-3 col-xs-9">
                     <div class="btn-group">

                        <?php
                        $wochentag = date("N");
                        switch($wochentag){
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            ?>
                                <button data-date="<?php echo date("Y-m-d") ;?>"type="button" class="tagespicker btn btn-primary">Heute</button>
                                <button data-date="<?php echo makePickerDateFromString("last Friday");?>" type="button" class="tagespicker btn btn-default">Freitag</button>
                                <button data-date="<?php echo makePickerDateFromString("last Saturday");?>" type="button" class="tagespicker samstag btn btn-default">Samstag</button>
                            <?php
                            break;
                            case 5:
                            ?>
                                <button data-date="<?php echo date("Y-m-d") ;?>"type="button" class="tagespicker btn btn-primary">Heute</button>
                            <?php
                            break;
                            case 6: ?>
                                <button data-date="<?php echo makePickerDateFromString("today");?>" type="button" class="tagespicker btn samstag btn-primary">Heute</button>
                                <button data-date="<?php echo makePickerDateFromString("yesterday");?>" type="button" class="tagespicker btn btn-default">Gestern</button>
                            <?php
                            break;
                            case 7: ?>
                                <button data-date="<?php echo makePickerDateFromString("last Friday");?>" type="button" class="tagespicker btn btn-default">Freitag</button>
                                <button data-date="<?php echo makePickerDateFromString("last Saturday");?>" type="button" class="tagespicker samstag btn btn-default">Samstag</button>
                       <?php
                            break;
                         } ?>
                            <!-- <button type="button" class="visible-xs tagespicker btn btn-default"><i class="fa fa-calendar"></i></button> -->

                    </div>

                </div>
                <div class="col-md-3 col-xs-6 col-md-offset-0 col-xs-offset-3">
                    <div class="micropadding visible-xs"></div>
                    <div class="input-group date" id="" data-date="<?php echo date("d.m.Y") ;?>">
                        <input id="datumswahl" class="form-control" name="datum" type="text" value="<?php echo date("d.m.Y") ;?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1 col-xs-3">
                    Fach:
                </div>
                <div class="col-md-3 col-xs-9">
                    <input type="text" class="form-control" name="fach" value="<?php echo $user['fach'] ;?>" placeholder="Fach" >
                </div>
                <div class="col-md-1 col-xs-3">
                    Lehrperson:
                </div>
                <div class="col-md-3 col-xs-9">
                    <input type="text" class="form-control" name="lehrperson" value="<?php echo $user['name'] ;?>" placeholder="Name" >
                    <input type="hidden" class="form-control" name="erfasser" value="<?php echo $user['name'] ;?>"  >
                    <input type="hidden" class="form-control" name="klasse" value="<?php echo $klasse['kuerzel'] ;?>"  >
                </div>
            </div>
            <br>




            <div class="row ">
                <br>
                <?php while ($row = $people->fetchArray()) {
                    $bildname = "profilDummy";
                    if(strlen($row['bild']) > 0 && file_exists("assets/profilbilder/".$row['bild']."_thumb.png")){
                        $bildname = $row['bild'];
                    }
                    ?>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 listenEintrag">
                            <h4 class=" zeromargin"><?php echo $row['vorname']. " " .$row['name'] ;?></h4>
                            <input type="hidden" name="name[<?php echo $row['id'];?>]" value="<?php echo $row['vorname']. " " .$row['name'] ;?>">

                            <div class="row">
                                <div class="col-xs-2">
                                    <img width="50" class=" media-object" src="assets/profilbilder/<?php echo $bildname ;?>_thumb.png " alt="<?php echo $row['vorname']. " " .$row['name'] ;?>">
                                </div>
                                <input type="hidden" id="dauer<?php echo $row['id'] ;?>" name="dauer[<?php echo $row['id'] ;?>]" value="0">
                                <div class="col-xs-10">
                                    <div class="btn-group">
                                    <?php switch ($typ) {
                                        case 'IAD': ?>
                                            <button type="button" data-wert="1" data-id="<?php echo $row['id'];?>" class="dauer <?php echo $row['id'];?> btn btn-default ">Morgen</button>
                                            <button type="button" data-wert="2" data-id="<?php echo $row['id'];?>" class="dauer <?php echo $row['id'];?> btn btn-default ">Nachmittag</button>
                                            <?php break;

                                        default:?>
                                            <button type="button" data-wert="2" data-id="<?php echo $row['id'];?>" class="dauer <?php echo $row['id'];?> btn btn-default ">Nachmittag</button>
                                            <button type="button" data-wert="4" data-id="<?php echo $row['id'];?>" class="dauer <?php echo $row['id'];?> btn btn-default ">Abend</button>
                                           <?php break;
                                    } ?>

                                    </div>
                                    <div class="micropadding"></div>
                                    <input type="hidden" id="formAbwesend<?php echo $row['id'] ;?>" name="abwesend[<?php echo $row['id'] ;?>]" value="">
                                    <div class="btn-group">
                                        <button type="button" data-id="<?php echo $row['id'];?>" class="disabled abwesend abwesend<?php echo $row['id'];?> btn btn-default ">abwesend</button>
                                        <button type="button" data-id="<?php echo $row['id'];?>" class="disabled entschuldigt abwesend abwesend<?php echo $row['id'];?> btn btn-default ">entschuldigt</button>
                                    </div>


                                            <div id="grund<?php echo $row['id'] ;?>" class="form-group hide">

                                                <div class=" col-sm-10">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="grund<?php echo $row['id'] ;?>" value="Krank" checked="checked"> Krank
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="grund<?php echo $row['id'] ;?>" value="Krank mit Zeugnis"> Krank mit Zeugnis
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="grund<?php echo $row['id'] ;?>" value="Zivil/Militärdienst"> Zivil/Militärdienst
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="grund<?php echo $row['id'] ;?>" value="Firmenanlass"> Firmenanlass
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input style="position:relative" type="radio" id="radiogrund<?php echo $row['id'] ;?>" name="grund<?php echo $row['id'] ;?>" value="Anderer Grund">
                                                        </label><input data-id="<?php echo $row['id'] ;?>" type="text" class="manuellerGrund" placeholder="Anderer Grund">
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                              </div>
                                </div>
                            </div>
                    <?php } ?>
            </div>
            <input type="submit" class="btn btn-lg btn-success" value="Absenzen erfassen" name="senden">
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
<?php $db->close(); ?>
