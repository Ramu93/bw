function login(){

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var data = "username="+username+"&password="+password+"&action=login";
    $.ajax({
            url: "loginservices.php",
            type: "POST",
            data:  data,
            dataType: 'json',
            success: function(result){
              if(result.infocode == "LOGINSUCCESS"){
                window.location.href = result.message;
              } else {
                bootbox.alert(result.message);
              }
            },
            error: function(){
              bootbox.alert(result.message);}           
          });
  }