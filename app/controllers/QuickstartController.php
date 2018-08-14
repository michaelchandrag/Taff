<?php

class QuickstartController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
			$client = new Google_Client();
			$client->setApplicationName('Google Calendar API PHP Quickstart');
			$client->setScopes(Google_Service_Calendar::CALENDAR);
			$client->setAuthConfig('client_secret.json');
			$client->setAccessType('offline');
			$client->setRedirectUri('http://taff.top/quickstart');
			// Load previously authorized credentials from a file.
			if (isset($_GET['code'])) {
				echo $_GET['code'];
				$service = new Google_Service_Calendar($client);
				$authCode = $_GET["code"];
				$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
				$client->setAccessToken($accessToken);
				$event = new Google_Service_Calendar_Event(array(
				  'summary' => 'Google I/O 2015',
				  'location' => '800 Howard St., San Francisco, CA 94103',
				  'description' => 'A chance to hear more about Google\'s developer products.',
				  'start' => array(
					'dateTime' => '2018-07-12T09:00:00-07:00',
					'timeZone' => 'America/Los_Angeles',
				  ),
				  'end' => array(
					'dateTime' => '2018-07-13T17:00:00-07:00',
					'timeZone' => 'America/Los_Angeles',
				  ),
				  'recurrence' => array(
					'RRULE:FREQ=DAILY;COUNT=2'
				  ),
				  'attendees' => array(
					array('email' => 'lpage@example.com'),
					array('email' => 'sbrin@example.com'),
				  ),
				  'reminders' => array(
					'useDefault' => FALSE,
					'overrides' => array(
					  array('method' => 'email', 'minutes' => 24 * 60),
					  array('method' => 'popup', 'minutes' => 10),
					),
				  ),
				));
				$event2 = new Google_Service_Calendar_Event(array(
				  'summary' => 'Google I/O 2015',
				  'location' => '800 Howard St., San Francisco, CA 94103',
				  'description' => 'A chance to hear more about Google\'s developer products.',
				  'start' => array(
					'dateTime' => '2018-07-15T09:00:00-07:00',
					'timeZone' => 'America/Los_Angeles',
				  ),
				  'end' => array(
					'dateTime' => '2018-07-16T17:00:00-07:00',
					'timeZone' => 'America/Los_Angeles',
				  ),
				  'recurrence' => array(
					'RRULE:FREQ=DAILY;COUNT=2'
				  ),
				  'attendees' => array(
					array('email' => 'lpage@example.com'),
					array('email' => 'sbrin@example.com'),
				  ),
				  'reminders' => array(
					'useDefault' => FALSE,
					'overrides' => array(
					  array('method' => 'email', 'minutes' => 24 * 60),
					  array('method' => 'popup', 'minutes' => 10),
					),
				  ),
				));
				$calendarId = 'primary';
				$event = $service->events->insert($calendarId, $event);
				$event = $service->events->insert($calendarId, $event2);
				printf('Event created: %s\n', $event->htmlLink);
			} else {
				$authUrl = $client->createAuthUrl();
				header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
				// Fallback behaviour goes here
			}
    }

}

