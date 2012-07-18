<?php
include("databaseConnect.php");

/**
* makeTable.php
* Collection of functions used to write the table containing all of the assignees in the database.
* Called from client code.
*/


/**
 * writeRows_modified()
 * Modified version of writeRows() in makeTable.php
 * modified to use a new type of object, made from the subclass AssigneeRow.php
 */
function writeRows_modified($result)
{
	$counter = 0;

	//display the story information from the database, using tablerow objects
		while($row = mysql_fetch_array($result)) 
		{
			//create object, instance of table row class
			$instance = new AssigneeRow($row, $counter);

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


/**
 * getAssignees()
 * Function use to, like showAssignees, get all of the assignees from the table. 
 * However, this function does not call the other functions to create the rest of the table (waits for user to call on thier own).
 * Returns:
 * 		$result, the result of the query
 */
function getAssignees()
{
	//retrieve all assignees
	$sql = "SELECT * FROM table_assignee";
	$result = mysql_query($sql) or die ("Unable to retrieve a record from the database " . mysql_error());

	return $result;
}



/**
 * writeTableShell()
 * Function used to create the shell of the table of the popup manage page, such as table tags, headings, title, and footer.
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
				<th scope="col">Manager Status</th>
			</tr><!-- End column headers -->
		</thead><!-- end header -->

		<tfoot>
			<tr>
				<!--<th scope="row">Footer</th>-->
				<!--<td colspan="2">Footer Data</td>-->
				<td colspan="5"></td>
			</tr><!-- end column footers -->
		</tfoot><!-- end footer -->

		<tbody>
	';
}

/**
 * writeTableShell_modified()
 * Function used to create the shell of the table on the main page, such as table tags, headings, title, and footer.
 * Modified version echoes a different heading for the last row
 */
function writeTableShell_modified()
{
	echo 
	'
		<table summary="Table pulled from database">
		<caption> Assignee Mailing List </caption>
		
		<thead>
			<tr>
				<th scope="col">Email</th>
				<th scope="col">First Name</th>
				<th scope="col">Last Name</th>
				<th scope="col">Include Assignee</th>
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