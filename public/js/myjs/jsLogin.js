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