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

function detailList(id)
{
  $.ajax({
          type: "POST",
          url: "mlist/getListById",
          data:{listId:id},
          dataType:"json",
          success: function (response) {
            $("#detailListId").val(response.listId);
            $("#detailListBoardId").val(response.listBoardId);
            $("#detailListTitle").val(response.listTitle);
            $("#detailListPosition").val(response.listPosition);
            $("#detailListCreated").val(response.listCreated);
            $("#detailListArchive").val(response.listArchive);
            $("#detailListStatus").val(response.listStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function searchList()
{
  var listId = $("#searchListId").val();
  $.ajax({
          type: "POST",
          url: "mlist/getListById",
          data:{listId:listId},
          dataType:"json",
          success: function (response) {
            $("#detailListId").val(response.listId);
            $("#detailListBoardId").val(response.listBoardId);
            $("#detailListTitle").val(response.listTitle);
            $("#detailListPosition").val(response.listPosition);
            $("#detailListCreated").val(response.listCreated);
            $("#detailListArchive").val(response.listArchive);
            $("#detailListStatus").val(response.listStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveList()
{
  var listId = $("#detailListId").val();
  var listTitle = $("#detailListTitle").val();
  var listPosition = $("#detailListPosition").val();
  var listArchive = $("#detailListArchive").val();
  var listStatus = $("#detailListStatus").val();
  $.ajax({
          type: "POST",
          url: "mlist/setListById",
          data:{listId:listId,listTitle:listTitle,listPosition:listPosition,listArchive:listArchive,listStatus:listStatus},
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

function insertList()
{
  var listTitle = $("#insertListTitle").val();
  var boardId = $("#insertBoardId").val();
  $.ajax({
          type: "POST",
          url: "mlist/createList",
          data:{listTitle:listTitle,boardId:boardId},
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

function checkBoard()
{
  var boardId = $("#detailBoardId").val();
  location.href="cboard?id="+boardId;
}