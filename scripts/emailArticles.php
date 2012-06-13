<?php
	/**
	 * Form handler called by "Email Selected Assignees" button.
	 * Grabs checked assinees and checked articles, and sends an email to the assignees.
	 */
	if (isset($_POST["mailer_form"]))
	{
		//$_POST["mailer_form"];
		$checked_boxes = $_POST['assignee_email'];
		$checked_articles = $_POST['article_checkbox'];

		//create and send the email message
		$emailSent = makeEmail($checked_boxes, $checked_articles);
		if($emailSent == true)
		{
			echo '<script type="text/javascript">alert("Message successfully sent.");</script>';
		}

		/*
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
		}//end debug*/
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
	$message .="<p> If you have any questions, please contact Carol Caldwell-Edmonds, or Travis Bartlett";
	$message .-"</body></html>";
	
	//headers
	$headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: Limeaid Blog Management\r\n";

	// and now to mail it
    $mailIt = mail($recipients, $subject, $message, $headers);

	return true;
}


?>