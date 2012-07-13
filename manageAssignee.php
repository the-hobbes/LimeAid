<?php
include("scripts/databaseConnect.php");

//include TableRow parent class
include ("scripts/TableRow.php");

/**
 * if (isset($_POST["deleteAssignee"]))
 * this handles when a request to delete an assignee is canceled.
 * a request of this type is triggered by the delete button in the form.
 * this form submission retrieves the pk of the deleted value, and used it to expunge the assignee from the database
 * NOTE: 
 * 		See TableRow.php class for the POST variables.
 */
if (isset($_POST["deleteAssignee"]))
{
	$email_ID = $_POST["txtEmail"];

	$removeAssigneeSql = "DELETE FROM table_assignee WHERE pk_email = '$email_ID'";
	$removeFirstName = "DELETE FROM table_intersection WHERE fk_email = '$email_ID'";

	mysql_query($removeAssigneeSql) or die('Error, assignee delete failed from table assignee: '. mysql_error());
	mysql_query($removeFirstName) or die('Error, assignee delete failed from table interection: '. mysql_error());
}
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Helpline Blog Update Status</title>
		<link rel = "stylesheet" href = "style.css">
		<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="assigneeBrowser">

			<?php
				//include code to write the table containing all of the assignees
				include("scripts/makeTable.php");
				//begin table writing (kicker)
				showAssignees();
			?>
			<p></p>
			<div style="margin:0px auto;"><a href="javascript:window.close()">Close Window</a></div><!--end close -->
		</div><!-- end assigneeBrowser -->
	</body>
</html>