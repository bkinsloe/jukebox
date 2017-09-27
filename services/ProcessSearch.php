<?php
// This script processes the youtube search
// It is called via AJAX
require_once '../classes/PDO.php';

if (isset($_GET) && !empty($_GET)) {
	require_once 'Google/Client.php';
	require_once 'Google/Service/YouTube.php';
	$client = new Google_Client();
	//$client->setApplicationName("Client_Library_Examples");
	$client->setClientId('CLIENT_ID');
	$client->setClientSecret('CLIENT_SECRET');
	$client->setRedirectUri('/jukebox/services');
	$client->setDeveloperKey('DEVELOPER_KEY');
	$youtube = new Google_Service_Youtube($client);
	$optParams = array('q' => $_GET['yt'], 'maxResults' => '8', 'videoEmbeddable' => 'true', /*'videoSyndicated' => 'true',*/ 'type' => 'video');
	$response = $youtube->search->listSearch('id,snippet', $optParams);

	if ( (isset($response)) && (count($response) > 0) ) {
		$videoIds = array();
		foreach ($response['items'] as $searchResult) {
			if ($searchResult['id']['kind'] === 'youtube#video') {
				$title = $searchResult['snippet']['title'];
				$videoId = $searchResult['id']['videoId'];
				array_push($videoIds, $videoId);
				$thumbnail = 'http://img.youtube.com/vi/'. $videoId .'/0.jpg';

				// Get durations of each video with next call
				$details = $youtube->videos->listVideos('contentDetails', array('id' => $videoId, 'fields' => 'items'));
				foreach($details['items'] as $detail) {
					$duration = parse_duration($detail['contentDetails']['duration']);
				}

				echo '<li><a id="' . $videoId . '" class="'. $duration .'"><img src="' . $thumbnail . '" alt="' . $title . '"><p class="title">' . $title . '</p><span class="duration">'. $duration .'</span></a></li>';
			}
		}

	} elseif ( (isset($response)) && (count($response) < 1) ) {
		echo '<li><p>No results.</p></li>';
	}
} else {
	echo '<li>Invalid Search</li>';
}


// Takes string in format: PT1H15M47S, convert and return total seconds
function parse_duration($string) {
	$hours = 0;
	$minutes = 0;
	$seconds = 0;

	// trim the PT from front of string
	$string = str_replace('PT', '', $string);

	if (strpos($string, "H") !== FALSE) {
		$exploded = explode("H", $string);
		$hours = $exploded[0];
		$string = $exploded[1];
	}
	if (strpos($string, "M") !== FALSE) {
		$exploded = explode("M", $string);
		$minutes= $exploded[0];
		$string = $exploded[1];
	}
	if (strpos($string, "S") !== FALSE) {
		$exploded = explode("S", $string);
		$seconds = $exploded[0];
		$string = $exploded[1];
	}

	$totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

	return $totalSeconds;
}