=== Cache Tweets Widget  ===

Contributors: vickythegme

Donate link: http://vickythegme.com

Tags: twitter tweets, tweet widget, search, api, v1.1, cache, feed, user timeline, tweets 

Requires at least: 3.0

Tested up to: 4.2.2

Stable tag: 4.3

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html


Cache Tweets Widget is a simple widget plugin with cache functionality to avoid rate limit with Twitter Search API v1.1.

== Description ==


Cache Tweets Widget is a simple plugin widget that collects the tweets feed from twitter's search API provided with a hashtag or any keyword.



It is cached to avoid rate limit with twitter. 

Now You can fetch the user tweets of any user with their username.


Make sure you provide the Application Credentials created with Twitter.



== Installation ==


1. Unzip the compressed file that you downloaded from Wordpress repository or any place where you downloaded.


2. Upload `Cache Tweets Widget` folder to the `/wp-content/plugins/` directory


3. Activate the plugin through the 'Plugins' menu in WordPress

4. Now go to "Widgets" in "Appearances" and drag and drop the widget to any place you want.

== Frequently Asked Questions ==

=
Where to find the Consumer Key, Secret, Access Token and Secret? 

	

You have to create an application on Twitter at (http://dev.twitter.com), and copy the consumer key, secret, access token and secret at the places that are required.



Is it vulnerable to add my credentials with your widget?

Obviously No. You're saving your credentials in your own wordpress site and we never get your credentials.



Do I have to fill all the details in the widget?

	

Yes, it is recommended to fill all the details for better results.
	


Can I add a url link at the place of hashtag or keyword?

		

Yes you can, but while adding the url, make sure you don't use http:// before it. 
		
		
For example: Instead of http://example.com, you have to type as example.com 


Can I type both hashtag and Username ?

Yes, you can have both hashtag and username, But which ever you selected from the textbox will be used to fetch the tweets.
	

== Changelog ==
=
Initial submit to WP Repository
	


23 June 2015

Added the functionality to fetch tweets from any particular user with twitter username.

Now You can select any option to get tweets either from search hashtag or from a username. 

Added fetch users_timeline api request to get user tweets along with the search tweets api.
== Screenshots ==


1. screenshot-1.(png)
	shows the screenshot of how the widget looks like once it is installed.


== Upgrade Notice ==

=


= 2.0 =
Upgrade your plugin to make use of the new functionality (getting user timeline tweets)