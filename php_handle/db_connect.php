<?php
// spremenljivke za povezavo na bazo
$servername = "localhost";
$username = "root";
$password = "";
$baza = "opravila";

// objekt za novo povezavo
$conn = new mysqli($servername, $username, $password, $baza);

// v primeru, da se server poveže na bazo
if ($conn->connect_error) {
    die("Povezava ni uspela: " . $conn->connect_error);
}
 ?>
