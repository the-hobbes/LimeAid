<?php
	
	/**
	 * getRss()
	 * Function used to retrieve an rss feed from a supplied url.
	 * Parameters:
	 *		url_in, the url of the RSS Feed
	 *		username_in, the username that has access to the remote feed
	 *		password_in, the password for the username
	 * Returns:
	 *		rss_obj, the object containing the rss feed.
	 * Note: 
	 * The usename and password must be for the remote publishing account, found @ somewhere like:
	 * https://blog.uvm.edu/helpline-tech/wp-admin/profile.php,
	 * at the bottom look for Remote publishing passcode.
	**/
	function getRss($url_in, $username_in, $password_in)
	{
		//setup variables
		$feed_url = $url_in;
		$username = $username_in;
		$password = $password_in;

		//pass username and password along with url to file_get_contents 
		$context = stream_context_create(array('http' => array('header'  => "Authorization: Basic " . base64_encode("$username:$password"))));
		
		//retrieve the RSS feed
		$data = file_get_contents($feed_url, false, $context); 

		//return the RSS feed
   		return $data;
	}
?>