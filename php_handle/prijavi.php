<?php
# povezava na bazo
include("db_connect.php");

# nastavi spremenljivke na post metodo iz ajax-a
$username = $_POST['username'];
$password = $_POST['password'];

# sql poizvedba
$sql = "SELECT username, password, 'dijak' AS tabela FROM dijak WHERE username='$username' AND password = '$password' UNION SELECT username, password, 'profesor' AS tabela FROM profesor WHERE username='$username' AND password = '$password'";
$detail = mysqli_num_rows(mysqli_query($conn, $sql));
$vrsta_up = mysqli_fetch_all(mysqli_query($conn, $sql));

# Preveri uporabnisko ime in geslo in vrne parameter "data" (echo)
if($detail == 1){
  session_start();
  $_SESSION['username'] = $username;
  $_SESSION['vrsta_up'] = $vrsta_up[0][2];
  echo 1;
}else{
  echo 0;
}
 ?>
