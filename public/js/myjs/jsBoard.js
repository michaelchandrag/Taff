/*$("#section").sortable();

$( ".listUserDrag" ).draggable({
	containment:"#main"
});

$( ".cardUserDrag" ).draggable({
	appendTo :"body",
	helper:"clone",
	start: function(e, ui)
	 {
	  $(ui.helper).addClass("ui-draggable-helper");
	 }
});
$( ".listUser" ).sortable()*/

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
			if((listUser+1) %6 ==  0 && listUser != 0)
			{
				$("#listCreateList").remove();
				var gabung = "";
				gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+response+'">';
				gabung += '<div class="card">';
				gabung += '<div class="card-content grey lighten-2 white-text">';
				gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+response+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
				gabung += '<div id="list'+response+'" class="listUser">';
				gabung += '</div>';
				gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
				gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+response+'\')">Add a Card..</a></div>';
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				$("#ajaxList"+rowList).append(gabung);

				var gabung2 = "";
				gabung2 += '<div class="row ajaxList" id="ajaxList'+(rowList+1)+'">';
				gabung2 += '<div class="col s12 m6 l2" style="margin-left:0px;" id="listCreateList">';
				gabung2 += '<div class="card">';
				gabung2 += '<div class="card-content grey white-text">';
				gabung2 += '<div class="card-compare  grey" style="margin-top:8px;border-radius:5px;">';
				gabung2 += '<div id="invoice-line" class="left-align white-text"><a href="javascript:void(0)" class="white-text">Add a List..</a></div>';
				gabung2 += '</div>';
				gabung2 += '</div>';
				gabung2 += '</div>';
				gabung2 += '</div>'; 
				gabung2 += '</div>';
				$("#rowList").append(gabung2);
			}
			else
			{
				$("#listCreateList").remove();
				var gabung = "";
				gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+response+'">';
				gabung += '<div class="card">';
				gabung += '<div class="card-content grey lighten-2 white-text">';
				gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+response+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
				gabung += '<div id="list'+response+'" class="listUser">';
				gabung += '</div>';
				gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
				gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+response+'\')">Add a Card..</a></div>';
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				$("#ajaxList"+rowList).append(gabung);

				var gabung2 = "";
				gabung2 += '<div class="col s12 m6 l2" style="margin-left:0px;" id="listCreateList">';
				gabung2 += '<div class="card">';
				gabung2 += '<div class="card-content grey white-text">';
				gabung2 += '<div class="card-compare  grey" style="margin-top:8px;border-radius:5px;">';
				gabung2 += '<div id="invoice-line" class="left-align white-text"><a href="javascript:void(0)" class="modal-trigger white-text">Add a List..</a></div>';
				gabung2 += '</div>';
				gabung2 += '</div>';
				gabung2 += '</div>';
				gabung2 += '</div>'; 
				$("#ajaxList"+rowList).append(gabung2);

			}
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
				var gabung	= '<a id="card'+cardId+'" href="javascript:void(0);" class="cardUser'+owner+'" onclick="ajaxModalCard(\''+cardId+'\')">';
				gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				gabung 		+= '<div class="row" id="labelCard'+cardId+'" style="margin:auto;">';
				gabung 		+= '</div>'
				gabung 		+= '<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'+response+'">'+title+'</div>';
				gabung 		+= '</div>';
				gabung 		+= '</a>';
				//alert(gabung);
				$("#list"+owner).append(gabung);
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
				var gabung = '<a id="card'+response+'" href="javascript:void(0)" class="cardUser'+owner+'" onclick="ajaxModalCard(\''+response+'\')">';
				gabung += '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
				gabung += "<div class='row' id='labelCard"+response+"' style='margin:auto;'>";
				gabung += "</div>";
				gabung += '<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'+response+'">'+title+'</div>';
				gabung += '</div>';
				gabung += '</a>';
				//alert(gabung);
				$("#list"+owner).append(gabung);
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
				  var gabung	= '<a id="card'+response+'" href="javascript:void(0);" class="cardUser'+listId+'" onclick="ajaxModalCard(\''+response+'\')">';
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
	var rowList = $('div.ajaxList').length;
	var jumlahList = $(".colListUser").length;
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
		  async:false,
		  type: "POST",
		  url: "board/createList",
		  data: {title:title,owner:owner},
		  success: function (response) {
			//alert(response);
				listTujuan = response;
				var gabung = "";
				gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+response+'">';
				gabung += '<div class="card">';
				gabung += '<div class="card-content grey lighten-2 white-text">';
				gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+response+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
				gabung += '<div id="list'+response+'" class="listUser">';
				gabung += '</div>';
				gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
				gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+response+'\')">Add a Card..</a></div>';
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				gabung += '</div>';
				//$("#ajaxList"+rowList).append(gabung);
				if(posTujuan %6 == 1)
				{
					//awal
					$(gabung).insertBefore("#listCreateList");
				}
				else if(posTujuan %6 == "0" && posTujuan > 0)
				{
					//akhir
					$(gabung).insertAfter(".colListUser:eq("+ (jumlahList-1)+")");
					$("#listCreateList").remove();
					var gabung2 = "";
					gabung2 += '<div class="row ajaxList" id="ajaxList'+(rowList+1)+'">';
					gabung2 += '<div class="col s12 m6 l2" style="margin-left:0px;" id="listCreateList">';
					gabung2 += '<div class="card">';
					gabung2 += '<div class="card-content grey white-text">';
					gabung2 += '<div class="card-compare  grey" style="margin-top:8px;border-radius:5px;">';
					gabung2 += '<div id="invoice-line" class="left-align white-text"><a href="javascript:void(0)" class="white-text">Add a List..</a></div>';
					gabung2 += '</div>';
					gabung2 += '</div>';
					gabung2 += '</div>';
					gabung2 += '</div>'; 
					gabung2 += '</div>';
					$("#rowList").append(gabung2);
					$('#listCreateList').prop('onclick',null).off('click');
					$('#listCreateList').on('click', function() {
						//alert("klik + "+ cardId +" owner : "+owner);
						//var href = $(this).attr("href");
						$("#modalcreatelist").openModal();
					});
				}
				else
				{
					$(gabung).insertAfter(".colListUser:eq("+ (jumlahList-1)+")");
				}
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

		$.ajax({
			async:false,
		  type: "POST",
		  url: "board/copyAllCard",
		  data: {boardId:boardId,listTujuan:listTujuan,listId:listId},
		  success: function (response) {
			    //alert(response);
			    //%20id%10title%20id%10title
			    var split = response.split("%20");
			    for(var i=1;i<split.length;i++)
			    {
			    	var split2 = split[i].split("%10");
			    	var cardId = split2[0];
			    	var title = split2[1];
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
		    		var gabung	= '<a id="card'+cardId+'" href="javascript:void(0);" class="cardUser'+listTujuan+'" onclick="ajaxModalCard(\''+cardId+'\')">';
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
					//alert(gabung);
					$("#list"+listTujuan).append(gabung);

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
	var jumlahRow = $(".ajaxList").length;
	var jumlahList = $(".colListUser").length;
	$.ajax({
		  type: "POST",
		  url: "board/archiveList",
		  data: {boardId:boardId,listId:listId},
		  success: function (response) {
		  	//alert(response);
			  
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
	if(rowAwal < 0)
	{
		rowAwal = 0;
	}
	rowAwal = parseInt(rowAwal);
	rowAwal+=1;
	if(rowAwal == jumlahRow)
	{
		//hanya remove
		$("#colList"+listId).remove();
	}
	else
	{
		var diff = jumlahRow-rowAwal;
		for(var i =0;i<diff;i++)
		{
			var rowDiff = (rowAwal+i);
			var temp = rowDiff*6+1;
			var z = $(".colListUser:eq("+(temp-1)+")").appendTo("#ajaxList"+rowDiff);
		}
		$("#colList"+listId).remove();
		if(jumlahList%6 == 0 && jumlahList > 0)
		{
			//list create list ikut pindah
			$("#listCreateList").remove();
			$("#ajaxList"+jumlahRow).remove();
			var gabung2 = "";
			gabung2 += '<div class="col s12 m6 l2" style="margin-left:0px;" id="listCreateList">';
			gabung2 += '<div class="card">';
			gabung2 += '<div class="card-content grey white-text">';
			gabung2 += '<div class="card-compare  grey" style="margin-top:8px;border-radius:5px;">';
			gabung2 += '<div id="invoice-line" class="left-align white-text"><a href="javascript:void(0)" class="white-text">Add a List..</a></div>';
			gabung2 += '</div>';
			gabung2 += '</div>';
			gabung2 += '</div>';
			gabung2 += '</div>'; 
			$("#ajaxList"+(jumlahRow-1)).append(gabung2);
			$('#listCreateList').prop('onclick',null).off('click');
			$('#listCreateList').on('click', function() {
				//alert("klik + "+ cardId +" owner : "+owner);
				//var href = $(this).attr("href");
				$("#modalcreatelist").openModal();
			});
		}
	}

}

function changeListPosition()
{
	var posTujuan =$("#selectListPosition").val();
	var listId = $("#hiddenListId").val();
	var posAwal = getPositionList(listId);
	var boardId = $("#hiddenBoardId").val();
	var jumlahList = $("#selectListPosition option").size(); //jumlahList
	var arah = "awal";
	var rowList = $('div.ajaxList').length;
	var listUser = $('div.listUser').length;
	var rowTujuan = (posTujuan-1)/6;
	var rowAwal = (posAwal-1)/6;
	$.ajax({
		  type: "POST",
		  url: "board/changeListPosition",
		  data: {boardId:boardId,listId:listId,posAwal:posAwal,posTujuan:posTujuan},
		  success: function (response) {
		  	alert(response);
			  
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
			});
	if(rowTujuan < 0)
	{
		rowTujuan = 0;
	}
	if(rowAwal < 0)
	{
		rowAwal = 0;
	}
	rowTujuan = parseInt(rowTujuan);
	rowTujuan+=1;
	rowAwal = parseInt(rowAwal);
	rowAwal+=1;
	var diff = 0;
	var gerak="atas";
	if(rowTujuan > rowAwal)
	{
		gerak = "atas";
		diff = rowTujuan-rowAwal; //list pindah ke bawah, gerak ke atas
	}
	else
	{
		gerak = "bawah";
		diff = rowAwal-rowTujuan; //list pindah ke atas, gerak ke bawah
	}
	if(gerak == "atas")
	{
		for(var i =0;i<diff;i++)
		{
			var rowDiff = (rowAwal+i);
			var temp = rowDiff*6+1;
			var z = $(".colListUser:eq("+(temp-1)+")").appendTo("#ajaxList"+rowDiff);
		}
	}
	else if(gerak == "bawah")
	{
		for(var i =0;i<diff;i++)
		{
			var rowDiff = (rowAwal-i-1);
			var temp = rowDiff*6;
			var z = $(".colListUser:eq("+(temp-1)+")").prependTo("#ajaxList"+(rowDiff+1));
		}
	}
	if(posTujuan%6 == "1")
	{
		$("#colList"+listId).prependTo("#ajaxList"+rowTujuan);
	}
	else if(posTujuan %6 == "0" && posTujuan > 0)
	{
		$("#colList"+listId).appendTo("#ajaxList"+rowTujuan);
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
	
}

function getPositionList(id)
{
	var listId = id;
	var position = "1";
	$.ajax({
	  async:false,
	  type: "POST",
	  url: "board/getListPosition",
	  data: {listId:listId},
	  success: function (response) {
		  //alert("response");
		  position = response;
	  },
	  error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		alert(xhr.responseText);
	  }
	});
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
	getBoardCard(id);

	getBoardMember(id);

	getBoardLabelCard(id);

	getStartDate(id);

	getDueDate(id);

	getChecklist(id);

	getComment(id);

	getAttachment(id);

	getMoveCard(id);

	$("#changeArchive").show();
	$("#changeSend").hide();

	$("#modal3").openModal();
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
			  	  $("#hiddenListId").val(response.cardListId);
			  	  $("#textareaDescription").text(response.cardDescription);
			  	  $("#modalCardDescription").text(response.cardDescription);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getMoveCard(id)
{
	var id = id;
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getMoveCard",
		  data: {id:id,boardId:boardId},
		  dataType:"json",
		  success: function (response) {
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
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
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
					$("#card"+cardId).prependTo($("#list"+selectId));
				}
				else if(pos==size)
				{
					//akhir
					$("#card"+cardId).appendTo($("#list"+selectId));
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
						$("#card"+cardId).insertAfter(".cardUser"+selectId+":eq( "+pos+" )");
					}
					else if(response == "atas")
					{
						$("#card"+cardId).insertBefore(".cardUser"+selectId+":eq( "+pos+" )");
					}
					else if(response == "Berhasil")
					{
						$("#card"+cardId).insertBefore(".cardUser"+selectId+":eq( "+pos+" )");
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

function getBoardMember(id)
{
	var id = id;
	var boardId = $("#hiddenBoardId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getBoardMember",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  	$("#assignMembers").empty();
			  	$("#iconMember").empty();
			  	$("#iconMember").append("<h6><b>Members</b></h6>");
			  $.each(response, function(idx, response){
				  	if(response.memberStatus == "1") //Artinya terdapat didalam board sbg member, jika di kick atau leave tidak akan ditampilkan
				  	{
			  			var checked = getBoardAssignChecked(response.userId);
			  			var name = getNameUser(response.userId);
			  			var gabung = "<p>";
			  			if(checked == "true")
			  			{
			  				gabung += "<input type='checkbox' class='assignMembers' id='"+response.userId+"' checked='checked'/>";
				  			var directory = getDirectoryUser(response.userId);
				  			var gabung2 = '<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
				  			$("#iconMember").append(gabung2);
			  			}
			  			else
			  			{
			  				gabung += "<input type='checkbox' class='assignMembers' id='"+response.userId+"' />";
			  			}
			  			gabung += "<label class='black-text' for='"+response.userId+"' />"+name+"</label>";
			  			gabung +=  "</p>";
			  			$("#assignMembers").append(gabung);
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
				$("#ajaxLabelCard").append("<h6><b>Label</b></h6>");
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
			  		if(response.labelRed == "false" && response.labelYellow == "false" && response.labelGreen == "false" && response.labelBlue == "false")
			  		{
			  			$("#ajaxLabelCard").empty();
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
			  	if(response.startDateStatus == "1")
			  	{
			  		$("#ajaxStartDate").append("<h6><b>Start Date</b></h6>");
			  		var gabung = "<p>";
			  		if(response.startDateChecked == "1")
			  		{
			  			gabung += "<input type='checkbox' id='sd' onchange='changeStartDateChecked(\""+id+"\")' checked='checked'/>";
			  		}
			  		else
			  		{
			  			gabung += "<input type='checkbox' id='sd' onchange='changeStartDateChecked(\""+id+"\")' />";
			  		}
			  		gabung += "<label for='sd'>"+bln+" "+tgl+" at " +jam+":00 - </label><a href='javascript:void(0);' onclick='deleteStartDate(\""+id+"\")' >Remove</a>";
			  		gabung += "</p>";
			  	}

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
			  }
			  
			  $.each(response, function(idx, response){
			  	//alert(response.startDate); //2018-03-07 12:00:00
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
			  		gabung += "<label for='dd'>"+bln+" "+tgl+" at " +jam+":00 - </label><a href='javascript:void(0);' onclick='deleteDueDate(\""+id+"\")' >Remove</a>";
			  		gabung += "</p>";
			  	}
			  	$("#ajaxDueDate").append(gabung);

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
				  	if(response.checklistStatus == "1")
				  	{
				  		var atas = '<div id="checklist'+response.checklistId+'">';
				  		var luaratas1 = '<div class="col s12 m6 l10 ">';
				  		var header = '<h6><b>'+response.checklistTitle+'</b></h6>';
				  		var progressbar = '<div class="progress"><div id="pb'+response.checklistId+'" class="determinate" style="width:0%"></div></div>';
				  		//var item ='<p> <input type="checkbox" id="test3" /><label for="test3">Satu</label></p>';
				  		var item ='<div id="checklistItem'+response.checklistId+'"></div>';
				  		var addatas ='<div id="item'+response.checklistId+'">';
				  		var add = '<p><a href="javascript:void(0);" onclick="changeInput(\''+response.checklistId+'\')">Add an item</a></p>';
				  		var addbawah ='</div>';
				  		var luaratas2 = '</div>';
				  		var luarbawah1 = '<div class="col s12 m6 l1 ">';
				  		var tengah = '<a href="javascript:void(0);" onclick="deleteChecklist(\''+response.checklistId+'\')">Delete</a>';
				  		var luarbawah2 = '</div>';
				  		var a = "</div>";
				  		var gabung = atas+luaratas1+header+progressbar+item+addatas+add+addbawah+luaratas2+luarbawah1+tengah+luarbawah2+a;
				  		$("#ajaxChecklist").append(gabung);
				  		//alert(response.checklistId);
				  		$.ajax({
						  type: "POST",
						  url: "board/getChecklistItem",
						  data: {id:response.checklistId},
						  dataType:"json",
						  success: function (response) {
							  $.each(response, function(idx, response){
							  	if(response.itemStatus == "1")
							  	{

							  		if(response.itemChecked == "1")
							  		{
							  			$("#checklistItem"+response.checklistId).append('<p id="item'+response.itemId+'"> <input type="checkbox" checked="checked" class="cb'+response.checklistId+'" id="test'+response.itemId+'" onchange="changeItem(\''+response.itemId+'\')" onclick="countPb(\''+response.checklistId+'\')" /><label class="black-text" for="test'+response.itemId+'">'+response.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteChecklistItem(\''+response.itemId+'\')" class="right-align red-text">Delete</a></span></p>');
							  		}
							  		else
							  		{
							  			$("#checklistItem"+response.checklistId).append('<p id="item'+response.itemId+'"> <input type="checkbox" class="cb'+response.checklistId+'" id="test'+response.itemId+'" onchange="changeItem(\''+response.itemId+'\')" onclick="countPb(\''+response.checklistId+'\')" /><label class="black-text" for="test'+response.itemId+'">'+response.itemTitle+'</label><span style="margin-left:7%;" class="ultra-small"><a href="javascript:void(0);" onclick="deleteChecklistItem(\''+response.itemId+'\')" class="right-align red-text">Delete</a></span></p>');

							  		}
							  		countPb(response.checklistId);
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
			  		
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
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
			  	if(response.commentStatus == "1")
			  	{
			  		var directory = getDirectoryUser(response.userId);
			  		var name = getNameUser(response.userId);
			  		var gabung = "";
			  		gabung  +=	'<div class="row" id="comment'+response.commentId+'">';
					gabung  +=		'<div class="col s12 m4 l1">';
					gabung  +=			'<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
					gabung  +=		'</div>';
					gabung  +=		'<div class="col s12 m4 l11">';
					gabung  +=			'<p style="margin-top:-3px;">';
					gabung  +=				'<b><u>'+name+'</u></b>';
					gabung  +=			'</p>';
					gabung  +=			'<p style="margin-top:-13px;" id="textComment'+response.commentId+'">'+response.commentText+'</p>';
					gabung  +=				'<div id="changeComment'+response.commentId+'" style="margin-top:-25px;margin-bottom:15px;display:none;">';
					gabung 	+= 					'<textarea id="textareaChangeComment'+response.commentId+'" class="materialize-textarea" >'+response.commentText+'</textarea>';
					gabung	+= 					'<a class="btn waves-effect waves-light green" style="margin-right:10px;" onclick="changeCommentText(\''+response.commentId+'\')">Change</a>';
					gabung	+= 					'<a class="btn-floating waves-effect waves-light" onclick="closeEditComment(\''+response.commentId+'\')"><i class="mdi-content-clear"></i></a>';
					gabung  += 				'</div>';
					gabung  +=			'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
					gabung  +=				'yesterday at 8:17 PM - <a href="javascript:void(0);" onclick="changeReply(\''+response.commentId+'\')"><u>Reply</u></a> - <a href="javascript:void(0);" onclick="editComment(\''+response.commentId+'\')"><u>Edit</u></a> - <a href="javascript:void(0)" onclick="deleteComment(\''+response.commentId+'\')"><u>Delete</u></a>' ;
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
						  	if(response.replyStatus == "1")
						  	{
						  		var name2 = getNameUser(response.userId);
						  		var directory2 = getDirectoryUser(response.userId);
						  		var gabung2 = "";
						  		gabung2  += '<div id="replyUser'+response.replyId+'">';
								gabung2  +=	'<div class="col s12 m4 l1">';
								gabung2  +=		'<img src="'+directory+'" style="border-radius:50%;" width="32px" height="32px" alt="Profile" />';
								gabung2  +=	'</div>';
								gabung2  +=	'<div class="col s12 m4 l11">';
								gabung2  +=		'<p style="margin-top:-3px;">';
								gabung2  +=			'<b><u>'+name+'</u></b>';
								gabung2  +=		'</p>';
								gabung2  +=		'<p id="textReply'+response.replyId+'" style="margin-top:-13px;">'+response.replyText+'</p>';
								gabung2  +=				'<div id="changeReply'+response.replyId+'" style="margin-top:-25px;margin-bottom:15px;display:none;">';
								gabung2  += 					'<textarea id="textareaChangeReply'+response.replyId+'" class="materialize-textarea" >'+response.replyText+'</textarea>';
								gabung2	 += 					'<a class="btn waves-effect waves-light green" style="margin-right:10px;" onclick="changeReplyText(\''+response.replyId+'\')">Change</a>';
								gabung2	 += 					'<a class="btn-floating waves-effect waves-light" onclick="closeEditReply(\''+response.replyId+'\')"><i class="mdi-content-clear"></i></a>';
								gabung2  += 				'</div>';
								gabung2  +=		'<p class="ultra-small grey-text darken-4" style="margin-top:-10px;">';
								gabung2  +=			'yesterday at 8:17 PM - <a href="javascript:void(0);" onclick="editReply(\''+response.replyId+'\')"><u>Edit</u></a> - <a href="javascript:void(0);" onclick="deleteReply(\''+response.replyId+'\')"><u>Delete</u></a>' ;
								gabung2  +=		'</p>';
								gabung2  +=	'</div>';
								gabung2  += '</div>';
								$("#ajaxReplyComment"+response.commentId).append(gabung2);
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
					
			    });
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
		gabung2  +=			'yesterday at 8:17 PM - <a href="javascript:void(0);" onclick="editReply(\''+response+'\')"><u>Edit</u></a> - <a href="javascript:void(0);" onclick="deleteReply(\''+response+'\')"><u>Delete</u></a>' ;
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

function changeAdd(index)
{
	//mengubah input text menjadi button add
	//alert(index);
	var add = '<p><a href="javascript:void(0);" onclick="changeInput(\''+index+'\')">Add an item</a></p>';
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
			async:false,
		  type: "POST",
		  url: "board/sendBackList",
		  data: {listId:listId,status:status,boardId:boardId},
		  success: function (response) {
		  	title = response;
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	var gabung = "";
	gabung += '<div class="col s12 m6 l2 colListUser" id="colList'+listId+'">';
	gabung += '<div class="card">';
	gabung += '<div class="card-content grey lighten-2 white-text">';
	gabung += '<p class=" grey-text text-darken-4 truncate" style="font-weight:bold;font-size:150%;">'+title+'<a href="javascript:void(0);" onclick="openModalListMenu(\''+listId+'\')" class="black-text"><i class="mdi-navigation-more-vert right"></i></a></p>';
	gabung += '<div id="list'+listId+'" class="listUser">';
	gabung += '</div>';
	gabung += '<div class="card-compare  grey lighten-2" style="margin-top:8px;border-radius:5px;">';
	gabung += '<div id="invoice-line" class="left-align grey-text"><a href="javascript:void(0)" class="grey-text" onclick="setHiddenListId(\''+listId+'\')">Add a Card..</a></div>';
	gabung += '</div>';
	gabung += '</div>';
	gabung += '</div>';
	gabung += '</div>';
	if(listUser%6 == 5 && listUser > 0 )
	{
		$("#ajaxList"+jumlahRow).append(gabung);
		//create list pindah bawah
		$("#listCreateList").remove();
		var gabung2 = "";
		gabung2 += '<div class="row ajaxList" id="ajaxList'+(jumlahRow+1)+'">';
		gabung2 += '<div class="col s12 m6 l2" style="margin-left:0px;" id="listCreateList">';
		gabung2 += '<div class="card">';
		gabung2 += '<div class="card-content grey white-text">';
		gabung2 += '<div class="card-compare  grey" style="margin-top:8px;border-radius:5px;">';
		gabung2 += '<div id="invoice-line" class="left-align white-text"><a href="javascript:void(0)" class="white-text">Add a List..</a></div>';
		gabung2 += '</div>';
		gabung2 += '</div>';
		gabung2 += '</div>';
		gabung2 += '</div>'; 
		gabung2 += '</div>';
		$("#rowList").append(gabung2);
		$('#listCreateList').prop('onclick',null).off('click');
		$('#listCreateList').on('click', function() {
			//alert("klik + "+ cardId +" owner : "+owner);
			//var href = $(this).attr("href");
			$("#modalcreatelist").openModal();
		});
	}
	else
	{
		$("#ajaxList"+jumlahRow).append(gabung);
		$("#listCreateList").remove();
		var gabung2 = "";
		gabung2 += '<div class="col s12 m6 l2" style="margin-left:0px;" id="listCreateList">';
		gabung2 += '<div class="card">';
		gabung2 += '<div class="card-content grey white-text">';
		gabung2 += '<div class="card-compare  grey" style="margin-top:8px;border-radius:5px;">';
		gabung2 += '<div id="invoice-line" class="left-align white-text"><a href="javascript:void(0)" class="white-text">Add a List..</a></div>';
		gabung2 += '</div>';
		gabung2 += '</div>';
		gabung2 += '</div>';
		gabung2 += '</div>'; 
		$("#ajaxList"+jumlahRow).append(gabung2);
		$('#listCreateList').prop('onclick',null).off('click');
		$('#listCreateList').on('click', function() {
			//alert("klik + "+ cardId +" owner : "+owner);
			//var href = $(this).attr("href");
			$("#modalcreatelist").openModal();
		});
	}
	$("#archiveL"+id).remove();

	$.ajax({
		  type: "POST",
		  url: "board/getCardList",
		  data: {listId:listId},
		  dataType:"json",
		  success: function (response) {
			  $.each(response, function(idx, response){
				  	if(response.cardArchive == "0" && response.cardStatus == "1" && response.cardPosition > 0)
				  	{
					  var label = getLabelCard(response.cardId);
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
					  var gabung	= '<a id="card'+response.cardId+'" href="javascript:void(0);" class="cardUser'+listId+'" onclick="ajaxModalCard(\''+response.cardId+'\')">';
					  gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
					  gabung 		+= '<div class="row" id="labelCard'+response.cardId+'" style="margin:auto;">';
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
					  gabung 		+= '<div class="left-align black-text" id="cardTitle'+listId+'">'+response.cardTitle+'</div>';
					  gabung 		+= '</div>';
					  gabung 		+= '</a>';
					  $("#list"+listId).append(gabung);		  		
				  	}
			  		
			    });
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
		  url: "board/getCardArchive",
		  data: {},
		  dataType:"json",
		  success: function (response) {
			// alert(response);
			$("#archiveCard").empty();
			$("#archiveCard").append('<p><b>Cards</b></p><div class="divider"></div>');
			  $.each(response, function(idx, response){
			  		if(response.cardBoardId == boardId && response.cardStatus == "1")
			  		{
			  			//alert(response.cardId);
			  			$("#archiveCard").append('<p id="archiveC'+response.cardId+'" style="font-size:100%;"><b>'+response.cardTitle+'</b> -<a href="javascript:void(0);" class="ultra-small green-text" onclick="changeArchiveMenu(\''+response.cardId+'\')" style="margin-left:8px;">Send to Board </a>-<a href="javascript:void(0);" onclick="deleteCard(\''+response.cardId+'\')" class="ultra-small red-text" style="margin-left:8px;">Delete</a></p>');
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
		  url: "board/getListArchive",
		  data: {},
		  dataType:"json",
		  success: function (response) {
			// alert(response);
			$("#archiveList").empty();
			$("#archiveList").append('<p><b>Lists</b></p><div class="divider"></div>');
			  $.each(response, function(idx, response){
			  		if(response.listBoardId == boardId && response.listStatus == "1")
			  		{
			  			//alert(response.cardId);
			  			$("#archiveList").append('<p id="archiveL'+response.listId+'" style="font-size:100%;"><b>'+response.listTitle+'</b> -<a href="javascript:void(0);" class="ultra-small green-text" onclick="changeArchiveList(\''+response.listId+'\')" style="margin-left:8px;">Send to Board </a>-<a href="javascript:void(0);" onclick="deleteList(\''+response.listId+'\')" class="ultra-small red-text" style="margin-left:8px;">Delete</a></p>');
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
		gabung  +=				'yesterday at 8:17 PM - <a href="javascript:void(0);" onclick="changeReply(\''+response+'\')"><u>Reply</u></a> - <a href="javascript:void(0);" onclick="editComment(\''+response+'\')"><u>Edit</u></a> - <a href="javascript:void(0)" onclick="deleteComment(\''+response+'\')"><u>Delete</u></a>' ;
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

function getAttachment(id)
{
	var id = id;
	$.ajax({
		  type: "POST",
		  url: "board/getAttachment",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
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
				  		gabung += '<a onclick="downloadAttachment(\''+response.attachmentId+'\')" href="javascript:void(0);">Download - <a href="javascript:void(0);" onclick="deleteAttachment(\''+response.attachmentId+'\')">Delete</a>';
				  		gabung += '</div>';
				  		gabung += '</div>';
				  		$("#ajaxAttachment").append(gabung);
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

function downloadAttachment(id)
{
	window.location.href = "board/downloadAttachment?id="+id;

}


function ajaxModalMore()
{
	var boardId = $("#hiddenBoardId").val();

	getBoard(boardId);

	getBoardFavorite(boardId);

	getBoardSubscribe(boardId);

}

function getBoard(id)
{
	var boardId = id;
	$.ajax({
		  type: "POST",
		  url: "board/getBoard",
		  data: {id:id},
		  dataType:"json",
		  success: function (response) {
		  		$("#bgRed").hide();
		  		$("#bgYellow").hide();
		  		$("#bgGreen").hide();
		  		$("#bgBlue").hide();
			  	$.each(response, function(idx, response){
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
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getBoardFavorite(id)
{
	var boardId = id;
	var userId = $("#hiddenUserId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getFavorite",
		  data: {boardId:boardId,userId:userId},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		if(response.boardId == boardId && response.userId == userId && response.favoriteCheck == "1")
			  		{
						$("#testfav").prop('checked', true);
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

function getBoardSubscribe(id)
{
	var boardId = id;
	var userId = $("#hiddenUserId").val();
	$.ajax({
		  type: "POST",
		  url: "board/getSubscribe",
		  data: {boardId:boardId,userId:userId},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		if(response.boardId == boardId && response.userId == userId && response.subscribeChecked == "1")
			  		{
						$("#testsub").prop('checked', true);
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
			  url: "board/getList",
			  data: {boardId:boardId},
			  dataType:"json",
			  success: function (response) {
				  	$.each(response, function(idx, response){
				  		var listId = response.listId;
				  		if(response.listArchive == "0" && response.listStatus == "1")
				  		{
				  			$.ajax({
								async:false,
								  type: "POST",
								  url: "board/getCard",
								  data: {listId:listId},
								  dataType:"json",
								  success: function (response) {
									  	$.each(response, function(idx, response){
									  		var cardId = response.cardId;
									  		if(response.cardArchive == "0" && response.cardStatus == "1")
									  		{
									  			var startDate = getStartDateGantt(cardId);
									  			var dueDate = getDueDateGantt(cardId);
									  			//alert(startDate); //2018-04-12 12:00:00
									  			var split = startDate.split(" ");
									  			var split2 = dueDate.split(" ");
									  			if(startDate != "" && dueDate != "" && dueDate > startDate)
									  			{
									  				var check = getChecklistChart(cardId);
									  				var split3 = check.split(" ");
									  				var checklistTitle = split3[0];
									  				var progress = split3[1];
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
												      if(checklistTitle != "")
												      {
												      	rows.push([r1,r2,r3,r4,r5,r6,r7,r8]);
												      }
												      //alert(rows);
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
				  		}
				    });
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				alert(xhr.responseText);
			  }
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
	     	$("#chart_div").append("<p>You have to create a card that has a Start Date, Due Date and a Checklist with item</p>");
	    }
      
    }

	$("#modalganttchart").openModal();
}



$(document).keypress(function(e) {
    if(e.which == 13) {
        createChat();
    }
});

$(document).ready(function() {
    //
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
			alert("Chat");
		  }
		});
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