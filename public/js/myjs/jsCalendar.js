$(document).ready(function() {
    $("#calendar").fullCalendar('today');
    $('#calendar').fullCalendar({
      dayClick: function() {
      }
    });
    var boardId = $("#hiddenBoardId").val();
    $.ajax({
        async:false,
          type: "POST",
          url: "calendar/getAll",
          data: {boardId:boardId},
          dataType:"json",
          success: function (response) {
                //console.log(response);
                $.each(response, function(idx, res){
                        var startDate = res.startDate;
                        var dueDate = res.dueDate;
                        var title = res.cardTitle;
                        //alert(startDate); //2018-04-12 12:00:00
                        var split = startDate.split(" ");
                        var split2 = dueDate.split(" ");
                        if(startDate != "" && dueDate != "" && dueDate > startDate)
                        {
                            var event=
                            {
                                title: title, 
                                start:  split[0]+'T'+split[1],
                                end: split2[0]+'T'+split[1],
                                color:'blue',
                                allday:false
                            };

                            $('#calendar').fullCalendar( 'renderEvent', event, true);
                        }
                        else if(startDate != "" && dueDate == "")
                        {
                            var event=
                            {
                                title: title, 
                                start:  split[0]+'T'+split[1],
                                color:'green',
                                allday:false
                            };

                            $('#calendar').fullCalendar( 'renderEvent', event, true);
                        }
                        else if(dueDate != "" && startDate == "")
                        {
                            var event=
                            {
                                title: title, 
                                start:  split2[0]+'T'+split2[1],
                                color:'red',
                                allday:false
                            };

                            $('#calendar').fullCalendar( 'renderEvent', event, true);
                        }
                });
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
    //getList(boardId);
});

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

function sync()
{
    var boardId = $("#hiddenBoardId").val();
    window.open("quickstart?boardId="+boardId);
}