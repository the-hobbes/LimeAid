<?php
	include("scripts/databaseConnect.php");

	/**
	 * Form handler called by "Email Selected Assignees" button.
	 * Grabs checked assinees and checked articles, and sends an email to the assignees.
	 */
	if (isset($_POST["mailer_form"]))
	{
		$debug = False;

		//$_POST["mailer_form"];
		$checked_boxes = $_POST['assignee_email'];
		$checked_articles = $_POST['article_checkbox'];

		//create and send the email message
		$emailSent = makeEmail($checked_boxes, $checked_articles);
		if($emailSent == true)
		{
			echo '<script type="text/javascript">alert("Message successfully sent.");</script>';
		}

		//are we debugging?
		if($debug)
		{
			if(empty($checked_boxes))
			{
				echo("You didn't select any assignees.");
			}
			else
			{
				$N = count($checked_boxes);
				echo("You selected $N assignees(s): ");
				for($i=0; $i < $N; $i++)
				{
					echo($checked_boxes[$i] . " ");
				}
			}

			echo "<p></p>";

			if(empty($checked_articles))
			{
				echo("You didn't select any articles.");
			}
			else
			{
				$N = count($checked_articles);
				echo("You selected $N article(s): ");
				for($i=0; $i < $N; $i++)
				{
					echo($checked_articles[$i] . " ");
				}
			}
		}//end debug
	}

/**
 * makeEmail()
 * Function used to create the email to be sent to the assignees, then send it.
 * Parameters:
 *		Two arrays, the assignees that were checked, and the articles that were checked.
 * Returns:
 *		true if message created successfully, false if not. 
 */
function makeEmail($checked_boxes_in, $checked_articles_in)
{
	//recipients
	$recipients = "";
	if(empty($checked_boxes_in))
	{
		echo '<script type="text/javascript">alert("You have not selected any assignees.");</script>';
		return false;
	}
	else
	{
		$N = count($checked_boxes_in);
		for($i=0; $i < $N; $i++)
		{
			$recipients .= ", " . $checked_boxes_in[$i];
		}
	}
	
	//subject
	$subject = "You have been selected to update the following blog article(s)";
	
	//body
	$message = "
				<html>
					<head>
						<title>UVM Knowledge Base</title>
					</head>
					<body>
						<h1>Lucky you!</h1>
						<p>Because of your expertise, you have been chosen to update the following Knowledge Base articles, in order to bring them up to current ETS standards:</p>
				";
	if(empty($checked_articles_in))
	{
		echo '<script type="text/javascript">alert("You have not selected any articles.");</script>';
		return false;
	}
	else
	{
		$N = count($checked_articles_in);
		for($i=0; $i < $N; $i++)
		{
			$message .= "<p><b>" . $checked_articles_in[$i] . "</b></p>";
		}
	}
	$message .= "<p></p>";
	$message .="<p> Since this is an automated message, if you have any questions please contact Carol Caldwell-Edmonds or Travis Bartlett";
	$message .-"</body></html>";
	
	//headers
	$headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: Limeaid Blog Management\r\n";

	//now to mail it
    $mailIt = mail($recipients, $subject, $message, $headers);

    //update the tracking database
    updateDatabase($checked_boxes_in, $checked_articles_in);
	return true;
}

/**
 * updateDatabase($checked_boxes_in, $checked_articles_in)
 * Function used to add the information of the assignment of the article to the database, specifically in the table_progress.
 */
function updateDatabase($checked_boxes_in, $checked_articles_in)
{
	$name_array = array();
	$article_array = array();

	//FILL ARRAY: for each recipient, get the full name and put it into an array
	for($i=0; $i < count($checked_boxes_in); $i++)
	{
		$email = $checked_boxes_in[$i];
		
		//look up the recipient's full name by thier email
		$name_sql = "SELECT fld_firstname, fld_lastname FROM table_assignee WHERE pk_email = '$email'";
		$name_result = mysql_query($name_sql) or die ("Unable to retrieve a record from table progess " . mysql_error());
		$row = mysql_fetch_array($name_result);
		$fullName = $row['fld_firstname'] . " " . $row['fld_lastname'];
		$name_array[] = $fullName;
	}

	//FILL ARRAY: for each article, get the article name and put it into an array
	for($i=0; $i < count($checked_articles_in); $i++)
	{
		$rawArticle = deleteFirstFiveChar($checked_articles_in[$i]);
		$article = removeRemainingTag($rawArticle);
		$article_array[] = $article;
	}

	//DO WORK (add to database): for each recipient...
	for($i=0; $i < count($name_array); $i++)
	{
		//for each article, put name, article, and date into the database
		for($z=0; $z < count($article_array); $z++)
		{
			$date = date('l jS \of F Y h:i:s A');
			$name = $name_array[$i];
			$article = $article_array[$z];

			$insert_sql = "INSERT INTO table_progress (fld_name, fld_articleAssigned, fld_dateAssigned) VALUES ('$name', '$article', '$date')";

			//run the query
	    	mysql_query($insert_sql); 
		}
	}
	
}

/**
 * deleteFirstFiveChar($string)
 * used to remove the <div> tag added to the blog title
 */
function deleteFirstFiveChar($string) 
{
	//used to remove <div> tag from the string
	return substr( $string, 5);
}

/**
 * removeRemainingTag($string)
 * used to remove everything after the final '<' character in the title
 */
function removeRemainingTag($string)
{
	//position of < in div tag
	$findme = "<";
	$pos = strpos($string, $findme);

	return substr($string, 0, $pos);
}
?>