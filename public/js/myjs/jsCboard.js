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

function detailMember(id)
{
  $.ajax({
          type: "POST",
          url: "cboard/getMemberById",
          data:{memberId:id},
          dataType:"json",
          success: function (response) {
            $("#detailMemberId").val(response.memberId);
            $("#detailUserId").val(response.userId);
            $("#detailMemberCreated").val(response.memberCreated);
            $("#detailMemberRole").val(response.memberRole);
            $("#detailMemberStatus").val(response.memberStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function searchMember()
{
  var memberId = $("#searchMemberId").val();
  $.ajax({
          type: "POST",
          url: "cboard/getMemberById",
          data:{memberId:memberId},
          dataType:"json",
          success: function (response) {
            $("#detailMemberId").val(response.memberId);
            $("#detailUserId").val(response.userId);
            $("#detailMemberCreated").val(response.memberCreated);
            $("#detailMemberRole").val(response.memberRole);
            $("#detailMemberStatus").val(response.memberStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveMember()
{
  var memberId = $("#detailMemberId").val();
  var userId = $("#detailUserId").val();
  var memberCreated = $("#detailMemberCreated").val();
  var memberRole = $("#detailMemberRole").val();
  var memberStatus = $("#detailMemberStatus").val();
  $.ajax({
          type: "POST",
          url: "cboard/setMemberById",
          data:{memberId:memberId,memberRole:memberRole,memberStatus:memberStatus},
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

function saveCollaborator()
{
  var boardId = $("#hiddenBoardId").val();
  var collListCreate = $("#collListCreate").val();
  var collListEdit = $("#collListEdit").val();
  var collListDelete = $("#collListDelete").val();
  var collCardCreate = $("#collCardCreate").val();
  var collCardEdit = $("#collCardEdit").val();
  var collCardDelete = $("#collCardDelete").val();
  var collActAM = $("#collActAM").val();
  var collActLabel = $("#collActLabel").val();
  var collActChecklist = $("#collActChecklist").val();
  var collActStart = $("#collActStart").val();
  var collActDue = $("#collActDue").val();
  var collActAttachment = $("#collActAttachment").val();
  var collStatus = $("#collStatus").val();
  $.ajax({
          type: "POST",
          url: "cboard/setCollaboratorById",
          data:{boardId:boardId,collListCreate:collListCreate,collListEdit:collListEdit,collListDelete:collListDelete,collCardCreate:collCardCreate,collCardEdit:collCardEdit,collCardDelete:collCardDelete,collActAM:collActAM,collActLabel:collActLabel,collActChecklist:collActChecklist,collActStart:collActStart,collActDue:collActDue,collActAttachment:collActAttachment,collStatus:collStatus},
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

function saveClient()
{
  var boardId = $("#hiddenBoardId").val();
  var cliListCreate = $("#cliListCreate").val();
  var cliListEdit = $("#cliListEdit").val();
  var cliListDelete = $("#cliListDelete").val();
  var cliCardCreate = $("#cliCardCreate").val();
  var cliCardEdit = $("#cliCardEdit").val();
  var cliCardDelete = $("#cliCardDelete").val();
  var cliActAM = $("#cliActAM").val();
  var cliActLabel = $("#cliActLabel").val();
  var cliActChecklist = $("#cliActChecklist").val();
  var cliActStart = $("#cliActStart").val();
  var cliActDue = $("#cliActDue").val();
  var cliActAttachment = $("#cliActAttachment").val();
  var cliStatus = $("#cliStatus").val();
  $.ajax({
          type: "POST",
          url: "cboard/setClientById",
          data:{boardId:boardId,cliListCreate:cliListCreate,cliListEdit:cliListEdit,cliListDelete:cliListDelete,cliCardCreate:cliCardCreate,cliCardEdit:cliCardEdit,cliCardDelete:cliCardDelete,cliActAM:cliActAM,cliActLabel:cliActLabel,cliActChecklist:cliActChecklist,cliActStart:cliActStart,cliActDue:cliActDue,cliActAttachment:cliActAttachment,cliStatus:cliStatus},
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

function savePdate()
{
  var boardId = $("#hiddenBoardId").val();
  var date = $("#progressDate").val();
  $.ajax({
      type: "POST",
      url: "cboard/setProgressDateById",
      data: {boardId:boardId,date:date},
      success: function (response) {
        location.reload();
        //alert(response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
      alert(xhr.responseText);
      }
    });
}

function deleteChat()
{
  var boardId = $("#hiddenBoardId").val();
  $.ajax({
      type: "POST",
      url: "cboard/deleteChatById",
      data: {boardId:boardId},
      success: function (response) {
        location.reload();
        //alert(response);
      },
      error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
      alert(xhr.responseText);
      }
    });
}

function inviteUser()
{
  var boardId = $("#hiddenBoardId").val();
  var userId = $("#inviteUserId").val();
  $.ajax({
      type: "POST",
      url: "cboard/inviteUserById",
      data: {boardId:boardId,userId:userId},
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

function insertPitem()
{
  var boardId = $("#hiddenBoardId").val();
  var itemTitle = $("#insertProgressItemTitle").val();
  $.ajax({
      type: "POST",
      url: "cboard/insertItemById",
      data: {boardId:boardId,itemTitle:itemTitle},
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

function detailItem()
{
  var itemId = $("#progressItem").val();
  $.ajax({
      type: "POST",
      url: "cboard/getItemById",
      data: {itemId:itemId},
      dataType:"json",
      success: function (response) {
        $("#progressItemId").val(response.progressItemId);
        $("#progressItemTitle").val(response.itemTitle);
        $("#progressItemChecked").val(response.itemChecked);
        $("#progressItemStatus").val(response.itemStatus);
      },
      error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
      alert(xhr.responseText);
      }
    });
}

function saveItem()
{
  var itemId = $("#progressItemId").val();
  var itemTitle = $("#progressItemTitle").val();
  var itemChecked = $("#progressItemChecked").val();
  var itemStatus = $("#progressItemStatus").val();
  $.ajax({
      type: "POST",
      url: "cboard/saveItemById",
      data: {itemId:itemId,itemTitle:itemTitle,itemChecked:itemChecked,itemStatus:itemStatus},
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
  location.href="mboard/checkBoard/"+boardId;
}