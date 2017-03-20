function showdialog1(id)
    {  
      $("#mydialog1").dialog(
      {height:300, width:600,
      buttons: [
    {
      text: "Submit",
      icons: {
        primary: "ui-icon-heart"
        },
      click: function() {
        $( this ).dialog( "close" );
         var title=document.getElementById("edittitle").value;
         var category=document.getElementById("editcategory").value;
         var time=document.getElementById("edittime").value;
        storeevent(id,title,category,time);
       }
    }
  ]
       
    }
      )
    }
    

function storeevent(id,title,category,time){
var dataString = "title=" + encodeURIComponent(title) + "&category=" + encodeURIComponent(category)+"&time=" + encodeURIComponent(time)+"&id=" + encodeURIComponent(id);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "storeedit.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("Edit an event successfully!");
		}
		else{
		   alert("Fail to edit an event!");
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}


function editevent(event){
	var eventid= document.getElementById("editevent").value; 
	// Make a URL-encoded string for passing POST data:
	var dataString = "eventid=" + encodeURIComponent(eventid) ;
 
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "editevent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		var id=jsonData.id;
		if(jsonData.success){  

     var htmlContent3 ="<form name=\"input\" method=\"POST\" class =\"form\">";
	  htmlContent3 +="<p> Title: <input type=\"text\" id=\"edittitle\" value ="+jsonData.title+" /> </p>";
	  htmlContent3 +="<label> Tag:</label><select id=\"editcategory\"><option value = \"reminder\"> reminder </option><option value = \"target\"> target </option><option value = \"activity\"> activity </option><option value = \"other\"> other </option><option value = \"group\"> group </option></select>";
	  htmlContent3 +="<p> Time: <input type=\"text\" id=\"edittime\" value ="+jsonData.time+" /> </p></form>";
	 // <p><input type=\"submit\" value=\"Submit\" /></p> 
    //htmlContent2 +="</table>"
    document.getElementById("mydialog1").innerHTML = htmlContent3;
    showdialog1(id);
		
		}else{
			alert("You are not authorized to edit this event!");
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}


