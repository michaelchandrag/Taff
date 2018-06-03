function cekRegister()
{
	var name = $("#name").val();
	var email = $("#email").val();
	var password = $("#password").val();
	var confpassword = $("#confpassword").val();
	var rules = true;
	$("#errorName").hide();
	$("#errorEmail").hide();
	$("#errorPass").hide();
	$("#errorcPass").hide();
	if(name.length < 3 || isEmail(email) == false || password < 6 || confpassword < 6)
	{
		rules = false;
		if(password != confpassword)
		{
			rules = false;
		}
	}
	if(rules)
	{
		$.ajax({
		  type: "POST",
		  url: "register/register",
		  data: {name:name,email:email,password:password},
		  success: function (response) {
			  //alert(response);
			  if(response == "Berhasil")
			  {
			  	window.location.href = "login";
			  }
			  else
			  {
			  	$("#errorEmail").show();
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
		if(name == "" || name.length < 5)
		{
			$("#errorName").show();
		}
		if(password == "")
		{
			$("#errorPass").show();
		}
		if(confpassword != password || confpassword == "")
		{
			$("#errorcPass").show();
		}
		if(isEmail(email) == false)
		{
			$("#errorEmail").show();
		}
	}

}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
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
		  //alert(response);
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