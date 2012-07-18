<?php 
	session_start();
	//debugging?
	$debug = false;

	//logic to determine who is logged on (manager or not). sets the $_SESSION['manager'] variable to 1 or 0
	include("scripts/login.php");

	//parse the rss feeds using simplpie
	include("scripts/mergeFeeds.php");

	//include sublcass of TableRow for the assingee email list 
	include("scripts/AssigneeRow.php");

	//include form processing that allows emails to be sent
	include("scripts/emailArticles.php");

	/*
	foreach ($feed->get_items() as $item):

		//$dateItem = $feed->get_item();   // the first item in feed; do it in loop
		$dateData = $item->get_item_tags("http://www.w3.org/2005/Atom", "updated");
		$sub_data = $dateData[0][data];
		
		//print_r($data);
		//print_r($sub_data);
		//echo "<p></p>"; 
		echo $sub_data;
		echo "<p></p>";

	endforeach;
	*/
?>
<!doctype html>
<!-- Limeaid is refreshing, and that's exactly what we want to do to the blogs. -->
<html>
	<head>
		<meta charset="utf-8">
		<title>Limeaid: Update your Blog</title>
		<!--<script src = "scripts/jquery-1.7.2.min.js"></script> --> <!-- include jquery-->
		<!--<script src = "scripts/getXml.js"></script>-->
		<script src = "scripts/windowPopup.js"></script><!-- used to make popup windows -->
		<link rel = "stylesheet" href = "style.css">
		<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id = "wrapper">

			<div id = "header">
				<img class="logo" src="images/limeaid_logo.png" alt="Logo" />
			</div><!-- end header -->

			<div id ="leftColumn">
				<?php 
					//code to determine if the manage assignee button should be enabled
					if($_SESSION['manager'] == 1)
						$buttonType = 'class="green"';					
					elseif($_SESSION['manager'] == 0) 
						$buttonType = 'disabled="disabled" class="greenDisabled"';
				?>
				<!-- addAssignee_button is a function provided by windowpopup to open new windows containing data -->
				<div id = "addAssignee"><button class="green" type="button" onclick="addAssignee_button('addAssignee.php', '255', '250')">Add Assignee to Database</button></div><!-- end addAssignee -->
				<div id = "manageAssignee"><button <?php echo $buttonType ?> type="button" onclick="addAssignee_button('manageAssignee.php', '510', '520')">Manage Assignee</button></div><!-- end manageAssignee -->

<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post"><!-- Begin form to add posts to an email and send them to assignees -->

				<div id = "currentAssignees">
					<?php
						//include functions to make tables
						include("scripts/makeTable.php");

						//Note: uses AssigneeRow class to manage the assignees

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

				<div id = "sendEmail">
					<input style="margin-top:10px" class = "button_class green" type="submit" value="Email Selected Assignees" name="mailer_form" />
				</div><!-- end sendEmail -->

				<div id ="trackStatus"><button style="margin-top:10px" class="green" type="button" onclick="addAssignee_button('trackStatus.php', '1000', '1200')">Track Status</button></div><!-- end trackStatus -->
<!--
				<div id = "trackStatus">
					<a href="trackStatus.php" target="_blank"><input style="margin-top:10px" class = "button_class green" type="submit" value="Track Status"/></a>
				</div>
-->
			</div><!-- end leftColumn -->

			<div id = "xmlDisplay">
				<?php
				/*
				Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
				*/
				$postCount = 0;
				
				foreach ($feed->get_items() as $item):
					$postCount++; //increment postcount to count the number of articles.
				?>
				<div class="xmlItem">
				<h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
				<p><?php echo $item->get_description(); ?></p>
				<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?> | Source: <a href="<?php $feed = $item->get_feed(); echo $feed->get_permalink(); ?>"><?php $feed = $item->get_feed(); echo $feed->get_title(); ?></a></small></p>
				<input type="checkbox" name="article_checkbox[]" value="<?php echo $item->get_title() . 'From the '. $feed->get_title();?>" />Add this Post to the Email

				</div>
				<?php 
					endforeach;

					$_SESSION['postCount'] = $postCount; //set a session variable to contain postcount
				?>
			</div><!-- end xmlDisplay -->

</form><!-- end pagewide form -->
			<div id ="test">
				<?php
					/*
					foreach ($feed->get_items() as $item)
					{
						$item = $feed->get_item(0);   // the first item in feed; do it in loop
						$data = $item->get_item_tags("http://www.w3.org/2005/Atom", "updated");
						$sub_data = $data[0][data];
						
						//print_r($data);
						print_r($sub_data);
						echo "<p></p>";
					}
					*/
				?>
			</div><!-- end test-->
		</div><!-- end wrapper -->
	</body>
</html>
