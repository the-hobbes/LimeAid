<?php 
	$debug = false;

	require_once('php/simplepie.inc');
	include("ParseRss.php");
	include("setSimplepie.php");

	//get the raw rss of the blog, using remote account login (SIMPLEPIE)
	$raw_rss = getRss("http://blog.uvm.edu/helpline-tech/feed/atom/", "pvendevi", "Yaer0eR0wi3n");

	//parse the raw rss with simplepie (SIMPLEPIE)
	$feed = setSimplepie($raw_rss);

	//include sublcass of TableRow for the assingee email list 
	include("scripts/AssigneeRow.php");

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

	echo '<script type="text/javascript">alert("Message successfully sent.");</script>';

	return true;
}


?>
<!doctype html>
<!-- Limeaid is refreshing, and that's exactly what we want to do to the blogs. -->
<html>
	<head>
		<meta charset="utf-8">
		<title>Helpline Blog Update Status</title>
		<!--<script src = "scripts/jquery-1.7.2.min.js"></script> --> <!-- include jquery-->
		<!--<script src = "scripts/getXml.js"></script>-->
		<script src = "scripts/windowPopup.js"></script>
		<link rel = "stylesheet" href = "style.css">
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id = "wrapper">

			<div id = "header">
				<img class="logo" src="images/limeaid_logo.png" alt="Logo" />
			</div><!-- end header -->

			<div id ="leftColumn">
				<!-- <div id = "xmlSelector"></div> --><!-- end xmlSelector -->
				<!-- <div id = "xmlSort"></div> --><!-- end xmlSort -->

				<div id = "addAssignee"><button class="green" type="button" onclick="addAssignee_button('addAssignee.php', '255', '250')">Add Assignee to Database</button></div><!-- end addAssignee -->
				<div id = "manageAssignee"><button class="green" type="button" onclick="addAssignee_button('manageAssignee.php', '500', '500')">Manage Assignee</button></div><!-- end manageAssignee -->

<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post"><!-- Begin form to add posts to an email and send them to assignees -->

				<div id = "currentAssignees">
					<?php
						//include functions to make tables
						include("scripts/makeTable.php");

						//retrieve assigness from database
						$query = getAssignees();
						//write table shell
						writeTableShell_modified();
						//write the rows
						writeRows_modified($query);
						//close the table tags
						closeTableShell();
					?>
				</div><!-- end currentAssignees -->

<!-- YOU ARE HERE, trying to add the form submission -->
				<div id = "sendEmail">
					<input style="margin-top:10px" class = "button_class green" type="submit" value="Email Selected Assignees" name="mailer_form" />
				</div><!-- end sendEmail -->

			</div><!-- end leftColumn -->

			<div id = "xmlDisplay">
				<?php
				/*
				Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
				*/
				foreach ($feed->get_items() as $item):
				?>
				<div class="xmlItem">
				<h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
				<p><?php echo $item->get_description(); ?></p>
				<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
				<input type="checkbox" name="article_checkbox[]" value="<?php echo $item->get_title();?>" />Add this Post to the Email

				</div>
				<?php endforeach; ?>
			</div><!-- end xmlDisplay -->

</form><!-- end pagewide form -->
		</div><!-- end wrapper -->
	</body>
</html>
