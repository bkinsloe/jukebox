<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- font-awesome icons -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
	<!-- bootstrap styles -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- main stylesheet -->
	<link href="styles.css?<?php echo time(); ?>" rel="stylesheet">

  <!-- jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>

</head>
<body>
	<div id="header">
		<div class="wrapper">
			<div class="col-sm-9">
				<h1>BBQ Jukebox</h1>
			</div>
			<div class="col-sm-3 text-right">
				<?php if (isset($_COOKIE['username'])) { ?>
				<span class="username"><?php echo 'Hi ' .  $_COOKIE['username']; ?></span>
				<a href="/jukebox/logout.php">(Sign out)</a>
				<?php } //END if username set ?>
			</div>
			<div class="clear">
			</div>
		</div>
	</div>

	<div id="content">
		<div class="wrapper">
