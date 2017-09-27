<?php
// This script adds playlist selections to the db
// It is called via AJAX
require_once '../classes/PDO.php';

// Check for post variables
if (isset($_POST)) {
	// TODO: Post validation
	$videoId = $_POST['videoId'];
	$title = $_POST['title'];
	$thumbnail = $_POST['thumbnail'];
	$duration = $_POST['duration'];
	$type = $_POST['type'];

	// check if username is set
	if (isset($_COOKIE['username'])) {
		$requested_by = $_COOKIE['username'];
	} else {
		$requested_by = '_anonymous';
	}

	// connect to db
	$pdo = new PDOmysql();

	$values = array($videoId, $title, $thumbnail, $duration, $type, $requested_by);
	$fields = array('youtube_id', 'title', 'thumbnail', 'length', 'type', 'requested_by');

	// Check if admin or not
	if (isset($_COOKIE['desktop-admin']) || isset($_COOKIE['mobile-admin'])) {
		$playlist_table = 'admin_playlist';
	} else {
		$playlist_table = 'users_playlist';
	}

	// Insert into playlist table
	$pdo->insert($playlist_table, $fields, $values);

} else {
	echo 'failed';
}
