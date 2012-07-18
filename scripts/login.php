<?php

	/**
	 * login.php
	 * Used to determine the privelige level of the account that is logged in.
	 * Login handled by htaccess and uvm servers. 
	 */
	
	//are we debugging?
	$debug = FALSE;

	//get the remote username (netid)
	$user = getenv('REMOTE_USER');
	//create email address from netid. This is the primary key. 
	$primaryKey = $user . "@uvm.edu";
	//echo $primaryKey;

	//determine access level of user by querying the database
	include("scripts/databaseConnect.php");

	$sql = "SELECT fld_manager FROM table_assignee WHERE pk_email = '$primaryKey'";
	$result = mysql_query($sql) or die('Error: '. mysql_error());
	
	while($row = mysql_fetch_array($result)) 
	{
		if($debug)
		{
			echo $row['fld_manager'];
			if ($row['fld_manager'] == 0)
				echo "not a manager";
			elseif ($row['fld_manager'] == 1)
				echo "a manager";
			else
				echo "fld_manager not set";
		}
		
		//set session variable
		$_SESSION['manager'] = $row['fld_manager'];
		//echo $_SESSION['manager'];
	}

?>