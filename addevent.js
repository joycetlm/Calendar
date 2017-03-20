function addevent(event){
	var title = document.getElementById("title").value; 
	var category = document.getElementById("category").value;
	var month = document.getElementById("month").value -1; 
	var day = document.getElementById("day").value; 
	var year = document.getElementById("year").value; 
	var time = document.getElementById("time").value; 
	var date = month + "-" + day + "-" + year;
	var month_year = month + "-" + year;
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "title=" + encodeURIComponent(title) + "&category=" + encodeURIComponent(category)+"&date=" + encodeURIComponent(date)+"&time=" + encodeURIComponent(time)+"&month_year=" + encodeURIComponent(month_year);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "addevent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("Add an event successfully!");
	       showtag(month_year);
		}
		else{
		   alert("Fail to add an event!");
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
