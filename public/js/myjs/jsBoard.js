function createList()
{
	var title = $("#listTitle").val();
	var owner = $("#hiddenListId").val();
	var rules = true;
	if(title == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/createList",
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

function createCard()
{
	var title = $("#titleCard").val();
	var owner = $("#hiddenListId").val();
	var rules = true;
	if(title == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/createCard",
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

function createCardDua()
{
	var title = $("#titleCardManual").val();
	var owner = $("#listCardManual").val();
	var rules = true;
	if(title == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/createCard",
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

function hiddenListId(id)
{
	$("#hiddenListId").val(id);
	var asd = $("#hiddenListId").val();
	//alert(asd);
}

function ajaxModalCard(id)
{
	$.ajax({
			  type: "POST",
			  url: "board/getBoardCard",
			  data: {id:id},
			  dataType:"json",
			  success: function (response) {
				  //alert("response");
				  $.each(response, function(idx, response){
				  	  $("#modalCardTitle").text(response.cardTitle);
				  	  $("#modalListTitle").text("in list "+response.listTitle);
				  	  if(response.cardDescription == "null")
				  	  {
				  	  	$("#modalCardDescription").text("Harusnya ada deskripsi ini.. tapi gak ada");
				  	  }
				  	  else
				  	  {
				  	  	$("#modalCardDescription").text(response.cardDescription);
				  	  }
				      // picture.pic_location
				      // picture.name
				      // picture.age
				      // picture.gender
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
}
