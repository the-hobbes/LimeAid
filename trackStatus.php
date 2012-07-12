<?php
	//connect to db
	include("scripts/databaseConnect.php");
	//include table row class
	include ("scripts/ProgressRow.php");

?>
<!doctype html>
<!-- Limeaid is refreshing, and that's exactly what we want to do to the blogs. -->
<html>
	<head>
		<meta charset="utf-8">
		<title>Limeaid: Update your Blog</title>
		<!--<script src = "scripts/jquery-1.7.2.min.js"></script> --> <!-- include jquery-->
		<!--<script src = "scripts/getXml.js"></script>-->
		<script src = "scripts/windowPopup.js"></script>
		<link rel = "stylesheet" href = "style.css">
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script><!-- jquery -->
		<script src="http://www.appelsiini.net/projects/jeditable/jquery.jeditable.js"></script><!-- jeditable -->


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
			});
		});
		</script><!-- end jeditable functions -->
 
	</head>
	<body>
		<div id = "wrapper">
			<div id = "header">
				<img class="logo" src="images/limeaid_logo.png" alt="Logo" />
			</div><!-- end header -->

			<div id="tableContent">


				<table style="margin-bottom:10px" summary="Table pulled from database">
					<caption>Article Status</caption>
					
					<thead>
						<tr>
							<th class="tableHeaders" scope="col">Name</th>
							<th class="tableHeaders" scope="col">Article</th>
							<th class="tableHeaders" scope="col">Date Assigned</th>
							<th class="tableHeaders" scope="col">Date Completed</th>
							<th class="tableHeaders" scope="col">Date Reviewed</th>
							<th class="tableHeaders" scope="col">Reviewed By</th>
							<th class="tableHeaders" scope="col">Public</th>
							<th scope="col">Archived</th>
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
								$sql = "SELECT * FROM table_progress";
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
							}
							
							retrieveRecords();
						?>
					</tbody><!-- end table body -->

				</table><!--end table-->


			</div> <!-- end tableContent -->

		</div><!-- end wrapper -->
	</body>
</html>
