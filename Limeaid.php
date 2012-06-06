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
		<link rel = "stylesheet" href = "style.css">
	</head>
	<body>
		<div id = "wrapper">

			<div id = "header">
				<h1><?php echo $feed->get_title(); ?></a></h1>
				<p><?php echo $feed->get_description(); ?></p>
			</div><!-- end header -->

			<div id ="leftColumn">
				<div id = "xmlSelector"></div><!-- end xmlSelector -->
				<div id = "xmlSort"></div> <!-- end xmlSort -->
				<div id = "addAssignee"></div><!-- end addAssignee -->
				<div id = "manageAssignee"></div><!-- end manageAssignee -->
				<div id = "removeAssignees"></div><!-- end removeAssignees -->
				<div id = "sendEmail"></div><!-- end sendEmail -->

				<div id = "currentAssignees"></div><!-- end currentAssignees -->
			</div><!-- end leftColumn -->

			<div id = "xmlDisplay">
				
				<?php
				/*
				Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
				*/
				foreach ($feed->get_items() as $item):
				?>

				<div class="item">
				<h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
				<p><?php echo $item->get_description(); ?></p>
				<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
				</div>

				<?php endforeach; ?>

			</div><!-- end xmlDisplay -->

		</div><!-- end wrapper -->
	</body>
</html>
