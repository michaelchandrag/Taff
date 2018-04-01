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
				  gabung += '<div class="secondary-content yellow"><i class="mdi-action-grade"></i></div>';
				  gabung += '<div class="card-content green white-text">';
				  gabung += '<h2 class="card-stats-title">'+title+'</h2>';
				  gabung += '</div>';
				  gabung += '<div class="card-action  green darken-2">';
				  gabung += '<div id="invoice-line" class="center-align black-text">'+date2+'</div>';
				  gabung += '</div>';
				  gabung += '</div>';
				  gabung += '</a>';
				  gabung += '</div>';
				  $("#ajaxBoard"+owner).append(gabung);
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
				  //alert(response);
				  var gabung = "";
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
				  $("#groupName").val("");
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
