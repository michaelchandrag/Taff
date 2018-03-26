function createList()
{
	var title = $("#listTitle").val();
	var owner = $("#hiddenBoardId").val();
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
		var cardId = "";
		$.ajax({
			  type: "POST",
			  url: "board/createCard",
			  data: {title:title,owner:owner},
			  success: function (response) {
				cardId = response;
				var gabung2	= '<a id="card'+cardId+'" href="#" class="modal-baru" onclick="ajaxModalCard(\''+cardId+'\')">';
				gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				gabung 		+= '<div class="row" id="labelCard'+cardId+'" style="margin:auto;">';
				gabung 		+= '</div>'
				gabung 		+= '<div class="left-align black-text" id="cardTitle'+response+'">'+title+'</div>';
				gabung 		+= '</div>';
				gabung 		+= '</a>';
				//alert(gabung);
				$("#list"+owner).append(gabung);
				$('#card'+cardId).on('click', function() {
					//alert("klik + "+ cardId +" owner : "+owner);
					//var href = $(this).attr("href");
					$("#modal3").openModal();
				});
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

function updateCardTitle()
{
	var cardId = $("#hiddenCardId").val();
	var cardTitle = $("#txtCardTitle").val();
	$.ajax({
		  type: "POST",
		  url: "board/updateCardTitle",
		  data: {cardId:cardId,cardTitle:cardTitle},
		  success: function (response) {
			 $("#cardTitle"+cardId).text(cardTitle);
			 $("#modalCardTitle").text(cardTitle);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
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
		var cardId = "";
		$.ajax({
			  type: "POST",
			  url: "board/createCard",
			  data: {title:title,owner:owner},
			  success: function (response) {
				 cardId = response;
				var satu = '<a id="card'+cardId+'" href="#" class="modal-baru" onclick="ajaxModalCard(\''+cardId+'\')">';
				var dua = '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				var tiga = '<div class="left-align black-text" id="cardTitle'+response+'">'+title+'</div>';
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
	$("#titleCardManual").val("");
}

function setHiddenListId(id)
{
	$("#hiddenListId").val(id);
	var asd = $("#hiddenListId").val();
	//alert(asd);
}

function ajaxModalCard(id)
{
	$("#hiddenCardId").val(id);
	getBoardCard(id);

	getBoardAssignMembers(id);

	getBoardLabelCard(id);

	getStartDate(id);

	getDueDate(id);

	getChecklist(id);

	getComment(id);
}

function getBoardCard(id)
{
	var id = id;
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
			  	  $("#txtCardTitle").val(response.cardTitle);
			  	  $("#textareaDescription").val("");
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
}

function getBoardAssignMembers(id)
{
	var id = id;
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
}

function getBoardLabelCard(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/getLabelCard",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
			  //alert(response);
			  	$("#labelred").prop("checked",false);
			  	$("#labelyellow").prop("checked",false);
			  	$("#labelgreen").prop("checked",false);
			  	$("#labelblue").prop("checked",false);
			  	$("#ajaxLabelCard").empty();
			  	if(response != "")
			  	{
				  $("#ajaxLabelCard").append("<h6><b>Label</b></h6>");
				}
			  $.each(response, function(idx, response){
			  		if(response.labelRed == "true")
			  		{
			  			$("#labelred").prop("checked",true);
			  			var label = '<div class="red" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
			  			$("#ajaxLabelCard").append(label);
			  		}
			  		if(response.labelYellow == "true")
			  		{
			  			$("#labelyellow").prop("checked",true);
			  			var label = '<div class="yellow" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
			  			$("#ajaxLabelCard").append(label);
			  		}
			  		if(response.labelGreen == "true")
			  		{
			  			$("#labelgreen").prop("checked",true);
			  			var label = '<div class="green" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
			  			$("#ajaxLabelCard").append(label);
			  		}
			  		if(response.labelBlue == "true")
			  		{
			  			$("#labelblue").prop("checked",true);
			  			var label = '<div class="blue" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
			  			$("#ajaxLabelCard").append(label);
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

function getStartDate(id)
{
	var id = id;
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
			  		bln = "Sep";
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
			  	var gabung = "<p>";
			  	gabung += "<input type='checkbox' id='a2' />";
			  	gabung += "<label for='a2'>"+bln+" "+tgl+" at " +jam+":00</label>";
			  	gabung += "</p>";

			  	/*$("#ajaxStartDate").append("<p>");
			  	$("#ajaxStartDate").append("<input type='checkbox' id='a2' />");
			  	$("#ajaxStartDate").append("<label for='a2'>"+bln+" "+tgl+" at " +jam+":00</label>");//Feb 26 at 12:00PM*/
			  	$("#ajaxStartDate").append(gabung);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getDueDate(id)
{
	var id = id;
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

function getChecklist(id)
{
	var id = id;
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
						  		$("#checklistItem"+response.checklistId).append('<p> <input type="checkbox" id="test'+response.itemId+'" /><label for="test'+response.itemId+'">'+response.itemTitle+'</label></p>');
						  		
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
}

function getComment(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/getComment",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
			  //alert(response);
			  $("#ajaxComment").empty();
			  $.each(response, function(idx, response){
			  		var gabung = "";
			  		gabung  +=	'<div class="row">';
					gabung  +=		'<div class="col s12 m4 l1">';
					gabung  +=			'<img src="images/user/gerrard.png" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
					gabung  +=		'</div>';
					gabung  +=		'<div class="col s12 m4 l11">';
					gabung  +=			'<p style="margin-top:-3px;">';
					gabung  +=				'<b><u>Steven Gerrard</u></b>';
					gabung  +=			'</p>';
					gabung  +=			'<p style="margin-top:-13px;">'+response.commentText+'</p>';
					gabung  +=			'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
					gabung  +=				'yesterday at 8:17 PM - <a href="#" onclick="changeReply(\''+response.commentId+'\')"><u>Reply</u></a> - <a href="#"><u>Edit</u></a> - <a href="javascript:void(0)"><u>Delete</u></a>' ;
					gabung  +=			'</p>';
					gabung	+=			'<div id="ajaxReplyComment'+response.commentId+'">';
					gabung 	+= 				'<div class="col s12 m6 l12" id="changeReply'+response.commentId+'">';
					gabung 	+= 				'</div>';
					gabung 	+=			'</div>';
					gabung  +=		'</div>';
					gabung  +=	'</div>';
					$("#ajaxComment").append(gabung);

					$.ajax({
					  type: "POST",
					  url: "board/getReplyComment",
					  data: {commentId:response.commentId},
					  dataType:"json",
					  success: function (response) {
						  //alert(response);
						  $("#ajaxReplyComment"+response.commentId).empty();
						  $.each(response, function(idx, response){
						  		var gabung2 = "";
								gabung2  +=	'<div class="col s12 m4 l1">';
								gabung2  +=		'<img src="images/user/gerrard.png" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
								gabung2  +=	'</div>';
								gabung2  +=	'<div class="col s12 m4 l11">';
								gabung2  +=		'<p style="margin-top:-3px;">';
								gabung2  +=			'<b><u>Steven Gerrard</u></b>';
								gabung2  +=		'</p>';
								gabung2  +=		'<p style="margin-top:-13px;">'+response.replyText+'</p>';
								gabung2  +=		'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
								gabung2  +=			'yesterday at 8:17 PM - <a href="#"><u>Edit</u></a> - <a href="#"><u>Delete</u></a>' ;
								gabung2  +=		'</p>';
								gabung2  +=	'</div>';
								$("#ajaxReplyComment"+response.commentId).append(gabung2);
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
}

function modalStartDate()
{
	var id = $("#hiddenCardId").val();
	var date = $("#startDate").val(); // 8 March, 2018 --> Mar 08 at  18:00
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
				  //alert(response);
				  $("#ajaxStartDate").empty();
				  $("#ajaxStartDate").append("<h6><b>Start Date</b></h6>");
				  var pecah = date.split(" ");
				  var tgl = pecah[0];
				  var bln = pecah[1].substr(0,3);
				  var jam = time;
				  var gabung = "<p>";
				  gabung += "<input type='checkbox' id='a2' />";
				  gabung += "<label for='a2'>"+bln+" "+tgl+" at " +jam+":00</label>";
				  gabung += "</p>";
				  $("#ajaxStartDate").append(gabung);
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
				  $("#ajaxDueDate").empty();
				  $("#ajaxDueDate").append("<h6><b>Due Date</b></h6>");
				  var pecah = date.split(" ");
				  var tgl = pecah[0];
				  var bln = pecah[1].substr(0,3);
				  var jam = time;
				  var gabung = "<p>";
				  gabung += "<input type='checkbox' id='a2' />";
				  gabung += "<label for='a2'>"+bln+" "+tgl+" at " +jam+":00</label>";
				  gabung += "</p>";
				  $("#ajaxDueDate").append(gabung);
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
				  //alert(response);
				  var luaratas1 = '<div class="col s12 m6 l10 ">';
			  	  var header = '<h6><b>'+title+'</b></h6>';
			  	  var progressbar = '<div class="progress"><div class="determinate" style="width: 70%"></div></div>';
			  	  var item ='<div id="checklistItem'+response+'"></div>';
			      var addatas ='<div id="item'+response+'">';
			  	  var add = '<p><a href="#" onclick="changeInput(\''+response+'\')">Add an item</a></p>';
			  	  var addbawah ='</div>';
			  	  var luaratas2 = '</div>';
			  	  var luarbawah1 = '<div class="col s12 m6 l1 ">';
			      var tengah = '<a href="#">Delete</a>';
			  	  var luarbawah2 = '</div>';
			  	  var gabung = luaratas1+header+progressbar+item+addatas+add+addbawah+luaratas2+luarbawah1+tengah+luarbawah2;
			  	  $("#ajaxChecklist").append(gabung);
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
	$("#item"+index).append('<input type="text" id="text'+index+'" placeholder="Item.." style="margin-bottom:2px;">');
	$("#item"+index).append('<a class="btn waves-effect waves-light green" onclick="createChecklistItem(\''+index+'\')" style="margin-right:10px;margin-bottom:2px;">Add</a>');
	$("#item"+index).append('<a class="btn-floating waves-effect waves-light" style="margin-bottom:2px;" onclick="changeAdd(\''+index+'\')"><i class="mdi-content-clear"></i></a>');

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
				  $("#checklistItem"+index).append('<p> <input type="checkbox" id="test'+response+'" /><label for="test'+response+'">'+title+'</label></p>');
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

function createCardComment()
{
	var boardId = $("#hiddenBoardId").val();
	var cardId = $("#hiddenCardId").val();
	var text = $("#textareaComment").val();
	$.ajax({
	  type: "POST",
	  url: "board/createComment",
	  data: {boardId:boardId,cardId:cardId,text:text},
	  success: function (response) {
		alert(response);
		var gabung = "";
  		gabung  +=	'<div class="row">';
		gabung  +=		'<div class="col s12 m4 l1">';
		gabung  +=			'<img src="images/user/gerrard.png" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
		gabung  +=		'</div>';
		gabung  +=		'<div class="col s12 m4 l11">';
		gabung  +=			'<p style="margin-top:-3px;">';
		gabung  +=				'<b><u>Steven Gerrard</u></b>';
		gabung  +=			'</p>';
		gabung  +=			'<p style="margin-top:-13px;">'+text+'</p>';
		gabung  +=			'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
		gabung  +=				'yesterday at 8:17 PM - <a href="#" onclick="changeReply(\''+response+'\')"><u>Reply</u></a> - <a href="#"><u>Edit</u></a> - <a href="javascript:void(0)"><u>Delete</u></a>' ;
		gabung  +=			'</p>';
		gabung	+=			'<div id="ajaxReplyComment'+response+'">';
		gabung 	+= 				'<div class="col s12 m6 l12" id="changeReply'+response+'">';
		gabung 	+= 				'</div>';
		gabung 	+=			'</div>';
		gabung  +=		'</div>';
		gabung  +=	'</div>';
		$("#ajaxComment").append(gabung);
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
}

function createCardReply(id)
{
	var boardId = $("#hiddenBoardId").val();
	var cardId = $("#hiddenCardId").val();
	var commentId = id;
	var text = $("#textareaReply"+id).val();
	$.ajax({
	  type: "POST",
	  url: "board/createReplyComment",
	  data: {commentId:commentId,boardId:boardId,cardId:cardId,text:text},
	  success: function (response) {
		//alert(response);
		var gabung2 = "";
		gabung2  +=	'<div class="col s12 m4 l1">';
		gabung2  +=		'<img src="images/user/gerrard.png" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
		gabung2  +=	'</div>';
		gabung2  +=	'<div class="col s12 m4 l11">';
		gabung2  +=		'<p style="margin-top:-3px;">';
		gabung2  +=			'<b><u>Steven Gerrard</u></b>';
		gabung2  +=		'</p>';
		gabung2  +=		'<p style="margin-top:-13px;">'+text+'</p>';
		gabung2  +=		'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
		gabung2  +=			'yesterday at 8:17 PM - <a href="#"><u>Edit</u></a> - <a href="#"><u>Delete</u></a>' ;
		gabung2  +=		'</p>';
		gabung2  +=	'</div>';
		$("#ajaxReplyComment"+commentId).append(gabung2);
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
}

function changeReply(id)
{
	$("#changeReply"+id).empty();
	var gabung ="";
	gabung 	+= 					'<textarea id="textareaReply'+id+'" class="materialize-textarea" ></textarea>';
	gabung	+= 					'<a class="btn waves-effect waves-light green" onclick="createCardReply(\''+id+'\')" style="margin-right:10px;">Add</a>';
	gabung	+= 					'<a class="btn-floating waves-effect waves-light" onclick="closeReply(\''+id+'\')" ><i class="mdi-content-clear"></i></a>';
	$("#changeReply"+id).append(gabung);
}

function closeReply(id)
{
	$("#changeReply"+id).empty();
}

function createChat()
{
	var boardId = $("#hiddenBoardId").val();
	var chatText = $("#chatText").val();
	var rules = true;
	if(chatText == "")
	{
		rules = false;
	}
	if(rules == true)
	{
		$.ajax({
		  type: "POST",
		  url: "board/createChat",
		  data: {boardId:boardId,chatText:chatText},
		  success: function (response) {
			alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
		$("#chatText").val("");
	}
	else
	{
		alert("Error");
	}

}

function createLabelCard()
{
	var boardId 	= $("#hiddenBoardId").val();
	var cardId 		= $("#hiddenCardId").val();
	var red 		= $("#labelred").is(":checked");
	var yellow 		= $("#labelyellow").is(":checked");
	var green 		= $("#labelgreen").is(":checked");
	var blue 		= $("#labelblue").is(":checked");
	$.ajax({
		  type: "POST",
		  url: "board/createLabelCard",
		  data: {boardId:boardId,cardId:cardId,red:red,yellow:yellow,green:green,blue:blue},
		  success: function (response) {
			//alert(response);
			var show = false;
			if(red == true || yellow == true || green == true || blue == true)
			{
				show = true;
			}
			if(show == true)
			{
				$("#ajaxLabelCard").empty();
				$("#ajaxLabelCard").append("<h6><b>Label</b></h6>");
				$("#labelCard"+cardId).empty();
				if(red == true)
				{
					$("#labelred").prop("checked",true);
		  			var label = '<div class="red" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
		  			$("#ajaxLabelCard").append(label);
		  			var divlabel = '<div class="task-cat red left-align red-text" style="width:45%;float:left;margin:2px;">';
		  			divlabel+= "Blank Text";
		  			divlabel+= "</div>";
		  			$("#labelCard"+cardId).append(divlabel);
				}
				if(yellow == true)
				{
					$("#labelyellow").prop("checked",true);
		  			var label = '<div class="yellow" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
		  			$("#ajaxLabelCard").append(label);
		  			var divlabel = '<div class="task-cat yellow left-align yellow-text" style="width:45%;float:left;margin:2px;">';
		  			divlabel+= "Blank Text";
		  			divlabel+= "</div>";
		  			$("#labelCard"+cardId).append(divlabel);
				}
				if(green == true)
				{
					$("#labelgreen").prop("checked",true);
		  			var label = '<div class="green" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
		  			$("#ajaxLabelCard").append(label);
		  			var divlabel = '<div class="task-cat green left-align green-text" style="width:45%;float:left;margin:2px;">';
		  			divlabel+= "Blank Text";
		  			divlabel+= "</div>";
		  			$("#labelCard"+cardId).append(divlabel);
				}
				if(blue == true)
				{
					$("#labelblue").prop("checked",true);
		  			var label = '<div class="blue" style="width:28px;height:28px;border-radius:15%;margin:1px;float:left;"></div>';
		  			$("#ajaxLabelCard").append(label);
		  			var divlabel = '<div class="task-cat blue left-align blue-text" style="width:45%;float:left;margin:2px;">';
		  			divlabel+= "Blank Text";
		  			divlabel+= "</div>";
		  			$("#labelCard"+cardId).append(divlabel);
				}

			}
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

$(document).keypress(function(e) {
    if(e.which == 13) {
        createChat();
    }
});

//var myVar = setInterval(function(){ myTimer() }, 1000);

function myTimer() {
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getChat",
		  data: {boardId:boardId},
		  dataType :"json",
		  success: function (response) {
			//alert(response);
			$("#ajaxChat").empty();
			$.each(response, function(idx, response){
			  		var gabung = "";
			  		gabung += '<div class="favorite-associate-list chat-out-list row">';
                    gabung +=     '<div class="col s4"><img src="images/user/user2.png" alt="" class="circle responsive-img online-user valign profile-image">';
                    gabung +=     '</div>';
                    gabung +=     '<div class="col s8">';
                    gabung +=         '<p>'+response.userId+'</p>';
                    gabung +=        '<p class="place black-text">'+response.chatText+'</p>';
                    gabung +=         '<p class="ultra-small grey-text lighten-3">just now</p>';
                    gabung +=     '</div>';
                    gabung += '</div>';
                    $("#ajaxChat").append(gabung);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}