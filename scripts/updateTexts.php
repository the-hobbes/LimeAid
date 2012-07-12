<?php
	//connect to db
	include("databaseConnect.php");

	$debug = False;

	//get the id of the div you are passing in from jeditable
	$id = $_POST["id"];
	//echo $id . "\n";

	$primaryKey = substr($id, 0, 1); //primary key of row to be changed
	$field_name = deleteFirstChar($id); //field name of row to be changed

	function deleteFirstChar($string) 
	{
		return substr( $string, 1 );
	}

	if($debug)
	{
		echo $primaryKey . " "; 
		echo $field_name . " ";
		echo $value . "\n";
	}

	//get the value that has been changed
	$value = $_POST["value"];
	
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