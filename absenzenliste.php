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
         Select * from absenzen order by name ;
 ');

    $absenzen = $stmt->execute();




?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Abwesenheitsliste</title>
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
                    <h1>Absenzenliste</h1>
                </span>


            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-condensed">
                        <tr>
                            <th>Name</th>
                            <th>Datum</th>
                            <th>Dauer</th>
                            <th>Typ</th>
                            <th>Fach</th>
                            <th>Lehrperson</th>
                            <th>Erfasser</th>
                            <th>Klasse</th>
                        </tr>
                        <?php while ($absenz = $absenzen->fetchArray()) {

                            $datum = substr($absenz['datum'],8,2).".".substr($absenz['datum'],5,2).".".substr($absenz['datum'],0,4);
                            ?>

                        <tr>
                            <td><?php echo $absenz['name'] ;?></td>
                            <td><?php echo $datum ;?></td>
                            <td><?php echo $absenz['dauer'] ;?></td>
                            <td><?php echo $absenz['typ'] ;?></td>
                            <td><?php echo $absenz['fach'] ;?></td>
                            <td><?php echo $absenz['lehrperson'] ;?></td>
                            <td><?php echo $absenz['erfasser'] ;?></td>
                            <td><?php echo $absenz['klasse'] ;?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
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
