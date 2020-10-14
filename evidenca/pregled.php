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
    $osnovni_podatki = mysqli_query($conn, "SELECT ime, priimek, kabinet FROM profesor WHERE username='$username';");

    while ($vrstica = mysqli_fetch_assoc($osnovni_podatki)) {
        $ime = $vrstica["ime"];
        $priimek = $vrstica["priimek"];
        $kabinet = $vrstica["kabinet"];
    }

    $oddelek = "Matic more zrihtat sql";

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
    <link rel="stylesheet" href="css/modal.css">
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
        </ul>
        <ul class="nav navbar-nav" id="prijavljenNavbar">
          <li><p><span style="font-weight: bold;">Prijavljen uporabnik: </span><?php echo $ime . " " . $priimek; ?></p></li>
        </ul>
      </div>
    </div>
    <script>
        // Za URL parametre
        function insertParam(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);

            var kvp = document.location.search.substr(1).split('&');
            let i=0;

            for(; i<kvp.length; i++){
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }

            if(i >= kvp.length){
                kvp[kvp.length] = [key,value].join('=');
            }

            let params = kvp.join('&');

            document.location.search = params;
        } 
        
        $(document).ready(function(){
            $("#dodajOcenoForm").submit(function(event){
                event.preventDefault();    
                
                var ocena = $("#formOcena").val();
                var komentar = $("#formKomentar").val();
                var dijak_id = $("#idDijakID").val();
                var vrsta_ocene = $("#vrstaOceneDropdown").val();
                var obdobje = $("#idObdobje").val();
                var predmet_id = $("#idPredmet").val();
                
                // ajax request za dodajanje ocene.
                $.ajax({
                  type: "POST",
                  url: "php/dodaj_oceno.php",
                  data:{ocena:ocena, komentar:komentar, dijak_id:dijak_id, vrsta_ocene:vrsta_ocene, obdobje:obdobje, predmet_id:predmet_id},
                  success: function(data){
                      if (data == 1){
                          alert("Ocena je bila uspešno dodana.");
                      } else {
                          alert("Napaka pri dodajanju ocene, poskusi ponovno.");
                      }
                      // reload strani
                      location.reload();
                  }
                });
        
            });
        });
   
        function IzbrisiOceno (ocena_id){
            // ajax request za brisanje ocene.
            $.ajax({
              type: "POST",
              url: "php/izbrisi_oceno.php",
              data:{ocena_id:ocena_id},
              success: function(data){
                  if (data == 1){
                      alert("Ocena je bila uspešno izbrisana.");
                  } else {
                      alert("Napaka pri brisanju ocene, poskusi ponovno.");
                  }
                  // reload strani.
                  location.reload();
              }
          });
        }
        
    </script>
  </head>
  <body>
    <h4><span style="font-weight: bold;">Status: </span><?php echo ucfirst($vrsta_up); ?></h4>

    <?php
      if ($vrsta_up == "profesor") {
          echo "<h4><span style='font-weight: bold;'>Kabinet: </span>$kabinet</h4>";
      } else {
          echo "<h4><span style='font-weight: bold;'>Oddelek: </span>$oddelek</h4>";
      }
    ?>
      <?php
        if ($vrsta_up == "dijak") {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th scope='col'>Predmet</th>";
            echo "<th scope='col'>1. ocenjevalno obdobje</th>";
            echo "<th scope='col'>2. ocenjevalno obdobje</th>";
            echo "<th scope='col'>Zaključena ocena</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
        for ($i = 0; $i < count($predmeti); $i++) {
          echo "<tr>";
          echo "<th scope='row'>" . $predmeti[$i][0] . "</th>";
          $predmet_prvo = mysqli_query($conn, "SELECT ocena, vrsta_ocene, komentar, obdobje, datum FROM ocena o WHERE o.predmet_id = '".$predmeti[$i][1]."' AND o.dijak_id = (SELECT dijak_id FROM dijak WHERE username='$username') AND o.obdobje = 1");

          $predmet_drugo = mysqli_query($conn, "SELECT ocena, vrsta_ocene, komentar, obdobje, datum FROM ocena o WHERE o.predmet_id = '".$predmeti[$i][1]."' AND o.dijak_id = (SELECT dijak_id FROM dijak WHERE username='$username') AND o.obdobje = 2");

          $predmet_zakljucena = mysqli_query($conn, "SELECT ocena, vrsta_ocene, komentar, obdobje, datum FROM ocena o WHERE o.predmet_id = '".$predmeti[$i][1]."' AND o.dijak_id = (SELECT dijak_id FROM dijak WHERE username='$username') AND o.obdobje = 3");
          # 1. OCENJEVALNO OBDOBJE
          echo "<td>";
          while($ocena = mysqli_fetch_assoc($predmet_prvo)){
              $ocena_temp = $ocena["ocena"];
              $vrstaOcene_temp = $ocena["vrsta_ocene"];
              $komentar_temp = $ocena["komentar"];
              $datumOcena = $ocena["datum"];

              echo "<div class='oblacek'>$ocena_temp<span class='txtOblacek'><b>Datum: </b>$datumOcena<br><b>Vrsta ocene: </b>$vrstaOcene_temp<br><b>Komentar: </b>$komentar_temp<br></span></div>";
          }
          echo "</td>";
          # 2. OCENJEVALNO OBDOBJE
          echo "<td>";
          while($ocena = mysqli_fetch_assoc($predmet_drugo)){
              $ocena_temp = $ocena["ocena"];
              $vrstaOcene_temp = $ocena["vrsta_ocene"];
              $komentar_temp = $ocena["komentar"];
              $datumOcena = $ocena["datum"];

              echo "<div class='oblacek'>$ocena_temp<span class='txtOblacek'><b>Datum: </b>$datumOcena<br><b>Vrsta ocene: </b>$vrstaOcene_temp<br><b>Komentar: </b>$komentar_temp<br></span></div>";
          }
          echo "</td>";
          # ZAKLJUCENA
          echo "<td>";
          while($ocena = mysqli_fetch_assoc($predmet_zakljucena)){
              $ocena_temp = $ocena["ocena"];
              echo "<b>$ocena_temp</b>";
          }
          echo "</td>";
          echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        } else if ($vrsta_up == "profesor") {
            echo "<h3>Predmeti</h3>";
            $predmeti = mysqli_query($conn, "SELECT kratica, naziv_predmeta FROM predmet p WHERE p.profesor_id = (SELECT profesor_id FROM profesor WHERE username='$username')");
            while ($predmet = mysqli_fetch_assoc($predmeti)) {
                $predmetKratica = $predmet["kratica"];
                echo "<a href='?p=$predmetKratica'>$predmetKratica</a>" . " " . $predmet["naziv_predmeta"] . "<br>";
            }
            if (isset($_GET["p"])) {
              $izbranPredmet = $_GET["p"];
              $razrediPredmet = mysqli_query($conn, "SELECT r.razred FROM predmet_razred pr JOIN razred r ON r.razred_id = pr.razred_id WHERE pr.predmet_id = (SELECT predmet_id FROM predmet WHERE kratica = '$izbranPredmet')");
              echo "<div class='izbranPredmet'>";
              echo "<h4 style='font-weight: bold;'>$izbranPredmet</h4>";
              while ($razred = mysqli_fetch_assoc($razrediPredmet)) {
                $tmpRazred = $razred["razred"];
                echo "<a onclick='insertParam(&quot;r&quot;, &quot;".$tmpRazred."&quot;)'>$tmpRazred</a><br>";
              }
              echo "</div>";
              if (isset($_GET["r"])) {
                 echo "<h1>". $_GET["r"] . "</h1>";
                 $izbranRazred = $_GET["r"];
                 $izbranPredmet = $_GET["p"];
                  
                 $sqlFirst = mysqli_query($conn, "SELECT * FROM dijak d JOIN razred r ON r.razred_id = d.razred_id WHERE r.razred='$izbranRazred' ORDER BY d.ime");
                 echo "<table class='table'>";
                 echo "<thead>";
                 echo "<tr>";
                 echo "<th scope='col'>Ime, priimek</th>";
                 echo "<th scope='col'>1. ocenjevalno obdobje</th>";
                 echo "<th scope='col'>2. ocenjevalno obdobje</th>";
                 echo "<th scope='col'>Zaključena ocena</th>";
                 echo "</tr>";
                 echo "</thead>";
                 echo "<tbody>";
                 
                 $count = 1;
                 while ($imePriimek = mysqli_fetch_assoc($sqlFirst)) {
                     echo "<tr>";
                     echo "<th scope='col'> $count. " . $imePriimek["ime"] . " " . $imePriimek["priimek"] . "</th>";
                     echo "<td>";
                     $sqlPrvoObdobje = mysqli_query($conn, "SELECT ocena_id, ocena, obdobje FROM ocena o
                     INNER JOIN dijak d ON d.dijak_id = o.dijak_id
                     INNER JOIN predmet p ON p.predmet_id = o.predmet_id
                     WHERE d.dijak_id = " . $imePriimek["dijak_id"] . "
                     AND p.kratica = '" . $izbranPredmet . "'
                     AND o.obdobje = 1");
                     while ($ocena = mysqli_fetch_assoc($sqlPrvoObdobje)) {
                         echo "<span style='margin-right:35px;' id='ocena' onclick='IzbrisiOceno(&quot;".$ocena["ocena_id"]."&quot;)'>" . $ocena["ocena"] . "</span>";
                     }
                     echo "<span id='". $imePriimek["dijak_id"] ."' class='addGrade' onclick='OdpriModalno(&quot;". $imePriimek["dijak_id"] ."&quot;, &quot;1&quot;, &quot;".$izbranPredmet."&quot;)'>+</span>";
                     echo "</td>";
                     echo "<td>";
                     
                     $sqlDrugoObdobje = mysqli_query($conn, "SELECT ocena_id, ocena FROM ocena o
                     INNER JOIN dijak d ON d.dijak_id = o.dijak_id
                     INNER JOIN predmet p ON p.predmet_id = o.predmet_id
                     WHERE d.dijak_id = " . $imePriimek["dijak_id"] . "
                     AND p.kratica = '" . $izbranPredmet . "'
                     AND o.obdobje = 2");
                     
                     while ($ocena = mysqli_fetch_assoc($sqlDrugoObdobje)) {
                         echo "<span style='margin-right:35px;' id='ocena' onclick='IzbrisiOceno(&quot;".$ocena["ocena_id"]."&quot;)'>" . $ocena["ocena"] . "</span>";
                     }
                     
                     echo "<span id='". $imePriimek["dijak_id"] ."' class='addGrade' onclick='OdpriModalno(&quot;". $imePriimek["dijak_id"] ."&quot;, &quot;2&quot;, &quot;".$izbranPredmet."&quot;)'>+</span>";
                     echo "</td>";
                     echo "<td>";
                     $sqlZakljucnaOcena = mysqli_query($conn, "SELECT ocena_id, ocena FROM ocena o
                     INNER JOIN dijak d ON d.dijak_id = o.dijak_id
                     INNER JOIN predmet p ON p.predmet_id = o.predmet_id
                     WHERE d.dijak_id = " . $imePriimek["dijak_id"] . "
                     AND p.kratica = '" . $izbranPredmet . "'
                     AND o.obdobje = 3");
                     while ($ocena = mysqli_fetch_assoc($sqlZakljucnaOcena)) {
                         echo "<span style='margin-right:35px;' id='ocena' onclick='IzbrisiOceno(&quot;".$ocena["ocena_id"]."&quot;)'>" . $ocena["ocena"] . "</span>";
                     }
                     if (mysqli_num_rows($sqlZakljucnaOcena) < 1){
                        echo "<span id='". $imePriimek["dijak_id"] ."' class='addGrade' onclick='OdpriModalno(&quot;". $imePriimek["dijak_id"] ."&quot;, &quot;3&quot;, &quot;".$izbranPredmet."&quot;)'>+</span>"; 
                     }
                     
                     echo "</td>";
                     echo "</tr>";
                     $count = $count + 1;
                 }
                echo "<div id='addGradeModal' class='modal'>";
                    echo "<div class='modal-content'>";
                        echo "<span class='close'>&times;</span>";
                        echo "<p style='font-weight:bold;'>Dodaj oceno</p>";
                        echo "<form type='POST' id='dodajOcenoForm'>";
                        echo "<div id='tabela'>";
                            echo "<div id='tabela-leva'>";
                  
                            echo "<span id='idDijakID'></span>";
                            echo "<span id='idPredmet'></span>";
                            echo "<span id='idObdobje'></span>";
                                
                  
                            echo "<p>Ocena:</p>";
                            echo "<p id='txtKomentar'>Komentar:</p><br>";
                            echo "<p id='txtVrstaOcene'>Vrsta ocene:</p>";
                            echo "</div>";
                            echo "<div id='tabela-desna'>";
                            echo "<input type='number' min='1' max='5' id='formOcena'>";
                            echo "<textarea id='formKomentar'></textarea>";
                            echo "<select id='vrstaOceneDropdown'>";
                                echo "<option value='pisna'>Pisna ocena</option>";
                                echo "<option value='ustna'>Ustna ocena</option>";
                                echo "<option value='izdelek'>Izdelek</option>";
                            echo "</select>";
                            echo "<input type='submit'>";
                            echo "</div>";
                        echo "</div>";
                        echo "</form>";
                    echo "</div>";
                echo "</div>";
              }
            }
        }
      ?>
  </body>
    <script>
        function OdpriModalno(dijak_id, obdobje, predmet_id){
            modal.style.display = "block";
            
            $("#idDijakID").val(dijak_id);
            $("#idObdobje").val(obdobje);
            $("#idPredmet").val(predmet_id);
            
            if (obdobje == 3) {
                // vrsta ocene
                document.getElementById("vrstaOceneDropdown").style.display = "none";
                document.getElementById("txtVrstaOcene").style.display = "none";
                
                //komentar
                document.getElementById("formKomentar").style.display = "none";
                document.getElementById("txtKomentar").style.display = "none";
            } else {
                // vrsta ocene
                document.getElementById("vrstaOceneDropdown").style.display = "inline";
                document.getElementById("txtVrstaOcene").style.display = "inline";
                
                //komentar
                document.getElementById("formKomentar").style.display = "inline";
                document.getElementById("txtKomentar").style.display = "inline";
            }
        }
    </script>
    <script src="js/modal.js" charset="utf-8"></script>
</html>
