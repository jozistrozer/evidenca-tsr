// preveri ce so vsi DOM elementi ustvarjeni
$(document).ready(function(){
  // caka na klik gumba (prijavi)
  $("#gumb_p").click(function(data){
    // spremenljivka uporabniskega imena (input text)
    var username = $("#username").val();
    // spremenljivka gesla (input password)
    var password = $("#password").val();
    var error = false;

    if(username.length < 3){
      error = true;
      $("#username").css("border", "1px solid red");
      $("#info").html("Uporabniško ime mora biti dolgo vsaj 3 črke");
    }

    // preveri ce sta polja prazna
    if(username == "" && password == "" && error == false){
      // nastavi span html vrednost z idjem #info
      $("#info").html("Vnesi vsa polja!");
    }else{
      // POST request na php_handle/prijavi.php, prijavi.php vrne parameter data
      $.ajax({
          type: "POST",
          url: "php_handle/prijavi.php",
          data:{username:username, password:password},
          success: function(data){
            if(data == 1){
              alert("uspesna prijava");
            }else {
              $("#username").css("border", "1px solid red");
              $("#password").css("border", "1px solid red");
              $("#info").html("Uporabniško ime in geslo se ne ujemata!")
            }
          }
      });
    }
  });
});
