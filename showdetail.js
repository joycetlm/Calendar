function showDetail(dateid){
//alert(dateid);
 var dataId = "date=" + encodeURIComponent(dateid);
var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "eventlist.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		var num_rows = jsonData.num_rows;
		var events = jsonData.event;
	    
	    
	    function eventdetail(){
	    var htmlContent2 ='<table cellspacing = "15" >';
    //alert(num_rows);
    var i;
    if(num_rows == 0){
     htmlContent2 += "<tr> No Event </tr>";
    }
    else{
     htmlContent2 +="<tr><th>title</th> <th>tag</th> <th>time</th> <th>creator</th></tr>";
    for( i=0; i<events.length;i++){
     htmlContent2 +="<tr>";
     var t=events[i].title;
     htmlContent2 += "<td>"+events[i].title +"</td>"+"<td>"+events[i].category +"</td>"+"<td>"+events[i].time +"</td>"+"<td>"+events[i].username +"</td>"+"<td><input type=\"button\" id=\"edit\""+events[i].id+" value=\"Edit\"/></td>"+"<td><input type=\"button\" id=\"delete\""+events[i].id+" value=\"Delete\"/></td>";
     htmlContent2 +="</tr>";
     }
    }
    htmlContent2 +="</table>"
    document.getElementById("calendar").innerHTML = htmlContent2;
	    };
		
		
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataId); // Send the data
}