<?php
	session_start();
	$_SESSION['managerUpdate'] = FALSE; //set this to false so that updatetexts knows which table to select regarding jeditable updates
	
	//connect to db
	include("scripts/databaseConnect.php");
	//include table row class
	include ("scripts/ProgressRow.php");

/**
 * if (isset($_POST["deleteAssignee"]))
 * this handles when a request to delete a record is canceled.
 * a request of this type is triggered by the delete button in the form.
 * this form submission retrieves the pk of the deleted value, and used it to expunge the assignee from the database
 *
 * takes in a hidden value posted from the table, the primary key of that specific row to be deleted.
 *
 * NOTE: 
 * 		See ProgressRow.php class for the POST variables.
 */
if (isset($_POST["deleteAssignee"]))
{
	//code to determine if the user should have the power to delete records
	if($_SESSION['manager'] == 1)
	{
		$row_ID = $_POST["txtRow"];

		$removeAssigneeSql = "DELETE FROM table_progress WHERE pk_id = '$row_ID'";

		mysql_query($removeAssigneeSql) or die('Error, assignee delete failed from table progress: '. mysql_error());
	}			
	elseif($_SESSION['manager'] == 0) 
	{
		echo '<script type="text/javascript">alert("You do not have permission to perform deletions.");</script>';
	}
}
?>
<!doctype html>
<!-- Limeaid is refreshing, and that's exactly what we want to do to the blogs. -->
<html>
	<head>
		<meta charset="utf-8">
		<title>Limeaid: Update your Blog</title>
		<script src = "scripts/windowPopup.js"></script>
		<link rel = "stylesheet" href = "style.css">
		<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script><!-- jquery -->
		<script src="scripts/jeditable.js"></script><!-- jeditable -->


		<script>
		/**
		* document.ready()
		* using jeditable to edit the database results in place.
		* essentially treats each region as its own form, then submits to save.php, which performs validations and updates to the database
		**/
		$(document).ready(function() 
		{
			//note that updateTexts.php handles the updating of the database, according to what is passed into it from jeditable
			$('.edit').editable('scripts/updateTexts.php', {
			indicator : 'Saving...',
			tooltip   : 'Click to edit...',
			cancel    : 'Cancel',
			submit    : 'OK',
			//style     : 'inherit'
			style     : 'display: inline'
			});
		});
		</script><!-- end jeditable function -->
 
	</head>
	<body>
		<div id = "tableWrapper">
			<div id = "header">
				<a href="https://www.uvm.edu/~helpline/limeaid/index.php"><img class="logo" src="images/limeaid_logo.png" alt="Logo"/></a>
			</div><!-- end header -->

<div id="scrollView">

			<div id="tableContent">
				<table style="margin-bottom:10px" summary="Table pulled from database">
					<caption>Article Status</caption>
					
					<thead>
						<tr class= "tableRow">
							<th class="statusTableHeaders" scope="col">Name</th>
							<th class="statusTableHeaders" scope="col">Article</th>
							<th class="statusTableHeaders" scope="col">Date Assigned</th>
							<th class="statusTableHeaders" scope="col">Date Completed</th>
							<th class="statusTableHeaders" scope="col">Date Reviewed</th>
							<th class="statusTableHeaders" scope="col">Reviewed By</th>
							<th class="statusTableHeaders" scope="col">Public</th>
							<th class="statusTableHeaders" scope="col">Archived</th>
							<th class="statusTableHeaders" scope="col">Delete Record</th>

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
						<?php
							function retrieveRecords()
							{
								//retrieve all records from the progress table
								$sql = "SELECT * FROM table_progress ORDER BY fld_name";
								$result = mysql_query($sql) or die ("Unable to retrieve a record from table progess " . mysql_error());

								//create the table rows from the results
								writeRows($result);
							}

							function writeRows($result)
							{

								$counter = 0;

								//display the story information from the database, using tablerow objects
								while($row = mysql_fetch_array($result)) 
								{
									//create object, instance of progess row class (extension of tablerow)
									$instance = new ProgressRow($row, $counter);

									//set a variable equal to the result of the writeData() function called from the instance
									$printObject = $instance->writeData();

									//write out that data in the variable (a table row)
									echo $printObject;

									//increase counter
									$counter++;

									//destroy object
									unset($instance);
								}
								//set a session variable to hold the number of records retrieved from the progress table
								$_SESSION['updateCount'] = $counter;
							}

							//call the above function
							retrieveRecords();
						?>
					</tbody><!-- end table body -->				
				</table><!--end table-->
			</div> <!-- end tableContent -->

</div> <!-- end scrollView -->

				<?php
					//display total counts of articles assigned and extant
					if(isset($_SESSION['postCount']))
					{
						echo "<p>" . "Total Blog Article Count: " .$_SESSION['postCount'] . "</p>"; 
						echo "<p>" . "Total Assigned Articles for Updating: " .$_SESSION['updateCount'] . "</p>";
					}
				?>

		</div><!-- end tableWrapper -->
	</body>
</html>
