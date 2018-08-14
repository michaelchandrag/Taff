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

function detailGroup(id)
{
  $.ajax({
          type: "POST",
          url: "mgroup/getGroupById",
          data:{groupId:id},
          dataType:"json",
          success: function (response) {
            $("#detailGroupId").val(response.groupId);
            $("#detailGroupName").val(response.groupName);
            $("#detailGroupDescription").val(response.groupDescription);
            $("#detailGroupWebsite").val(response.groupWebsite);
            $("#detailGroupLocation").val(response.groupLocation);
            $("#detailGroupStatus").val(response.groupStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function searchGroup()
{
  var groupId = $("#searchGroupId").val();
  $.ajax({
          type: "POST",
          url: "mgroup/getGroupById",
          data:{groupId:groupId},
          dataType:"json",
          success: function (response) {
            $("#detailGroupId").val(response.groupId);
            $("#detailGroupName").val(response.groupName);
            $("#detailGroupDescription").val(response.groupDescription);
            $("#detailGroupWebsite").val(response.groupWebsite);
            $("#detailGroupLocation").val(response.groupLocation);
            $("#detailGroupStatus").val(response.groupStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveGroup()
{
  var groupId = $("#detailGroupId").val();
  var groupName = $("#detailGroupName").val();
  var groupDescription = $("#detailGroupDescription").val();
  var groupWebsite = $("#detailGroupWebsite").val();
  var groupLocation = $("#detailGroupLocation").val();
  var groupStatus = $("#detailGroupStatus").val();
  $.ajax({
          type: "POST",
          url: "mgroup/setGroupById",
          data:{groupId:groupId,groupName:groupName,groupDescription:groupDescription,groupWebsite:groupWebsite,groupLocation:groupLocation,groupStatus:groupStatus},
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

function insertGroup()
{
  var groupName = $("#insertGroupName").val();
  var userId = $("#insertUserId").val();
  alert(userId);
  $.ajax({
          type: "POST",
          url: "mgroup/createGroup",
          data:{groupName:groupName,userId:userId},
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

function getMemberByGroupId()
{
  var groupId = $("#memberGroupId").val();
  $('#removeMemberUserId').material_select();
  $.ajax({
          type: "POST",
          url: "mgroup/getMemberByGroupId",
          data:{groupId:groupId},
          dataType:"json",
          success: function (response) {
            $("#removeMemberUserId").empty();
            $.each(response, function(idx, response){
              $("#removeMemberUserId").append("<option value='"+response.userId+"'>"+response.userId+"</option>");
            });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function insertMember()
{
  var groupId = $("#memberGroupId").val();
  var userId = $("#insertMemberUserId").val();
  $.ajax({
          type: "POST",
          url: "mgroup/insertMember",
          data:{groupId:groupId,userId:userId},
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

function removeMember()
{
  var groupId = $("#memberGroupId").val();
  var userId = $("#removeMemberUserId").val();
  $.ajax({
          type: "POST",
          url: "mgroup/removeMember",
          data:{groupId:groupId,userId:userId},
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