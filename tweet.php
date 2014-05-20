<?php
//function to create the connection string to twitter with the api v 1.1

function createconnection($consumer_key, $consumer_secret, $oauth_token, $oauth_secret, $hashtag, $count, $vicache) {
	$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_secret);
	$content = $connection -> get('search/tweets', array('q' => $hashtag, 'count' => $count));
	$content = json_encode($content, true);
	$content = json_decode($content);
	$visearch_tweets_userkey = get_option('widget_visearch_tweets_widget');
	update_option('visearch_tweets', serialize($content));
	update_option('visearch_tweets_cache', time());
	update_option('visearch_tweets_hashtag', $hashtag);
	update_option('visearch_tweets_details', $visearch_tweets_userkey);
	vi_cache_unserialize_show(get_option('visearch_tweets'));
}

//function ends here

//function to unserialize the cached tweets and show
function vi_cache_unserialize_show($visearch_tweets) {
	$visearch_tweets = maybe_unserialize($visearch_tweets);
	if (!empty($visearch_tweets)) {
		echo "<div class='vicontainer'>";
		if ($visearch_tweets -> errors != '') {
			echo "<p>You just might have used wrong Credential or may be left something blank somewhere. Try again with correct Credential details.</p>";
		} else {
			foreach ($visearch_tweets->statuses as $tweet) {
				$created_at_date = substr($tweet -> created_at, 4, 7);
				$created_at_time = substr($tweet -> created_at, 11, 5);
				echo "<b class='viname'><a href='http://twitter.com/" . $tweet -> user -> screen_name . "' target='_blank'>@{$tweet->user->screen_name}</a></b>";
				echo "<p><a href='http://twitter.com/" . $tweet -> user -> screen_name . "/status/" . $tweet -> id_str . "' class='vip' target='_blank'>{$tweet->text}";
				echo "</br><span style='float:right'>" . $created_at_date . ",&nbsp;" . $created_at_time . "</span></a></p>";
			}
			echo "</div>";
		}
	}
}

//function to unserialize ends here
?>