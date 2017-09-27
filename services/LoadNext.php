<?php
// This script adds playlist selections to the db
// It is called via AJAX
require_once '../classes/PDO.php';

$pdo = new PDOmysql();

// select the next song from users playlist (next on list with 0 plays)
$result = $pdo->select_all('users_playlist', 'plays = 0 LIMIT 1');

// if no result in users playlist, check the admin playlist
if (!$result) {
	// get all the unplayed videos in admin playlist
	$results = $pdo->select_all('admin_playlist', 'plays = 0');

	// if no results in admin playlist, reset all to 0 and select again
	if (!$results) {
		$pdo->update('admin_playlist', 'plays', '0', 'plays <> 0');
		$results = $pdo->select_all('admin_playlist', 'plays = 0');
	}

	// select next song randomly
	$total = count($results);
	$random = mt_rand(0, $total - 1);
	$nextSong = $results[$random];

	// update plays +1
	$pdo->update('admin_playlist', 'plays', '1', 'id = "' . $nextSong['id'] . '"');

	echo $nextSong['youtube_id'];

} else {

	$nextSong = $result[0];

	// update plays +1
	$pdo->update('users_playlist', 'plays', '1', 'id = "' . $nextSong['id'] . '"');

	echo $nextSong['youtube_id'];
}
