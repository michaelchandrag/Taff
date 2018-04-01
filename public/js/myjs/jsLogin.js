function cekLogin()
{
	var email = $("#email").val();
	var password = $("#password").val();
	var remember = "false";
	if ($('#remember').is(":checked"))
	{
		remember = "true";
	  // it is checked
	}
	var rules = true;
	if(email == "" || password == "")
	{
		rules = false;
	}
	if(rules == true)
	{
	  $.ajax({
			  type: "POST",
			  url: "login/login",
			  data: {email:email,password:password,remember:remember},
			  success: function (response) {
				  alert(response);
				  if(response == "Berhasil")
				  {
				 	window.location.href = "home";

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
		alert("Error");
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


function onSuccess(googleUser) {
  var profile = googleUser.getBasicProfile();
  var name = profile.getName();
  var email = profile.getEmail();
  var image = profile.getImageUrl();
  var password = email;
  var remember = "true";
  $.ajax({
	  type: "POST",
	  url: "login/googleLogin",
	  data: {name:name,email:email,password:password,image:image,remember:remember},
	  success: function (response) {
		  alert(response);
		  if(response == "Berhasil")
		  {

		  }
		  	googleUser.disconnect();
		 	window.location.href = "home";
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
}

function onFailure(error) {
  //alert("Error");
}

function renderButton() {
  gapi.signin2.render('my-signin2', {
    'scope': 'profile email',
    'width': 240,
    'height': 50,
    'longtitle': true,
    'theme': 'dark',
    'onsuccess': onSuccess,
    'onfailure': onFailure
  });
}

/*function onLoad() {
  gapi.load('auth2', function() {
    gapi.auth2.init();
  });
}*/