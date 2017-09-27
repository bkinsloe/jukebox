<?php
if (isset($_POST) && !empty($_POST['login-submit'])) {
	$username = $_POST['login-name'];
	$err_msg = '';

	if ($username === "bob7717") {
		setcookie('desktop-admin', $username, time()+60*60*24*30, '/', null);
		setcookie('mobile-admin', $username, time()+60*60*24*30, '/', null);
		setcookie('username', $username, time()+60*60*24*30, '/', null);
		$username = "BoB";
		header('location: http://localhost/jukebox');
	} elseif ($username === "boboverride") {
		setcookie('mobile-admin', $username, time()+60*60*24*30, '/', null);
		setcookie('username', $username, time()+60*60*24*30, '/', null);
		$username = "BoB";
		header('location: http://localhost/jukebox');
	} elseif ( ($username !== "") && (preg_match('/^[A-Za-z0-9_]+$/', $username)) && (strlen($username) <= 20) ) {
		setcookie('username', $username, time()+60*60*24*30, '/', null);
		header('location: http://localhost/jukebox');
	} else {
		$err_msg = 'Please enter a valid username';
		header('location: http://localhost/jukebox');
	}
} else {
	header('location: http://localhost/jukebox');
}
