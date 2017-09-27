$(function(){

	// Actions to perform when search result is clicked
	$('.search-results ul').on('click', 'a', function(){
		var videoId = $(this).attr("id");
		var duration = $(this).attr("class");
		var title = $(this).find('img').attr("alt");
		var thumbnail = $(this).find('img').attr("src");
		add_to_playlist(videoId, title, thumbnail, duration, 'youtube');
	});

	$('#youtube-search').submit(function(event){
		event.preventDefault();
		$('.search-results ul li').remove();
		var query = '';
		query = $('input[name=yt]').val();
		search_youtube(query);
		//console.log(query);
	});

	// Ajax call to add song to playlist
	function add_to_playlist(videoId, title, thumbnail, duration, type){
		var track = {videoId: videoId, title: title, thumbnail: thumbnail, duration: duration, type: type};
		$.ajax({
			type: 'POST',
			url: 'services/AddToPlaylist.php',
			data: track,
			success: function(response){
				//console.log(response);
			}
		});
		$('.search-results ul li').remove();
		alert('Song Added!');
		$('input[name=yt]').val('');
	}

	// Ajax call to perform youtube search
	function search_youtube(query){
		var data = {yt: query};
		$.ajax({
			type: 'GET',
			url: 'services/ProcessSearch.php',
			data: data,
			success: function(response){
				$('.search-results ul').html(response);
			}
		});
	}

	/*function interval(){
		$.ajax({
			url: 'services/LoadNext.php',
			success: function(response){
				console.log(response);
			},
			complete: function() {
				//setTimeout(interval, 1000);
			}
		});
	}*/

	var src = $('iframe').attr('src');
	var autoplay = '?autoplay=1';
	// works! $('iframe').attr('src', src+autoplay);
});
