<?php
/**
 * mergeFeeds.php
 * This include is used to setup multiple RSS feeds and parse them through simplePie.
 */

//include necessary scripts
require_once('php/simplepie.inc');
//include("scripts/ParseRss.php");
include("setSimplepie.php");

/*
//get the raw rss of the blog, using remote account login (SIMPLEPIE) (PARSERSS.php)
$raw_rss = getRss("http://blog.uvm.edu/helpline-tech/feed/atom/", "pvendevi", "Yaer0eR0wi3n");

//parse the raw rss with simplepie (SIMPLEPIE)
$feed = setSimplepie($raw_rss);
*/

// Create a new SimplePie object
$feed = new SimplePie();
 
// Instead of only passing in one feed url, we'll pass in an array of two (helpline and helpline-tech)
$feed->set_feed_url(array(
	'http://blog.uvm.edu/helpline/feed/atom/',
	'http://blog.uvm.edu/helpline-tech/feed/atom/'
));
 
// Initialize the feed object
$feed->init();
 
// This will work if all of the feeds accept the same settings.
$feed->handle_content_type();

?>