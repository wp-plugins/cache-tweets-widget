<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Cache Tweets Widget
 * @author   vickythegme <vickythegme@gmail.com>
 * @license   GPL-2.0+
 * @link      http://vickythegme.com
 * @copyright 2014 Vickythegme
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$option_array = array('visearch_tweets','visearch_tweets_cache','visearch_tweets_hashtag','widget_visearch_tweets_widget','visearch_tweets_details');
foreach($option_array as $options){
delete_option($options);
}
// TODO: Define uninstall functionality here
