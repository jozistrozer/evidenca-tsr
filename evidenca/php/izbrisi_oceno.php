<?php
# povezava na bazo
include("../../php_handle/db_connect.php");

# podatki
$ocena_id = $_POST["ocena_id"];

# izbris ocene
$sql = "DELETE FROM ocena WHERE ocena_id='$ocena_id'";

if (mysqli_query($conn, $sql)){
    echo 1;
} else {
    echo 0;
}

?>