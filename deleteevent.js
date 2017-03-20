function deleteevent(event){
	var eventid= document.getElementById("deleteevent").value; 
	// Make a URL-encoded string for passing POST data:
	var dataString = "eventid=" + encodeURIComponent(eventid) ;
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "deleteevent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  
            alert("Delete successfully!");
     
		}else{
			alert("You are not authorized to delete this event!");
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
