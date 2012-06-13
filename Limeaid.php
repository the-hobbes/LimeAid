<?php 
	//debugging?
	$debug = false;

	//parse the rss feeds
	include("scripts/mergeFeeds.php");

	//include sublcass of TableRow for the assingee email list 
	include("scripts/AssigneeRow.php");

	//include form processing that allows emails to be sent
	include("scripts/emailArticles.php");

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
				<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?> | Source: <a href="<?php $feed = $item->get_feed(); echo $feed->get_permalink(); ?>"><?php $feed = $item->get_feed(); echo $feed->get_title(); ?></a></small></p>
				<input type="checkbox" name="article_checkbox[]" value="<?php echo $item->get_title() . 'From the '. $feed->get_title();?>" />Add this Post to the Email

				</div>
				<?php endforeach; ?>
			</div><!-- end xmlDisplay -->

</form><!-- end pagewide form -->
		</div><!-- end wrapper -->
	</body>
</html>
