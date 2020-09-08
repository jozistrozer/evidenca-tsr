<?php
# povezava na bazo
include("db_connect.php");

# nastavi spremenljivke na post metodo iz ajax-a
$username = $_POST['username'];
$password = $_POST['password'];

# sql poizvedba
$sql = "SELECT * FROM uporabniki WHERE username='$username' AND password = PASSWORD('$password')";
$detail = mysqli_num_rows(mysqli_query($conn, $sql));

# Preveri uporabnisko ime in geslo in vrne parameter "data" (echo)
if($detail == 1){
  echo 1;
}else{
  echo 0;
}




 ?>
