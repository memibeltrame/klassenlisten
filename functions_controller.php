<?php


$db = new SQLite3('assets/db/default');

// set domain
if (empty($_SESSION['aktiveListe'])){
    $stmt = $db->prepare('
        Select id from klassen where typ != \'Dozenten\'  and aktiv = 1 order by von Limit 1 ;
    ');

    $results = $stmt->execute();
    $klasse = $results->fetchArray();
    $aktiveListe = $klasse['id'];
    $_SESSION['aktiveListe'] = $aktiveListe;

}

$is_admin = false;
$is_dozenten = false;
$user = false ;

if (!empty($_COOKIE['user'])) {
    $user = unserialize($_COOKIE['user']);
}

if (!empty($user['id'])) {
    $stmt = $db->prepare('
         Select is_admin from people where facebook_id = '.$user['id'].' ;
    ');
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $is_admin = $row['is_admin'];
}


// Manage User from Cookie
if(empty($_SESSION['user']) && !empty($_COOKIE['user'])){
    $_SESSION['user'] = unserialize($_COOKIE['user']);
}

$is_admin = false;
if(!empty($_SESSION['user']) && !empty($_SESSION['user']['is_admin'])){
    $is_admin = $_SESSION['user']['is_admin'];
}



function eightCardPdf($pdf, $strings){
    Foreach ($strings as $key => $string) {
        $string = trim($string);
        $num = $key + 1;
        Switch ($num%24){
            case 1:
                $pdf->AddPage();
                $pdf->SetXY(10, 10);
                break;
            case 2:
                $pdf->SetXY(80, 10);
                break;
            case 3:
                $pdf->SetXY(150, 10);
                break;


            case 4:
                $pdf->SetXY(10, 47);
                break;
            case 5:
                $pdf->SetXY(80, 47);
                break;
            case 6:
                $pdf->SetXY(150, 47);
                break;


            case 7:
                $pdf->SetXY(10, 84);
                break;
            case 8:
                $pdf->SetXY(80, 84);
                break;
            case 9:
                $pdf->SetXY(150, 84);
                break;


            case 10:
                $pdf->SetXY(10, 121);
                break;
            case 11:
                $pdf->SetXY(80, 121);
                break;
            case 12:
                $pdf->SetXY(150, 121);
                break;


            case 13:
                $pdf->SetXY(10, 158);
                break;
            case 14:
                $pdf->SetXY(80, 158);
                break;
            case 15:
                $pdf->SetXY(150, 158);
                break;


            case 16:
                $pdf->SetXY(10, 195);
                break;
            case 17:
                $pdf->SetXY(80, 195);
                break;
            case 18:
                $pdf->SetXY(150, 195);
                break;


            case 19:
                $pdf->SetXY(10, 233);
                break;
            case 20:
                $pdf->SetXY(80, 233);
                break;
            case 21:
                $pdf->SetXY(150, 233);
                break;


            case 22:
                $pdf->SetXY(10, 270);
                break;
            case 23:
                $pdf->SetXY(80, 270);
                break;
            case 24:
                $pdf->SetXY(150, 270);
                break;



        }

        //write Card Name
        $pdf->SetFont('DejaVu','',12);
        $pdf->MultiCell( 70, 7, $string, 0, 'L'); // write Cardname
    }
    return $pdf;
}

function figureFormat($num, $dez = 2){
    $num = floatval($num);
   return number_format($num, $dez, '.', '&rsquo;');
}

// Order stuff via uasort($array, 'itemOrder');
function itemOrder($a, $b) {

    // Change 'orderKey' to whatever Index your array should be ordered by
    return $a['orderIndex'] > $b['orderIndex'] ? 1 : -1;

}

function getRawText($people){
    if(empty($_GET['rawtext'])){
        return;
    }
    header("Content-Type: text/plain; charset=utf-8");
    echo "Name,Adresse,Ort\n";
    while ($row = $people->fetchArray()) {
        echo $row['vorname'] . " " .$row['name'] .",";
        echo $row['adresse'] .",";
        echo $row['plz']. " " .$row['ort'] .",";
        echo $row['email'] ."\n";
    }
    die();
}

function getXls($aktiveListe, $people){
    if(empty($_GET['xls'])){
        return;
    }
    header ( "Content-type: application/vnd.ms-excel" );
    header ( "Content-Disposition: attachment; filename=adressliste_".$aktiveListe.".xls" );
    echo "<table><tr><th>Vorname</th><th>Name</th><th>Adresse</th><th>PLZ / Ort</th><th>Email</th></tr>";
    while ($row = $people->fetchArray()) {
        echo "<td>" . $row['vorname'] ."</td>";
        echo "<td>" . $row['name'] ."</td>";
        echo "<td>" . $row['adresse'] ."</td>";
        echo "<td>" . $row['plz']. " " .$row['ort'] ."</td>";
        echo "<td>" . $row['email'] ."</td></tr>";
        }
    echo "</table>";
    die();
}

function getEtiketten($people){
    if (empty($_GET['etiketten'])) {
        return;
    }

    define('tFPDF_FONTPATH','tfpdf/font/');
        include("tfpdf/tfpdf.php");

        $adressen = array();
        while ($row = $people->fetchArray()) {
            $adressentemp = "";
            $adressentemp .=  $row['vorname'] . " " .$row['name'] ."\n";
            $adressentemp .=  $row['adresse'] ."\n";
            $adressentemp .=  $row['plz']. " " .$row['ort'] ."";
            $strings[] = $adressentemp;
        }

        $orientation = "P";


        $pdf = new tFPDF($orientation, "mm", "A4");
        $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
        $pdf->SetTopMargin = 0;
        $pdf->SetDrawColor(220, 220, 220);

        $pdf->SetLineWidth(0.1);
        $pdf = eightCardPdf($pdf, $strings);

        $pdf->Output("adressen.pdf","D");

        die();
}

function box($text, $class="info",$icon="inherit", $id="", $dismiss = true ){
    if ($icon == "inherit") {
        switch ($class) {
            case 'success':
                $icon = "check";
                break;
            case 'danger':
                $icon = "warning";
                break;

            default:
                $icon = "info-circle";
                break;
        }
    }
    echo "<div id=\"" . $id . "\" class=\"alert alert-". $class ."\">";
    if($dismiss){
        echo "<button class=\"close\" data-dismiss=\"alert\"  type=\"button\">×</button>";
    }
    echo "<ul class=\"fa-ul\">
          <li style='width:96%'>
            <i class=\"fa fa-" . $icon . " fa-lg fa-li\"></i>
            " . $text . "
          </li>
        </ul>
      </div>";


}

function checkDozent($email,$db){
    $is_dozent = false ;
    $stmt = $db->prepare('
         Select liste from people where email = "'.$email.'" ;
    ');
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if($row != false && $row['liste'] == "dozenten"){
        $is_dozent = true ;
    }
    return $is_dozent;
}