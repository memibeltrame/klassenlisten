<?php
include('./img_save_to_file.php');
    if(strlen($filepath)>0){
        include('./SimpleImage.php');
        try {
            $img = new abeautifulsite\SimpleImage($filepath);
            $time = time();
            $img->adaptive_resize(235, 310)->save('assets/profilbilder/'.$rowid.'-'.$time.'.png');
            $img->adaptive_resize(64, 84)->save('assets/profilbilder/'.$rowid.'-'.$time.'_thumb.png');

            $stmt = $db->prepare('
                Update people set bild = \'' . $rowid . '-'.$time.'\' where id = \'' . $rowid . '\';
             ');
            $result = $stmt->execute();

            if(empty($dontlog)){
                // Log Schreiben
                $stmt = $db->prepare("
                    insert into logs ('user', 'username', 'post') values('".$_SESSION['user']['id'] ."', '". $_SESSION['user']['name'] ."', '".  $rowid . "-".time() ."');
                 ");
                $result = $stmt->execute();
            }
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }