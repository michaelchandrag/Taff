function cekLogout()
{
    $.ajax({
          type: "POST",
          url: "admlogin/logout",
          success: function (response) {
                window.location.href = "login";
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function reportBoardPDF()
{
  var boardId  = $("#reportBoardId").val();
  if(boardId != "")
  {
    window.location.href="repadmin/createPDF/"+boardId;
  }
}

function reportBoardExcel()
{
  var boardId  = $("#reportBoardId").val();
  if(boardId != "")
  {
    window.location.href="repadmin/createExcel/"+boardId;
  }
}

function reportWebsitePDF()
{
  var from = $("#reportWebsiteFrom").val();
  var until = $("#reportWebsiteUntil").val();
  var date_from = new Date(from);
  var date_until = new Date(until);
  if((from != "" && until != "") && (date_until > date_from))
    window.location.href="repadmin/websitePDF/"+from+"/"+until;
  else
    alert("error");


}

function reportWebsiteExcel()
{
  var from = $("#reportWebsiteFrom").val();
  var until = $("#reportWebsiteUntil").val();
  var date_from = new Date(from);
  var date_until = new Date(until);
  if((from != "" && until != "") && (date_until > date_from))
    window.location.href="repadmin/websiteExcel/"+from+"/"+until;
  else
    alert("error");
}

function reportUserPDF()
{
  var from = $("#reportWebsiteFrom").val();
  var until = $("#reportWebsiteUntil").val();
  var date_from = new Date(from);
  var date_until = new Date(until);
  if((from != "" && until != "") && (date_until > date_from))
    window.location.href="repadmin/userPDF/"+from+"/"+until;
  else
    alert("error");


}

function reportUserExcel()
{
  var from = $("#reportWebsiteFrom").val();
  var until = $("#reportWebsiteUntil").val();
  var date_from = new Date(from);
  var date_until = new Date(until);
  if((from != "" && until != "") && (date_until > date_from))
    window.location.href="repadmin/userExcel/"+from+"/"+until;
  else
    alert("error");
}