<?php
include("scripts/databaseConnect.php");

//setup variables to put form info into. 
$firstName ="";
$lastName = "";
$email ="";


if (isset($_POST["cmdSubmitted"]))
{
	//set php variables containing data from form
	$firstName = $_POST["txtFirstName"];    
	$lastName = $_POST["txtLastName"];
    $email = $_POST["txtEmail"];

    //sanitize input through stripslashes and htmlentities
    $firstName = stripslashes($firstName);
    $lastName = stripslashes($lastName);
    $email = stripslashes($email);

    $firstName = htmlentities($firstName, ENT_QUOTES);
    $lastName = htmlentities($lastName, ENT_QUOTES);
    $email = htmlentities($email, ENT_QUOTES);

    //variable to store errors
    $errorMsg = "";

    //check to see if form boxes are empty
    if($firstName=="" || $lastName=="" || $email=="")
    {
    	$errorMsg = "All fields must be filled in";
    } 

    //is there an error
    if($errorMsg)
    {
    	//show it
    	//echo "error: " . $errorMsg;
    	echo "<p class='error'>". $errorMsg . "</p>";
    }
    else
    {
    	//craft query
    	$sql = craftInsert("table_assignee", $firstName, $lastName, $email);
    	
    	//run the query, catching errors
    	$returnValue = mysql_query($sql); 
    	if($returnValue === false)
	   		echo "<p class='error'>That email already exists</p>";
    	else
    		echo "<p class='success'>Successfully Submitted</p>";
    }
}

/**
 * craftInsert()
 * A function used to craft the sql statement necessary to insert the form elements into the table.
 * Parameters: 
 * 		$table_name, the name of the table to insert the SQL into, $first_in, $last_in, $email_in, the data from the form
 * Returns:
 *		$sql_statement, the crafted sql
 */
function craftInsert($table_name, $first_in, $last_in, $email_in)
{
	//set variables for tables and fields of those tables
	$targetTable = $table_name;
	$targetPK = "pk_email";
	$tarketFirstName = "fld_firstname";
	$tarketLastName = "fld_lastname";

	$firstName = $first_in;
	$lastName = $last_in;
	$email = $email_in;

	//make the sql statement
	$strSql = "INSERT INTO ";
    $strSql .= "$targetTable SET "; //name of table
    $strSql .= "$targetPK ='$email', ";
    $strSql .= "$tarketFirstName ='$firstName', ";
    $strSql .= "$tarketLastName='$lastName' ";

    return $strSql;
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
		<div id = "addNew">
			<form action="<? print $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<label for="txtFirstName">First Name:</label><br /><input type="text" name="txtFirstName" id="txtFirstName" /><br />
					<label for="txtLastName">Last Name:</label><br /><input type="text" name="txtLastName" id="txtLastName" /><br />
					<label for="txtEmail">Email:</label><br /><input type="text" name="txtEmail" id="txtEmail" /><br />
					<input class="inputSubmit" type="submit" name="cmdSubmitted" value="Submit" />
				</fieldset><!-- end form fieldset-->
			</form><!-- end form -->
		</div><!-- end addNew -->
        <p></p>
		<div style="float:left;"><a href="javascript:window.close()">Close Window</a></div><!--end close -->
		<!-- <p>Add assignee code here</p> -->
	</body>
</html>