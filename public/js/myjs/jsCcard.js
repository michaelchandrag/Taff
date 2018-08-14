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

function detailAssign(id)
{
  var assignId = $("#selectAssignId").val();
  $.ajax({
          type: "POST",
          url: "ccard/getAssignById",
          data:{assignId:assignId},
          dataType:"json",
          success: function (response) {
            $("#detailAssignId").val(response.assignId);
            $("#detailAssignCardId").val(response.cardId);
            $("#detailAssignUserId").val(response.userId);
            $("#detailAssignUserName").val(response.userName);
            $("#detailAssignChecked").val(response.assignChecked);
            $("#detailAssignStatus").val(response.assignStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function detailAttachment(id)
{
  var attachmentId = $("#selectAttachmentId").val();
  $.ajax({
          type: "POST",
          url: "ccard/getAttachmentById",
          data:{attachmentId:attachmentId},
          dataType:"json",
          success: function (response) {
            $("#detailAttachmentId").val(response.attachmentId);
            $("#detailAttachmentBoardId").val(response.boardId);
            $("#detailAttachmentCardId").val(response.cardId);
            $("#detailAttachmentTitle").val(response.attachmentTitle);
            $("#detailAttachmentDirectory").val(response.attachmentDirectory);
            $("#detailAttachmentStatus").val(response.attachmentStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function detailChecklist()
{
  var checklistId = $("#selectChecklistId").val();
  $.ajax({
          type: "POST",
          url: "ccard/getChecklistById",
          data:{checklistId:checklistId},
          dataType:"json",
          success: function (response) {
            $("#detailChecklistId").val(response.checklistId);
            $("#detailChecklistCardId").val(response.cardId);
            $("#detailChecklistTitle").val(response.checklistTitle);
            $("#detailChecklistStatus").val(response.checklistStatus);

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
  var itemId = $("#selectItemId").val();
  $.ajax({
          type: "POST",
          url: "ccard/getItemById",
          data:{itemId:itemId},
          dataType:"json",
          success: function (response) {
            $("#detailItemId").val(response.itemId);
            $("#detailItemChecklistId").val(response.checklistId);
            $("#detailItemCardId").val(response.cardId);
            $("#detailItemTitle").val(response.itemTitle);
            $("#detailItemChecked").val(response.itemChecked);
            $("#detailItemStatus").val(response.itemStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function detailComment()
{
  var commentId = $("#selectCommentId").val();
  $.ajax({
          type: "POST",
          url: "ccard/getCommentById",
          data:{commentId:commentId},
          dataType:"json",
          success: function (response) {
            $("#detailCommentId").val(response.commentId);
            $("#detailCommentCardId").val(response.cardId);
            $("#detailCommentBoardId").val(response.boardId);
            $("#detailCommentUserId").val(response.userId);
            $("#detailCommentText").val(response.commentText);
            $("#detailCommentCreated").val(response.commentCreated);
            $("#detailCommentStatus").val(response.commentStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function detailReply()
{
  var replyId = $("#selectReplyId").val();
  $.ajax({
          type: "POST",
          url: "ccard/getReplyById",
          data:{replyId:replyId},
          dataType:"json",
          success: function (response) {
            $("#detailReplyId").val(response.replyId);
            $("#detailReplyCommentId").val(response.commentId);
            $("#detailReplyCardId").val(response.cardId);
            $("#detailReplyBoardId").val(response.boardId);
            $("#detailReplyUserId").val(response.userId);
            $("#detailReplyText").val(response.replyText);
            $("#detailReplyCreated").val(response.replyCreated);
            $("#detailReplyStatus").val(response.replyStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveAssign()
{
  var assignId = $("#detailAssignId").val();
  var userName = $("#detailAssignUserName").val();
  var assignChecked = $("#detailAssignChecked").val();
  var assignStatus = $("#detailAssignStatus").val();
  $.ajax({
          type: "POST",
          url: "ccard/setAssignById",
          data:{assignId:assignId,userName:userName,assignChecked:assignChecked,assignStatus:assignStatus},
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

function saveAttachment()
{
  var attachmentId = $("#detailAttachmentId").val();
  var attachmentTitle = $("#detailAttachmentTitle").val();
  var attachmentStatus = $("#detailAttachmentStatus").val();
  $.ajax({
          type: "POST",
          url: "ccard/saveAttachmentById",
          data:{attachmentId:attachmentId,attachmentTitle:attachmentTitle,attachmentStatus:attachmentStatus},
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

function saveLabelCard()
{
  var cardId = $("#hiddenCardId").val();
  var boardId = $("#hiddenBoardId").val();
  var labelRed = $("#detailLabelRed").val();
  var labelYellow = $("#detailLabelYellow").val();
  var labelGreen = $("#detailLabelGreen").val();
  var labelBlue = $("#detailLabelBlue").val();
  $.ajax({
          type: "POST",
          url: "ccard/saveLabelCard",
          data:{cardId:cardId,boardId:boardId,labelRed:labelRed,labelYellow:labelYellow,labelGreen:labelGreen,labelBlue:labelBlue},
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

function saveStartDate()
{
    var boardId = $("#hiddenBoardId").val();
    var cardId = $("#hiddenCardId").val();
    var date = $("#detailStartDate").val();
    var time = $("#detailStartDateTime").val();
    $.ajax({
          type: "POST",
          url: "ccard/saveStartDate",
          data:{cardId:cardId,boardId:boardId,date:date,time:time},
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

function saveDueDate()
{
    var boardId = $("#hiddenBoardId").val();
    var cardId = $("#hiddenCardId").val();
    var date = $("#detailDueDate").val();
    var time = $("#detailDueDateTime").val();
    $.ajax({
          type: "POST",
          url: "ccard/saveDueDate",
          data:{cardId:cardId,boardId:boardId,date:date,time:time},
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

function saveChecklist()
{
  var checklistId = $("#detailChecklistId").val();
  var checklistTitle = $("#detailChecklistTitle").val();
  var checklistStatus = $("#detailChecklistStatus").val();
  $.ajax({
          type: "POST",
          url: "ccard/saveChecklist",
          data:{checklistId:checklistId,checklistTitle:checklistTitle,checklistStatus:checklistStatus},
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

function saveItem()
{
  var itemId = $("#detailItemId").val();
  var itemTitle = $("#detailItemTitle").val();
  var itemChecked = $("#detailItemChecked").val();
  var itemStatus = $("#detailItemStatus").val();
  $.ajax({
          type: "POST",
          url: "ccard/saveItemById",
          data:{itemId:itemId,itemTitle:itemTitle,itemChecked:itemChecked,itemStatus:itemStatus},
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

function saveComment()
{
  var commentId = $("#detailCommentId").val();
  var commentText = $("#detailCommentText").val();
  var commentStatus = $("#detailCommentStatus").val();
  $.ajax({
          type: "POST",
          url: "ccard/saveCommentById",
          data:{commentId:commentId,commentText:commentText,commentStatus:commentStatus},
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

function saveReply()
{
  var replyId = $("#detailReplyId").val();
  var replyText = $("#detailReplyText").val();
  var replyStatus = $("#detailReplyStatus").val();
  $.ajax({
          type: "POST",
          url: "ccard/saveReplyById",
          data:{replyId:replyId,replyText:replyText,replyStatus:replyStatus},
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

function insertAssign()
{
  var cardId = $("#hiddenCardId").val();
  var userId = $("#selectAssignUserId").val();
  $.ajax({
          type: "POST",
          url: "ccard/createAssign",
          data:{userId:userId,cardId:cardId},
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

function insertAttachment()
{
  var boardId = $("#hiddenBoardId").val();
  var cardId = $("#hiddenCardId").val();
  var computer = $("#fileAttachment").val();
  //computer = computer.toLowerCase();
  var parse1 = computer.substr( (computer.lastIndexOf('.') +1) );
  var title = computer.replace(/C:\\fakepath\\/i, '');
  var rules = false;
  
  if(parse1 == "jpg" || parse1 == "jpeg" || parse1 == "png" || parse1 == "doc" || parse1 == "docx" || parse1 == "pdf" || parse1 == "rar" || parse1 == "zip")
  {
    //alert(parse1);
    rules = true;
  }
    var file_data1 = $('#fileAttachment').prop('files')[0];

    var form_data = new FormData();
    form_data.append('file1', file_data1);
    form_data.append('boardId',boardId);
    form_data.append('cardId',cardId);
    form_data.append('title',title);
    form_data.append('extension',parse1);
    $.ajax({
          url: 'ccard/createAttachment', // point to server-side PHP script
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
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

function insertChecklist()
{
  var cardId = $("#hiddenCardId").val();
  var checklistTitle = $("#insertChecklistTitle").val();
  $.ajax({
          type: "POST",
          url: "ccard/createChecklist",
          data:{checklistTitle:checklistTitle,cardId:cardId},
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

function insertItem()
{
  var cardId = $("#hiddenCardId").val();
  var checklistId = $("#selectInsertItemChecklistId").val();
  var itemTitle = $("#insertItemTitle").val();
  $.ajax({
          type: "POST",
          url: "ccard/createItem",
          data:{itemTitle:itemTitle,cardId:cardId,checklistId:checklistId},
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

function insertComment()
{
  var cardId = $("#hiddenCardId").val();
  var userId =$("#selectInsertCommentUserId").val();
  var commentText = $("#insertCommentText").val();
  $.ajax({
          type: "POST",
          url: "ccard/createComment",
          data:{cardId:cardId,userId:userId,commentText:commentText},
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

function insertReply()
{
  var commentId = $("#selectInsertReplyCommentId").val();
  var userId = $("#selectInsertReplyUserId").val();
  var cardId = $("#hiddenCardId").val();
  var replyText = $("#insertReplyText").val();
   $.ajax({
          type: "POST",
          url: "ccard/createReply",
          data:{cardId:cardId,userId:userId,replyText:replyText,commentId:commentId},
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


function checkCard()
{
  var cardId = $("#detailCardId").val();
  location.href="ccard?id="+cardId;
}