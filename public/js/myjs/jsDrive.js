// The Browser API key obtained from the Google API Console.
// Replace with your own Browser API key, or your own key.
var developerKey = 'AIzaSyCPc6yxbOd1dd3N7bWNWUzPKQgLNivirvY';

// The Client ID obtained from the Google API Console. Replace with your own Client ID.
var clientId = "1072527821213-85dpr667g5dlr9efvgdsinbf9sfhl9re.apps.googleusercontent.com"

// Replace with your own project number from console.developers.google.com.
// See "Project number" under "IAM & Admin" > "Settings"
var appId = "1072527821213";

// Scope to use to access user's Drive items.
var scope = ['https://www.googleapis.com/auth/drive'];

var pickerApiLoaded = false;
var oauthToken;

function loadPicker() {
  gapi.load('auth', {'callback': onAuthApiLoad});
  gapi.load('picker', {'callback': onPickerApiLoad});
}

function onAuthApiLoad() {
    gapi.auth.authorize(
      {
        'client_id': clientId,
        'scope': scope,
        'immediate': false
      },
      handleAuthResult);
}

function onPickerApiLoad() {
  pickerApiLoaded = true;
  createPicker();
}

function handleAuthResult(authResult) {
  if (authResult && !authResult.error) {
    oauthToken = authResult.access_token;
    createPicker();
  }
}

// Create and render a Picker object for searching images.
function createPicker() {
  if (pickerApiLoaded && oauthToken) {
    var view = new google.picker.View(google.picker.ViewId.DOCS);
    view.setMimeTypes("image/png,image/jpeg,image/jpg,application/pdf,application/zip");
    var picker = new google.picker.PickerBuilder()
        .enableFeature(google.picker.Feature.NAV_HIDDEN)
        .setAppId(appId)
        .setOAuthToken(oauthToken)
        .addView(new google.picker.DocsView().setIncludeFolders(true).setOwnedByMe(true))
        .setDeveloperKey(developerKey)
        .setCallback(pickerCallback)
        .build();
        picker.setVisible(true);
    var elements= document.getElementsByClassName('picker-dialog');
    for(var i=0;i<elements.length;i++)
    {
        elements[i].style.zIndex = "2000";
    }
        //picker.setVisible(true);
  }
}

// A simple callback implementation.
function pickerCallback(data) {
  if (data.action == google.picker.Action.PICKED) {
    var fileId = data.docs[0].id;
    var title = data.docs[0].name;
    var boardId = $("#hiddenBoardId").val();
    var cardId = $("#hiddenCardId").val();
    var parse1 = title.substr( (title.lastIndexOf('.') +1) );
    //alert('The user selected: ' + fileId+" " + oauthToken);
    $.ajax({
          type: "POST",
          url: "drive/download",
          data: {fileId:fileId,oauthToken:oauthToken,boardId:boardId,cardId:cardId,title:title,extension:parse1},
          success: function (response) {
            window.location.href="board?id="+boardId;
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
            alert(xhr.responseText);
          }
        });
    
  }
}