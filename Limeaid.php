<?php 
	require_once('php/simplepie.inc');
	include("ParseRss.php");
	include("setSimplepie.php");

	//get the raw rss of the blog
	$raw_rss = getRss("http://blog.uvm.edu/helpline-tech/feed/atom/", "pvendevi", "Yaer0eR0wi3n");

	//parse the raw rss with simplepie
	$feed = setSimplepie($raw_rss);

	//$update_group = $feed->get_item_tags('http://www.w3.org/2005/Atom', 'updated');
	//echo gettype($feed
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
				<h1><?php //echo $feed->get_title(); ?></a></h1>
				<p><?php //echo $feed->get_description(); ?></p>
			</div><!-- end header -->

			<div id ="leftColumn">
				<!-- <div id = "xmlSelector"></div> --><!-- end xmlSelector -->
				<!-- <div id = "xmlSort"></div> --><!-- end xmlSort -->

				<div id = "addAssignee"><button type="button" onclick="addAssignee_button('addAssignee.php', '255', '250')">Add Assignee to Database</button></div><!-- end addAssignee -->
				<div id = "manageAssignee"><button type="button" onclick="addAssignee_button('manageAssignee.php', '500', '500')">Manage Assignee</button></div><!-- end manageAssignee -->

<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post"><!-- Begin form to add posts to an email and send them to assignees -->

				<div id = "currentAssignees">List of Assignees (check the checkbox to add to email list)</div><!-- end currentAssignees -->
				<div id = "sendEmail">Send Email to Assignees</div><!-- end sendEmail -->
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
				<input type="checkbox" name="post" value="<?php echo $item->get_title();?>" />Add this Post
				</div>
				<?php endforeach; ?>
			</div><!-- end xmlDisplay -->

</form><!-- end pagewide form -->
		</div><!-- end wrapper -->
	</body>
</html>
