<?php

/** --- B A S E F U N C T I O N S ---
    This file sets up project-wide things like authentication -
    DO NOT REMOVE
**/

include('core/protostrap.php');

/* Handle login */
$data = array();
$is_dozent = false;
$is_admin = false;
$name = "";

/** Angaben vorhanden? **/
if(empty($_POST['email']) OR strlen(($_POST['email'])) < 1 OR empty($_POST['passwort']) ){
    $data['status'] = "Error";
    $data['msg'] = "Angaben fehlen, bitte Email und Passwort ausfüllen";
    sendReturn($data);
}
$email = $_POST['email'];
$pw = $_POST['passwort'];

/* ist das ein Dozent? */
if(checkDozent($email,$db) == false){
    $data['status'] = "Error";
    $data['msg'] = "Email gehört nicht einer Lehrperson";
    sendReturn($data);
}

if(md5($pw) != "92f8a2a2dd22f35178f99eadcce38bb8"){
    $data['status'] = "Error";
    $data['msg'] = "Passwort falsch";
    sendReturn($data);
}

// Alles OK -> User daten holen und Session / Cookie setzen
    $stmt = $db->prepare('
         Select name, vorname, is_admin, fach from people where email = "'.$email.'" ;
    ');
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    $is_admin = $row['is_admin'];
    $fach = $row['fach'];
    $name = $row['vorname'] . " ". $row['name'];


    $user = array("name" => $name, "id" => "", "is_admin" => $is_admin,  "fach" => $fach, "is_dozent" => true);
    $_SESSION['user'] = $user;
    setcookie("user",serialize($user), time()+60*60*24*700);



$data['status'] = "OK";
sendReturn($data);

function sendReturn($data){
    header('Content-Type: text/html; charset=utf-8');
    echo json_encode($data);
    die();
}




