
// preveri ce so vsi DOM elementi ustvarjeni
$(document).ready(function(){

  // caka na klik gumba (registriraj)
  $("#gumb_r").click(function(data){

    // spremenljivke
    var username = $("#username").val();
    var password = $("#password").val();
    var password_c = $("#password_c").val();
    var error = false;

    if(password.length < 8){
      error = true;
      $("#password").css("border", "1px solid red");
      $("#info").html("Geslo mora biti dolgo vsaj 8 črk");
    }
    if(username.length < 3){
      error = true;
      $("#username").css("border", "1px solid red");
      $("#info").html("Uporabniško ime mora biti dolgo vsaj 3 črke");
    }
    if(password != password_c){
      error = true;
      $("#password_c").css("border", "1px solid red");
      $("#info").html("Gesli se ne ujemata");
    }

    // preveri ce so polja prazna
    if(username != "" && password != "" && password_c != "" && error == false){
      // POST request na php_handle/registriraj.php,
      // registriraj.php vrne parameter data
      $.ajax({
        type: "POST",
        url: "php_handle/registriraj.php",
        data: {username: username, password:password},
        success: function(data){
          if(data == 1){
            // nastavi span html vrednost z idjem #info
            $("#info").html("Registracija je uspela");
            setInterval(window.location.replace("index.html"), 1000);
          }else{
              // nastavi span html vrednost z idjem #info
              $("#info").html("Uporabniško ime je ze zasedeno");
            }
          }
        });
      }
    });
  });
