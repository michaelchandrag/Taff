/*$("#section").sortable();

$( ".listUserDrag" ).draggable({
	containment:"#main"
});
*/

function bindUiList()
{

	$( ".sortable" ).sortable({
		appendTo:"body",
		dropOnEmpty:"false",
		stop : function (e,ui)
		 {
		 	//alert();
		 },
		 change : function(e,ui)
		 {
		 	ui.placeholder.css({visibility: 'visible', border : '1px solid black'});
		 }
	});
	$( "#card-stats" ).sortable({
		appendTo:"body",
		dropOnEmpty:"false",
		cancel: "#listCreateList",
		 update : function(e,ui)
		 {
		 	ui.placeholder.css({visibility: 'visible', border : '1px solid black'});
		 	var boardId = $("#hiddenBoardId").val();
		 	var kids = $("#card-stats").children();
		 	var listId = ui.item.attr("id").substr(7);
		 	var posTujuan = 1;
		 	var pojok = false;
		 	for(var i=0;i<kids.length;i++)
		 	{
		 		if($(kids[i]).is(ui.item))
		 		{
		 			posTujuan = i+1;
		 		}
		 	}
		 	if(posTujuan == kids.length)
		 	{
		 		posTujuan = kids.length-1;
		 		pojok = true;
		 	}
		 	$.ajax({
			  type: "POST",
			  url: "board/sortListPosition",
			  data: {boardId:boardId,listId:listId,posTujuan:posTujuan},
			  success: function (response) {
			  		if(pojok == true)
			  		{
			  			$(ui.item).insertBefore("#listCreateList");
			  		}
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					alert(xhr.responseText);
				  }
				});

		 }
	});
$("#card-stats").disableSelection();

}

function bindUiCard()
{
	$( ".dragable" ).draggable({
		appendTo :"body",
		helper:"clone",
		grid: [1, 1],
		revert:false,
		connectToSortable:".sortable",
		start: function(e, ui)
		 {
		  var draggableId = e.target.id;
		  var width = $("#"+draggableId).css("width");
		  var height = $("#"+draggableId).css("height");
		 	$(ui.helper).css("width",width);
		  $(ui.helper).css("height",height);
		 },
		 stop : function (e,ui)
		 {
		  var draggableId = e.target.id;
		  //$("#"+draggableId+":eq(0)").remove();
		  var asd = (ui.helper).parent();
		  var id = asd.attr("id");
		  var banyak = $(".listUser").length;
		  var kids = $("#"+id).children();
		  for(var i=0;i<kids.length;i++)
		  {
		  	if($(kids[i]).is(ui.helper))
		  	{
		  		var selectId = id.substr(4);
		  		var cardId = draggableId.substr(5);
		  		var pos = i+1;
		  		if(pos >= kids.length)
		  		{
		  			pos = kids.length-1;
		  		}
		  		$.ajax({
						  type: "POST",
						  url: "board/updateCardPosition",
						  data: {cardId:cardId,listSelect:selectId,position:pos},
						  success: function (response) {
								location.reload();
					  		},
					  error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						alert(xhr.responseText);
					  }
					});
		  	}
		  }
		 }
	});
}

$( ".sortable" ).sortable({
	appendTo:"body",
	dropOnEmpty:"false",
	stop : function (e,ui)
	 {
	 	//alert();
	 },
	 change : function(e,ui)
	 {
	 	ui.placeholder.css({visibility: 'visible', border : '1px solid black'});
	 }
});

$( "#card-stats" ).sortable({
	appendTo:"body",
	dropOnEmpty:"false",
	cancel: "#listCreateList",
	 update : function(e,ui)
	 {
	 	ui.placeholder.css({visibility: 'visible', border : '1px solid black'});
	 	var boardId = $("#hiddenBoardId").val();
	 	var kids = $("#card-stats").children();
	 	var listId = ui.item.attr("id").substr(7);
	 	var posTujuan = 1;
	 	var pojok = false;
	 	for(var i=0;i<kids.length;i++)
	 	{
	 		if($(kids[i]).is(ui.item))
	 		{
	 			posTujuan = i+1;
	 		}
	 	}
	 	if(posTujuan == kids.length)
	 	{
	 		posTujuan = kids.length-1;
	 		pojok = true;
	 	}
	 	$.ajax({
		  type: "POST",
		  url: "board/sortListPosition",
		  data: {boardId:boardId,listId:listId,posTujuan:posTujuan},
		  success: function (response) {
		  		if(pojok == true)
		  		{
		  			$(ui.item).insertBefore("#listCreateList");
		  		}
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});

	 }
});
$("#card-stats").disableSelection();
$( ".dragable" ).draggable({
	appendTo :"body",
	helper:"clone",
	grid: [1, 1],
	revert:false,
	connectToSortable:".sortable",
	start: function(e, ui)
	 {
	  var draggableId = e.target.id;
	  var width = $("#"+draggableId).css("width");
	  var height = $("#"+draggableId).css("height");
	 	$(ui.helper).css("width",width);
	  $(ui.helper).css("height",height);
	 },
	 stop : function (e,ui)
	 {

	  var draggableId = e.target.id;
	  //$("#"+draggableId+":eq(0)").remove();
	  var asd = (ui.helper).parent();
	  var id = asd.attr("id");
	  var banyak = $(".listUser").length;
	  var kids = $("#"+id).children();
	  for(var i=0;i<kids.length;i++)
	  {
	  	if($(kids[i]).is(ui.helper))
	  	{
	  		var selectId = id.substr(4);
	  		var cardId = draggableId.substr(5);
	  		var pos = i+1;
	  		if(pos >= kids.length)
	  		{
	  			pos = kids.length-1;
	  		}
	  		$.ajax({
					  type: "POST",
					  url: "board/updateCardPosition",
					  data: {cardId:cardId,listSelect:selectId,position:pos},
					  success: function (response) {

							$(ui.helper).replaceWith($("#"+draggableId));
							$(ui.helper).remove();
				  		},
				  error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					alert(xhr.responseText);
				  }
				});
	  	}
	  }
	 }
});


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
			//alert(response);
			var rowList = $('div.ajaxList').length;
			var listUser = $('div.listUser').length;
			//$("#listCreateList").remove();
			var gabung = "";
			gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+response+'">';
			gabung += '<div class="card">';
			gabung += '<div class="card-content grey lighten-2 white-text">';
			gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+response+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
			gabung += '<div id="list'+response+'" class="listUser dropable sortable" style="height:100%;min-height:60px;width:100%;">';
			gabung += '</div>';
			gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
			gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+response+'\')">Add a Card..</a></div>';
			gabung += '</div>';
			gabung += '</div>';
			gabung += '</div>';
			gabung += '</div>';
			$(gabung).insertBefore($("#listCreateList"));
			bindUiList();
			bindUiCard();
			$('#listCreateList').prop('onclick',null).off('click');
			$('#listCreateList').on('click', function() {
				//alert("klik + "+ cardId +" owner : "+owner);
				//var href = $(this).attr("href");
				$("#modalcreatelist").openModal();
			});
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
		$("#listTitle").val("");

	}
	else
	{
		alert("Error");
	}

}


$('#listCreateList').prop('onclick',null).off('click');
$('#listCreateList').on('click', function() {
		//alert("klik + "+ cardId +" owner : "+owner);
		//var href = $(this).attr("href");
		$("#modalcreatelist").openModal();
	});

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
				var gabung = '<div class="dragable cDrag'+cardId+' cardUser'+owner+'" id="cDrag'+cardId+'" style="width:100%;height:100%;">';
				gabung		+= '<a id="card'+cardId+'" href="javascript:void(0);" class="cardUser'+owner+'" onclick="ajaxModalCard(\''+cardId+'\')">';
				gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				gabung 		+= '<div class="row" id="labelCard'+cardId+'" style="margin:auto;">';
				gabung 		+= '</div>'
				gabung 		+= '<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'+response+'">'+title+'</div>';
				gabung 		+= '</div>';
				gabung 		+= '</a>';
				gabung 		+= '</div>';
				//alert(gabung);
				$("#list"+owner).append(gabung);
				bindUiCard();
				$("#titleCard").val("");
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
			 $("#txtCardTitle").val("");
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function updateCardDescription()
{
	var cardId 		= $("#hiddenCardId").val();
	var description = $("#textareaDescription").val();
	$.ajax({
		  type: "POST",
		  url: "board/updateCardDescription",
		  data: {cardId:cardId,cardDescription:description},
		  success: function (response) {
		  	$("#modalCardDescription").text(description);
		  	$("textareaDescription").text(description);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

	/*
	$("#textareaDescription").val("");
  	$("#modalCardDescription").text(response.cardDescription);
	*/
	//var cardDescription = $("#textareaDescription").text();

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
				 var gabung = '<div class="dragable cDrag'+cardId+' cardUser'+owner+'" id="cDrag'+cardId+'" style="width:100%;height:100%;">';
				gabung += '<a id="card'+response+'" href="javascript:void(0)" class="cardUser'+owner+'" onclick="ajaxModalCard(\''+response+'\')">';
				gabung += '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				gabung += "<div class='row' id='labelCard"+response+"' style='margin:auto;'>";
				gabung += "</div>";
				gabung += '<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'+response+'">'+title+'</div>';
				gabung += '</div>';
				gabung += '</a>';
				gabung += '</div>';
				//alert(gabung);
				$("#list"+owner).append(gabung);
				bindUiCard();
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

function openModalCopy()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getMoveCard",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  //alert("response");
			  $("#copyCardList").empty();
			  var gabung = "";
			    gabung += "<option value=0 disabled selected>Choose a list</option>";
			    $("#copyCardList").append(gabung);
			  $.each(response, function(idx, response){
			  	if(response.listStatus == "1" && response.listArchive == "0")
			  	{

				  	var gabung = "";
				    gabung += "<option value='"+response.listId+"'>"+response.listTitle+"</option>";
				    $("#copyCardList").append(gabung);
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

function setCopyCard()
{
	var cardId = $("#hiddenCardId").val();
	createCopyCard(cardId);
}

function createCopyCard(id)
{
	var cardId = id; //cardId
	var boardId = $("#hiddenBoardId").val();
	var title = $("#copyCardTitle").val();
	var listId = $("#copyCardList").val();
	var rules = false;
	if(title != "" && listId != null )
	{
		rules = true;
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "board/copyCard",
			  data: {cardId:cardId,boardId:boardId,title:title,listId:listId},
			  success: function (response) {
			  	//alert(response);
			  	  var label = getLabelCard(cardId);
				  var labelRed = false;
				  var labelYellow = false;
				  var labelBlue = false;
				  var labelGreen = false;
				  $.each(label, function(idx, response){
					  	if(response.labelRed == "true")
					  	{
					  		labelRed = true;
					  	}
					  	if(response.labelYellow == "true")
					  	{
					  		labelYellow = true;
					  	}
					  	if(response.labelGreen == "true")
					  	{
					  		labelGreen = true;
					  	}
					  	if(response.labelBlue == "true")
					  	{
					  		labelBlue = true;
					  	}
				    });
				  gabung 		= '<div class="dragable cDrag'+response+' cardUser'+listId+'" id="cDrag'+response+'" style="width:100%;height:100%;">'; 
				  gabung		+= '<a id="card'+response+'" href="javascript:void(0);" class="cardUser'+listId+'" onclick="ajaxModalCard(\''+response+'\')">';
				  gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				  gabung 		+= '<div class="row" id="labelCard'+response+'" style="margin:auto;">';
				  if(labelRed)
				  {
				  	gabung+= '<div class="task-cat red left-align red-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelYellow)
				  {
				  	gabung+= '<div class="task-cat yellow left-align yellow-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelBlue)
				  {
				  	gabung+= '<div class="task-cat blue left-align blue-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelGreen)
				  {
				  	gabung+= '<div class="task-cat green left-align green-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  gabung 		+= '</div>'
				  gabung 		+= '<div class="left-align black-text" id="cardTitle'+listId+'">'+title+'</div>';
				  gabung 		+= '</div>';
				  gabung 		+= '</a>';
				  $("#list"+listId).append(gabung);
				  bindUiCard();
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

function openModalListAddCard()
{
	var id = $("#hiddenListId").val();
	setHiddenListId(id);
}

function setHiddenListId(id)
{
	$("#hiddenListId").val(id);
	var asd = $("#hiddenListId").val();
	$("#modalcreatecard").openModal();
	//alert(asd);
}

function openModalListMoveAllCard()
{
	var boardId = $("#hiddenBoardId").val();
	var listId = $("#hiddenListId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getMoveCard",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  //alert("response");
			  $("#selectAllCardList").empty();
			  	var gabung = "";
			    gabung += "<option value=0 disabled selected>Choose a list</option>";
			    $("#selectAllCardList").append(gabung);
			  	$.each(response, function(idx, response){
			  	if(response.listStatus == "1" && response.listArchive == "0" && response.listId != listId)
			  	{
				  	var gabung = "";
				    gabung += "<option value='"+response.listId+"'>"+response.listTitle+"</option>";
				    $("#selectAllCardList").append(gabung);
			  	}
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	$("#modalmovecardlist").openModal();
}

function openModalListCopyList()
{
	$("#modalcopylist").openModal();
}

function createCopyList()
{
	var owner = $("#hiddenBoardId").val();
	var boardId = owner;
	var listId = $("#hiddenListId").val();
	var title = $("#copyListTitle").val();
	var jumlahList = $(".colListUser").length;
	//alert(jumlahList);
	var posTujuan = jumlahList+1;
	var listTujuan = "";
	var rules = false;
	if(title != "")
	{
		rules = true;
	}
	$("#copyListTitle").val("");
	if(rules == true)
	{
		$.ajax({
		  type: "POST",
		  url: "board/copyList",
		  data: {title:title,owner:owner,listId:listId},
		  dataType:"json",
		  success: function (response) {
		  	console.log(response);
		  	var listId = response["listId"];
		  	var card = response["card"];
			var gabung = "";
			gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+listId+'">';
			gabung += '<div class="card">';
			gabung += '<div class="card-content grey lighten-2 white-text">';
			gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+listId+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
			gabung += '<div id="list'+listId+'" class="listUser dropable sortable" style="height:100%;min-height:60px;width:100%;">';
			gabung += '</div>';
			gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
			gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+listId+'\')">Add a Card..</a></div>';
			gabung += '</div>';
			gabung += '</div>';
			gabung += '</div>';
			gabung += '</div>';
			$(gabung).insertBefore("#listCreateList");
			$('#listCreateList').prop('onclick',null).off('click');
			bindUiList();
			$('#listCreateList').on('click', function() {
				//alert("klik + "+ cardId +" owner : "+owner);
				//var href = $(this).attr("href");
				$("#modalcreatelist").openModal();
			});
			$.each(card, function(idx, res){
				var cardId = res.cardId;
				var listTujuan = listId;
		    	var title = res.cardTitle;
		    	var label = res.label;
			  	var labelRed = false;
			  	var labelYellow = false;
			  	var labelBlue = false;
			 	var labelGreen = false;
			 	if(label != false || label != null)
			 	{
			 		if(label.labelRed == "true")
				  	{
				  		labelRed = true;
				  	}
				  	if(label.labelYellow == "true")
				  	{
				  		labelYellow = true;
				  	}
				  	if(label.labelGreen == "true")
				  	{
				  		labelGreen = true;
				  	}
				  	if(label.labelBlue == "true")
				  	{
				  		labelBlue = true;
				  	}
			 	}
			 	gabung 		= '<div class="dragable cDrag'+cardId+' cardUser'+listTujuan+'" id="cDrag'+cardId+'" style="width:100%;height:100%;">';
	    		gabung		+= '<a id="card'+cardId+'" href="javascript:void(0);" class="cardUser'+listTujuan+'" onclick="ajaxModalCard(\''+cardId+'\')">';
				gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				gabung 		+= '<div class="row" id="labelCard'+cardId+'" style="margin:auto;">';
				if(labelRed)
				  {
				  	gabung+= '<div class="task-cat red left-align red-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelYellow)
				  {
				  	gabung+= '<div class="task-cat yellow left-align yellow-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelBlue)
				  {
				  	gabung+= '<div class="task-cat blue left-align blue-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelGreen)
				  {
				  	gabung+= '<div class="task-cat green left-align green-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				gabung 		+= '</div>'
				gabung 		+= '<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'+cardId+'">'+title+'</div>';
				gabung 		+= '</div>';
				gabung 		+= '</a>';
				gabung 		+= '</div>';
				//alert(gabung);
				$("#list"+listTujuan).append(gabung);
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

function openModalMoveList()
{
	var boardId = $("#hiddenBoardId").val();
	var listId = $("#hiddenListId").val();
	$.ajax({
	  type: "POST",
	  url: "board/getMoveCard",
	  data: {boardId:boardId},
	  dataType:"json",
	  success: function (response) {
		  //alert("response");
		  $("#selectListPosition").empty();
		  	var gabung = "";
		    gabung += "<option value=0 disabled selected>Choose a list</option>";
		    $("#selectListPosition").append(gabung);
		  	$.each(response, function(idx, response){
		  	if(response.listStatus == "1" && response.listArchive == "0" && response.listId != listId)
		  	{
			  	var gabung = "";
			    gabung += "<option value='"+response.listPosition+"'>"+response.listPosition+"</option>";
			    $("#selectListPosition").append(gabung);
		  	}
		    });
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
	$("#modalmovelist").openModal();
}
function openModalListArchiveAllCard()
{
	var listId = $("#hiddenListId").val();
	$.ajax({
		  async:false,
		  type: "POST",
		  url: "board/archiveAllCard",
		  data: {listId:listId},
		  success: function (response) {
		  	//alert(response);
			  
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
	var listId = $("#hiddenListId").val();
	$("#list"+listId).empty();
}
function openModalListArchiveList()
{
	var listId = $("#hiddenListId").val();
	var boardId = $("#hiddenBoardId").val();
	var posAwal = getPositionList(listId);
	var rowAwal = (posAwal-1)/6;
	var jumlahList = $(".colListUser").length;
	$.ajax({
		  type: "POST",
		  url: "board/archiveList",
		  data: {boardId:boardId,listId:listId},
		  success: function (response) {
		  		//alert(response);
			  
				//hanya remove
				$("#colList"+listId).remove();
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});

}

function changeListPosition()
{
	var posTujuan =$("#selectListPosition").val();
	var listId = $("#hiddenListId").val();
	var posAwal = getPositionList(listId);
	var boardId = $("#hiddenBoardId").val();
	var jumlahList = $("#selectListPosition option").size(); //jumlahList
	var listUser = $('.colListUser').length;
	$.ajax({
		  type: "POST",
		  url: "board/changeListPosition",
		  data: {boardId:boardId,listId:listId,posAwal:posAwal,posTujuan:posTujuan},
		  success: function (response) {
		  	//alert(response);
				if(posTujuan == "1")
				{
					$("#colList"+listId).prependTo("#card-stats");
				}
				else if(posTujuan == listUser)
				{
					$("#colList"+listId).insertBefore("#listCreateList");
				}
				else
				{
					if(posAwal < posTujuan)
					{
						$("#colList"+listId).insertAfter(".colListUser:eq("+(posTujuan-1)+")");
					}
					else if(posAwal > posTujuan)
					{
						$("#colList"+listId).insertBefore(".colListUser:eq("+(posTujuan-1)+")");
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

function getPositionList(id)
{
	var listId = id;
	var position = "1";
	var listUser = $(".colListUser").length;
	for(var i=0;i<listUser;i++)
	{
		var listIdCheck = $(".colListUser:eq("+i+")").attr("id");
		listIdCheck = listIdCheck.substr(7); 
		if(listId == listIdCheck && listIdCheck != "listCreateList" )
		{
			position = i+1;
		}
	}

	return position;
}

function openModalListMenu(id)
{
	$("#hiddenListId").val(id);
	$("#modallistmenu").openModal();
}

function saveMoveAllCardList()
{
	var listId = $("#hiddenListId").val(); //list awal
	var listTujuan = $("#selectAllCardList").val();
	var rules = false;
	if(listTujuan != null)
	{
		rules = true;
	}
	if(rules == true)
	{

		var banyak = $(".cardUser"+listId).length;
		for(var i =0;i<banyak;i++)
		{
			$(".cardUser"+listId+":eq(0)").appendTo("#list"+listTujuan).addClass("cardUser"+listTujuan).removeClass("cardUser"+listId);
		}
		$.ajax({
			  async:false,
			  type: "POST",
			  url: "board/moveAllCard",
			  data: {listId:listId,listTujuan:listTujuan},
			  success: function (response) {
			  	//alert(response);
				  
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					alert(xhr.responseText);
					alert("ASD");
				  }
				});
	}
	else
	{
		alert("Error");
	}

}

function ajaxModalCard(id)
{
	$("#hiddenCardId").val(id);
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getCardDetails",
		  data: {id:id,boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  getBoardCard(response["header"]);
			  getBoardMember(response["member"]);
			  getBoardLabelCard(response["label"]);
			  getStartDate(response["startDate"]);
			  getDueDate(response["dueDate"]);
			  getChecklist(response["checklist"]);
			  getComment(response["comment"]);
			  getAttachment(response["attachment"]);
			  getMoveCard(response["move"]);
			  $("#changeArchive").show();
			  $("#changeSend").hide();
			  $("#modal3").openModal();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

	//$("#changeArchive").show();
	//$("#changeSend").hide();
	//$("#modal3").openModal();
}


function getBoardCard(header)
{
	$("#modalCardTitle").text(header["0"].cardTitle);
    $("#modalListTitle").text("in list "+header["0"].listTitle);
    $("#txtCardTitle").val(header["0"].cardTitle);
    $("#hiddenListId").val(header["0"].cardListId);
    $("#textareaDescription").text(header["0"].cardDescription);
    $("#modalCardDescription").text(header["0"].cardDescription);
}

function getMoveCard(response)
{
	  //alert("response");
	  $("#selectListCard").empty();
	  var gabung = "";
	  gabung += "<option value=0 disabled selected>Choose a list</option>";
	  $("#selectListCard").append(gabung);
	  $.each(response, function(idx, response){
	  	if(response.listStatus == "1" && response.listArchive == "0")
	  	{
	  		var gabung = "";
	    	gabung += "<option value='"+response.listId+"'>"+response.listTitle+"</option>";
	    	$("#selectListCard").append(gabung);
	  	}
	  });

}

function changeCardPosition()
{
	var cardId = $("#hiddenCardId").val();
	var listId = $("#hiddenListId").val();
	var selectList = $("#selectListCard").val();
	var selectPosition = $("#selectCardPosition").val();
	var rules = false;
	if(selectList != null && selectPosition != null)
	{
		rules = true;
	}
	else
	{
		rules = false;
	}
	if(rules == true)
	{
		var selectId = $("#selectListCard").val();
		var size = $("#selectCardPosition option").size();
		var pos = $("#selectCardPosition").val();
		$.ajax({
			  type: "POST",
			  url: "board/updateCardPosition",
			  data: {cardId:cardId,listSelect:selectId,position:pos},
			  success: function (response) {
			  	//alert(response);
			  	if(pos == 1)
				{
					//awal
					$("#cDrag"+cardId).prependTo($("#list"+selectId));
				}
				else if(pos==size)
				{
					//akhir
					$("#cDrag"+cardId).appendTo($("#list"+selectId));
				}
				else
				{
					pos = pos-1;
					//awal = 0 -->dihitung dari brp banyak class cardUser
					//pos = 2 -> 0 awal
					//pos = 3 -> 1 tengah
					//pos = 4 -> 2 tengah
					if(response == "bawah")
					{
						$("#cDrag"+cardId).insertAfter(".cardUser"+selectId+":eq( "+pos+" )");
					}
					else if(response == "atas")
					{
						$("#cDrag"+cardId).insertBefore(".cardUser"+selectId+":eq( "+pos+" )");
					}
					else if(response == "Berhasil")
					{
						$("#cDrag"+cardId).insertBefore(".cardUser"+selectId+":eq( "+pos+" )");
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
	else
	{
		alert("Error");
	}
}

function changeList()
{
	var listId = $("#selectListCard").val();
	var hiddenList = $("#hiddenListId").val();
	//alert(listId);
	//alert(hiddenList);
	$.ajax({
		  type: "POST",
		  url: "board/getMoveCardPosition",
		  data: {listId:listId},
		  dataType:"json",
		  success: function (response) {
			  //alert("response");
			  $("#selectCardPosition").empty();
			  var item = 1;
			  $.each(response, function(idx, response){
			  		if(response.cardArchive == "0" && response.cardStatus == "1")
			  		{
				  		item++;
				  		var gabung = "";
					    gabung += "<option value='"+response.cardPosition+"'>"+response.cardPosition+"</option>";
					    $("#selectCardPosition").append(gabung);
			  		}
			    });
			  if(listId != hiddenList)
			  {
			  	var gabung = "";
			    gabung += "<option value='"+item+"'>"+item+"</option>";
			    $("#selectCardPosition").append(gabung);
			  }
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getBoardMember(response)
{
	$("#assignMembers").empty();
  	$("#iconMember").empty();
  	$("#iconMember").append("<h6><b>Members</b></h6>");
	  $.each(response, function(idx, response){
		  	if(response.memberStatus == "1") //Artinya terdapat didalam board sbg member, jika di kick atau leave tidak akan ditampilkan
		  	{
	  			var checked = response.checked;
	  			var name = response.userName;
	  			var gabung = "<p>";
	  			if(checked == "true")
	  			{
	  				gabung += "<input type='checkbox' class='assignMembers' id='"+response.userId+"' checked='checked'/>";
		  			var directory = response.userImage;
		  			var gabung2 = '<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
		  			$("#iconMember").append(gabung2);
	  			}
	  			else
	  			{
	  				gabung += "<input type='checkbox' class='assignMembers' id='"+response.userId+"' />";
	  			}
	  			gabung += "<label class='black-text' for='"+response.userId+"' />"+response.userName+"</label>";
	  			gabung +=  "</p>";
	  			$("#assignMembers").append(gabung);
		  	}

	    });
}

function getBoardAssignChecked(id)
{
	//userId
	var userId = id;
	var cardId = $("#hiddenCardId").val();
	var checked = "false";
	$.ajax({
		  async:false,
		  type: "POST",
		  url: "board/getBoardAssignChecked",
		  data: {userId:userId,cardId:cardId},
		  success: function (response) {
			  checked = response;
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return checked;
}

function createAssignMembers()
{
	var cb = $(".assignMembers").length;
	var cardId = $("#hiddenCardId").val();
	$("#iconMember").empty();
	$("#iconMember").append("<h6><b>Members</b></h6>");
	for(var i=0;i<cb;i++)
	{
		var userId = $(".assignMembers:eq("+i+")").attr("id");
		var check = $("#"+userId).is(":checked");
		if(check == true)
		{
			check = "1";
		}
		else
		{
			check = "0";
		}
		var name = getNameUser(userId);
		$.ajax({
		  type: "POST",
		  url: "board/createAssignMembers",
		  data: {cardId:cardId,userId:userId,check:check,name:name},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
		if(check == "1")
		{
		  	var directory = getDirectoryUser(userId);
			var gabung2 = '<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
			$("#iconMember").append(gabung2);
		}
	}
}

function getBoardLabelCard(response)
{
	$("#labelred").prop("checked",false);
  	$("#labelyellow").prop("checked",false);
  	$("#labelgreen").prop("checked",false);
  	$("#labelblue").prop("checked",false);
  	$("#ajaxLabelCard").empty();
	$("#ajaxLabelCard").append("<h6><b>Label</b></h6>");
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
	if(response.labelRed == "false" && response.labelYellow == "false" && response.labelGreen == "false" && response.labelBlue == "false")
	{
		$("#ajaxLabelCard").empty();
	}
}

function getStartDate(response)
{
	$("#ajaxStartDate").empty();
	if(response.startDate != null)
	{
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
	  	if(response.startDateStatus == "1")
	  	{
	  		$("#ajaxStartDate").append("<h6><b>Start Date</b></h6>");
	  		var gabung = "<p>";
	  		if(response.startDateChecked == "1")
	  		{
	  			gabung += "<input type='checkbox' id='sd' onchange='changeStartDateChecked(\""+response.cardId+"\")' checked='checked'/>";
	  		}
	  		else
	  		{
	  			gabung += "<input type='checkbox' id='sd' onchange='changeStartDateChecked(\""+response.cardId+"\")' />";
	  		}
	  		gabung += "<label for='sd'>"+bln+" "+tgl+" at " +jam+":00 </label><a class='roleActivityStartDate' href='javascript:void(0);' onclick='deleteStartDate(\""+response.cardId+"\")' > - Remove</a>";
	  		gabung += "</p>";
	  	}
	  	$("#ajaxStartDate").append(gabung);
	}
}

function getDueDate(response)
{
	$("#ajaxDueDate").empty();
  	if(response.dueDate != null)
  	{
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
	  	var id = response.cardId;
	  	if(response.dueDateStatus == "1")
	  	{
	  		$("#ajaxDueDate").append("<h6><b>Due Date</b></h6>");
	  		var gabung = "<p>";
	  		if(response.dueDateChecked == "1")
	  		{
	  			gabung += "<input type='checkbox' id='dd' onchange='changeDueDateChecked(\""+id+"\")' checked='checked'/>";
	  		}
	  		else
	  		{
	  			gabung += "<input type='checkbox' id='dd' onchange='changeDueDateChecked(\""+id+"\")' />";
	  		}
	  		gabung += "<label for='dd'>"+bln+" "+tgl+" at " +jam+":00 </label><a class='roleActivityDueDate' href='javascript:void(0);' onclick='deleteDueDate(\""+id+"\")' >Remove</a>";
	  		gabung += "</p>";
	  	}
	  	$("#ajaxDueDate").append(gabung);
  	}
  	
}

function getChecklist(response)
{
  $("#ajaxChecklist").empty();
  $.each(response, function(idx, response){
	  	if(response.checklistStatus == "1")
	  	{
	  		var atas = '<div id="checklist'+response.checklistId+'">';
	  		var luaratas1 = '<div class="col s12 m6 l10 ">';
	  		var header = '<h6><b>'+response.checklistTitle+'</b></h6>';
	  		var progressbar = '<div class="progress"><div id="pb'+response.checklistId+'" class="determinate" style="width:0%"></div></div>';
	  		var item ='<div id="checklistItem'+response.checklistId+'"></div>';
	  		var addatas ='<div id="item'+response.checklistId+'">';
	  		var add = '<p><a href="javascript:void(0);" onclick="changeInput(\''+response.checklistId+'\')">Add an item</a></p>';
	  		var addbawah ='</div>';
	  		var luaratas2 = '</div>';
	  		var luarbawah1 = '<div class="col s12 m6 l1 roleActivityChecklist" style="">';
	  		var tengah = '<a href="javascript:void(0);" onclick="deleteChecklist(\''+response.checklistId+'\')">Delete</a>';
	  		var luarbawah2 = '</div>';
	  		var a = "</div>";
	  		var gabung = atas+luaratas1+header+progressbar+item+addatas+add+addbawah+luaratas2+luarbawah1+tengah+luarbawah2+a;
	  		$("#ajaxChecklist").append(gabung);
	  		$.each(response.item, function(index, res){
			  	if(res.itemStatus == "1")
			  	{

			  		if(res.itemChecked == "1")
			  		{
			  			$("#checklistItem"+response.checklistId).append('<p id="item'+res.itemId+'"> <input type="checkbox" checked="checked" class="cb'+response.checklistId+'" id="test'+res.itemId+'" onchange="changeItem(\''+res.itemId+'\')" onclick="countPb(\''+response.checklistId+'\')" /><label class="black-text" for="test'+res.itemId+'">'+res.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteChecklistItem(\''+res.itemId+'\')" class="right-align red-text">Delete</a></span></p>');
			  		}
			  		else
			  		{
			  			$("#checklistItem"+response.checklistId).append('<p id="item'+res.itemId+'"> <input type="checkbox" class="cb'+response.checklistId+'" id="test'+res.itemId+'" onchange="changeItem(\''+res.itemId+'\')" onclick="countPb(\''+response.checklistId+'\')" /><label class="black-text" for="test'+res.itemId+'">'+res.itemTitle+'</label><span style="margin-left:7%;display:none;" class="ultra-small roleActivityChecklist"><a href="javascript:void(0);" onclick="deleteChecklistItem(\''+res.itemId+'\')" class="right-align red-text">Delete</a></span></p>');

			  		}
			  		countPb(response.checklistId);
			  	}
		  		
		  	});
	  	}
  		
    });
}

function getDirectoryUser(id)
{
	//userId
	var id = id;
	var directory = "";
	$.ajax({
		  async: false,
		  type: "POST",
		  url: "board/getDirectoryUser",
		  data: {id:id},
		  success: function (response) {
			  directory = response;

		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return directory;
}

function getNameUser(id)
{
	var id = id;
	var name = "";
	$.ajax({
		  async: false,
		  type: "POST",
		  url: "board/getNameUser",
		  data: {id:id},
		  success: function (response) {
			  name = response;

		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return name;

}

function getLabelCard(id)
{
	var id = id;
	var label = "";
	$.ajax({
		  async: false,
		  type: "POST",
		  url: "board/getLabelCard",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
			  label = response;

		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return label;

}

function getComment(response)
{
	//alert(response);
  $("#ajaxComment").empty();
  $.each(response, function(idx, response){
  	if(response.commentStatus == "1")
  	{
  		var gabung = "";
  		gabung  +=	'<div class="row" id="comment'+response.commentId+'">';
		gabung  +=		'<div class="col s12 m4 l1">';
		gabung  +=			'<img src="'+response.commentDirectory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
		gabung  +=		'</div>';
		gabung  +=		'<div class="col s12 m4 l11">';
		gabung  +=			'<p style="margin-top:-3px;">';
		gabung  +=				'<b><u>'+response.commentName+'</u></b>';
		gabung  +=			'</p>';
		gabung  +=			'<p style="margin-top:-13px;" id="textComment'+response.commentId+'">'+response.commentText+'</p>';
		gabung  +=				'<div id="changeComment'+response.commentId+'" style="margin-top:-25px;margin-bottom:15px;display:none;">';
		gabung 	+= 					'<textarea id="textareaChangeComment'+response.commentId+'" class="materialize-textarea" >'+response.commentText+'</textarea>';
		gabung	+= 					'<a class="btn waves-effect waves-light green" style="margin-right:10px;" onclick="changeCommentText(\''+response.commentId+'\')">Change</a>';
		gabung	+= 					'<a class="btn-floating waves-effect waves-light" onclick="closeEditComment(\''+response.commentId+'\')"><i class="mdi-content-clear"></i></a>';
		gabung  += 				'</div>';
		gabung  +=			'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
		gabung  +=				'<a href="javascript:void(0);" onclick="changeReply(\''+response.commentId+'\')"><u>Reply</u></a>' ;
		if($("#hiddenUserId").val == response.commentUserId)
		{
			$gabung += ' - <a href="javascript:void(0);" onclick="editComment(\''+response.commentId+'\')"><u>Edit</u></a> - <a href="javascript:void(0)" onclick="deleteComment(\''+response.commentId+'\')"><u>Delete</u></a>';
		}
		gabung  +=			'</p>';
		gabung 	+= 				'<div class="col s12 m6 l12" id="changeReply'+response.commentId+'">';
		gabung 	+= 				'</div>';
		gabung	+=			'<div id="ajaxReplyComment'+response.commentId+'">';
		
		gabung 	+=			'</div>';
		gabung  +=		'</div>';
		gabung  +=	'</div>';
		$("#ajaxComment").append(gabung);

		//alert(response);
		$("#ajaxReplyComment"+response.commentId).empty();
		$.each(response.commentReply, function(idx, res){
		  	if(res.replyStatus == "1")
		  	{
		  		var gabung2 = "";
		  		gabung2  += '<div id="replyUser'+res.replyId+'">';
				gabung2  +=	'<div class="col s12 m4 l1">';
				gabung2  +=		'<img src="'+res.replyDirectory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
				gabung2  +=	'</div>';
				gabung2  +=	'<div class="col s12 m4 l11">';
				gabung2  +=		'<p style="margin-top:-3px;">';
				gabung2  +=			'<b><u>'+res.replyName+'</u></b>';
				gabung2  +=		'</p>';
				gabung2  +=		'<p id="textReply'+res.replyId+'" style="margin-top:-13px;">'+res.replyText+'</p>';
				gabung2  +=				'<div id="changeReply'+res.replyId+'" style="margin-top:-25px;margin-bottom:15px;display:none;">';
				gabung2  += 					'<textarea id="textareaChangeReply'+res.replyId+'" class="materialize-textarea" >'+res.replyText+'</textarea>';
				gabung2	 += 					'<a class="btn waves-effect waves-light green" style="margin-right:10px;" onclick="changeReplyText(\''+res.replyId+'\')">Change</a>';
				gabung2	 += 					'<a class="btn-floating waves-effect waves-light" onclick="closeEditReply(\''+res.replyId+'\')"><i class="mdi-content-clear"></i></a>';
				gabung2  += 				'</div>';
				gabung2  +=		'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
				if($("#hiddenUserId").val() == res.replyUserId)
				{
					
				gabung2  +=			'<a href="javascript:void(0);" onclick="editReply(\''+res.replyId+'\')"><u>Edit</u></a> - <a href="javascript:void(0);" onclick="deleteReply(\''+res.replyId+'\')"><u>Delete</u></a>' ;
				}
				gabung2  +=		'</p>';
				gabung2  +=	'</div>';
				gabung2  += '</div>';
				$("#ajaxReplyComment"+response.commentId).append(gabung2);
		  	}
		});
  	}
		
    });
}


function createCardReply(id)
{
	var boardId = $("#hiddenBoardId").val();
	var cardId = $("#hiddenCardId").val();
	var commentId = id;
	var text = $("#textareaReply"+id).val();
	var userId = $("#hiddenUserId").val();
	$.ajax({
	  type: "POST",
	  url: "board/createReplyComment",
	  data: {commentId:commentId,boardId:boardId,cardId:cardId,text:text},
	  success: function (response) {
		//alert(response);
		var name = getNameUser(userId);
		var directory = getDirectoryUser(userId);
		var gabung2 = "";
		gabung2  += '<div id="replyUser'+response+'">';
		gabung2  +=	'<div class="col s12 m4 l1">';
		gabung2  +=		'<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
		gabung2  +=	'</div>';
		gabung2  +=	'<div class="col s12 m4 l11">';
		gabung2  +=		'<p style="margin-top:-3px;">';
		gabung2  +=			'<b><u>'+name+'</u></b>';
		gabung2  +=		'</p>';
		gabung2  +=		'<p id="textReply'+response+'" style="margin-top:-13px;">'+text+'</p>';
		gabung2  +=				'<div id="changeReply'+response+'" style="margin-top:-25px;margin-bottom:15px;display:none;">';
		gabung2  += 					'<textarea id="textareaChangeReply'+response+'" class="materialize-textarea" >'+text+'</textarea>';
		gabung2	 += 					'<a class="btn waves-effect waves-light green" style="margin-right:10px;" onclick="changeReplyText(\''+response+'\')">Change</a>';
		gabung2	 += 					'<a class="btn-floating waves-effect waves-light" onclick="closeEditReply(\''+response+'\')"><i class="mdi-content-clear"></i></a>';
		gabung2  += 				'</div>';
		gabung2  +=		'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
		gabung2  +=			'<a href="javascript:void(0);" onclick="editReply(\''+response+'\')"><u>Edit</u></a> - <a href="javascript:void(0);" onclick="deleteReply(\''+response+'\')"><u>Delete</u></a>' ;
		gabung2  +=		'</p>';
		gabung2  +=	'</div>';
		gabung2  +=	'</div>';
		$("#ajaxReplyComment"+commentId).append(gabung2);
		$("#changeReply"+commentId).empty();
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
}

function editComment(id)
{
	$("#textComment"+id).hide();
	$("#changeComment"+id).show();
}

function closeEditComment(id)
{
	$("#textComment"+id).show();
	$("#changeComment"+id).hide();
}

function editReply(id)
{
	$("#textReply"+id).hide();
	$("#changeReply"+id).show();
}

function closeEditReply(id)
{
	$("#textReply"+id).show();
	$("#changeReply"+id).hide();
}

function changeCommentText(id)
{
	var id = id;
	var text = $("#textareaChangeComment"+id).val();
	//alert(text);
	$.ajax({
			  type: "POST",
			  url: "board/changeCommentText",
			  data: {id:id,text:text},
			  success: function (response) {
				  //alert(response);
				  $("#textareaChangeComment"+id).text(text);
				  $("#textComment"+id).text(text);
				  $("#textComment"+id).show();
				  $("#changeComment"+id).hide();

			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
}

function changeReplyText(id)
{
	var id = id;
	var text = $("#textareaChangeReply"+id).val();
	//alert(text);
	$.ajax({
			  type: "POST",
			  url: "board/changeReplyText",
			  data: {id:id,text:text},
			  success: function (response) {
				  //alert(response);
				  $("#textareaChangeReply"+id).text(text);
				  $("#textReply"+id).text(text);
				  $("#textReply"+id).show();
				  $("#changeReply"+id).hide();

			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
}

function deleteReply(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteReply",
		  data: {id:id},
		  success: function (response) {
			  //alert(response);
			  $("#replyUser"+id).remove();

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
				  gabung += "<input type='checkbox' id='sd' onchange='changeStartDateChecked(\""+id+"\")' />";
				  gabung += "<label for='sd'>"+bln+" "+tgl+" at " +jam+":00 - </label><a href='javascript:void(0);' onclick='deleteStartDate(\""+id+"\")' >Remove</a>";
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
				  gabung += "<input type='checkbox' id='dd' onchange='changeDueDateChecked(\""+id+"\")' />";
				  gabung += "<label for='dd'>"+bln+" "+tgl+" at " +jam+":00</label><a href='javascript:void(0);' onclick='deleteDueDate(\""+id+"\")' >Remove</a>";
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
				  var atas = "<div id='checklist"+response+"'>"
				  var luaratas1 = '<div class="col s12 m6 l10 ">';
			  	  var header = '<h6><b>'+title+'</b></h6>';
			  	  var progressbar = '<div class="progress"><div id="pb'+response+'" class="determinate" style="width: 0%"></div></div>';
			  	  var item ='<div id="checklistItem'+response+'"></div>';
			      var addatas ='<div id="item'+response+'">';
			  	  var add = '<p><a href="javascript:void(0);" onclick="changeInput(\''+response+'\')">Add an item</a></p>';
			  	  var addbawah ='</div>';
			  	  var luaratas2 = '</div>';
			  	  var luarbawah1 = '<div class="col s12 m6 l1 ">';
			      var tengah = '<a href="javascript:void(0);" onclick="deleteChecklist(\''+response+'\')">Delete</a>';
			  	  var luarbawah2 = '</div>';
			  	  var a = "</div>";
			  	  var gabung = atas+luaratas1+header+progressbar+item+addatas+add+addbawah+luaratas2+luarbawah1+tengah+luarbawah2+a;

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

function changeInputBoard()
{
	//mengubah button add menjadi input text
	$("#itemBoard").empty();
	$("#itemBoard").append('<input type="text" id="textItemBoard" placeholder="Item.." style="margin-bottom:2px;">');
	$("#itemBoard").append('<a class="btn waves-effect waves-light green" onclick="createProgressItemBoard()"  style="margin-right:10px;margin-bottom:2px;">Add</a>');
	$("#itemBoard").append('<a class="btn-floating waves-effect waves-light" style="margin-bottom:2px;" onclick="changeAddBoard()"><i class="mdi-content-clear"></i></a>');

}

function changeAdd(index)
{
	//mengubah input text menjadi button add
	//alert(index);
	var add = '<p><a href="javascript:void(0);" onclick="changeInput(\''+index+'\')">Add an item</a></p>';
	$("#item"+index).empty();
	$("#item"+index).append(add);

}
function changeAddBoard()
{
	//mengubah input text menjadi button add
	//alert(index);
	var add = '<p><a href="javascript:void(0);" onclick="changeInputBoard()">Add an item</a></p>';
	$("#itemBoard").empty();
	$("#itemBoard").append(add);

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
				  //alert(response);
				  $("#checklistItem"+index).append('<p id="item'+response+'"> <input class="cb'+index+'" onchange="changeItem(\''+response+'\')" onclick="countPb(\''+index+'\')" type="checkbox" id="test'+response+'" /><label class="black-text" for="test'+response+'">'+title+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteChecklistItem(\''+response+'\')" class="right-align red-text">Delete</a></span></p>');
			  	  var add = '<p><a href="javascript:void(0);" onclick="changeInput(\''+index+'\')">Add an item</a></p>';
				  $("#item"+index).empty();
				  $("#item"+index).append(add);
				  countPb(index);
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

function changeArchive()// hilang dari board
{
	var id = $("#hiddenCardId").val();
	var listId = $("#hiddenListId").val();
	var status = "1";
	$.ajax({
			  type: "POST",
			  url: "board/setCardArchive",
			  data: {id:id,listId:listId,status:status},
			  success: function (response) {
				  //alert(response);
				  $("#card"+id).remove();
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

function changeArchiveMenu(id) //kembali ke board
{
	//send back
	var status = 0;
	$.ajax({
		  type: "POST",
		  url: "board/sendBackCard",
		  data: {id:id,status:status},
		  success: function (response) {
			  //alert(response);
			  var split = response.split("%20");
			  var listId = split[0];
			  var title = split[1];
			  var label = getLabelCard(id);
			  var labelRed = false;
			  var labelYellow = false;
			  var labelBlue = false;
			  var labelGreen = false;
			  $.each(label, function(idx, response){
				  	if(response.labelRed == "true")
				  	{
				  		labelRed = true;
				  	}
				  	if(response.labelYellow == "true")
				  	{
				  		labelYellow = true;
				  	}
				  	if(response.labelGreen == "true")
				  	{
				  		labelGreen = true;
				  	}
				  	if(response.labelBlue == "true")
				  	{
				  		labelBlue = true;
				  	}
			    });
			  var gabung	= '<a id="card'+id+'" href="javascript:void(0);" class="cardUser'+listId+'" onclick="ajaxModalCard(\''+id+'\')">';
			  gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
			  gabung 		+= '<div class="row" id="labelCard'+id+'" style="margin:auto;">';
			  if(labelRed)
			  {
			  	gabung+= '<div class="task-cat red left-align red-text" style="width:45%;float:left;margin:2px;">';
			  	gabung+= "Blank Text";
			  	gabung+= "</div>";
			  }
			  if(labelYellow)
			  {
			  	gabung+= '<div class="task-cat yellow left-align yellow-text" style="width:45%;float:left;margin:2px;">';
			  	gabung+= "Blank Text";
			  	gabung+= "</div>";
			  }
			  if(labelBlue)
			  {
			  	gabung+= '<div class="task-cat blue left-align blue-text" style="width:45%;float:left;margin:2px;">';
			  	gabung+= "Blank Text";
			  	gabung+= "</div>";
			  }
			  if(labelGreen)
			  {
			  	gabung+= '<div class="task-cat green left-align green-text" style="width:45%;float:left;margin:2px;">';
			  	gabung+= "Blank Text";
			  	gabung+= "</div>";
			  }
			  gabung 		+= '</div>'
			  gabung 		+= '<div class="left-align black-text" id="cardTitle'+listId+'">'+title+'</div>';
			  gabung 		+= '</div>';
			  gabung 		+= '</a>';
			  $("#list"+listId).append(gabung);
			  bindUiCard();
			  $("#archiveC"+id).remove();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function changeArchiveList(id)
{
	//send back
	var listId = id;
	var listUser = $(".colListUser").length;
	var jumlahRow = $(".ajaxList").length;
	var boardId = $("#hiddenBoardId").val();
	var status = "0";
	var title = "";
	$.ajax({
		  type: "POST",
		  url: "board/sendBackList",
		  dataType:"json",
		  data: {listId:listId,status:status,boardId:boardId},
		  success: function (response) {
		  	title = response["listTitle"];
		  	cardList = response["cardList"];
		  	var gabung = "";
			gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+listId+'">';
			gabung += '<div class="card">';
			gabung += '<div class="card-content grey lighten-2 white-text">';
			gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+listId+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
			gabung += '<div id="list'+listId+'" class="listUser dropable sortable" style="height:100%;min-height:60px;width:100%;">';
			gabung += '</div>';
			gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
			gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+listId+'\')">Add a Card..</a></div>';
			gabung += '</div>';
			gabung += '</div>';
			gabung += '</div>';
			gabung += '</div>';
			$(gabung).insertBefore("#listCreateList");
			$('#listCreateList').prop('onclick',null).off('click');
			bindUiList();
				$('#listCreateList').on('click', function() {
					//alert("klik + "+ cardId +" owner : "+owner);
					//var href = $(this).attr("href");
					$("#modalcreatelist").openModal();
				});
			$("#archiveL"+id).remove();
			$.each(cardList, function(idx, res){
				  var labelRed = false;
				  var labelYellow = false;
				  var labelBlue = false;
				  var labelGreen = false;
				  	if(res.label.labelRed == "true")
				  	{
				  		labelRed = true;
				  	}
				  	if(res.label.labelYellow == "true")
				  	{
				  		labelYellow = true;
				  	}
				  	if(res.label.labelGreen == "true")
				  	{
				  		labelGreen = true;
				  	}
				  	if(res.label.labelBlue == "true")
				  	{
				  		labelBlue = true;
				  	}
				  var gabung 	= '<div class="dragable cDrag'+res.card.cardId+'" id="cDrag'+res.cardId+'" style="width:100%;height:100%;">';
				  gabung		+= '<a id="card'+res.card.cardId+'" href="javascript:void(0);" class="cardUser'+listId+'" onclick="ajaxModalCard(\''+res.card.cardId+'\')">';
				  gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				  gabung 		+= '<div class="row" id="labelCard'+res.card.cardId+'" style="margin:auto;">';
				  if(labelRed)
				  {
				  	gabung+= '<div class="task-cat red left-align red-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelYellow)
				  {
				  	gabung+= '<div class="task-cat yellow left-align yellow-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelBlue)
				  {
				  	gabung+= '<div class="task-cat blue left-align blue-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  if(labelGreen)
				  {
				  	gabung+= '<div class="task-cat green left-align green-text" style="width:45%;float:left;margin:2px;">';
				  	gabung+= "Blank Text";
				  	gabung+= "</div>";
				  }
				  gabung 		+= '</div>'
				  gabung 		+= '<div class="left-align black-text" id="cardTitle'+listId+'">'+res.card.cardTitle+'</div>';
				  gabung 		+= '</div>';
				  gabung 		+= '</a>';
				  gabung 		+= '</div>';
				  $("#list"+listId).append(gabung);	
		  		
		    });
			bindUiCard();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	$("#modallistmenu").closeModal();
	
}

function deleteList(id)
{
	var listId = id;
	$.ajax({
	  type: "POST",
	  url: "board/deleteList",
	  data: {listId:listId},
	  success: function (response) {
		  alert(response);
		  $("#archiveL"+id).remove();
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
}

function deleteCard(id)
{
	var cardId = id;
	$.ajax({
	  type: "POST",
	  url: "board/deleteCard",
	  data: {cardId:cardId},
	  success: function (response) {
		  alert(response);
		  $("#archiveC"+id).remove();
		  $("#modal3").closeModal();
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
	var id = $("#hiddenCardId").val();
	changeArchiveMenu(id);
	$("#changeSend").hide();
	$("#changeArchive").show();
}

function changeDelete()
{
	var id = $("#hiddenCardId").val();
	deleteCard(id);
	$("#changeSend").hide();
	$("#changeArchive").show();
}

function modalArchive()
{
	var boardId = $("#hiddenBoardId").val();
	//alert(boardId);
	$.ajax({
		  type: "POST",
		  url: "board/getArchive",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			// alert(response);
			//console.log(response);
			card = response["card"];
			list = response["list"];
			$("#archiveCard").empty();
			$("#archiveCard").append('<p><b>Cards</b></p><div class="divider"></div>');
			$("#archiveList").empty();
			$("#archiveList").append('<p><b>Lists</b></p><div class="divider"></div>');
			$.each(card, function(idx, res){
	  			$("#archiveCard").append('<p class="roleDeleteCard" id="archiveC'+res.cardId+'" style="font-size:100%;"><b>'+res.cardTitle+'</b> -<a href="javascript:void(0);" class="ultra-small green-text" onclick="changeArchiveMenu(\''+res.cardId+'\')" style="margin-left:8px;">Send to Board </a>-<a href="javascript:void(0);" onclick="deleteCard(\''+res.cardId+'\')" class="ultra-small red-text" style="margin-left:8px;">Delete</a></p>');
		    });
		    $.each(list, function(idx, res){
		  			$("#archiveList").append('<p class="roleDeleteList" id="archiveL'+res.listId+'" style="font-size:100%;"><b>'+res.listTitle+'</b> -<a href="javascript:void(0);" class="ultra-small green-text" onclick="changeArchiveList(\''+res.listId+'\')" style="margin-left:8px;">Send to Board </a>-<a href="javascript:void(0);" onclick="deleteList(\''+res.listId+'\')" class="ultra-small red-text" style="margin-left:8px;">Delete</a></p>');
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
	var userId = $("#hiddenUserId").val();
	$.ajax({
	  type: "POST",
	  url: "board/createComment",
	  data: {boardId:boardId,cardId:cardId,text:text},
	  success: function (response) {
		//alert(response);
		var gabung = "";
		var name = getNameUser(userId);
		var directory = getDirectoryUser(userId);
  		gabung  +=	'<div class="row" id="comment'+response+'">';
		gabung  +=		'<div class="col s12 m4 l1">';
		gabung  +=			'<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
		gabung  +=		'</div>';
		gabung  +=		'<div class="col s12 m4 l11">';
		gabung  +=			'<p style="margin-top:-3px;">';
		gabung  +=				'<b><u>'+name+'</u></b>';
		gabung  +=			'</p>';
		gabung  +=			'<p style="margin-top:-13px;" id="textComment'+response+'">'+text+'</p>';
		gabung  +=				'<div id="changeComment'+response+'" style="margin-top:-25px;margin-bottom:15px;display:none;">';
		gabung 	+= 					'<textarea id="textareaChangeComment'+response+'" class="materialize-textarea" >'+text+'</textarea>';
		gabung	+= 					'<a class="btn waves-effect waves-light green" style="margin-right:10px;" onclick="changeCommentText(\''+response+'\')">Change</a>';
		gabung	+= 					'<a class="btn-floating waves-effect waves-light" onclick="closeEditComment(\''+response+'\')"><i class="mdi-content-clear"></i></a>';
		gabung  += 				'</div>';
		gabung  +=			'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
		gabung  +=				'<a href="javascript:void(0);" onclick="changeReply(\''+response+'\')"><u>Reply</u></a> - <a href="javascript:void(0);" onclick="editComment(\''+response+'\')"><u>Edit</u></a> - <a href="javascript:void(0)" onclick="deleteComment(\''+response+'\')"><u>Delete</u></a>' ;
		gabung  +=			'</p>';
		gabung	+=			'<div id="ajaxReplyComment'+response+'">';
		gabung 	+= 				'<div class="col s12 m6 l12" id="changeReply'+response+'">';
		gabung 	+= 				'</div>';
		gabung 	+=			'</div>';
		gabung  +=		'</div>';
		gabung  +=	'</div>';
		$("#ajaxComment").append(gabung);
		$("#textareaComment").val("");
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
	gabung 	+= 	'<textarea id="textareaReply'+id+'" class="materialize-textarea" ></textarea>';
	gabung	+= 	'<a class="btn waves-effect waves-light green" onclick="createCardReply(\''+id+'\')" style="margin-right:10px;">Add</a>';
	gabung	+= 	'<a class="btn-floating waves-effect waves-light" onclick="closeReply(\''+id+'\')" ><i class="mdi-content-clear"></i></a>';
	$("#changeReply"+id).append(gabung);
}

function closeReply(id)
{
	$("#changeReply"+id).empty();
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
			else
			{
				$("#ajaxLabelCard").empty();
				$("#labelCard"+cardId).empty();
			}
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function createAttachment()
{
	var boardId = $("#hiddenBoardId").val();
	var cardId = $("#hiddenCardId").val();
	var computer = $("#inputComputer").val();
	//computer = computer.toLowerCase();
	var parse1 = computer.substr( (computer.lastIndexOf('.') +1) );
	var title = computer.replace(/C:\\fakepath\\/i, '');
	var rules = false;
	
	if(parse1 == "jpg" || parse1 == "jpeg" || parse1 == "png" || parse1 == "doc" || parse1 == "docx" || parse1 == "pdf" || parse1 == "rar" || parse1 == "zip")
	{
		//alert(parse1);
		rules = true;
	}
	if(rules == true)
	{
		var file_data1 = $('#inputComputer').prop('files')[0];

		var form_data = new FormData();
		form_data.append('file1', file_data1);
		form_data.append('boardId',boardId);
		form_data.append('cardId',cardId);
		form_data.append('title',title);
		form_data.append('extension',parse1);
		$.ajax({
			  	url: 'board/createAttachment', // point to server-side PHP script
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
			  success: function (response) {
			  	//alert(response);
			  	if($("#ajaxAttachment").children().length <= 0)
			  	{
			  		var gabung = "";
			  		gabung += '<h6><b>Attachment</b></h6>';
			  		$("#ajaxAttachment").append(gabung);
			  	}

			  	var gabung = '';
		  		gabung += '<div class="row" id="attachmentUser'+response+'">';
		  		gabung += '<div class="col s12 m6 l2">';
		  		var extension = title.substr( (title.lastIndexOf('.') +1) );
		  		var img = "";
		  		if(extension == "jpg" || extension == "png" || extension == "jpeg")
		  		{
		  			img = "userAttachment/"+response+"."+extension;;
		  		}
		  		else if(extension == "pdf")
		  		{
		  			img = "userAttachment/pdf.png";
		  		}
		  		else if(extension == "doc" || extension == "docx")
		  		{
		  			img = "userAttachment/doc.png";
		  		}
		  		else if(extension == "rar" || extension == "zip")
		  		{
		  			img = "userAttachment/zip.jpg";
		  		}
		  		else
		  		{
		  			img = "userAttachment/file.jpg";
		  		}
		  		gabung += '<img src="'+img+'" style="width:90px;height:70px;" alt="Profile" />';
		  		gabung += '</div>';
		  		gabung += '<div class="col s12 m6 l9" style="margin-left:15px;margin-top:-15px;">';
		  		gabung += '<p>'+title+'</p>';
		  		gabung += '<a href="javascript:void(0);" onclick="downloadAttachment(\''+response+'\')">Download - <a onclick="deleteAttachment(\''+response+'\')" href="javascript:void(0);">Delete</a>';
		  		gabung += '</div>';
		  		gabung += '</div>';
		  		$("#ajaxAttachment").append(gabung);

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

function getAttachment(response)
{
  	//alert(response);
  	$("#ajaxAttachment").empty();
	var gabung = "";
	gabung += '<h6><b>Attachment</b></h6>';
	$("#ajaxAttachment").append(gabung);

  	$.each(response, function(idx, response){
  		if(response.attachmentStatus == "1")
  		{
	  		var gabung = '';
	  		gabung += '<div class="row" id="attachmentUser'+response.attachmentId+'">';
	  		gabung += '<div class="col s12 m6 l2">';
	  		var title = response.attachmentTitle;
	  		var extension = title.substr( (title.lastIndexOf('.') +1) );
	  		var img = "";
	  		if(extension == "jpg" || extension == "png" || extension == "jpeg")
	  		{
	  			img = response.attachmentDirectory;
	  		}
	  		else if(extension == "pdf")
	  		{
	  			img = "userAttachment/pdf.png";
	  		}
	  		else if(extension == "doc" || extension == "docx")
	  		{
	  			img = "userAttachment/doc.png";
	  		}
	  		else if(extension == "rar" || extension == "zip")
	  		{
	  			img = "userAttachment/zip.jpg";
	  		}
	  		else
	  		{
	  			img = "userAttachment/file.jpg";
	  		}
	  		gabung += '<img src="'+img+'" style="width:90px;height:70px;" alt="Profile" />';
	  		gabung += '</div>';
	  		gabung += '<div class="col s12 m6 l9" style="margin-left:15px;margin-top:-15px;">';
	  		gabung += '<p>'+response.attachmentTitle+'</p>';
	  		gabung += '<a onclick="downloadAttachment(\''+response.attachmentId+'\')" href="javascript:void(0);">Download <a class="roleActivityAttachment" style="" href="javascript:void(0);" onclick="deleteAttachment(\''+response.attachmentId+'\')">- Delete</a>';
	  		gabung += '</div>';
	  		gabung += '</div>';
	  		$("#ajaxAttachment").append(gabung);
  		}


    });
}

function downloadAttachment(id)
{
	window.location.href = "board/downloadAttachment?id="+id;

}


function ajaxModalMore()
{
	var boardId = $("#hiddenBoardId").val();
	var userId = $("#hiddenUserId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getBoard",
		  data: {boardId:boardId,userId:userId},
		  dataType:"json",
		  success: function (response) {
		  		getBoard(response["board"]);
		  		getBoardFavorite(response["favorite"]);
		  		getBoardSubscribe(response["subscribe"]);
				$("#modalmore").openModal();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	//getBoard(boardId);

	//getBoardFavorite(boardId);

	//getBoardSubscribe(boardId);

	//checkRoleMore();

	/*$("#closeboard").show();
	$("#openboard").hide();*/
}

function getBoard(response)
{
	$("#bgRed").hide();
	$("#bgYellow").hide();
	$("#bgGreen").hide();
	$("#bgBlue").hide();
	$("#txtEditBoard").val(response.boardTitle);
	if(response.boardBackground == "red")
	{
		$("#bgRed").show();
	}
	else if(response.boardBackground == "yellow")
	{
		$("#bgYellow").show();
	}
	else if(response.boardBackground == "green")
	{
		$("#bgGreen").show();
	}
	else if(response.boardBackground == "blue")
	{
		$("#bgBlue").show();
	}
}

function getBoardFavorite(response)
{
	if(response != null)
	{
		if(response.favoriteCheck == "1")
		{
			$("#testfav").prop('checked', true);
		}
	}
	
}

function getBoardSubscribe(response)
{
	if(response != null)
	{
		if(response.subscribeChecked == "1")
		{
			$("#testsub").prop('checked', true);
		}
	}
	
}

function changeBackground(color)
{
	var id 		= $("#hiddenBoardId").val();
	var color 	= color;
	$.ajax({
		  type: "POST",
		  url: "board/changeBackground",
		  data: {id:id,color:color},
		  success: function (response) {
		  		//alert(response);
		  		$("#bgRed").hide();
		  		$("#bgYellow").hide();
		  		$("#bgGreen").hide();
		  		$("#bgBlue").hide();
		  		if(color == "red")
		  		{
		  			$("#bgRed").show();
		  		}
		  		else if(color == "yellow")
		  		{
		  			$("#bgYellow").show();
		  		}
		  		else if(color == "green")
		  		{
		  			$("#bgGreen").show();
		  		}
		  		else if(color == "blue")
		  		{
		  			$("#bgBlue").show();
		  		}
		  		location.reload();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function changeEditBoard()
{
	var id 		= $("#hiddenBoardId").val();
	var title 	= $("#txtEditBoard").val();
	$.ajax({
		  type: "POST",
		  url: "board/changeBoardTitle",
		  data: {id:id,title:title},
		  success: function (response) {
		  	$("#boardTitle").text(title);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function deleteAttachment(id)
{
	var id=id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteAttachment",
		  data: {id:id},
		  success: function (response) {
		  	$("#attachmentUser"+id).remove();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}


function deleteChecklist(id)
{
	var id=id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteChecklist",
		  data: {id:id},
		  success: function (response) {
		  	//alert(response);
		  	$("#checklist"+id).remove();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function deleteChecklistItem(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteChecklistItem",
		  data: {id:id},
		  success: function (response) {
		  	alert(response);
		  	$("#item"+id).remove();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function countPb(id)
{
	var cb = $(".cb"+id).length;
	var check = $(".cb"+id+":checked").length;
	var total = check*100/cb;
	var total = total + "%";
	$("#pb"+id).width(total);
}

function changeItem(id)
{
	var id = id;
	var check = $("#test"+id).is(":checked");
	if(check == true)
	{
		check = "1";
	}
	else
	{
		check = "0";
	}
	$.ajax({
		  type: "POST",
		  url: "board/changeitemChecked",
		  data: {id:id,check:check},
		  success: function (response) {
		  	//alert(response);
		  	//$("#item"+id).remove();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}



function deleteStartDate(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteStartDate",
		  data: {id:id},
		  success: function (response) {
		  	//alert(response);
		  	$("#ajaxStartDate").empty();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function changeStartDateChecked(id)
{
	var id = id;
	var check = $("#sd").is(":checked");
	if(check == true)
	{
		check = "1";
	}
	else
	{
		check = "0";
	}
	$.ajax({
		  type: "POST",
		  url: "board/changeStartDateChecked",
		  data: {id:id,check:check},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function deleteDueDate(id)
{
	var id = id;
	alert(id);
	$.ajax({
		  type: "POST",
		  url: "board/deleteDueDate",
		  data: {id:id},
		  success: function (response) {
		  	//alert(response);
		  	$("#ajaxDueDate").empty();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function changeDueDateChecked(id)
{
	var id = id;
	var check = $("#dd").is(":checked");
	if(check == true)
	{
		check = "1";
	}
	else
	{
		check = "0";
	}
	$.ajax({
		  type: "POST",
		  url: "board/changeDueDateChecked",
		  data: {id:id,check:check},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function deleteComment(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteComment",
		  data: {id:id},
		  success: function (response) {
		  	alert(response);
		  	$("#comment"+id).remove();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function openGoogleDrive()
{
	var cardId = $("#hiddenCardId").val();
	var boardId = $("#hiddenBoardId").val();
	window.location.href = "drive?id="+boardId+"&cardId="+cardId;
}

function openDropbox()
{
	Dropbox.choose({
            linkType: "direct",
            success: function (files) {
                //alert(files[0].link);
                var link = files[0].link;
                var name = files[0].name;
                var extension = name.substr( (name.lastIndexOf('.') +1) );
                var cardId = $("#hiddenCardId").val();
                var boardId = $("#hiddenBoardId").val();
                $.ajax({
				  type: "POST",
				  url: "board/dropbox",
				  data: {link:link,name:name,extension:extension,cardId:cardId,boardId:boardId},
				  success: function (response) {
				  	//alert(response);
				  	if($("#ajaxAttachment").children().length <= 0)
				  	{
				  		var gabung = "";
				  		gabung += '<h6><b>Attachment</b></h6>';
				  		$("#ajaxAttachment").append(gabung);
				  	}
				  	var title = name;
				  	var gabung = '';
			  		gabung += '<div class="row" id="attachmentUser'+response+'">';
			  		gabung += '<div class="col s12 m6 l2">';
			  		var extension = title.substr( (title.lastIndexOf('.') +1) );
			  		var img = "";
			  		if(extension == "jpg" || extension == "png" || extension == "jpeg")
			  		{
			  			img = "userAttachment/"+response+"."+extension;;
			  		}
			  		else if(extension == "pdf")
			  		{
			  			img = "userAttachment/pdf.png";
			  		}
			  		else if(extension == "doc" || extension == "docx")
			  		{
			  			img = "userAttachment/doc.png";
			  		}
			  		else if(extension == "rar" || extension == "zip")
			  		{
			  			img = "userAttachment/zip.jpg";
			  		}
			  		else
			  		{
			  			img = "userAttachment/file.jpg";
			  		}
			  		gabung += '<img src="'+img+'" style="width:90px;height:70px;" alt="Profile" />';
			  		gabung += '</div>';
			  		gabung += '<div class="col s12 m6 l9" style="margin-left:15px;margin-top:-15px;">';
			  		gabung += '<p>'+title+'</p>';
			  		gabung += '<a href="javascript:void(0);" onclick="downloadAttachment(\''+response+'\')">Download - <a onclick="deleteAttachment(\''+response+'\')" href="javascript:void(0);">Delete</a>';
			  		gabung += '</div>';
			  		gabung += '</div>';
			  		$("#ajaxAttachment").append(gabung);
				  },
				  error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					alert(xhr.responseText);
				  }
				});
            },
            cancel: function() {
			  //optional
			},
			linkType: "direct", // "preview" or "direct"
			multiselect: false, // true or false
			extensions: ['.png', '.jpg','.doc','.docx','.pdf','.rar','.zip','.jpeg'],
        });
}

function createFavorite()
{
	var boardId = $("#hiddenBoardId").val();
	var userId = $("#hiddenUserId").val();
	var checked = $("#testfav").is(":checked");
	var check = "";
	if(checked == true)
	{
		check = "1";
	}
	else
	{
		check = "0";
	}
	$.ajax({
		  type: "POST",
		  url: "board/createFavorite",
		  data: {boardId:boardId,userId:userId,check:check},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function createSubscribe()
{
	var boardId = $("#hiddenBoardId").val();
	var userId = $("#hiddenUserId").val();
	var checked = $("#testsub").is(":checked");
	var check = "";
	if(checked == true)
	{
		check = "1";
	}
	else
	{
		check = "0";
	}
	$.ajax({
		  type: "POST",
		  url: "board/createSubscribe",
		  data: {boardId:boardId,userId:userId,check:check},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getList(id)
{
	var boardId = id;
	
}

function getCard(id)
{
	//dapet card,start date, due date
	var listId = id;
	

}

function getStartDateGantt(id)
{
	var cardId = id;
	var date = "";
	$.ajax({
		async:false,
		  type: "POST",
		  url: "board/getStartDate",
		  data: {id:id},
		  dataType :"json",
		  success: function (response) {
		  	$.each(response, function(idx, response){
			  		if(response.startDateStatus == "1")
			  		{
			  			date = response.startDate;
			  		}
			  		//getDueDate(cardId);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return date;
}

function getDueDateGantt(id)
{
	var cardId = id;
	var date = "";
	$.ajax({
		async:false,
		  type: "POST",
		  url: "board/getDueDate",
		  data: {id:id},
		  dataType :"json",
		  success: function (response) {
		  	$.each(response, function(idx, response){
			  		if(response.dueDateStatus == "1")
			  		{
			  			date = response.dueDate;
			  		}
			  		//getDueDate(cardId);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return date;
}

function getChecklistChart(id)
{
	//dapet title
	var cardId = id;
	var progress = 0;
	var title = "";
	$.ajax({
		async:false,
		  type: "POST",
		  url: "board/getChecklist",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		if(response.checklistStatus == "1")
			  		{
			  			title = response.checklistTitle;
			  			var id = response.checklistId;
			  			progress = getChecklistItemChart(id);
			  		}
			  		//getDueDate(cardId);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	var gabung = title +" "+progress;
	return gabung;
}

function getChecklistItemChart(id)
{
	//dapet progress
	var total = 0;
	var checked = 0;
	$.ajax({
		async:false,
		  type: "POST",
		  url: "board/getChecklistItem",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		if(response.itemStatus == "1")
			  		{
			  			total++;
			  			if(response.itemChecked == "1")
			  			{
			  				checked++;
			  			}
			  		}
			  		//getDueDate(cardId);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	var progress = checked*100/total;
	return progress;
}

function openModalGanttChart()
{
	google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);
    var boardId = $("#hiddenBoardId").val();
    function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {
    	
    	$("#chart_div").empty();
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');


      var rows = new Array();
		$.ajax({
			  async:false,
			  type: "POST",
			  url: "board/getGanttChart",
			  data: {boardId:boardId},
			  dataType:"json",
			  success: function (response) {
			  	//console.log(response);
			  	$.each(response, function(idx, response){
		  			var checklist = response.checklist;
		  			$.each(checklist, function(idx, res){
				  		var startDate = response.startDate.startDate;
			  			var dueDate = response.dueDate.dueDate;
		  				var checklistTitle = res.checklist.checklistTitle;
		  				var item = res.item;
		  				if(startDate == null)
		  				{
		  					console.log("sd");
		  				}
			  			if(startDate != null && dueDate != null && dueDate>startDate)
			  			{
			  				var split = startDate.split(" ");
			  				var split2 = dueDate.split(" ");
			  				var progress = 0;
			  				var itemTotal = 0;
			  				var itemChecked = 0;
			  				$.each(item, function(idx, resp){
						  		itemTotal++;
						  		if(resp.itemChecked == "1")
						  		{
						  			itemChecked++;
						  		}
						  	});
						  	progress = itemChecked*100/itemTotal;
						  	if(progress < 0)
						  	{
						  		progress = 0;
						  	}
			  				var startDate = split[0];
			  				var dueDate = split2[0];
			  				var start = startDate.split("-");
			  				var tahun = start[0];
			  				var bulan = start[1];
			  				var tgl = start[2];
			  				var due = dueDate.split("-");
			  				var tahun2 = due[0];
			  				var bulan2 = due[1];
			  				var tgl2 = due[2];
			  				var r1 = checklistTitle;
						    var r2 = checklistTitle;
						    var r3 = response.cardTitle;
						    var b1 = parseInt(bulan)+1;
						    var b2 = parseInt(bulan2)+1;
						    var r4 = new Date(tahun, b1, tgl);
						    //alert(r4);
						    var r5 = new Date(tahun2, b2, tgl2);
						    //alert(r5);
						    var r6 = null;
						    var r7 = parseInt(progress);
						    var r8 = null;
						    rows.push([r1,r2,r3,r4,r5,r6,r7,r8]);
			  			}
				  	});
			  	});
				if(rows.length > 0 )
		      	{
			      	data.addRows(
				        rows
				    );


			      var options = {
			        gantt: {
			          trackHeight: 30
			        }
			      };

			      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

			      chart.draw(data, options);
		     	}
			    else
			    {
			     	$("#chart_div").append("<p>You have to create a card that has a Start Date, Due Date and a Checklist with at least 1 item.</p>");
			    }

			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
		
      
    }

	$("#modalganttchart").openModal();
}

function copyBoard()
{
	var boardId = $("#hiddenBoardId").val();
	var title = $("#newTitle").val();
	$.ajax({
		  type: "POST",
		  url: "board/copyBoard",
		  data: {boardId:boardId,title:title},
		  success: function (response) {
		  	location.href="board?id="+response;
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function closeBoard()
{
	$("#openboard").show();
	$("#closeboard").hide();
	var boardId = $("#hiddenBoardId").val();
	var status = "1";
	$.ajax({
		  type: "POST",
		  url: "board/setClosedBoard",
		  data: {boardId:boardId,status:status},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function openBoard()
{
	$("#openboard").hide();
	$("#closeboard").show();
	var boardId = $("#hiddenBoardId").val();
	var status = "0";
	$.ajax({
		  type: "POST",
		  url: "board/setClosedBoard",
		  data: {boardId:boardId,status:status},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function openStatus()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getProgress",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
		  	var date = response["date"];
		  	var item = response["item"];
		  	console.log(item);
		  	if(date != false || date != null)
		  	{
		  		var split = date.date.split(" ");
		  		var date = split[0];
		  		var $input = $('#progressDate').pickadate();
		  		var split2 = date.split("-");
		  		var tahun = split2[0];
		  		var bulan = split2[1];
		  		var tanggal = split2[2];

				// Use the picker object directly.
				var picker = $input.pickadate('picker');

				picker.set('select', new Date(tahun, (bulan-1), tanggal));
		  	}
		  	$("#ajaxProgressChecklist").empty();
			var gabung = "";
			gabung += '<div id="progressChecklist">';
			gabung += '<div class="col s12 m6 l10 ">';
			gabung +=  '';
			gabung +=  '<div class="progress"><div id="pb'+"ChecklistBoard"+'" class="determinate" style="width:0%"></div></div>';
			//var item ='<p> <input type="checkbox" id="test3" /><label for="test3">Satu</label></p>';
			gabung += '<div id="checklistItem'+"ProgressChecklist"+'"></div>';
			gabung += '<div id="itemBoard'+'">';
			gabung += '<p><a href="javascript:void(0);" onclick="changeInputBoard()">Add an item</a></p>';
			gabung += '</div>';
			gabung +=  '</div>';
			gabung += '<div class="col s12 m6 l1 ">';
			gabung += '';
			gabung += '</div>';
			gabung += "</div>";
			$("#ajaxProgressChecklist").append(gabung);
		  	$.each(item, function(idx, res){
		  		if(res.itemChecked == "1")
		  		{
		  			$("#checklistItemProgressChecklist").append('<p id="itemBoard'+res.progressItemId+'"> <input type="checkbox" checked="checked" class="cbBoard" id="testBoard'+res.progressItemId+'" onchange="changeProgressItem(\''+res.progressItemId+'\')" onclick="countPbProgress(\''+res.progressItemId+'\')" /><label class="black-text" for="testBoard'+res.progressItemId+'">'+res.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteProgressItem(\''+res.progressItemId+'\')" class="right-align red-text">Delete</a></span></p>');
		  		}
		  		else
		  		{
		  			$("#checklistItemProgressChecklist").append('<p id="itemBoard'+res.progressItemId+'"> <input type="checkbox" class="cbBoard" id="testBoard'+res.progressItemId+'" onchange="changeProgressItem(\''+res.progressItemId+'\')" onclick="countPbProgress(\''+res.progressItemId+'\')" /><label class="black-text" for="testBoard'+res.progressItemId+'">'+res.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteProgressItem(\''+res.progressItemId+'\')" class="right-align red-text">Delete</a></span></p>');
		  		}
		  	});
		  	countPbProgress();
			$("#modalstatus").openModal();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getProgressDate()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getProgressDate",
		  data: {boardId:boardId},
		  success: function (response) {
		  	//alert(response);//2018-04-20 10:00:00
		  	if(response != "")
		  	{
		  		var split = response.split(" ");
		  		var date = split[0];
		  		var $input = $('#progressDate').pickadate();
		  		var split2 = date.split("-");
		  		var tahun = split2[0];
		  		var bulan = split2[1];
		  		var tanggal = split2[2];

				// Use the picker object directly.
				var picker = $input.pickadate('picker');

				picker.set('select', new Date(tahun, (bulan-1), tanggal));

		  	}
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getProgressChecklist()
{
	$("#ajaxProgressChecklist").empty();
	var boardId = $("#hiddenBoardId").val();
	var gabung = "";
	gabung += '<div id="progressChecklist">';
	gabung += '<div class="col s12 m6 l10 ">';
	gabung +=  '';
	gabung +=  '<div class="progress"><div id="pb'+"ChecklistBoard"+'" class="determinate" style="width:0%"></div></div>';
	//var item ='<p> <input type="checkbox" id="test3" /><label for="test3">Satu</label></p>';
	gabung += '<div id="checklistItem'+"ProgressChecklist"+'"></div>';
	gabung += '<div id="itemBoard'+'">';
	gabung += '<p><a href="javascript:void(0);" onclick="changeInputBoard()">Add an item</a></p>';
	gabung += '</div>';
	gabung +=  '</div>';
	gabung += '<div class="col s12 m6 l1 ">';
	gabung += '';
	gabung += '</div>';
	gabung += "</div>";
	$("#ajaxProgressChecklist").append(gabung);
	$.ajax({
		  type: "POST",
		  url: "board/getProgressItem",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  $.each(response, function(idx, response){
			  	if(response.itemStatus == "1")
			  	{

			  		if(response.itemChecked == "1")
			  		{
			  			$("#checklistItemProgressChecklist").append('<p id="itemBoard'+response.progressItemId+'"> <input type="checkbox" checked="checked" class="cbBoard" id="testBoard'+response.progressItemId+'" onchange="changeProgressItem(\''+response.progressItemId+'\')" onclick="countPbProgress(\''+response.progressItemId+'\')" /><label class="black-text" for="testBoard'+response.progressItemId+'">'+response.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteProgressItem(\''+response.progressItemId+'\')" class="right-align red-text">Delete</a></span></p>');
			  		}
			  		else
			  		{
			  			$("#checklistItemProgressChecklist").append('<p id="itemBoard'+response.progressItemId+'"> <input type="checkbox" class="cbBoard" id="testBoard'+response.progressItemId+'" onchange="changeProgressItem(\''+response.progressItemId+'\')" onclick="countPbProgress(\''+response.progressItemId+'\')" /><label class="black-text" for="testBoard'+response.progressItemId+'">'+response.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteProgressItem(\''+response.progressItemId+'\')" class="right-align red-text">Delete</a></span></p>');

			  		}
			  		//countPb(response.checklistId);
			  	}
			  		
			  	});
				countPbProgress();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function deleteProgressItem(id)
{
	var itemId = id;
	$.ajax({
		  type: "POST",
		  url: "board/deleteProgressItem",
		  data: {itemId:itemId},
		  success: function (response) {
		  	$("#itemBoard"+id).remove();
		  	countPbProgress();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function createProgressItemBoard()
{
	var boardId = $("#hiddenBoardId").val();
	var text = $("#textItemBoard").val();
	if(text != "")
	{
		$.ajax({
		  type: "POST",
		  url: "board/setProgressItem",
		  data: {boardId:boardId,text:text},
		  success: function (response) {
		  	//alert(response);
		  	$("#checklistItemProgressChecklist").append('<p id="itemBoard'+response+'"> <input type="checkbox" class="cbBoard" id="testBoard'+response+'" onchange="changeProgressItem(\''+response+'\')" onclick="countPbProgress(\''+response+'\')" /><label class="black-text" for="testBoard'+response+'">'+text+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteProgressItem(\''+response+'\')" class="right-align red-text">Delete</a></span></p>');
		  	changeAddBoard();
			countPbProgress();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	}
	
}

function changeProgressItem(id)
{
	var itemId = id;
	var checked = $("#testBoard"+id).is(":checked");
	var status = "";
	if(checked == true)
	{
		status = "1";
	}
	else
	{
		status = "0";
	}
	$.ajax({
		  type: "POST",
		  url: "board/changeProgressItem",
		  data: {itemId:itemId,status:status},
		  success: function (response) {
		  	//alert(response);
		  	countPbProgress();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}

function countPbProgress()
{
	//alert("COUNT");
	var cb = $(".cbBoard").length;
	var check = $(".cbBoard:checked").length;
	var total = check*100/cb;
	var total = total + "%";
	if(cb == 0)
	{
		total = 0;
	}
	$("#pbChecklistBoard").width(total);
}

function createStatus()
{
	var boardId = $("#hiddenBoardId").val();
	var date = $("#progressDate").val();
	$.ajax({
		  type: "POST",
		  url: "board/setProgressDate",
		  data: {boardId:boardId,date:date},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function leaveBoard()
{
	var boardId = $("#hiddenBoardId").val();
	var userId = $("#hiddenUserId").val();
	$.ajax({
		  type: "POST",
		  url: "board/setLeaveBoard",
		  data: {boardId:boardId,userId:userId},
		  success: function (response) {
		  	//alert(response);
		  	window.location.href = "home";
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function openRole()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getRoleCollaboratorClient",
		  data: {boardId:boardId},
		  dataType :"json",
		  success: function (response) {
		  	console.log(response);
		  	var collaborator = response["collaborator"];
		  	var client = response["client"];
			if(collaborator.listCreate == "1")
			{
				$("#collListCreate").prop("checked",true);
			}
			else
			{
				$("#collListCreate").prop("checked",false);
			}
			if(collaborator.listEdit == "1")
			{
				$("#collListEdit").prop("checked",true);
			}
			else
			{
				$("#collListEdit").prop("checked",false);
			}
			if(collaborator.listDelete == "1")
			{
				$("#collListDelete").prop("checked",true);
			}
			else
			{
				$("#collListDelete").prop("checked",false);
			}
			if(collaborator.cardCreate == "1")
			{
				$("#collCardCreate").prop("checked",true);
			}
			else
			{
				$("#collCardCreate").prop("checked",false);
			}
			if(collaborator.cardEdit == "1")
			{
				$("#collCardEdit").prop("checked",true);
			}
			else
			{
				$("#collCardEdit").prop("checked",false);
			}
			if(collaborator.cardDelete == "1")
			{
				$("#collCardDelete").prop("checked",true);
			}
			else
			{
				$("#collCardDelete").prop("checked",false);
			}
			if(collaborator.activityAM == "1")
			{
				$("#collActAM").prop("checked",true);
			}
			else
			{
				$("#collActAM").prop("checked",false);
			}
			if(collaborator.activityLabel == "1")
			{
				$("#collActLabel").prop("checked",true);
			}
			else
			{
				$("#collActLabel").prop("checked",false);
			}
			if(collaborator.activityChecklist == "1")
			{
				$("#collActCheck").prop("checked",true);
			}
			else
			{
				$("#collActCheck").prop("checked",false);
			}
			if(collaborator.activityStartDate == "1")
			{
				$("#collActStart").prop("checked",true);
			}
			else
			{
				$("#collActStart").prop("checked",false);
			}
			if(collaborator.activityDueDate == "1")
			{
				$("#collActDue").prop("checked",true);
			}
			else
			{
				$("#collActDue").prop("checked",false);
			}
			if(collaborator.activityAttachment == "1")
			{	
				$("#collActAtt").prop("checked",true);
			}
			else
			{
				$("#collActAtt").prop("checked",false);
			}
			if(client.listCreate == "1")
			{
				$("#cliListCreate").prop("checked",true);
			}
			else
			{
				$("#cliListCreate").prop("checked",false);
			}
			if(client.listEdit == "1")
			{
				$("#cliListEdit").prop("checked",true);
			}
			else
			{
				$("#cliListEdit").prop("checked",false);
			}
			if(client.listDelete == "1")
			{
				$("#cliListDelete").prop("checked",true);
			}
			else
			{
				$("#cliListDelete").prop("checked",false);
			}
			if(client.cardCreate == "1")
			{
				$("#cliCardCreate").prop("checked",true);
			}
			else
			{
				$("#cliCardCreate").prop("checked",false);
			}
			if(client.cardEdit == "1")
			{
				$("#cliCardEdit").prop("checked",true);
			}
			else
			{
				$("#cliCardEdit").prop("checked",false);
			}
			if(client.cardDelete == "1")
			{
				$("#cliCardDelete").prop("checked",true);
			}
			else
			{
				$("#cliCardDelete").prop("checked",false);
			}
			if(client.activityAM == "1")
			{
				$("#cliActAM").prop("checked",true);
			}
			else
			{
				$("#cliActAM").prop("checked",false);
			}
			if(client.activityLabel == "1")
			{
				$("#cliActLabel").prop("checked",true);
			}
			else
			{
				$("#cliActLabel").prop("checked",false);
			}
			if(client.activityChecklist == "1")
			{
				$("#cliActCheck").prop("checked",true);
			}
			else
			{
				$("#cliActCheck").prop("checked",false);
			}
			if(client.activityStartDate == "1")
			{
				$("#cliActStart").prop("checked",true);
			}
			else
			{
				$("#cliActStart").prop("checked",false);
			}
			if(client.activityDueDate == "1")
			{
				$("#cliActDue").prop("checked",true);
			}
			else
			{
				$("#cliActDue").prop("checked",false);
			}
			if(client.activityAttachment == "1")
			{	
				$("#cliActAtt").prop("checked",true);
			}
			else
			{
				$("#cliActAtt").prop("checked",false);
			}
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	$("#modalsettingrole").openModal();
}

function createRole()
{
	var collListCreate = $("#collListCreate").is(":checked");
	if(collListCreate == true)
	{
		collListCreate = "1";
	}
	else
	{
		collListCreate = "0";
	}
	var collListEdit = $("#collListEdit").is(":checked");
	if(collListEdit == true)
	{
		collListEdit = "1";
	}
	else
	{
		collListEdit = "0";
	}
	var collListDelete = $("#collListDelete").is(":checked");
	if(collListDelete == true)
	{
		collListDelete = "1";
	}
	else
	{
		collListDelete = "0";
	}
	var collCardCreate = $("#collCardCreate").is(":checked");
	if(collCardCreate == true)
	{
		collCardCreate = "1";
	}
	else
	{
		collCardCreate = "0";
	}
	var collCardEdit = $("#collCardEdit").is(":checked");
	if(collCardEdit == true)
	{
		collCardEdit = "1";
	}
	else
	{
		collCardEdit = "0";
	}
	var collCardDelete = $("#collCardDelete").is(":checked");
	if(collCardDelete == true)
	{
		collCardDelete = "1";
	}
	else
	{
		collCardDelete = "0";
	}
	var collActAM = $("#collActAM").is(":checked");
	if(collActAM == true)
	{
		collActAM = "1";
	}
	else
	{
		collActAM = "0";
	}
	var collActLabel = $("#collActLabel").is(":checked");
	if(collActLabel == true)
	{
		collActLabel = "1";
	}
	else
	{
		collActLabel = "0";
	}
	var collActCheck = $("#collActCheck").is(":checked");
	if(collActCheck == true)
	{
		collActCheck = "1";
	}
	else
	{
		collActCheck = "0";
	}
	var collActStart = $("#collActStart").is(":checked");
	if(collActStart == true)
	{
		collActStart = "1";
	}
	else
	{
		collActStart = "0";
	}
	var collActDue = $("#collActDue").is(":checked");
	if(collActDue == true)
	{
		collActDue = "1";
	}
	else
	{
		collActDue = "0";
	}
	var collActAtt = $("#collActAtt").is(":checked");
	if(collActAtt == true)
	{
		collActAtt = "1";
	}
	else
	{
		collActAtt = "0";
	}
	var cliListCreate = $("#cliListCreate").is(":checked");
	if(cliListCreate == true)
	{
		cliListCreate = "1";
	}
	else
	{
		cliListCreate = "0";
	}
	var cliListEdit = $("#cliListEdit").is(":checked");
	if(cliListEdit == true)
	{
		cliListEdit = "1";
	}
	else
	{
		cliListEdit = "0";
	}
	var cliListDelete = $("#cliListDelete").is(":checked");
	if(cliListDelete == true)
	{
		cliListDelete = "1";
	}
	else
	{
		cliListDelete = "0";
	}
	var cliCardCreate = $("#cliCardCreate").is(":checked");
	if(cliCardCreate == true)
	{
		cliCardCreate = "1";
	}
	else
	{
		cliCardCreate = "0";
	}
	var cliCardEdit = $("#cliCardEdit").is(":checked");
	if(cliCardEdit == true)
	{
		cliCardEdit = "1";
	}
	else
	{
		cliCardEdit = "0";
	}
	var cliCardDelete = $("#cliCardDelete").is(":checked");
	if(cliCardDelete == true)
	{
		cliCardDelete = "1";
	}
	else
	{
		cliCardDelete = "0";
	}
	var cliActAM = $("#cliActAM").is(":checked");
	if(cliActAM == true)
	{
		cliActAM = "1";
	}
	else
	{
		cliActAM = "0";
	}
	var cliActLabel = $("#cliActLabel").is(":checked");
	if(cliActLabel == true)
	{
		cliActLabel = "1";
	}
	else
	{
		cliActLabel = "0";
	}
	var cliActCheck = $("#cliActCheck").is(":checked");
	if(cliActCheck == true)
	{
		cliActCheck = "1";
	}
	else
	{
		cliActCheck = "0";
	}
	var cliActStart = $("#cliActStart").is(":checked");
	if(cliActStart == true)
	{
		cliActStart = "1";
	}
	else
	{
		cliActStart = "0";
	}
	var cliActDue = $("#cliActDue").is(":checked");
	if(cliActDue == true)
	{
		cliActDue = "1";
	}
	else
	{
		cliActDue = "0";
	}
	var cliActAtt = $("#cliActAtt").is(":checked");
	if(cliActAtt == true)
	{
		cliActAtt = "1";
	}
	else
	{
		cliActAtt = "0";
	}
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/setRoleCollaboratorClient",
		  data: {boardId:boardId,collListCreate:collListCreate,collListEdit:collListEdit,collListDelete:collListDelete,collCardCreate:collCardCreate,collCardEdit:collCardEdit,collCardDelete:collCardDelete,collActAM:collActAM,collActLabel:collActLabel,collActCheck:collActCheck,collActStart:collActStart,collActDue:collActDue,collActAtt:collActAtt,cliListCreate:cliListCreate,cliListEdit:cliListEdit,cliListDelete:cliListDelete,cliCardCreate:cliCardCreate,cliCardEdit:cliCardEdit,cliCardDelete:cliCardDelete,cliActAM:cliActAM,cliActLabel:cliActLabel,cliActCheck:cliActCheck,cliActStart:cliActStart,cliActDue:cliActDue,cliActAtt:cliActAtt},
		  success: function (response) {
		  	//alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function findBoards()
{
	var text = $("#txtFindBoards").val();
	if(text != "")
	{
		window.location.href="home?find="+text;
	}
}


function checkRole()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getRole",
		  data: {boardId:boardId},
		  success: function (response) {
		  	setRole(response,boardId);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}

function checkRoleCard()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getRole",
		  data: {boardId:boardId},
		  success: function (response) {
		  	setRoleCard(response,boardId);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}

function checkRoleMore()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getRole",
		  data: {boardId:boardId},
		  success: function (response) {
		  	setRoleMore(response,boardId);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}

function checkRoleListMenu()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getRole",
		  data: {boardId:boardId},
		  success: function (response) {
		  	setRoleListMenu(response,boardId);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}

function createPDF()
{
	var boardId = $("#hiddenBoardId").val();
	window.location.href="board/createPDF/"+boardId;
}

function createExcel()
{
	var boardId = $("#hiddenBoardId").val();
	window.location.href ="board/createExcel/"+boardId;
}

function setFilter()
{
	//cardUserLabel aCardUserLabel
	var filterRed = $("#filterred").is(":checked");
	var filterYellow = $("#filteryellow").is(":checked");
	var filterGreen = $("#filtergreen").is(":checked");
	var filterBlue = $("#filterblue").is(":checked");

	if(filterRed == false && filterYellow == false && filterGreen == false && filterBlue == false)
	{
		var jumlahCard = $(".cardUserLabel").length;
		for(var i=0;i<jumlahCard;i++)
		{
			$(".aCardUserLabel:eq("+i+")").show();
			
		}
	}
	else
	{
		setDisplayCard(filterRed,filterYellow,filterGreen,filterBlue);
	}
	
}

function setDisplayCard(red,yellow,green,blue)
{
	var jumlahCard = $(".cardUserLabel").length;
	for(var i=0;i<jumlahCard;i++)
	{
		var child = $(".cardUserLabel:eq("+i+")").children();
		var match = false;
		for(var j =0;j<child.length;j++)
		{
			if($(child[j]).hasClass("red") && red == true || $(child[j]).hasClass("yellow") && yellow == true || $(child[j]).hasClass("green") && green == true || $(child[j]).hasClass("blue") && blue == true)
			{
				match=true;
			}
		}
		if(match == true)
		{
			$(".aCardUserLabel:eq("+i+")").show();
		}
		else if(match == false)
		{
			$(".aCardUserLabel:eq("+i+")").hide();
		}
		
	}
}

function showMemberRole()
{
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getBoardMember",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			//alert(response);
			$("#ajaxInviteMember").empty();
			$.each(response, function(idx, response){
				var directory = getDirectoryUser(response.userId);
				var name = getNameUser(response.userId);
				var gabung = "";
				gabung += '<div class="row">';
				gabung += '<div class="col s6 m4 l1">';
				gabung += '<img src="'+directory+'" style="border-radius:50%;margin-left:10px;" width="32px" height="32px" alt="Profile" />';
				gabung += '</div>';
				gabung += '<div class="col s6 m8 l11">';
				gabung += '<div style="margin-top:5px;"><a href="userProfile?userId='+response.userId+'">'+name+'</a> ('+response.memberRole+')';
				
				if(response.memberRole == "Creator")
				{
					var userId = $("#hiddenUserId").val();
					if(userId != response.userId)
					{
						gabung += ' -<a href="javascript:void(0);" onclick="changeMemberToCollaborator(\''+response.userId+'\')" class="green-text lighten-2 ultra-small"> Change to Collaborator</a>';
					}
				}
				else if(response.memberRole == "Collaborator")
				{
					gabung += ' -<a href="javascript:void(0);" onclick="changeMemberToClient(\''+response.userId+'\')" class="green-text lighten-2 ultra-small"> Change to Client</a>';
				}
				else if(response.memberRole == "Client")
				{
					gabung += ' -<a href="javascript:void(0);" onclick="changeMemberToCollaborator(\''+response.userId+'\')" class="green-text lighten-2 ultra-small"> Change to Collaborator</a>';
				}
				if(userId != response.userId)
				{
					gabung += ' -<a href="javascript:void(0);" onclick="removeMember(\''+response.userId+'\')" class="red-text ultra-small"> Remove</a>';
				}
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				$("#ajaxInviteMember").append(gabung);
		    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function openModalInvite()
{
	showMemberRole();
	$("#modalinvite").openModal();
}

function changeMember(role,userId,boardId)
{
	var userId = userId;
	var boardId = boardId;
	var role = role;
	$.ajax({
		  type: "POST",
		  url: "board/updateMemberRole",
		  data: {boardId:boardId,userId:userId,role:role},
		  success: function (response) {
		  	//alert(response);
			showMemberRole();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function changeMemberToCollaborator(userId)
{
	var userId = userId;
	var boardId = $("#hiddenBoardId").val();
	var role = "Collaborator";
	changeMember(role,userId,boardId);
}

function changeMemberToClient(userId)
{
	var userId = userId;
	var boardId = $("#hiddenBoardId").val();
	var role = "Client";
	changeMember(role,userId,boardId);
}

function removeMember(userId)
{
	var userId = userId;
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/removeMember",
		  data: {boardId:boardId,userId:userId},
		  success: function (response) {
		  	//alert(response);
			showMemberRole();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}


function sendInvite()
{
	var boardId = $("#hiddenBoardId").val();
	var email = $("#inviteEmail").val();
	var role = $("#inviteRoleMember").val();
	$.ajax({
		  type: "POST",
		  url: "board/createInvite",
		  data: {boardId:boardId,email:email,role:role},
		  success: function (response) {
		  	alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	$("#inviteEmail").val();

}

function createInvite()
{
	$.ajax({
		  type: "POST",
		  url: "board/createInvite",
		  data: {},
		  success: function (response) {
			alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
			alert("Chat");
		  }
		});
}

function createChat(name,directory,text)
{
	var gabung = "";
	gabung += '<div class="favorite-associate-list chat-out-list row">';
    gabung +=     '<div class="col s4"><img src="'+directory+'" alt="" class="circle responsive-img online-user valign profile-image">';
    gabung +=     '</div>';
    gabung +=     '<div class="col s8">';
    gabung +=         '<p>'+name+'</p>';
    gabung +=        '<p class="place black-text">'+text+'</p>';
    gabung +=         '<p class="ultra-small grey-text lighten-3">just now</p>';
    gabung +=     '</div>';
    gabung += '</div>';
    $("#ajaxChat").append(gabung);
	$("#chatText").val("");

}

$(document).ready(function() {
	var boardId = $("#hiddenBoardId").val();
	var conn = new WebSocket('ws://localhost:8080');
	conn.onopen = function(e) {
		console.log("Connection established!");
	};

	conn.onmessage = function(e) {
		console.log(e.data);
		var response = JSON.parse(e.data);
		var gabung = "";
  		var name = response.name;
  		var directory = response.directory;
  		gabung += '<div class="favorite-associate-list chat-out-list row">';
        gabung +=     '<div class="col s4"><img src="'+directory+'" alt="" class="circle responsive-img online-user valign profile-image">';
        gabung +=     '</div>';
        gabung +=     '<div class="col s8">';
        gabung +=         '<p>'+name+'</p>';
        gabung +=        '<p class="place black-text">'+response.text+'</p>';
        gabung +=         '<p class="ultra-small grey-text lighten-3">just now</p>';
        gabung +=     '</div>';
        gabung += '</div>';
        $("#ajaxChat").append(gabung);
	};
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
			  		var name = getNameUser(response.userId);
			  		var directory = getDirectoryUser(response.userId);
			  		gabung += '<div class="favorite-associate-list chat-out-list row">';
                    gabung +=     '<div class="col s4"><img src="'+directory+'" alt="" class="circle responsive-img online-user valign profile-image">';
                    gabung +=     '</div>';
                    gabung +=     '<div class="col s8">';
                    gabung +=         '<p>'+name+'</p>';
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
			alert("Chat");
		  }
		});
	$( "#sendChat" ).click(function() {
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
					  dataType:"json",
					  success: function (response) {
						//alert(response);
						var gabung = "";
				  		var name = response.userName;
				  		var directory = response.userImage;
				  		createChat(name,directory,chatText);
			            var obj = { "name":name, 
							        "directory":directory, 
							        "text":chatText
							      };
			            var myJSON = JSON.stringify(obj);
			            conn.send(myJSON);

					  },
					  error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						alert(xhr.responseText);
					  }
					});
					$("#chatText").val("");
				}
		});
    $(document).keypress(function(e) {
	    if(e.which == 13) {
	    	if($("#txtFindBoards").is(":focus"))
	        {
	        	findBoards();
	        }
	        if($("#chatText").is(":focus"))
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
					  dataType:"json",
					  success: function (response) {
						//alert(response);
						var gabung = "";
				  		var name = response.userName;
				  		var directory = response.userImage;
				  		createChat(name,directory,chatText);
			            var obj = { "name":name, 
							        "directory":directory, 
							        "text":chatText
							      };
			            var myJSON = JSON.stringify(obj);
			            conn.send(myJSON);

					  },
					  error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
						alert(xhr.responseText);
					  }
					});
					$("#chatText").val("");
				}
	        }
	    }
	});
});


function myTimer() {
	var boardId = $("#hiddenBoardId").val();
	
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