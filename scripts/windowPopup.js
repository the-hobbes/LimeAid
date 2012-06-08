/**
 * windowPopup.js
 * Script to popup windows, according to the button clicked and the value passed in.
 * Parameters:
 *		page_in, the url of the page to be displayed
 *		height_in, width_in, the height and width of the window display
 */

function addAssignee_button(page_in, height_in, width_in)
{
	//window.open(page_in,'name','height=255,width=250,toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no');	
	window.open(page_in,'name','height=' + height_in + ',width=' + width_in + ',toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no');	
}
