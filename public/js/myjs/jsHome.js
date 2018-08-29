function createBoard()
{
	var title = $("#boardTitle").val();
	var owner = $("#hiddenOwnerId").val();
	//alert(owner);
	$("#errorBoardTitle").hide();
	var rules = true;
	if(title == "")
	{
		rules = false;
		$("#errorBoardTitle").show();
	}
	if(rules == true)
	{
		$.ajax({
			  type: "POST",
			  url: "home/createBoard",
			  data: {title:title,owner:owner},
			  success: function (response) {
			  	alert(response);
				  var gabung = "";
				  var date = new Date();
				  var tgl = date.getDate();
				  tgl = (tgl<10 ? '0' : '') + tgl
				  var bln = date.getMonth()+1;
  			  	if(bln == "1")
			  	{
			  		bln = "Jan";
			  	}
			  	else if(bln == "2")
			  	{
			  		bln = "Feb";
			  	}
			  	else if(bln == "3")
			  	{
			  		bln = "Mar";
			  	}
			  	else if(bln == "4")
			  	{
			  		bln = "Apr";
			  	}
			  	else if(bln == "5")
			  	{
			  		bln = "May";
			  	}
			  	else if(bln == "6")
			  	{
			  		bln = "Jun";
			  	}
			  	else if(bln == "7")
			  	{
			  		bln = "Jul";
			  	}
			  	else if(bln == "8")
			  	{	
			  		bln = "Aug";
			  	}
			  	else if(bln == "9")
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
				  var thn = date.getFullYear();
				  var date2 = tgl + " " + bln + " " + thn;
				  gabung += '<div class="col s12 m6 l3">';
				  gabung += '<a href="board?id='+response+'" >';
				  gabung += '<div class="card">';
				  gabung += '<div class="card-content blue black-text">';
				  gabung += '<h2 class="card-stats-title">'+title+'</h2>';
				  gabung += '</div>';
				  gabung += '<div class="card-action  blue darken-2">';
				  gabung += '<div id="invoice-line" class="center-align black-text">'+date2+'</div>';
				  gabung += '</div>';
				  gabung += '</div>';
				  gabung += '</a>';
				  gabung += '</div>';
				  $("#ajaxBoard"+owner).append(gabung);
				  $("#modalcreateboard").closeModal();
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
		$("#errorBoardTitle").show();
	}

}

function createGroup()
{
	var name = $("#groupName").val();
	var rules = true;
	$("#errorGroupTitle").hide();
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
				  //alert(response);
				  /*var gabung = "";
				  gabung += '<p class="caption"><img src="images/user/group.png" width="20px" height="20px" alt="Profile" /><a href="#" class="black-text"> <b>'+name+'</b> </a></p>';
				  gabung += '<div id="card-stats">';
				  gabung += '<div class="row">';
				  gabung += '<div id="ajaxBoard'+response+'" style="margin-top:-25px;">';
				  gabung += '</div>';
				  gabung += '<div class="col s12 m6 l3">';
				  gabung += '<div class="card">';
				  gabung += '<div class="card-content grey white-text">';
				  gabung += '<a href="#modalcreateboard" class="modal-trigger" onclick="hiddenGroupId(\''+response+'\')">';
				  gabung += '<h2 class="card-stats-title white-text">Create a new Board..</h2>';
				  gabung +=  '</a>';
				  gabung += '</div>';
				  gabung += '</div>';
				  gabung += '</div>';
				  gabung += '</div>';
				  gabung += '</div>';
				  gabung += "<div class='divider'></div>";
				  $("#ajaxGroup").append(gabung);
				  $("#groupName").val("");*/
				  location.reload();
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
		$("#errorGroupTitle").show();
	}

}

function hiddenGroupId(id)
{
	$("#hiddenOwnerId").val(id);
	var asd = $("#hiddenOwnerId").val();
	//alert(asd);
}

function cekLogout()
{
	$.ajax({
		  type: "POST",
		  url: "login/logout",
		  success: function (response) {
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

function openClosedBoard()
{
	$("#modalclosedboards").openModal();
	$("#closedboard").empty();
	$.ajax({
		async:false,
		  type: "POST",
		  url: "home/getClosedBoard",
		  data: {},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		if(response.boardClosed == "1" && response.boardStatus == "1")
			  		{
			  			$("#closedboard").append('<p id="p'+response.boardId+'">'+response.boardTitle+' <a href="javascript:void(0)" onclick="openBoard(\''+response.boardId+'\')" class="ultra-small green-text">Re-open </a><a href="javascript:void(0)" onclick="deleteBoard(\''+response.boardId+'\')" class="ultra-small red-text">Delete</a></p>');
			  		}
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

	/*
	<p>Board Satu <a href="#" class="ultra-small green-text">Re-open </a><a href="#" class="ultra-small red-text">Delete</a></p>
	<p>Board Dua <a href="#" class="ultra-small green-text">Re-open </a><a href="#" class="ultra-small red-text">Delete</a></p>
	*/
}

function openBoard(id)
{
	var boardId = id;
	var status = "0";
	$.ajax({
		  type: "POST",
		  url: "home/setClosedBoard",
		  data: {boardId:boardId,status:status},
		  success: function (response) {
		  	//alert(response);
		  	$("#p"+id).remove();
		  	location.reload();
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function deleteBoard(id)
{
	var boardId = id;
	var status = "0";
	$.ajax({
		  type: "POST",
		  url: "home/setStatusBoard",
		  data: {boardId:boardId,status:status},
		  success: function (response) {
		  	//alert(response);
		  	$("#p"+id).remove();
		  	alert(response);
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function setFilter()
{
	if($("#filterred").is(":checked") == false && $("#filteryellow").is(":checked") == false && $("#filtergreen").is(":checked") == false && $("#filterblue").is(":checked") == false && $("#filterview1").is(":checked") == false && $("#filterview2").is(":checked") == false)
	{
		var jumlahBoard = $(".boardUser").length;
		for(var i=0;i<jumlahBoard;i++)
		{	
			$(".colBoardUser:eq("+i+")").show();
		}
	}
	else
	{
		if($("#filterred").is(":checked"))
		{
			setDisplayBoard("red","show");
		}
		else
		{
			setDisplayBoard("red","hide");
		}
		if($("#filteryellow").is(":checked"))
		{
			setDisplayBoard("yellow","show");
			
		}
		else
		{
			setDisplayBoard("yellow","hide");
		}
		if($("#filtergreen").is(":checked"))
		{
			setDisplayBoard("green","show");
			
		}
		else
		{
			setDisplayBoard("green","hide");
		}
		if($("#filterblue").is(":checked"))
		{
			setDisplayBoard("blue","show");
			
		}
		else
		{
			setDisplayBoard("blue","hide");
		}
		if($("#filterview1").is(":checked"))
		{
			setDisplayBoard("view1","show");
			
		}
		else
		{
			setDisplayBoard("view1","hide");
		}
		if($("#filterview2").is(":checked"))
		{
			setDisplayBoard("view2","show");
			
		}
		else
		{
			setDisplayBoard("view2","hide");
		}
	}
	
}

function setDisplayBoard(color,status)
{
	var jumlahBoard = $(".boardUser").length;
	for(var i=0;i<jumlahBoard;i++)
	{	
		if($(".boardUser:eq("+i+")").hasClass(color))
		{
			if(status == "show")
			{
				$(".colBoardUser:eq("+i+")").show();
			}
			else if(status == "hide")
			{
				$(".colBoardUser:eq("+i+")").hide();
			}
		}
	}
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
    Materialize.toast('<span>New to taff.top?<br>Go create board for one of your project !</span>', 6000);
    Materialize.toast('<span>Do you want to make a team? <br>Create a group board, then start to create your board! </span>', 8000);
    $(document).keypress(function(e) {
	    if(e.which == 13) {
	        if($("#txtFindBoards").is(":focus"))
	        {
	        	findBoards();
	        }
	    }
	});
});

