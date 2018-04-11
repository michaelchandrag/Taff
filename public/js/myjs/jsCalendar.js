$(document).ready(function() {
	$("#calendar").fullCalendar('today');
    $('#calendar').fullCalendar({
	  dayClick: function() {
	  }
	});

	

	var boardId = $("#hiddenBoardId").val();
	getList(boardId);
});

function getList(id)
{
	var boardId = id;
	$.ajax({
		async:false,
		  type: "POST",
		  url: "calendar/getList",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		var listId = response.listId;
			  		if(response.listArchive == "0" && response.listStatus == "1")
			  		{
			  			getCard(listId);
			  		}
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getListDrive(id)
{
	var boardId = id;
	$.ajax({
		async:false,
		  type: "POST",
		  url: "calendar/getList",
		  data: {boardId:boardId},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		var listId = response.listId;
			  		if(response.listArchive == "0" && response.listStatus == "1")
			  		{
			  			getCardDrive(listId);
			  		}
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getCard(id)
{
	var listId = id;
	$.ajax({
		async:false,
		  type: "POST",
		  url: "calendar/getCard",
		  data: {listId:listId},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		var cardId = response.cardId;
			  		if(response.cardArchive == "0" && response.cardStatus == "1")
			  		{
			  			var startDate = getStartDate(cardId);
			  			var dueDate = getDueDate(cardId);
			  			//alert(startDate); //2018-04-12 12:00:00
			  			var split = startDate.split(" ");
			  			var split2 = dueDate.split(" ");
			  			if(startDate != "" && dueDate != "")
			  			{
			  				var event=
							{
								title: response.cardTitle, 
								start:  split[0],
								end: split2[0],
								color:'blue',
								allday:false
							};

							$('#calendar').fullCalendar( 'renderEvent', event, true);
			  			}
			  			else if(startDate != "")
			  			{
			  				var event=
							{
								title: response.cardTitle, 
								start:  split[0],
								color:'green',
								allday:false
							};

							$('#calendar').fullCalendar( 'renderEvent', event, true);
			  			}
			  			else if(dueDate != "")
			  			{
			  				var event=
							{
								title: response.cardTitle, 
								start:  split2[0],
								color:'red',
								allday:false
							};

							$('#calendar').fullCalendar( 'renderEvent', event, true);
			  			}
			  		}
			  		//getDueDate(cardId);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});

}

function getCardDrive(id)
{
	var listId = id;
	$.ajax({
		async:false,
		  type: "POST",
		  url: "calendar/getCard",
		  data: {listId:listId},
		  dataType:"json",
		  success: function (response) {
			  	$.each(response, function(idx, response){
			  		var cardId = response.cardId;
			  		if(response.cardArchive == "0" && response.cardStatus == "1")
			  		{
			  			var startDate = getStartDate(cardId);
			  			var dueDate = getDueDate(cardId);
			  			//alert(startDate); //2018-04-12 12:00:00
			  			var split = startDate.split(" ");
			  			var split2 = dueDate.split(" ");
			  			var idStart = split[2];
			  			var idDue = split2[2];
			  			var title = response.cardTitle;
			  			if(startDate != "" && dueDate != "")
			  			{
			  				var event = {
							  'summary': title,
							  'description': 'Due Date '+title+' from Taff',
							  'start': {
								'dateTime': split[0]+'T'+split[1],
								'timeZone': 'Asia/Jakarta'
							  },
							  'end': {
								'dateTime': split2[0]+'T'+split2[1],
								'timeZone': 'Asia/Jakarta'
							  },
							  'reminders': {
								'useDefault': false,
								'overrides': [
								  {'method': 'email', 'minutes': 24 * 60},
								  {'method': 'popup', 'minutes': 10}
								]
							  }
							};

							var request = gapi.client.calendar.events.insert({
							  'calendarId': 'primary',
							  'resource': event
							});

							request.execute(function(event) {
							  appendPre('Event created: ' + event.htmlLink);
							});
			  			}
			  			else if(dueDate != "")
			  			{
			  				var event = {
							  'summary': title,
							  'description': 'Due Date '+title+' from Taff',
							  'start': {
								'dateTime': split2[0]+'T'+split2[1],
								'timeZone': 'Asia/Jakarta'
							  },
							  'end': {
								'dateTime': split2[0]+'T'+split2[1],
								'timeZone': 'Asia/Jakarta'
							  },
							  'reminders': {
								'useDefault': false,
								'overrides': [
								  {'method': 'email', 'minutes': 24 * 60},
								  {'method': 'popup', 'minutes': 10}
								]
							  }
							};

							var request = gapi.client.calendar.events.insert({
							  'calendarId': 'primary',
							  'resource': event
							});

							request.execute(function(event) {
							  appendPre('Event created: ' + event.htmlLink);
							});
			  			}
			  			else if(startDate != "")
			  			{
			  				var event = {
							  'summary': title,
							  'description': 'Start Date '+title+' from Taff',
							  'start': {
								'dateTime': split[0]+'T'+split[1],
								'timeZone': 'Asia/Jakarta'
							  },
							  'end': {
								'dateTime': '2018-04-12T17:00:00',
								'timeZone': 'Asia/Jakarta'
							  },
							  'reminders': {
								'useDefault': false,
								'overrides': [
								  {'method': 'email', 'minutes': 24 * 60},
								  {'method': 'popup', 'minutes': 10}
								]
							  }
							};

							var request = gapi.client.calendar.events.insert({
							  'calendarId': 'primary',
							  'resource': event
							});

							request.execute(function(event) {
							  appendPre('Event created: ' + event.htmlLink);
							});
			  			}
			  		}
			  		//getDueDate(cardId);
			    });
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
}

function getStartDate(id)
{
	var cardId = id;
	var date = "";
	$.ajax({
		async:false,
		  type: "POST",
		  url: "calendar/getStartDate",
		  data: {cardId:cardId},
		  success: function (response) {
		  	date = response;
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return date;
}

function getDueDate(id)
{
	var cardId = id;
	var date = "";
	$.ajax({
		async:false,
		  type: "POST",
		  url: "calendar/getDueDate",
		  data: {cardId:cardId},
		  success: function (response) {
		  	date = response;
		  },
		  error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			alert(xhr.responseText);
		  }
		});
	return date;
}

function cekLogout()
{
	$.ajax({
		  type: "POST",
		  url: "login/logout",
		  success: function (response) {
			  alert(response);
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
	//alert(boardId);
	getListDrive(boardId);
}

  // Client ID and API key from the Developer Console
  var CLIENT_ID = '1072527821213-c3qc7s3ub6t4m453vohnp9irpiq6b8t7.apps.googleusercontent.com';
  var API_KEY = 'AIzaSyCPc6yxbOd1dd3N7bWNWUzPKQgLNivirvY';

  // Array of API discovery doc URLs for APIs used by the quickstart
  var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

  // Authorization scopes required by the API; multiple scopes can be
  // included, separated by spaces.
  var SCOPES = "https://www.googleapis.com/auth/calendar";

  var authorizeButton = document.getElementById('authorize-button');
  var signoutButton = document.getElementById('signout-button');

  /**
   *  On load, called to load the auth2 library and API client library.
   */
  function handleClientLoad() {
    gapi.load('client:auth2', initClient);
  }

  /**
   *  Initializes the API client library and sets up sign-in state
   *  listeners.
   */
  function initClient() {
    gapi.client.init({
      apiKey: API_KEY,
      clientId: CLIENT_ID,
      discoveryDocs: DISCOVERY_DOCS,
      scope: SCOPES
    }).then(function () {
    	authorizeButton.style.display = 'block';
    	authorizeButton.onclick = handleAuthClick;
    	gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
    });
  }

  /**
   *  Called when the signed in status changes, to update the UI
   *  appropriately. After a sign-in, the API is called.
   */
  function updateSigninStatus(isSignedIn) {
  	if(gapi.auth2.getAuthInstance().isSignedIn.get()==true)
		{
			//insert();
			sync();
			gapi.auth2.getAuthInstance().disconnect();
			//location.reload();
		}
  }

  /**
   *  Sign in the user upon button click.
   */
  function handleAuthClick(event) {
     gapi.auth2.getAuthInstance().signIn();
  }

  /**
   *  Sign out the user upon button click.
   */
  function handleSignoutClick(event) {

  }

  /**
   * Append a pre element to the body containing the given message
   * as its text node. Used to display the results of the API call.
   *
   * @param {string} message Text to be placed in pre element.
   */
  function appendPre(message) {
    var pre = document.getElementById('content');
    var textContent = document.createTextNode(message + '\n');
    pre.appendChild(textContent);
  }

  /**
   * Print the summary and start datetime/date of the next ten events in
   * the authorized user's calendar. If no events are found an
   * appropriate message is printed.
   */



function insert()
	{
		var event = {
		  'summary': 'Google I/O 2015',
		  'location': '800 Howard St., San Francisco, CA 94103',
		  'description': 'A chance to hear more about Google\'s developer products.',
		  'start': {
			'dateTime': '2018-04-12T09:00:00-07:00',
			'timeZone': 'America/Los_Angeles'
		  },
		  'end': {
			'dateTime': '2018-04-20T17:00:00-07:00',
			'timeZone': 'America/Los_Angeles'
		  },
		  'attendees': [
			{'email': 'lpage@example.com'},
			{'email': 'sbrin@example.com'}
		  ],
		  'reminders': {
			'useDefault': false,
			'overrides': [
			  {'method': 'email', 'minutes': 24 * 60},
			  {'method': 'popup', 'minutes': 10}
			]
		  }
		};

		var request = gapi.client.calendar.events.insert({
		  'calendarId': 'primary',
		  'resource': event
		});

		request.execute(function(event) {
		  appendPre('Event created: ' + event.htmlLink);
		});
	}