<?php
# povezava na podatkovno bazo
include("db_connect.php");

# spremenljivka uporabnisko ime
$username = $_POST['username'];
# spremenljivka geslo
$password = $_POST['password'];

# sql poizvedba
$sql = "INSERT INTO uporabniki (username, password) VALUES ('$username', PASSWORD('$password'))";

# vstavljanje v bazo
if(mysqli_query($conn, $sql)){
  echo 1;
}else{
  echo 0;
}
 ?>
