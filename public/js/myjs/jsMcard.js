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
          url: "mcard/getCardById",
          data:{cardId:id},
          dataType:"json",
          success: function (response) {
            $("#detailCardId").val(response.cardId);
            $("#detailCardListId").val(response.cardListId);
            $("#detailCardBoardId").val(response.cardBoardId);
            $("#detailCardOwner").val(response.cardOwner);
            $("#detailCardTitle").val(response.cardTitle);
            $("#detailCardPosition").val(response.cardPosition);
            $("#detailCardCreated").val(response.cardCreated);
            $("#detailCardArchive").val(response.cardArchive);
            $("#detailCardStatus").val(response.cardStatus);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function searchCard()
{
  var cardId = $("#searchCardId").val();
  $.ajax({
          type: "POST",
          url: "mcard/getCardById",
          data:{cardId:cardId},
          dataType:"json",
          success: function (response) {
            $("#detailCardId").val(response.cardId);
            $("#detailCardListId").val(response.cardListId);
            $("#detailCardBoardId").val(response.cardBoardId);
            $("#detailCardOwner").val(response.cardOwner);
            $("#detailCardTitle").val(response.cardTitle);
            $("#detailCardDescription").val(response.cardDescription);
            $("#detailCardPosition").val(response.cardPosition);
            $("#detailCardCreated").val(response.cardCreated);
            $("#detailCardArchive").val(response.cardArchive);
            $("#detailCardStatus").val(response.cardStatus);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
}

function saveCard()
{
  var cardId = $("#detailCardId").val();
  var cardTitle = $("#detailCardTitle").val();
  var cardDescription = $("#detailCardDescription").val();
  var cardPosition = $("#detailCardPosition").val();
  var cardArchive = $("#detailCardArchive").val();
  var cardStatus = $("#detailCardStatus").val();
  $.ajax({
          type: "POST",
          url: "mcard/setCardById",
          data:{cardId:cardId,cardTitle:cardTitle,cardDescription:cardDescription,cardPosition:cardPosition,cardArchive:cardArchive,cardStatus:cardStatus},
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

function insertCard()
{
  var cardTitle = $("#insertCardTitle").val();
  var listId = $("#insertListId").val();
  var userId = $("#insertUserId").val();
  $.ajax({
          type: "POST",
          url: "mcard/createCard",
          data:{cardTitle:cardTitle,listId:listId,userId:userId},
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