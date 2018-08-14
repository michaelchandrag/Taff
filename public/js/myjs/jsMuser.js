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

function detailUser(id)
{
  $.ajax({
          type: "POST",
          url: "muser/getUserById",
          data:{userId:id},
          dataType:"json",
          success: function (response) {
            $("#detailUserId").val(response.userId);
            $("#detailUserEmail").val(response.userEmail);
            $("#detailUserName").val(response.userName);
            $("#detailUserBio").val(response.userBio);
            $("#detailUserLocation").val(response.userLocation);
            $("#detailUserGender").val(response.userGender);
            $("#detailUserStatus").val(response.userStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function searchUser()
{
  var userId = $("#searchUserId").val();
  $.ajax({
          type: "POST",
          url: "muser/getUserById",
          data:{userId:userId},
          dataType:"json",
          success: function (response) {
            $("#detailUserId").val(response.userId);
            $("#detailUserEmail").val(response.userEmail);
            $("#detailUserName").val(response.userName);
            $("#detailUserBio").val(response.userBio);
            $("#detailUserLocation").val(response.userLocation);
            $("#detailUserGender").val(response.userGender);
            $("#detailUserStatus").val(response.userStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveUser()
{
  var userId = $("#detailUserId").val();
  var userName = $("#detailUserName").val();
  var userEmail = $("#detailUserEmail").val();
  var userBio = $("#detailUserBio").val();
  var userLocation = $("#detailUserLocation").val();
  var userGender = $("#detailUserGender").val();
  var userStatus = $("#detailUserStatus").val();
  $.ajax({
          type: "POST",
          url: "muser/setUserById",
          data:{userId:userId,userBio:userBio,userName:userName,userEmail:userEmail,userLocation:userLocation,userGender:userGender,userStatus:userStatus},
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

function insertUser()
{
  var userName = $("#insertUserName").val();
  var userEmail = $("#insertUserEmail").val();
  var userPassword = $("#insertUserPassword").val();
  $.ajax({
          type: "POST",
          url: "muser/createUser",
          data:{userName:userName,userEmail:userEmail,userPassword:userPassword},
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