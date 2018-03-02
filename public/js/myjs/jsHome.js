function createBoard()
{
	var title = $("#boardTitle").val();
	var owner = $("#hiddenOwnerId").val();
	//alert(owner);
	var rules = true;
	if(title == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "home/createBoard",
			  data: {title:title,owner:owner},
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
	{
		alert("Error");
	}

}

function createGroup()
{
	var name = $("#groupName").val();
	var rules = true;
	if(name == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "home/createGroup",
			  data: {name:name},
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
	{
		alert("Error");
	}

}

function hiddenGroupId(id)
{
	$("#hiddenOwnerId").val(id);
	var asd = $("#hiddenOwnerId").val();
	//alert(asd);
}
