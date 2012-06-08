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
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="assigneeBrowser">

			<?php

			/**
			 * showAssignees()
			 * Function used to display all of the assignees in the database
			 * Writes the framework of the table, then calls writeRows() to populate with database information.
			 */
			function showAssignees()
			{
				//retrieve all assignees
				$sql = "SELECT * FROM table_assignee";
				$result = mysql_query($sql) or die ("Unable to retrieve a record from the database " . mysql_error());
				
				//make the table, in sections
				writeTableShell();
				writeRows($result);
				closeTableShell();
			}

			//begin table writing
			showAssignees();
			
			/**
			 * writeTableShell()
			 * Function used to create the shell of the table, such as table tags, headings, title, and footer.
			 */
			function writeTableShell()
			{
				echo 
				'
					<table summary="Table pulled from database">
					<caption>Existing Assignees</caption>
					
					<thead>
						<tr>
							<th scope="col">Email</th>
							<th scope="col">First Name</th>
							<th scope="col">Last Name</th>
							<th scope="col">Delete Assignee</th>
						</tr><!-- End column headers -->
					</thead><!-- end header -->

					<tfoot>
						<tr>
							<!--<th scope="row">Footer</th>-->
							<!--<td colspan="2">Footer Data</td>-->
							<td colspan="4"></td>
						</tr><!-- end column footers -->
					</tfoot><!-- end footer -->

					<tbody>
				';
			}

			/**
			 * writeRows()
			 * Function used to write each row of the table, populated with information from the database.
			 * takes in the record of the sql query as an argument.
			 * Objects from class TableRow are used here. An object of this class is created for each row in the result object.
			 * These TableRow objects contain all of the necessary information and formatting for a table row
			 */
			function writeRows($result)
			{
				$counter = 0;

				//display the story information from the database, using tablerow objects
					while($row = mysql_fetch_array($result)) 
					{
						//create object, instance of table row class
						$instance = new TableRow($row, $counter);

						//set a variable equal to the result of the writeData() function called from the instance
						$printObject = $instance->writeData();

						//write out that data in the variable (a table row)
						echo $printObject;

						//increase counter
						$counter++;

						//destroy object
						unset($instance);
					}
			}

			/**
			 * closeTableShell()
			 * function used to output closing tags of the table.
			 */
			function closeTableShell()
			{
				echo 
				'
					</tbody><!-- end table body -->
					</table><!--end table-->
				';
			}
			?>

		</div><!-- end assigneeBrowser -->
	</body>
</html>