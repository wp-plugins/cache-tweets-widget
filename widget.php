<?php
/*
Plugin Name: Cache Tweets Widget
Version: 1.0
Plugin URI: http://vickythegme.com
Description: Cache Tweets Widget is a simple plugin widget that collects the tweets feed from twitter's search API provided with a hashtag or any keyword.
Author: vickythegme
Author URI: http://vickythegme.com
*/
require_once('OAuth/OAuth.php');
require_once('OAuth/twitteroauth.php');
require_once('tweet.php');
class vitweet_widget extends WP_Widget {
/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'visearch_tweets_widget', // Base ID
			__('Cache Tweets- Twitter', 'text_domain'), // Name
			array( 'description' => __( 'Tweets widget that gets the tweets from the search api with hashtags', 'text_domain' ), ) // Args
		);
	}

	function vitweet_widget() {
		$widget_ops = array( 'classname' => 'search_tweets_widget', 'description' => 'Tweets widget that gets the tweets from the search api with hashtags' );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'vitweet_wid' );
		$this->WP_Widget( 'Swidget_class', 'Cache Tweets- Twitter', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$consumer_key = $instance['viconsumer_key'];
		$consumer_secret = $instance['viconsumer_secret'];
		$oauth_token = $instance['viaccess_token'];
		$oauth_secret = $instance['viaccess_secret'];
		$hashtag = $instance['vihashtags'];
		$count = $instance['vicount'];
		$vicache = $instant['vicache'];
		echo $before_widget;
		
		$title = apply_filters('widget_title', $instance['title'] );
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$visearch_tweets_cache = get_option('visearch_tweets_cache');
		$visearch_tweets_hashtag = get_option('visearch_tweets_hashtag');
		$visearch_tweets_userkey = get_option('widget_visearch_tweets_widget');
		$visearch_tweets_details = get_option('visearch_tweets_details');
		$timechange = time() - $visearch_tweets_cache;
		$realtime = $instance['vicache'] * 3600;
		if($timechange >= $realtime || empty($visearch_tweets_cache) || $visearch_tweets_hashtag != $hashtag || $visearch_tweets_userkey != $visearch_tweets_details){
		createconnection($consumer_key, $consumer_secret, $oauth_token, $oauth_secret, $hashtag, $count,$vicache);
		}
		else {
			vi_cache_unserialize_show(get_option('visearch_tweets'));
		}
		echo $after_widget;
		
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['viconsumer_key'] = ( ! empty( $new_instance['viconsumer_key'] ) ) ? strip_tags( $new_instance['viconsumer_key'] ) : '';
		$instance['viconsumer_secret'] = ( ! empty( $new_instance['viconsumer_secret'] ) ) ? strip_tags( $new_instance['viconsumer_secret'] ) : '';
		$instance['viaccess_token'] = ( ! empty( $new_instance['viaccess_token'] ) ) ? strip_tags( $new_instance['viaccess_token'] ) : '';
		$instance['viaccess_secret'] = ( ! empty( $new_instance['viaccess_secret'] ) ) ? strip_tags( $new_instance['viaccess_secret'] ) : '';
		$instance['vihashtags'] = ( ! empty( $new_instance['vihashtags'] ) ) ? strip_tags( $new_instance['vihashtags'] ) : '';
		$instance['vicount'] = ( ! empty( $new_instance['vicount'] ) ) ? strip_tags( $new_instance['vicount'] ) : '';
		$instance['vicache'] = ( ! empty( $new_instance['vicache'] ) ) ? strip_tags( $new_instance['vicache'] ) : '';
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 
			'title' 		=> '', 
			'viconsumer_key' => '',
			'viconsumer_secret' => '',
			'viaccess_token' => '',
			'viaccess_secret' => "",
			'vihashtags' =>  '',
			'vicount' => '',
			'vicache' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
<p>
	<label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e("Title"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" placeholder="Name me something!!" style="width:100%;" />
	<label for="<?php echo $this -> get_field_id('viconsumer_key'); ?>"><?php _e("Consumer Key"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('viconsumer_key'); ?>" name="<?php echo $this -> get_field_name('viconsumer_key'); ?>" value="<?php echo $instance['viconsumer_key']; ?>" placeholder="I must need it to work" style="width: 100%;" required />
	<label for="<?php echo $this -> get_field_id('viconsumer_secret'); ?>"><?php _e("Consumer Secret"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('viconsumer_secret'); ?>" name="<?php echo $this -> get_field_name('viconsumer_secret'); ?>" value="<?php echo $instance['viconsumer_secret']; ?>" placeholder="Me too!!" style="width: 100%;" required/>
	<label for="<?php echo $this -> get_field_id('viaccess_token'); ?>"><?php _e("Access Token"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('viaccess_token'); ?>" name="<?php echo $this -> get_field_name('viaccess_token'); ?>" value="<?php echo $instance['viaccess_token']; ?>" placeholder="Fill me too!!" style="width: 100%;" required/>
	<label for="<?php echo $this -> get_field_id('viaccess_secret'); ?>"><?php _e("Access Secret"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('viaccess_secret'); ?>" name="<?php echo $this -> get_field_name('viaccess_secret'); ?>" value="<?php echo $instance['viaccess_secret']; ?>" placeholder="What about me?" style="width: 100%;" required/>

	<label for="<?php echo $this -> get_field_id('vihashtags'); ?>"><?php _e("Hashtag or Keyword"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('vihashtags'); ?>" name="<?php echo $this -> get_field_name('vihashtags'); ?>" value="<?php echo $instance['vihashtags']; ?>" placeholder="Hashtag you want to show" style="width: 100%;" required />
	<label for="<?php echo $this -> get_field_id('vicount'); ?>"><?php _e("Number of Tweets"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('vicount'); ?>" name="<?php echo $this -> get_field_name('vicount'); ?>" value="<?php echo $instance['vicount']; ?>" placeholder="How many ?"style="width: 100%;" />
	<label for="<?php echo $this -> get_field_id('vicache'); ?>"><?php _e("Cache Time"); ?>:
	</label>
	<input id="<?php echo $this -> get_field_id('vicache'); ?>" name="<?php echo $this -> get_field_name('vicache'); ?>" value="<?php echo $instance['vicache']; ?>"  style="width:20%" />
	hours
</p>
<?php
}
}

function func_vicache_widget() {
register_widget( 'vitweet_widget' );
}

add_action( 'widgets_init', 'func_vicache_widget' );

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'register_plugin_vistyles' );

/**
* Register style sheet.
*/
function register_plugin_vistyles() {
wp_register_style( 'vicache-tweets', plugins_url( 'cache-tweets/css/vistyle.css' ) );
wp_enqueue_style( 'vicache-tweets' );
}
?>
