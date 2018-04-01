function changeProfile()
{
	var image = $("#inputImage").val();
	image = image.toLowerCase();
	var parse1 = image.substring(image.length-3);
	var rules = false;
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
	{
		alert("Error");
	}
}

function changePassword()
{
	alert("Change Password");
}
