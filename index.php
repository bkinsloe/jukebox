<?php

# -- USER TODO:
# X get duration by iterating over each result: $youtube->videos->listVideos('snippet', array('id'=>$videoId)); comma separate all id's in one call
# x create fancier user search results list.
# X store selected video id in playlist database
# - return approx time when user selection will play
# - limit # of user selections (5ish?) or repeats?
# - add soundcloud search capability
# X usernames? cookies/session
# X parse duration

# -- ADMIN TODO:
# X autoplay next video in playlist
# X detect/time when video is finished
# x create admin playlist to play from when no user video is selected
# - playback options for admin: priority selection

if (isset($_POST) && !empty($_POST['login-submit'])) {
	$username = $_POST['login-name'];
	$err_msg = '';

	// determine privileges and set cookies based on username
	if ($username === "bob7717") {
		setcookie('desktop-admin', $username, time()+60*60*24*30, '/', null);
		setcookie('mobile-admin', $username, time()+60*60*24*30, '/', null);
		setcookie('username', 'BoB', time()+60*60*24*30, '/', null);
	} elseif ($username === "boboverride") {
		setcookie('mobile-admin', $username, time()+60*60*24*30, '/', null);
		setcookie('username', 'BoB', time()+60*60*24*30, '/', null);
	} elseif ( ($username !== "") && (preg_match('/^[A-Za-z0-9 _]+$/', $username)) && (strlen($username) <= 20) ) {
		setcookie('username', $username, time()+60*60*24*30, '/', null);
	} else {
		$err_msg = 'Please enter a valid username';
	}
	header("location: /jukebox");
} else {

}

if (isset($_POST['delete'])) {
	if (isset($_COOKIE['username'])) {
		unset($_COOKIE['username']);
		setcookie('username', '', time() - 3600); // empty value and old timestamp
	}
	if (isset($_COOKIE['mobile-admin'])) {
		unset($_COOKIE['mobile-admin']);
		setcookie('mobile-admin', '', time() - 3600); // empty value and old timestamp
	}
	if (isset($_COOKIE['desktop-admin'])) {
		unset($_COOKIE['desktop-admin']);
		setcookie('desktop-admin', '', time() - 3600); // empty value and old timestamp
	}
	header("location: /jukebox");
}

?>

<?php include 'header.php'; ?>
<div class="col-md-6">
	<?php
	// if username or admin cookie is set, show the search forms
	if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])) {

	?>

	<form id="youtube-search" method="get" action="" name="youtube-search">
		<label for="yt"><h2 class="margin-top-10">Search YouTube</h2></label><input name="yt" type="search" placeholder="Enter song or artist name">
		<!--<label></label><input name="youtube-submit" type="submit" value="Search!">-->
	</form>

	<div class="search-results">
		<ul>

		</ul>
	</div>

	<?php
	/* else show the login form */
	} else {
	?>

	<div class="login">
		<h2>Enter Username</h2>
		<form id="login-form" method="post" action="" name="login-form">
			<div class="row">
				<div class="col-xs-9">
					<input id="login-name" name="login-name" type="text" maxlength="20">
				</div>
				<div class="col-xs-3">
					<input id="login-submit" name="login-submit" type="submit" value="Submit">
				</div>
			</div>
			<div class="clear"></div>
		</form>
		<span class="error"><?php if (isset($err_msg) && $err_msg !== '') echo $err_msg; ?></span>
	</div>

	<?php } /* end if */ ?>

</div>

<div class="col-md-6">
	<div id="now-playing">
		<h2 class="margin-top-10">Now Playing</h2>

		<?php if (isset($_COOKIE['desktop-admin'])) { /* if desktop-admin cookie is set show the player */ ?>

		<script>
		var player;
		function onYouTubeIframeAPIReady() {
			//var nextSongId = get_next_videoId();
			player = new YT.Player('player', {
				//videoId: 'Nf9FzEmt4mM',
				events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange,
					'onError': onPlayerError
				}
			});

			// Functions for admin controls
			$("a#skip").on('click', function(){
				load_next();
				console.log('skip');
			});

			$("a#pause").on('click', function(){
				player.pauseVideo();
				console.log('pause');
			});

			$("a#play").on('click', function(){
				player.playVideo();
				console.log('play');
			});
		}

		function onPlayerReady(event) {
			load_next();
    	}

    	function onPlayerStateChange(event) {
    		// if video ended, get and load next video
    		if(event.data === 0) {
    			load_next();
    		}
    	}

    	function onPlayerError(event) {
			load_next();
		}

		function load_next(){
			$.ajax({
				url: 'services/LoadNext.php',
				success: function(response){ // response = youtube videoId or 'false'
					if (response === 'false') {
						// do something...or nothing?
					} else {
						// play next youtube vid
						player.loadVideoById(response);
					}
					console.log(response);
				}
			});
		}
		</script>

		<iframe id="player" width="560" height="315" src="//www.youtube.com/embed/Nf9FzEmt4mM?enablejsapi=1&origin=http://localhost" allowfullscreen></iframe>

		<?php } else {/* end if */ ?>



		<?php } ?>

		<?php
		// if admin cookie set, show admin privilege buttons
		if (isset($_COOKIE['desktop-admin']) || isset($_COOKIE['mobile-admin'])) {
		?>

		<div class="admin">
			<a id="pause" class="admin-button">Pause</a>
			<a id="play" class="admin-button">Play</a>
			<a id="skip" class="admin-button">Skip</a>
		</div>

		<?php } /* end if */ ?>

	</div>
	<div id="playlist">
		<ul>

		</ul>
	</div>
</div>

<div class="clear"></div>

<?php include 'footer.php'; ?>
