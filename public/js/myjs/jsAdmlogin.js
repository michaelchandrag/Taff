function cekLogin()
{
    var email = $("#email").val();
    var password = $("#password").val();
    $("#errorEmail").hide();
    $("#errorPass").hide();
    $("#errorLogin").hide();
    var rules = true;
    if(email == "" || password == "")
    {
        rules = false;
    }
    if(rules == true)
    {
      $.ajax({
              type: "POST",
              url: "admlogin/routingLogin",
              data: {email:email,password:password},
              success: function (response) {
                  //alert(response);
                  if(response == "true")
                  {
                    window.location.href = "muser";
                    //alert(response);
                  }
                  else
                  {
                    //$("#errorLogin").show();
                  }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
                alert(xhr.responseText);
              }
            });
    }
    else
    {
        if(email.length < 1)
            $("#errorEmail").show();
        if(password.length < 1)
            $("#errorPass").show();
    }
}

function cekLogout()
{
    $.ajax({
          type: "POST",
          url: "login/logout",
          success: function (response) {
              alert(response);
              if(response == "Berhasil")
              {
                /*var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                  console.log('User signed out.');
                });*/
                window.location.href = "login";

              }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}