<?php
/**
	 * setSimplepie()
	 * Function used to setup simplepie to parse the RSS feed.
	 * Uses a feed object and set_raw_data() instead of a feed url. This is done to allow access to the password protected feed via
	 * the ParseRss.php function.  
	 * Parameters: 
	 * 		$rss_in, the raw rss object
	 * Returns:
	 *		$feed, the parsed rss feed.
	 */
	function setSimplepie($rss_in)
	{
		$rss = $rss_in;
		//new default simplepie object
		$feed = new SimplePie();
		//instead of using simplepie with a feed url, use the feed object obtained instead.
		$feed->set_raw_data($rss);
		//run simplepie
		$feed->init();
		// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it)
		$feed->handle_content_type();

		return $feed;
	}
?>