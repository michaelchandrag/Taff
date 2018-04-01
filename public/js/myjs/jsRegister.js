function cekRegister()
{
	var name = $("#name").val();
	var email = $("#email").val();
	var password = $("#password").val();
	var confpassword = $("#confpassword").val();
	var rules = true;
	if(name == "" || email == "" || password == "" || confpassword == "")
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
	else
	{
		alert("Error");
	}

}