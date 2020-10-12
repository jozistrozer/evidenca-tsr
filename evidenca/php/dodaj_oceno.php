<?php
$ocena = $_POST["ocena"];
$komentar = $_POST["komentar"];
$dijak_id = $_POST["dijak_id"];
$vrsta_ocene = $_POST["vrsta_ocene"];
$predmet_id = $_POST["predmet_id"];
$obdobje = $_POST["obdobje"];

echo "OCENA: " . $ocena;
echo "KOMENTAR: " . $komentar;
echo "DIJAK_ID: " . $dijak_id;
echo "VRSTA_OCENE: " . $vrsta_ocene;
echo "PREDMET_ID: " . $predmet_id;
echo "OBDOBJE: " . $obdobje;

$sql = "IN";

?>