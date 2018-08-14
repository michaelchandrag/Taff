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

function detailBoard(id)
{
  $.ajax({
          type: "POST",
          url: "mboard/getBoardById",
          data:{boardId:id},
          dataType:"json",
          success: function (response) {
            $("#detailBoardId").val(response.boardId);
            $("#detailBoardOwner").val(response.boardOwner);
            $("#detailBoardTitle").val(response.boardTitle);
            $("#detailBoardCreated").val(response.boardCreated);
            $("#detailBoardClosed").val(response.boardClosed);
            $("#detailBoardGroup").val(response.boardGroup);
            $("#detailBoardStatus").val(response.boardStatus);
            $("#detailBoardBackground").val(response.boardBackground);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function searchBoard()
{
  var boardId = $("#searchBoardId").val();
  $.ajax({
          type: "POST",
          url: "mboard/getBoardById",
          data:{boardId:boardId},
          dataType:"json",
          success: function (response) {
            $("#detailBoardId").val(response.boardId);
            $("#detailBoardOwner").val(response.boardOwner);
            $("#detailBoardTitle").val(response.boardTitle);
            $("#detailBoardCreated").val(response.boardCreated);
            $("#detailBoardClosed").val(response.boardClosed);
            $("#detailBoardGroup").val(response.boardGroup);
            $("#detailBoardStatus").val(response.boardStatus);
            $("#detailBoardBackground").val(response.boardBackground);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveBoard()
{
  var boardId = $("#detailBoardId").val();
  var boardOwner = $("#detailBoardOwner").val();
  var boardTitle = $("#detailBoardTitle").val();
  var boardCreated = $("#detailBoardCreated").val();
  var boardClosed = $("#detailBoardClosed").val();
  var boardStatus = $("#detailBoardStatus").val();
  var boardGroup = $("#detailBoardGroup").val();
  var boardBackground = $("#detailBoardBackground").val();
  $.ajax({
          type: "POST",
          url: "mboard/setBoardById",
          data:{boardId:boardId,boardOwner:boardOwner,boardTitle:boardTitle,boardCreated:boardCreated,boardClosed:boardClosed,boardGroup:boardGroup,boardStatus:boardStatus,boardBackground:boardBackground},
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

function insertBoard()
{
  var boardTitle = $("#insertBoardTitle").val();
  var userId = $("#insertUserId").val();
  var groupId = $("#insertGroupId").val();
  $.ajax({
          type: "POST",
          url: "mboard/createBoard",
          data:{boardTitle:boardTitle,userId:userId,groupId:groupId},
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