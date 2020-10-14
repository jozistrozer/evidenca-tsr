<?php
# povezava na bazo
include("../../php_handle/db_connect.php");

# podatki
$ocena = $_POST["ocena"];
$komentar = $_POST["komentar"];
$dijak_id = $_POST["dijak_id"];
$vrsta_ocene = $_POST["vrsta_ocene"];
$predmet_id = $_POST["predmet_id"];
$obdobje = $_POST["obdobje"];

# IZPIS
/*echo "OCENA: " . $ocena . " ";
echo "KOMENTAR: " . $komentar . " ";
echo "DIJAK_ID: " . $dijak_id . " ";
echo "VRSTA_OCENE: " . $vrsta_ocene . " ";
echo "PREDMET_ID: " . $predmet_id . " ";
echo "OBDOBJE: " . $obdobje . " ";
*/

#sql stavek
$sql = "INSERT INTO ocena (ocena, datum, vrsta_ocene, komentar, obdobje, predmet_id, dijak_id) VALUES ('$ocena', NOW(), '$vrsta_ocene', '$komentar', '$obdobje', (SELECT predmet_id FROM predmet WHERE kratica='$predmet_id'), '$dijak_id')";

# vstavljanje
if (mysqli_query($conn, $sql)) {
    echo 1;
} else {
    echo 0;
}

?>