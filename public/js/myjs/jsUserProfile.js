function changeProfile()
{
	var image = $("#inputImage").val();
	image = image.toLowerCase();
	var parse1 = image.substring(image.length-3);
	var rules = false;
	$("#errorImage").hide();
	if(parse1 == "jpg" || parse1 == "png")
	{
		rules = true;
	}
	if(rules == true)
	{
		var userId = $("#hiddenUserId").val();
		var file_data1 = $('#inputImage').prop('files')[0];

		var form_data = new FormData();
		form_data.append('file1', file_data1);
		form_data.append('userId',userId);

		$.ajax({
			  	url: 'userProfile/submitImage', // point to server-side PHP script
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
			  success: function (response) {
			  	var d = new Date();
				  $("#userImage").attr("src",response+"?"+d.getTime());
				  $("#visitUserImage").attr("src",response+"?"+d.getTime());
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});

	}
	else
		$("#errorImage").show();
}

function changePassword()
{
	//newpass
	//confpass
	var userId = $("#hiddenUserId").val();
	var pass = $("#newpass").val();
	var cpass = $("#confpass").val();
	var rules = false;
	$("#errorChangePassword").hide();
	if(pass.length > 1 && (pass==cpass))
	{
		rules = true;
	}
	if(rules == true)
	{
		alert(userId);
		$.ajax({
		  type: "POST",
		  url: "userprofile/changePassword",
		  data:{userId:userId,userPassword:pass},
		  success: function (response) {
		  	alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	}
	else
		$("#errorChangePassword").show();
}


function cekLogout()
{
	$.ajax({
		  type: "POST",
		  url: "login/logout",
		  success: function (response) {
			  //alert(response);
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

function changeData()
{
	$("#errorName").hide();
	var userId = $("#hiddenUserId").val();
	var userName = $("#userName").val();
	var userBio = $("#userBio").val();
	var userLocation = $("#userLocation").val();
	var userMale = $("#rmale").is(":checked");
	var userFemale = $("#rfemale").is(":checked");
	var userGender = "";
	if(userMale == true && userFemale == false)
		userGender = "Male";
	else if(userMale == false && userFemale == true)
		userGender = "Female";
	var rules = false;
	if(userName.length > 1)
		rules = true;
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "userprofile/changeData",
			  data:{userId:userId,userName:userName,userBio:userBio,userLocation:userLocation,userGender:userGender},
			  success: function (response) {
			  	$("#visitUserBio").empty();
				  $("#visitUserBio").append("<b><u>Bio</u></b></br>");
				  $("#visitUserBio").append(userBio+"</br></br>");
				  $("#visitUserBio").append("<b><u>Location</u></b></br>");
				  $("#visitUserBio").append(userLocation+"<br></br>");
				  $("#visitUserBio").append("<b><u>Gender</u></b></br>");
				  $("#visitUserBio").append(userGender+"</br></br>");
				  $("#visitUserName").text(userName);

			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
	}
	else
		$("#errorName").show();
}

function findBoards()
{
	var text = $("#txtFindBoards").val();
	if(text != "")
	{
		window.location.href="home?find="+text;
	}
}


$(document).ready(function() {
    $(document).keypress(function(e) {
	    if(e.which == 13) {
	        if($("#txtFindBoards").is(":focus"))
	        {
	        	findBoards();
	        }
	    }
	});
});