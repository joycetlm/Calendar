<!DOCTYPE html>
<html>
<head> 
<title>Calendar</title>
<?php
session_start();
?>
<style> 
.currentMonth{
 text-align: center;
}

.currentMonth th{
 background-color: coral;
 color: white;
 htmlContent:10x;
 text-align: center;
 height:50px;
}

.currentDay{
 background-color: springgreen;
 text-align: center;
}
.calendarDays td{
border: 2px  solid black;
 htmlContent: 6px;
 color: black;
 width: 120px;
 height:50px;
}

.weekName{
 background: yellow;
 text-align: center;
}
 #mydialog { display:none }
 #addevent{ display:none }
 #tag{ display:none }
 ##mydialog1 { display:none }
 
</style> 
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css" type="text/css" rel="Stylesheet" />
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script> -->
<script type="text/javascript" src="http://classes.engineering.wustl.edu/cse330/content/calendar.min.js"></script>
<script type="text/javascript" src="login.js"></script>
<script type="text/javascript" src="signup.js"></script>
<script type="text/javascript" src="logout.js"></script>
<script type="text/javascript" src="addevent.js"></script>
<script type="text/javascript" src="showdetail.js"></script>
<script type="text/javascript" src="editevent.js"></script>
<script type="text/javascript" src="deleteevent.js"></script>
<script type="text/javascript" src="share.js"></script>
<script type="text/javascript">

var tagstate = true;
function showtag(month_year){
  tagstate = true;
  var month_year = "month_year=" + encodeURIComponent(month_year);
   var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "tag.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		var num_rows = jsonData.num_rows;
	//alert(num_rows);
		var tag = jsonData.tag;
		for( var i=0;i<num_rows;i++){
		var activitytag= "activity"+tag[i].date;
		var remindertag= "reminder"+tag[i].date;
		var targettag= "target"+tag[i].date;
		var othertag= "other"+tag[i].date;
		var grouptag= "group"+tag[i].date;
		
		if(tag[i].category == "reminder"){
		
		 document.getElementById(remindertag).style.display = 'inline';
		}
		if(tag[i].category == "activity"){
		
		document.getElementById(activitytag).style.display = 'inline';  
		}
		if(tag[i].category == "target"){
		
		//alert(targettag);
		document.getElementById(targettag).style.display = 'inline';  
		}
		if(tag[i].category == "other"){
		
		//alert(othertag);
		document.getElementById(othertag).style.display = 'inline';  
		}
		if(tag[i].category == "group"){
		
		//alert(othertag);
		document.getElementById(grouptag).style.display = 'inline';  
		}
		
	} }, false); // Bind the callback to the load event
	xmlHttp.send(month_year); // Send the data
 }
 
 function hidetag(month_year){
 tagstate = false;
  var month_year = "month_year=" + encodeURIComponent(month_year);
   var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "tag.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		var num_rows = jsonData.num_rows;
		var tag = jsonData.tag;
		for( var i=0;i<num_rows;i++){
		var activitytag= "activity"+tag[i].date;
		var remindertag= "reminder"+tag[i].date;
		var targettag= "target"+tag[i].date;
		var othertag= "other"+tag[i].date;
		var grouptag= "group"+tag[i].date;
		
		// document.getElementById(remindertag).style.display = 'none';
		
		//document.getElementById(activitytag).style.display = 'none';  
		
		//document.getElementById(targettag).style.display = 'none';  
		
		//document.getElementById(othertag).style.display = 'none';  
		//document.getElementById(grouptag).style.display = 'none';  
		
	} }, false); // Bind the callback to the load event
	xmlHttp.send(month_year); // Send the data
 }
    
    function showdialog(dateid)
    {  
      $("#mydialog").dialog(
      {height:400, width:600
       
    }
      )
    }
 
 function eventList(groupevent,events,num_rows,groupnum_rows,dateid){
     var htmlContent2 ='<table cellspacing = "15" >';
    //alert(num_rows);
    var i;
    if(num_rows == 0){
     htmlContent2 += "<tr> No Personal Event </tr>";
    }
    else{
     htmlContent2 +="<tr><th>id</th><th>title</th> <th>tag</th> <th>time</th> <th>creator</th></tr>";
    for( i=0; i<events.length;i++){
     htmlContent2 +="<tr>";
     var t=events[i].title;
     htmlContent2 += "<td>"+events[i].id +"</td>"+"<td>"+events[i].title +"</td>"+"<td>"+events[i].category +"</td>"+"<td>"+events[i].time +"</td>"+"<td>"+events[i].username +"</td>";
     htmlContent2 +="</tr>";
     }
    }
     htmlContent2 +="</table><br><br>";
     htmlContent2 +='<table cellspacing = "15" >';
    if(groupnum_rows == 0){
     htmlContent2 += "<tr>No Group Event</tr>";
    }
    else{
     htmlContent2 +="<tr>Group Events</tr>";
    htmlContent2 +="<tr><th>id</th><th>title</th> <th>tag</th> <th>time</th> <th>creator</th></tr>";
    for( i=0; i<groupevent.length;i++){
     htmlContent2 +="<tr>";
     var t=groupevent[i].title;
     htmlContent2 += "<td>"+groupevent[i].id +"</td>"+"<td>"+groupevent[i].title +"</td>"+"<td>"+groupevent[i].category +"</td>"+"<td>"+groupevent[i].time +"</td>"+"<td>"+groupevent[i].username +"</td>";
     htmlContent2 +="</tr>";
     }
    }
    htmlContent2 +="</table>";
    
    document.getElementById("mydialog").innerHTML = htmlContent2;
    showdialog(dateid);
 } 
   
 function showList(dateid){
 var dataId = "date=" + encodeURIComponent(dateid);

   var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "eventlist.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	//alert(event.target.responseText);
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		var num_rows = jsonData.num_rows;
		var groupnum_rows = jsonData.groupnum_rows;
		var events = jsonData.event;
		var groupevent = jsonData.groupevent;   
	    eventList(groupevent,events,num_rows,groupnum_rows,dateid);
		
		
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataId); // Send the data
 }
 
 function welcome(){
 
 var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
 
	xmlHttp.open("POST", "welcome.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
	    //alert(event.target.responseText);
	    var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		var username = jsonData.name;
		if(username==''){
		var welcome = "<p>Welcome, Guest!</p>"; 
	  document.getElementById("welcome").innerHTML  = welcome;
		}
		else{
		var welcome = "<p>Welcome, "+username+"!</p>"; 
	  document.getElementById("welcome").innerHTML  = welcome;
	  }
	  //return welcome1;
	  
	}, false); // Bind the callback to the load event
	//var welcome2 =welcome1();
    //alert(welcome2);
	xmlHttp.send(); // Send the data
	
 }
 </script>
</head>
 
<script type="text/javascript"> 


 
 //get current month,day,year
 var currentDate = new Date();
 var month = currentDate.getMonth();
 var day = currentDate.getDate();
 var year = currentDate.getFullYear();
 var month_year = month + "-" + year;
 //prepare the variable to use Calendar Library 
 var currentMonth = new Month(year, month); 
 //var htmlContent2 = "<input type=\"hidden\" id=\"month\",value="+month+" />";
 //htmlContent2 += "<input type=\"hidden\"  id=\"year\" value="+year+" />";
 
//function to display calendar
function displayCalendar(month,year){
 
 var prevMonth = month - 1;
 var nextMonth = month + 1;
 var htmlContent ='';
 var FebDays;
 var counter = 1;
 
 //Determing whether the year is leap year(if so, Feb has 29 days) 
 if (month == 1){
    if ( (year%100!=0) && (year%4==0) || (year%400==0)){
      FebDays = 29;
    }else{
      FebDays = 28;
    }
 }
 
 // month names and week names
 var monthNames = ["January","February","March","April","May","June","July","August","September","October","November", "December"];
 //var weekNames = ["Sunday","Monday","Tuesday","Wednesday","Thrusday","Friday", "Saturday"];
 var monthDays = ["31", ""+FebDays+"","31","30","31","30","31","31","30","31","30","31"]  
 
 var nextDate = new Date(nextMonth +' 1 ,'+year);
 var weekdays1= nextDate.getDay(); // days in next month
 var weekdays2 = weekdays1; 
 var daysNumber = monthDays[month]; //number of days in current month
 
 // leave a white space for days of pervious month.
  while (weekdays1>0){
    htmlContent += "<td class='calendarDays'></td>";
     weekdays1--;
}
 
 // build the body of calendar 
 while (counter <= daysNumber){ 
    if (weekdays2 > 6){
        weekdays2 = 0;
        htmlContent += "</tr><tr>";
    }
    // highlight current day with different color
    var dateId =month + "-" + counter + "-" + year;
    if (counter == day && new Date().getMonth() == month && new Date().getFullYear() == year){
        htmlContent +="<td class='currentDay'  onMouseOver='this.style.background=\"skyblue\"' "+
        "onMouseOut='this.style.background=\"springgreen\"; this.style.color=\"black\"' "+" id= "+dateId+" >"+counter+"<br><div id=\"tag"+dateId+"\"><input type=\"button\"  id=\"reminder"+dateId+"\"   style=\"border-radius:1px; border-width:1px;background-color:Gold;display:none;\"\"/><input type=\"button\"  id=\"activity"+dateId+"\"   style=\"border-radius:1px; border-width:1px;background-color:Coral;display:none;\"\"/><input type=\"button\"  id=\"target"+dateId+"\"   style=\"border-radius:1px; border-width:1px;background-color:MistyRose;display:none;\"\"/><input type=\"button\"  id=\"other"+dateId+"\"   style=\"border-radius:1px; border-width:1px;background-color:Silver;display:none;\"\"/><input type=\"button\"  id=\"group"+dateId+"\"   style=\"border-radius:1px; border-width:1px;background-color:Violet;display:none;\"\"/></td>";
    }
    else{
        htmlContent +="<td class='currentMonth' onMouseOver='this.style.background=\"skyblue\"'"+
        " onMouseOut='this.style.background=\"white\"' "+" id= "+dateId+" >"+counter+"<br><div id=\"tag"+dateId+"\"><input type=\"button\"  id=\"reminder"+dateId+"\"  style=\"border-radius:1px; border-width:1px;background-color:Gold; display:none;\"\"/><input type=\"button\"  id=\"activity"+dateId+"\"  style=\"border-radius:1px; border-width:1px;background-color:Coral;display:none;\"\"/><input type=\"button\"  id=\"target"+dateId+"\"  onclick=alert(this.id) style=\"border-radius:1px; border-width:1px;background-color:MistyRose;display:none;\"\"/><input type=\"button\"   id=\"other"+dateId+"\"  style=\"border-radius:1px; border-width:1px;background-color:Silver;display:none;\"\"/><input type=\"button\"  id=\"group"+dateId+"\"   style=\"border-radius:1px; border-width:1px;background-color:Violet;display:none;\"\"/></td>";
    }  
     
    weekdays2++;
    counter++;
 } 
 // build calendar body
 //alert(welcome());
// var welcome = welcome();
//welcome();
 var calendarBody = ''; 
 calendarBody += "<table class='calendarDays'> <tr class='currentMonth'><th colspan='7'>"
 +monthNames[month]+" "+ year +"</th></tr>";
 calendarBody +="<tr class='weekName'>  <td>Sun</td>  <td>Mon</td> <td>Tue</td>"+
 "<td>Wed</td> <td>Thurs</td> <td>Fri</td> <td>Sat</td> </tr>";
 calendarBody += "<tr>";
 calendarBody += htmlContent;
 calendarBody += "</tr></table>";
 
 document.getElementById("calendar").innerHTML=calendarBody;
 //welcome();
 $('td').click(function(event){ showList(this.id) });
 

}


//function to display previous month calendar
function prevCalendar(){
currentMonth = currentMonth.prevMonth();
var prevMonth = currentMonth.month;
var prevMonthYear = currentMonth.year;
var prevmonth_year = prevMonth + "-" + prevMonthYear;
displayCalendar(prevMonth,prevMonthYear);
if(tagstate){
   showtag(prevmonth_year);

 }
else{
  hidetag(prevmonth_year);
}
}

//function to display next month calendar
function nextCalendar(){
currentMonth = currentMonth.nextMonth();
 var nextMonth = currentMonth.month; 
 var nextMonthYear = currentMonth.year; 
 var nextmonth_year = nextMonth + "-" + nextMonthYear;
 displayCalendar(nextMonth,nextMonthYear);
 if(tagstate){
   showtag(nextmonth_year);

 }
else{
  hidetag(nextmonth_year);
}
}
</script> 
 
<body onload="displayCalendar(month,year)"> 
<div id="mydialog" title="Event List"> </div>
<div id="mydialog1" title="Edit Event"> </div>
<p id ="welcome">Welcome, Guest!</p>
<div id="calendar"></div> 
<input type="submit" name="pre" value="Previous Month" id="pre" />
<input type="submit" name="adv" value="Next Month" id="next" />
<div id = "tag">
<input type="submit" name="show" value="Show Tag" id="show" />
<input type="submit" name="hide" value="Hide Tag" id="hide" />
</div>
<br><br>
<input type="text" id="username" placeholder="Username" />
<input type="password" id="password" placeholder="Password" />
<button id="login_btn">Log In</button>
<br><br>
<input type="text" id="username2" placeholder="Username" />
<input type="password" id="password2" placeholder="Password" />
<button id="signup_btn">Sign Up</button>
<div id="addevent">
<input type="button" id="logout_btn" value="Log Out"/>
<br><p> Share your events </p>
<input type="text" id="shareevent" placeholder="Enter the username you want to share" style="width:200px" />
<button id="share_btn">Share</button>
<br><br><p> Add an event </p>
<label>title &nbsp</label><input type="text" id="title" />
<label>&nbsp &nbsp tag &nbsp</label><select id="category">
<option value = "reminder"> reminder </option>
<option value = "target"> target </option>
<option value = "activity"> activity </option>
<option value = "other"> other </option>
<option value = "group"> group </option>
</select>
<label>&nbsp &nbsp month &nbsp</label><input type="number" id="month" placeholder="1-12"/>
<label>&nbsp &nbsp day &nbsp</label><input type="number" id="day" placeholder="1-31"/>
<label>&nbsp &nbsp year &nbsp</label><input type="number" id="year"/>
<label>&nbsp &nbsp time &nbsp</label><input type="text" id="time"/>
<br><button id="add"> add event</button>

<br><br><p> Edit an event </p>
<input type="text" id="editevent" placeholder="Enter the event id here" />
<button id="edit_btn">Edit</button>

<br><br><p> Delete an event </p>
<input type="text" id="deleteevent" placeholder="Enter the event id here" />
<button id="delete_btn">Delete</button>
</div>

</body>

<script>

document.getElementById('pre').addEventListener("click", prevCalendar,false);
document.getElementById('next').addEventListener("click", nextCalendar,false);
document.getElementById('show').addEventListener("click", function(){showtag(month_year)},false);
document.getElementById('hide').addEventListener("click", function(){hidetag(month_year)},false);
document.getElementById("signup_btn").addEventListener("click", signup, false); 
document.getElementById("login_btn").addEventListener("click", function(){login(month_year)}, false); 
document.getElementById("logout_btn").addEventListener("click", function(){logout(month,year)}, false); 
document.getElementById("edit_btn").addEventListener("click", editevent, false); 
document.getElementById("add").addEventListener("click", addevent, false); 
document.getElementById("delete_btn").addEventListener("click", deleteevent, false);
document.getElementById("share_btn").addEventListener("click", shareevent, false);
</script> 

</html> 