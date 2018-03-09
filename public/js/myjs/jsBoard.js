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
		var cardId = title;
		$.ajax({
			  type: "POST",
			  url: "board/createCard",
			  data: {title:title,owner:owner},
			  success: function (response) {
				  cardId = response;
				  //alert(cardId);
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
		var satu = '<a id="card'+cardId+'" href="#" class="modal-baru" onclick="">';
		var dua = '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
		var tiga = '<div class="left-align black-text">'+title+'</div>';
		var empat = '</div>';
		var lima = '</a>';
		var gabung = satu+dua+tiga+empat+lima;
		//alert(gabung);
		$("#list"+owner).append(gabung);
		$('#card'+cardId).on('click', function() {
			//alert("klik + "+ cardId +" owner : "+owner);
			//var href = $(this).attr("href");
			$("#modal3").openModal();
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
	$("#hiddenCardId").val(id);
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
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});

	$.ajax({
			  type: "POST",
			  url: "board/getBoardAssignMembers",
			  data: {id:id},
			  dataType:"json",
			  success: function (response) {
				  //alert(response);
				  	$("#assignMembers").empty();
				  $.each(response, function(idx, response){
				  	$("#assignMembers").append("<p>");
				  	if(response.assignStatus == "1")
				  	{
				  		$("#assignMembers").append("<input type='checkbox' id='"+response.userId+"' checked/>");
				  	}
				  	else
				  	{
				  		$("#assignMembers").append("<input type='checkbox' id='"+response.userId+"' />");
				  	}
				  	$("#assignMembers").append("<label class='black-text' for='"+response.userId+"' />"+response.userName+"</label>");
				  	$("#assignMembers").append("</p>");
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
	$.ajax({
			  type: "POST",
			  url: "board/getStartDate",
			  data: {id:id},
			  dataType:"json",
			  success: function (response) {
				  $("#ajaxStartDate").empty();
				  if(response != "")
				  {
				  	$("#ajaxStartDate").append("<h6><b>Start Date</b></h6>");
				  }
				  
				  $.each(response, function(idx, response){
				  	//alert(response.startDate); //2018-03-07 12:00:00
				  	var date = response.startDate;
				  	var pecah = date.split(" ");
				  	var tanggal = pecah[0];
				  	var waktu = pecah[1];
				  	var tanggal2 = tanggal.split("-");
				  	var waktu2 = waktu.split(":");
				  	var tgl = tanggal2[2];
				  	var bln = tanggal2[1];
				  	var jam = waktu2[0];
				  	if(bln == "01")
				  	{
				  		bln = "Jan";
				  	}
				  	else if(bln == "02")
				  	{
				  		bln = "Feb";
				  	}
				  	else if(bln == "03")
				  	{
				  		bln = "Mar";
				  	}
				  	else if(bln == "04")
				  	{
				  		bln = "Apr";
				  	}
				  	else if(bln == "05")
				  	{
				  		bln = "May";
				  	}
				  	else if(bln == "06")
				  	{
				  		bln = "Jun";
				  	}
				  	else if(bln == "07")
				  	{
				  		bln = "Jul";
				  	}
				  	else if(bln == "08")
				  	{	
				  		bln = "Aug";
				  	}
				  	else if(bln == "09")
				  	{
				  		bln = "Sept";
				  	}
				  	else if(bln == "10")
				  	{
				  		bln = "Oct";
				  	}
				  	else if(bln == "11")
				  	{
				  		bln = "Nov";
				  	}
				  	else if(bln == "12")
				  	{
				  		bln = "Dec";
				  	}
				  	$("#ajaxStartDate").append("<p>");
				  	$("#ajaxStartDate").append("<input type='checkbox' id='a2' />");
				  	$("#ajaxStartDate").append("<label for='a2'>"+bln+" "+tgl+" at " +jam+":00</label>");//Feb 26 at 12:00PM
				  	$("#ajaxStartDate").append("</p>");
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});



	$.ajax({
			  type: "POST",
			  url: "board/getChecklist",
			  data: {id:id},
			  dataType:"json",
			  success: function (response) {
			  	$("#ajaxChecklist").empty();
				  $.each(response, function(idx, response){
				  		var luaratas1 = '<div class="col s12 m6 l10 ">';
				  		var header = '<h6><b>'+response.checklistTitle+'</b></h6>';
				  		var progressbar = '<div class="progress"><div class="determinate" style="width: 70%"></div></div>';
				  		//var item ='<p> <input type="checkbox" id="test3" /><label for="test3">Satu</label></p>';
				  		var item ='<div id="checklistItem'+response.checklistId+'"></div>';
				  		var addatas ='<div id="item'+response.checklistId+'">';
				  		var add = '<p><a href="#" onclick="changeInput(\''+response.checklistId+'\')">Add an item</a></p>';
				  		var addbawah ='</div>';
				  		var luaratas2 = '</div>';
				  		var luarbawah1 = '<div class="col s12 m6 l1 ">';
				  		var tengah = '<a href="#">Delete</a>';
				  		var luarbawah2 = '</div>';
				  		var gabung = luaratas1+header+progressbar+item+addatas+add+addbawah+luaratas2+luarbawah1+tengah+luarbawah2;
				  		$("#ajaxChecklist").append(gabung);
				  		
				  		//alert(response.checklistId);
				  		$.ajax({
						  type: "POST",
						  url: "board/getChecklistItem",
						  data: {id:response.checklistId},
						  dataType:"json",
						  success: function (response) {
							  $.each(response, function(idx, response){
							  	//alert(response.itemTitle);
							  		//$("checklistItem"+response.checklistId).empty();
							  		$("#checklistItem"+response.checklistId).append('<p> <input type="checkbox" id="test'+response.itemId+'" /><label for="test'+response.itemId+'">'+response.itemTitle+'</label></p>');
							  		
							  		//$("#checklistItem"+response.checklistId).append("<p>ASDQWE</p>");
							  	});

						  },
						  error: function (xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(thrownError);
							alert(xhr.responseText);
						  }
						});
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});


	/*$.ajax({
			  type: "POST",
			  url: "board/getChecklistItem",
			  data: {id:id},
			  dataType:"json",
			  success: function (response) {
				  $.each(response, function(idx, response){
				  	//alert(response.itemTitle);
				  		//$("checklistItem"+response.checklistId).empty();
				  		//$("#checklistItem"+response.checklistId).append('<p> <input type="checkbox" id="test'+response.itemId+'" /><label for="test'+response.itemId+'">'+response.itemTitle+'</label></p>');
				  		//$("#checklistItem"+response.checklistId).append("<p>ASDQWE</p>");
				  		if($("#checklistItem"+response.checklistId).length)
				  		{
				  			alert(response.checklistTitle);
				  		}
				  	});

			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});*/

	$.ajax({
			  type: "POST",
			  url: "board/getDueDate",
			  data: {id:id},
			  dataType:"json",
			  success: function (response) {
				  $("#ajaxDueDate").empty();
				  if(response != "")
				  {
				  	$("#ajaxDueDate").append("<h6><b>Due Date</b></h6>");
				  }
				  
				  $.each(response, function(idx, response){
				  	//alert(response.startDate); //2018-03-07 12:00:00
				  	var id = response.dueDateId;
				  	var date = response.dueDate;
				  	var pecah = date.split(" ");
				  	var tanggal = pecah[0];
				  	var waktu = pecah[1];
				  	var tanggal2 = tanggal.split("-");
				  	var waktu2 = waktu.split(":");
				  	var tgl = tanggal2[2];
				  	var bln = tanggal2[1];
				  	var jam = waktu2[0];
				  	if(bln == "01")
				  	{
				  		bln = "Jan";
				  	}
				  	else if(bln == "02")
				  	{
				  		bln = "Feb";
				  	}
				  	else if(bln == "03")
				  	{
				  		bln = "Mar";
				  	}
				  	else if(bln == "04")
				  	{
				  		bln = "Apr";
				  	}
				  	else if(bln == "05")
				  	{
				  		bln = "May";
				  	}
				  	else if(bln == "06")
				  	{
				  		bln = "Jun";
				  	}
				  	else if(bln == "07")
				  	{
				  		bln = "Jul";
				  	}
				  	else if(bln == "08")
				  	{	
				  		bln = "Aug";
				  	}
				  	else if(bln == "09")
				  	{
				  		bln = "Sept";
				  	}
				  	else if(bln == "10")
				  	{
				  		bln = "Oct";
				  	}
				  	else if(bln == "11")
				  	{
				  		bln = "Nov";
				  	}
				  	else if(bln == "12")
				  	{
				  		bln = "Dec";
				  	}
				  	$("#ajaxDueDate").append("<p>");
				  	$("#ajaxDueDate").append("<input type='checkbox' id='"+id+"' />");
				  	$("#ajaxDueDate").append("<label for='"+id+"'>"+bln+" "+tgl+" at " +jam+":00</label>");//Feb 26 at 12:00PM
				  	$("#ajaxDueDate").append("</p>");
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
}

function modalStartDate()
{
	var id = $("#hiddenCardId").val();
	var date = $("#startDate").val();
	var time = $("#startDateTime").val();
	var rules = true;
	if(date == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/setStartDate",
			  data: {id:id,date:date,time:time},
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

function modalDueDate()
{
	var id = $("#hiddenCardId").val();
	var date = $("#dueDate").val();
	var time = $("#dueDateTime").val();
	var rules = true;
	if(date == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/setDueDate",
			  data: {id:id,date:date,time:time},
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

function createChecklist()
{
	var id = $("#hiddenCardId").val();
	var title = $("#checklistTitle").val();
	var rules = true;
	if(title == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/createChecklist",
			  data: {id:id,title:title},
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

function hiddenChecklistId(checklistId)
{
	$("#hiddenChecklistId").val(checklistId);
	//alert(checklistId);
}

function changeInput(index)
{
	//mengubah button add menjadi input text
	$("#item"+index).empty();
	$("#item"+index).append('<input type="text" id="text'+index+'" placeholder="Item..">');
	$("#item"+index).append('<a class="btn waves-effect waves-light green" onclick="createChecklistItem(\''+index+'\')" style="margin-right:10px;">Add</a>');
	$("#item"+index).append('<a class="btn-floating waves-effect waves-light" onclick="changeAdd(\''+index+'\')"><i class="mdi-content-clear"></i></a>');

}

function changeAdd(index)
{
	//mengubah input text menjadi button add
	//alert(index);
	var add = '<p><a href="#" onclick="changeInput(\''+index+'\')">Add an item</a></p>';
	$("#item"+index).empty();
	$("#item"+index).append(add);

}

function createChecklistItem(index)
{	
	var id = $("#hiddenCardId").val(); //cardId
	//alert(id);
	var title = $("#text"+index).val(); //index = checklistId
	var rules = true;
	if(title == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/createChecklistItem",
			  data: {id:id,checklistId:index,title:title},
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
	//alert(title);
}

function changeArchive()
{
	var id = $("#hiddenCardId").val();
	var status = "1";
	$.ajax({
			  type: "POST",
			  url: "board/setCardArchive",
			  data: {id:id,status:status},
			  success: function (response) {
				  alert(response);
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
	$("#changeSend").show();
	$("#changeArchive").hide();
}

function changeArchiveMenu(id)
{
	var status = 0;
	$.ajax({
			  type: "POST",
			  url: "board/setCardArchive",
			  data: {id:id,status:status},
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

function changeSend()
{
	$("#changeSend").hide();
	$("#changeArchive").show();
}

function modalArchive()
{
	var boardId = $("#hiddenBoardId").val();
	//alert(boardId);
	$.ajax({
		  type: "POST",
		  url: "board/getCardArchive",
		  data: {},
		  dataType:"json",
		  success: function (response) {
			// alert(response);
			$("#archiveCard").empty();
			$("#archiveCard").append('<p><b>Cards</b></p><div class="divider"></div>');
			  $.each(response, function(idx, response){
			  		if(response.cardBoardId == boardId)
			  		{
			  			//alert(response.cardId);
			  			$("#archiveCard").append('<p style="font-size:100%;"><b>'+response.cardTitle+'</b><a href="#" class="ultra-small green-text" onclick="changeArchiveMenu(\''+response.cardId+'\')" style="margin-left:8px;">Send to Board </a><a href="#" class="ultra-small red-text" style="margin-left:8px;">Delete</a></p>');
			  		}
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}