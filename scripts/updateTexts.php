<?php
	//connect to db
	include("databaseConnect.php");

	$debug = False;

	//get the id of the div you are passing in from jeditable
	$id = $_POST["id"];
	//echo $id . "\n";

	$delimeterPosition = strpos($id, "#"); //ue the # sign to indicate where pk ends and field name begins

	$primaryKey = substr($id, 0, $delimeterPosition); //primary key of row to be changed
	$field_name = deleteFirstChars($id, $delimeterPosition); //field name of row to be changed

	function deleteFirstChars($string, $position) 
	{
		return substr( $string, $position + 1 );
	}

	if($debug)
	{
		echo $primaryKey . " "; 
		echo $field_name . " ";
		echo $value . "\n";
	}

	//get the value that has been changed
	$value = $_POST["value"];


	//sanitize inputs
	$primaryKey = addslashes($primaryKey);
	$field_name = addslashes($field_name);
	$value = addslashes($value);

	$primaryKey = htmlentities($primaryKey);
	$field_name = htmlentities($field_name);
	$value = htmlentities($value);

	//call function, and pass in relevent information
	updateSql($primaryKey, $field_name, $value);


	/**
	 * updateSql()
	 * Used to update the appropriate record in the text table.
	 * Uses string operations to find the pk id of the text block, and update that record in the texts table.
	 */
	function updateSql($primaryKey, $field_name, $value)
	{
		//craft sql
		$sql = "UPDATE table_progress SET $field_name = '$value' WHERE pk_id = '$primaryKey'";
		//send sql statement to database
		mysql_query($sql) or die ("Unable to update the record in the database " . mysql_error());

		echo $value;
	}
?>