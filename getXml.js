/**
 * XML_Download
 * A class used to create instances of objects which facilitate the automated downloading of XML representing the blog posts of a wordpress site.
 * Requires a username, password, and url to be supplied to the class to create an object.
 * Parameters: 
 * 		wordpress admin username, wordpress admin password, xml source url
 */
function XML_Download(username_in, password_in, url_in)
{
	//create and instantiate global variables via parameters
	this.username = username_in;
	this.password = password_in;
	this.url = url_in;

	/**
	 * Function get_xml
	 * A function used to establish an authorized connection to the wordpress site and download the XML.
	 * Called from client code, uses
	 */
	 this.get_xml = function()
	 {
	 	//create a request object
	 	var request = new XMLHttpRequest();
	 	
	 	//use open method to set up the request with a url and the type of request to use
	 	request.open("GET", this.url);
	 	
	 	/**
	 	 * Function onload
	 	 * Using built in onload function, creates a handler to await the retrieval of the data by the request object.
	 	 * When the browser gets an answer from the remote service, it calls this function.
	 	 * If the data is successfully retured, the status code is 200. 
	 	 */
	 	 request.onload = function()
	 	 {
	 	 	if(request.status == 200)
	 	 	{
	 	 		//alert("Data Recieved");
	 	 		alert(request.responseText);
	 	 	}
	 	 }

	 	 //send the request to the server (passing null to the remote service as we are not sending any data to it).
	 	 request.send(null);
	 }

	 /**
	  * Testing Function
	  * Used for debugging.
	  */
	  this.test = function()
	  {
	  	alert(this.username + " " + this.password + " " + this.url);
	  }
}

//for debugging
var debug = false;

//change these as needed
var user = "pvendevi";
var pass = "HObbes_12!";
var url = "http://www.uvm.edu/~pvendevi/wp-admin/export.php?download";

//create connector object
var objConnector = new XML_Download(user, pass, url);

//call the get_xml function
objConnector.get_xml();

//for debugging
if (debug == true)
{
	objConnector.test();
}
