<?php
session_start();
include('../php_handle/db_connect.php');
$username = $_SESSION['username'];
$vrsta_up = $_SESSION["vrsta_up"];

if ($vrsta_up == "dijak") {
    # DIJAK
    $osnovni_podatki = mysqli_query($conn, "SELECT d.ime, d.priimek, r.razred FROM dijak d INNER JOIN razred r ON d.razred_id=r.razred_id WHERE d.username='$username';");

    while($vrstica = mysqli_fetch_assoc($osnovni_podatki)) {
      $ime = $vrstica["ime"];
      $priimek = $vrstica["priimek"];
      $oddelek = $vrstica["razred"];
    }

    $predmeti = mysqli_fetch_all(mysqli_query($conn, "SELECT DISTINCT p.kratica, pr.predmet_id FROM predmet p, dijak d, predmet_razred pr WHERE d.razred_id = (SELECT razred_id FROM dijak WHERE username='$username') AND pr.predmet_id = p.predmet_id"));
} else if ($vrsta_up == "profesor") {
    # PROFESOR
    
} else {
    header("Location: ../index.html");
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
    <script src="js/odjava.js" charset="utf-8"></script>
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
    <h4><span style="font-weight: bold;">Status: </span><?php echo ucfirst($vrsta_up); ?></h4>
    <h4><span style="font-weight: bold;">Oddelek: </span><?php echo $oddelek; ?></h4>

      <?php
        if ($vrsta_up == "dijak") {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Predmet</th>";
            echo "<th scope='col'>1. Ocenjevalno obdobje</th>";
            echo "<th scope='col'>2. Ocenjevalno obdobje</th>";
            echo "<th scope='col'>Zaključena ocena</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
        for ($i = 0; $i < count($predmeti); $i++) {
          echo "<tr>";
          echo "<th scope='row'>" . $predmeti[$i][0] . "</th>";
          $predmet_prvo = mysqli_query($conn, "SELECT ocena, vrsta_ocene, komentar, obdobje FROM ocena o WHERE o.predmet_id = '".$predmeti[$i][1]."' AND o.dijak_id = (SELECT dijak_id FROM dijak WHERE username='$username') AND o.obdobje = 1");

          $predmet_drugo = mysqli_query($conn, "SELECT ocena, vrsta_ocene, komentar, obdobje FROM ocena o WHERE o.predmet_id = '".$predmeti[$i][1]."' AND o.dijak_id = (SELECT dijak_id FROM dijak WHERE username='$username') AND o.obdobje = 2");

          $predmet_zakljucena = mysqli_query($conn, "SELECT ocena, vrsta_ocene, komentar, obdobje FROM ocena o WHERE o.predmet_id = '".$predmeti[$i][1]."' AND o.dijak_id = (SELECT dijak_id FROM dijak WHERE username='$username') AND o.obdobje = 3");
          # 1. OCENJEVALNO OBDOBJE
          echo "<td>";
          while($ocena = mysqli_fetch_assoc($predmet_prvo)){
              echo $ocena["ocena"] . " ";
          }
          echo "</td>";
          # 2. OCENJEVALNO OBDOBJE
          echo "<td>";
          while($ocena = mysqli_fetch_assoc($predmet_drugo)){
              echo $ocena["ocena"] . " ";
          }
          echo "</td>";
          # ZAKLJUCENA
          echo "<td>";
          while($ocena = mysqli_fetch_assoc($predmet_zakljucena)){
              echo $ocena["ocena"] . " ";
          }
          echo "</td>";
          echo "</tr>";
          
        } 
        echo "</tbody>";
        echo "</table>";
    }
        
      ?>

  </body>
  <footer>
    <p>Evidenca - TSR</p>
  </footer>
</html>
