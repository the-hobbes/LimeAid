//do we want to debug?
var debug = false;

//when the browser has loaded the page full, intitialize
window.onload = init();

/**
 * init()
 * Function used to control calling of the satellite functions and create the necessary objects for the page to work.
 */
function init() 
{
	//change this as needed. The location of the xml file.
	var url = "wordpress.2012-06-04.xml";

	//create connector object
	var obj_Connector = new XML_Download(url);

	//for debugging
	if (debug == true)
	{
		obj_Connector.test();
	}

	//call the get_xml function
	xml_Object = obj_Connector.get_xml();

	//call the parsing function, and setup the title and date arrays.
	var parse_Object = new ParseXML(xml_Object);

	var title_array = parse_Object.getTitles();
	var date_array = parse_Object.getDates();
	var cat_array = parse_Object.getCategories();

	//call xml output function to display xml
	xml_output(title_array, date_array, cat_array);
}


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
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.open("GET", this.url, false);
		xmlhttp.send();
		xmlDoc = xmlhttp.responseXML; 
		//alert(xmlDoc);
		return xmlDoc;
	 }

	 /**
	  * Testing Function
	  * Used for debugging.
	  */
	  this.test = function()
	  {
	  	alert(this.url);
	  }
}

/**
 * ParseXML
 * A function used to parse the desired XML sections from the xml object (date and title nodes).
 * Parameters:
 * 		xml object returned by the XMLHttpRequest
 */
 function ParseXML(xmlObject_in)
 {
 	//declare variables
 	var xmlObject = xmlObject_in;
 	var titleElements;
 	var pubDateElements;
 	var categoryElements;

 	this.titleElements = xmlObject.getElementsByTagName("title");
 	this.pubDateElements = xmlObject.getElementsByTagName("pubDate");
	this.categoryElements = xmlObject.getElementsByTagName("category");

 	//declare arrays to store titles and pubdates
 	var titleArray = new Array();
 	var datesArray = new Array();
 	var catArray = new Array();

 	//add elements to the arrays
 	for(i = 0; i < this.titleElements.length; i++)
 	{
 		titleArray.push(this.titleElements[i].childNodes[0].nodeValue);
 		datesArray.push(this.pubDateElements[i].childNodes[0].nodeValue);
 		catArray.push(this.categoryElements[i].childNodes[0].nodeValue);

 	}

 	/**
 	 * getTitles
 	 * Returns: titleArray, the array of parsed xml titles
 	 */
 	this.getTitles = function()
 	{
 		return titleArray;
 	}

	/**
 	 * getDates
 	 * Returns: datesArray, the array of parsed xml dates
 	 */
 	this.getDates = function()
 	{
 		return datesArray;
 	}

 	/**
 	 * getCategories
 	 * Returns: catArray, the array of parsed xml categories
 	 */
 	this.getCategories = function()
 	{
 		return catArray;
 	}

 	/**
 	 * Code to test the contents of the title and publication date variables, and the arrays.
 	 * Used for debugging.
 	 */
 	if(debug)
 	{
		for (i = 0; i < this.titleElements.length; i++)
		{ 
			//document.write(this.titleElements[i].childNodes[0].nodeValue, " :: ");
			//document.write(this.pubDateElements[i].childNodes[0].nodeValue, " :: ");
			//document.write(this.categoryElements[i].childNodes[0].nodeValue);

			//document.write("<br />");

			document.write(titleArray[i], " :: ");
			document.write(datesArray[i], " :: ");
			document.write(catArray[i]);

 			document.write("<br />");	
		}
	}
 }

 /**
 * xml_output
 * Function used to format the xml properly and insert it into the div.
 * Parameters:
 * 		3 arrays, containing the parsed titles, dates, and categories
 */
 function xml_output(title_in, date_in, cat_in)
 {
 	//initialize working local variables
 	var titleArray = title_in;
 	var dateArray = date_in;
 	var catArray = cat_in;

 	//get appropriate div from DOM
 	var xmlDisplay_div = document.getElementById("xmlDisplay");

 	alert(xmlDisplay_div); //FOR SOME REASON THIS IS GETTING CALLED BEFORE IT IS CREATED IN THE DOCUMENT.

 	//loop through each array and add it to the DOM
 	for(var i = 0; i < titleArray.length; i++)
 	{
 		var item = titleArray[i] + " " + dateArray[i] + " " + catArray[i]; //put all three pieces of information together
 		var div = document.createElement("div"); //create a div
 		div.setAttribute("class", "xmlItem"); //add the class, "xmlItem" to the div
 		div.innterHTML = item; //set the div's contents with innerhtml
 		xmlDisplay_div.appendChild(div); //append the fresh div to the xmlDisplay div in the DOM
 	}
 }