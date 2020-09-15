<?php
session_start();
include('../php_handle/db_connect.php');
$username = $_SESSION['username'];

$osnovni_podatki = mysqli_query($conn, "SELECT d.ime, d.priimek, r.razred FROM dijak d INNER JOIN razred r ON d.razred_id=r.razred_id WHERE d.username='$username';");

while($vrstica = mysqli_fetch_assoc($osnovni_podatki)) {
  $ime = $vrstica["ime"];
  $priimek = $vrstica["priimek"];
  $oddelek = $vrstica["razred"];
}

 ?>
<!DOCTYPE html>
<html lang="sl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/evidenca.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Pregled</title>
    <div class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand">Evidenca - TSR</a>
        </div>
        <ul class="nav navbar-nav" style="float: right;">
          <li><a class="btn btn-default" id="btnOdjava">Odjava</a></li>
          <li></li>
        </ul>
      </div>
    </div>
    <div class="navbar navbar-inverse" id="postavkeNavbar">
      <div class="container-fluid">
        <ul class="nav navbar-nav" id="postavkeList">
          <li><p>Redovalnica</p></li>
          <li><p>TAB2</p></li>
          <li><p>TAB3</p></li>
          <li><p>TAB4</p></li>
        </ul>

        <ul class="nav navbar-nav" id="prijavljenNavbar">
          <li><p><span style="font-weight: bold;">Prijavljen uporabnik: </span><?php echo $ime . " " . $priimek; ?></p></li>
        </ul>

      </div>
    </div>
  </head>
  <body>
    <p>Tukaj bojo vsi predmeti, podatki o dijaku, profesorju. Klik na predmet pokaže podrobnosti o predmetu in ocene.</p>
    <h4><span style="font-weight: bold;">Status: </span><?php echo "testtesttesttest"; ?></h4>
    <h4><span style="font-weight: bold;">Oddelek: </span><?php echo $oddelek; ?></h4>

    <table class="table">
      <thead>
      <tr>
        <th scope="col">Predmet</th>
        <th scope="col">1. ocenjevalno obdobje</th>
        <th scope="col">2. ocenjevalno obdobje</th>
        <th scope="col">Zaključena ocena</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th scope="row">MAT</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">SLO</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">ANG</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">FIZ</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">ŠVZ</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">ZGO</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">BIO</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>
      <tr>
        <th scope="row">KEM</th>
        <td>3, 5, 1</td>
        <td>5, 4, 2</td>
        <td> / </td>
      </tr>

      </tbody>
    </table>

  </body>
  <footer>
    <p>Evidenca - TSR</p>
  </footer>
</html>
