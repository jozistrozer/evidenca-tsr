$(document).ready(function() {
    $("#btnOdjava").click(function(){
         $.ajax({
          type: "POST",
          url: "php/odjavi.php",
          success: function(data){
              window.location.href = '../index.html';
          }
      });
    });
});