<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/
include('core/protostrap.php');


/** Define VALUES  valid for this file **/
$activeNavigation = $aktiveListe;


$stmt = $db->prepare('
         Select * from logs order by zeit DESC ;
 ');

    $logs = $stmt->execute();


?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Logs <?php echo " - " . $brand ;?></title>
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

            <div class="row">
                <span class="col-md-6">
                <h1>Logs</h1>

                </span>
            </div>

            <br>

                <?php
                $i = 0;
                while ($row = $logs->fetchArray()) {



                    ?>


                    <div class="row">
                        <span class="col-md-3">
                            <?php echo $row['username'] ;?><br>
                            <small> <?php echo $row['user'] ;?></small>
                        </span>
                        <span class="col-md-6">

                        <?php if(substr($row['post'], 0, 2 ) == "a:"){?>
                            <pre><?php var_dump(unserialize($row['post'])) ?></pre>
                         <?php } else { ?>
                            <img width="80" src="/assets/profilbilder/<?php echo $row['post'] ;?>.png">
                            <?php }?>
                        </span>

                        <span class="col-md-3">
                            <?php echo $row['zeit'] ;?>
                        </span>
                    </div>

                    <div class="micropadding"></div>



                 <?php } ?>

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
