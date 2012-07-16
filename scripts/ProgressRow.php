<?php
include('TableRow.php');
/**
* Class ProgressRow
* Used to create instances of objects that will represent the rows in the table.
* The constructor requires the row (an array created from the mysql query), and the index of the row in order to style odd and even rows. 
* Extends TableRow class
*/
class ProgressRow extends TableRow
{
	protected $name ="";
    protected $articleAssigned = "";
    protected $dateAssigned = "";
    protected $dateCompleted = "";
    protected $reviewedBy = "";
    protected $dateReviewed = "";
    protected $public = "";
    protected $archived = "";
    protected $pk = "";

    public function __construct($passRow, $passRowNumber)
    {
    	//initialize properties of the object instance
    	$this->email = $passRow['fk_email'];
    /*	$temp_email = $this->email;


    	//retrieve first and last name corresponding to email in table_assignee
    	$pk_sql = "SELECT * FROM table_assignee WHERE pk_email = '$temp_email'";
		$pk_result = mysql_query($pk_sql) or die ("Unable to retrieve a record from table assignee " . mysql_error());
		$resultArray = mysql_fetch_array($pk_result);

    	$this->firstName = $resultArray[1];
    	$this->lastName = $resultArray[2];
    	$this->name = $firstName . " " . $lastName;
    */

    	$this->rowNumber = $passRowNumber;

    	$this->name = $passRow['fld_name'];
    	$this->articleAssigned = $passRow['fld_articleAssigned'];
    	$this->dateAssigned = $passRow['fld_dateAssigned'];
    	$this->dateCompleted = $passRow['fld_dateCompleted'];
    	$this->reviewedBy = $passRow['fld_reviewedBy'];
    	$this->dateReviewed = $passRow['fld_dateReviewed'];
    	$this->public = $passRow['fld_public'];
    	$this->archived = $passRow['fld_archived'];
        $this->pk = $passRow['pk_id'];

    	if($debug)
	    	$this->testingFunction();
    }

    public function getPK()
    {
        return $this->pk;
    }

    public function writeData()
    {
    	//declare local variables
        $cellName = "";
        $cellArticle = "";
        $cellDateAssigned = "";
        $cellDateCompleted ="";
        $cellDateReviewed ="";
        $cellReviewedBy ="";
        $cellPublic ="";
        $cellArchived ="";

        //open row tag and setup class based on counter remainder (odd or even)
        if((($this->rowNumber) % 2) == 1)
            $this->row .= "<tr class = 'odd'>";
        else
            $this->row .= "<tr class = 'even'>";

        //setup cells
		$cellName = '<td id= "'. $this->pk .'#fld_name" class ="edit">' . $this->name . '</td>'; 
		$cellArticle = '<td id= "'. $this->pk .'#fld_articleAssigned" class ="edit">' . $this->articleAssigned . '</td>';            
		$cellDateAssigned = '<td id= "'. $this->pk .'#fld_dateAssigned" class ="edit">' . $this->dateAssigned . '</td>';
		$cellDateCompleted = '<td id= "'. $this->pk .'#fld_dateCompleted" class ="edit">' . $this->dateCompleted . '</td>';
		$cellDateReviewed = '<td id= "'. $this->pk .'#fld_reviewedBy" class ="edit">' . $this->dateReviewed . '</td>';
		$cellReviewedBy = '<td id= "'. $this->pk .'#fld_dateReviewed" class ="edit">' . $this->reviewedBy . '</td>';
		$cellPublic = '<td id= "'. $this->pk .'#fld_public" class ="edit">' . $this->public . '</td>';
		$cellArchived = '<td id= "'. $this->pk .'#fld_archived" class ="edit">' . $this->archived . '</td>';

        //append rows to row variable
        $this->row .= $cellName;
        $this->row .= $cellArticle;
        $this->row .= $cellDateAssigned;
        $this->row .= $cellDateCompleted;
        $this->row .= $cellDateReviewed;
        $this->row .= $cellReviewedBy;
        $this->row .= $cellPublic;
        $this->row .= $cellArchived;

        //close row tag
        $this->row .= "</tr>";

        //return row variable to caller for printing
        return $this->row;
    }

    public function testClass()
    {
    	echo "You object has the following properties: \n";

    	echo $this->name ."\n";
    	echo $this->email . "\n";
    	echo $this->articleAssigned ."\n";
    	echo $this->dateAssigned ."\n";
    	echo $this->dateCompleted ."\n";
    	echo $this->reviewedBy ."\n";
    	echo $this->dateReviewed ."\n";
    	echo $this->public ."\n";
    	echo $this->archived;

    }
}

?>