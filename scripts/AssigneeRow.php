<?php
include('TableRow.php');
/**
 * AssigneeRow.php
 * Extends parent class TableRow.php
 * Produces rows specific to the table of available assignees (adds a checkbox item to each).
 */
class AssigneeRow extends TableRow
{
	/**
	 * Function writeData()
	 * Overridden from the parent class.
	 */
	public function writeData()
	    {
	        //declare function variables
	        $firstCell = "";
	        $secondCell = "";
	        $thirdCell = "";
	        $fourthCell ="";

	        //open row tag and setup class based on counter remainder (odd or even)
	        if((($this->rowNumber) % 2) == 1)
	            $this->row .= "<tr class = 'odd'>";
	        else
	            $this->row .= "<tr class = 'even'>";

	        //setup cells
	        $this->firstCell = '<td>' . $this->email . '</td>';
	        $this->secondCell = '<td>' . $this->firstName . '</td>';
	        $this->thirdCell = '<td>' . $this->lastName . '</td>';
	        $this->fourthCell = '<td><input type="checkbox" name="assignee_email[]" value="' . $this->email .'" /></td>';

	        //append rows to row variable
	        $this->row .= $this->firstCell;
	        $this->row .= $this->secondCell;
	        $this->row .= $this->thirdCell;
	        $this->row .= $this->fourthCell;

	        //close row tag
	        $this->row .= "</tr>";

	        //return row variable to caller for printing
	        return $this->row;
	    }
}

?>