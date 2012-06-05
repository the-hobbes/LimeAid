/**
 * XML_Download
 * A class used to create instances of objects which facilitate the automated downloading of XML representing the blog posts of a wordpress site.
 * Requires a url to be supplied to the class to create an object.
 * Parameters: 
 * 		wordpress xml source url
 */
function XML_Download(url_in)
{
	//create and instantiate global variables via parameters
	this.url = url_in;

	/**
	 * Function get_xml
	 * A function used to establish an authorized connection to the wordpress site and download the XML.
	 * Called from client code, uses
	 */
	 this.get_xml = function()
	 {
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.open("GET", this.url, false);
		xmlhttp.send();
		xmlDoc = xmlhttp.responseXML; 
		//alert(xmlDoc);
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
var url = "wordpress.2012-06-04.xml";

//create connector object
var objConnector = new XML_Download(url);

//call the get_xml function
objConnector.get_xml();

//for debugging
if (debug == true)
{
	objConnector.test();
}
