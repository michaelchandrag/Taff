function changeProfile()
{
    var image = $("#inputImage").val();
    image = image.toLowerCase();
    var parse1 = image.substring(image.length-3);
    var rules = false;
    $("#errorImage").hide();
    if(parse1 == "jpg" || parse1 == "png")
    {
        rules = true;
    }
    if(rules == true)
    {
        var groupId = $("#hiddenGroupId").val();
        var file_data1 = $('#inputImage').prop('files')[0];

        var form_data = new FormData();
        form_data.append('file1', file_data1);
        form_data.append('groupId',groupId);

        $.ajax({
                url: 'groupProfile/submitImage', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
              success: function (response) {
                var d = new Date();
                  $("#groupImage").attr("src",response+"?"+d.getTime());
                  $("#visitGroupImage").attr("src",response+"?"+d.getTime());
              },
              error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
                alert(xhr.responseText);
              }
            });

    }
    else
        $("#errorImage").show();
}

function changePassword()
{
    //newpass
    //confpass
    var userId = $("#hiddenUserId").val();
    var pass = $("#newpass").val();
    var cpass = $("#confpass").val();
    var rules = false;
    $("#errorChangePassword").hide();
    if(pass.length > 1 && (pass==cpass))
    {
        rules = true;
    }
    if(rules == true)
    {
        alert(userId);
        $.ajax({
          type: "POST",
          url: "userprofile/changePassword",
          data:{userId:userId,userPassword:pass},
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
    else
        $("#errorChangePassword").show();
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

function changeData()
{
    $("#errorName").hide();
    var groupId = $("#hiddenGroupId").val();
    var groupName = $("#groupName").val();
    var groupDescription = $("#groupDescription").val();
    var groupLocation = $("#groupLocation").val();
    var groupWebsite = $("#groupWebsite").val();
    var rules = false;
    if(groupName.length > 3)
        rules = true;
    if(rules == true)
    {
        $.ajax({
              type: "POST",
              url: "groupprofile/changeData",
              data:{groupId:groupId,groupName:groupName,groupDescription:groupDescription,groupWebsite:groupWebsite,groupLocation:groupLocation},
              success: function (response) {
                //alert(response);
                $("#visitGroupBio").empty();
                  $("#visitGroupBio").append("<b><u>Description</u></b></br>");
                  $("#visitGroupBio").append(groupDescription+"</br></br>");
                  $("#visitGroupBio").append("<b><u>Website</u></b></br>");
                  $("#visitGroupBio").append(groupWebsite+"<br></br>");
                  $("#visitGroupBio").append("<b><u>Location</u></b></br>");
                  $("#visitGroupBio").append(groupLocation+"</br></br>");
                  $("#visitGroupName").text(groupName);

              },
              error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
                alert(xhr.responseText);
              }
            });
    }
    else
        $("#errorName").show();
}

function findBoards()
{
    var text = $("#txtFindBoards").val();
    if(text != "")
    {
        window.location.href="home?find="+text;
    }
}

function leaveGroup()
{
  var groupId = $("#hiddenGroupId").val();
  swal({
            title: "Are you sure?",
            text: "You will leave this group!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, leave it!',
            closeOnConfirm: false
          },
          function(){

          $.ajax({
                type: "POST",
                url: "groupprofile/leaveGroup",
                data:{groupId:groupId},
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
            swal("Confirmed!", "You have left this group!", "success");
          });

}

function deleteGroup()
{
  var groupId = $("#hiddenGroupId").val();
  swal({    title: "Are you sure?",
              text: "You will not be able to recover this group!",   
              type: "warning",   
              showCancelButton: true,   
              confirmButtonColor: "#DD6B55",   
              confirmButtonText: "Yes, delete it!",   
              closeOnConfirm: false }, 
              function(){   
              $.ajax({
                    type: "POST",
                    url: "groupprofile/deleteGroup",
                    data:{groupId:groupId},
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
              swal("Deleted!", "Your group has been deleted.", "success"); 
              });
}

function createInvite()
{
  var groupId = $("#hiddenGroupId").val();
  var email = $("#inviteEmail").val();
  $("#wait").show();
  $.ajax({
      type: "POST",
      url: "groupprofile/createInvite",
      data: {groupId:groupId,email:email},
      success: function (response) {
        alert(response);
        $("#wait").hide();
        $("#inviteEmail").val("");
      },
      error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
      alert(xhr.responseText);
      }
    });
  $("#inviteEmail").val();
}

function showMember()
{
  var groupId = $("#hiddenGroupId").val();
  $.ajax({
      type: "POST",
      url: "groupProfile/getGroupMember",
      data: {groupId:groupId},
      dataType:"json",
      success: function (response) {
       // alert(response);
        $("#ajaxMember").empty();
        $.each(response, function(idx, response){
          var directory = response.userImage;
          var name = response.userName;
          var gabung = "";
          gabung += '<div class="row">';
          gabung += '<div class="col s6 m4 l1">';
          gabung += '<img src="'+directory+'" style="border-radius:50%;margin-left:10px;" width="32px" height="32px" alt="Profile" />';
          gabung += '</div>';
          gabung += '<div class="col s6 m8 l11">';
          gabung += '<div style="margin-top:5px;"><a href="userProfile?userId='+response.userId+'">'+name+'</a> ('+response.memberRole+')';
          
          if(response.memberRole == "Admin")
          {
            var userId = $("#hiddenUserId").val();
            if(userId != response.userId)
            {
              gabung += ' -<a href="javascript:void(0);" onclick="changeMemberToMember(\''+response.userId+'\')" class="green-text lighten-2 ultra-small"> Change to Member</a>';
            }
          }
          else if(response.memberRole == "Member")
          {
            gabung += ' -<a href="javascript:void(0);" onclick="changeMemberToAdmin(\''+response.userId+'\')" class="green-text lighten-2 ultra-small"> Change to Admin</a>';
          }
          if(userId != response.userId)
          {
            gabung += ' -<a href="javascript:void(0);" onclick="removeMember(\''+response.userId+'\')" class="red-text lighten-2 ultra-small"> Remove</a>';
          }
          gabung += '</div>';
          gabung += '</div>';
          gabung += '</div>';
          $("#ajaxMember").append(gabung);
          });
      },
      error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
      alert(xhr.responseText);
      }
    });
}

function changeMemberToMember(userId)
{
  var role = "Member";
  var groupId = $("#hiddenGroupId").val();
  changeMember(groupId,userId,role);
}

function changeMemberToAdmin(userId)
{
  var role = "Admin";
  var groupId = $("#hiddenGroupId").val();
  changeMember(groupId,userId,role);
}

function changeMember(groupId,userId,role)
{
  var userId = userId;
  var groupId = groupId;
  var role = role;
  $.ajax({
      type: "POST",
      url: "groupProfile/updateMemberRole",
      data: {groupId:groupId,userId:userId,role:role},
      success: function (response) {
        //alert(response);
        showMember();
      },
      error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
      alert(xhr.responseText);
      }
    });
}

function removeMember(userId)
{
  var groupId = $("#hiddenGroupId").val();
  var userId = userId;
  $.ajax({
      type: "POST",
      url: "groupProfile/removeMember",
      data: {groupId:groupId,userId:userId},
      success: function (response) {
        //alert(response);
        showMember();
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

$(document).ready(function() {
    $(document).keypress(function(e) {
        if(e.which == 13) {
            if($("#txtFindBoards").is(":focus"))
            {
                findBoards();
            }
        }
    });
});