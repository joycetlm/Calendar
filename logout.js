function logout(month_year){
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "logout.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
			alert("Log out successfully!");
			document.getElementById("username2").style.display = 'inline';
			document.getElementById("password2").style.display = 'inline';
			document.getElementById("signup_btn").style.display = 'inline';
			document.getElementById("username").style.display = 'inline';
			document.getElementById("password").style.display = 'inline';
			document.getElementById("login_btn").style.display = 'inline';
			document.getElementById("logout_btn").style.display = 'none';
			document.getElementById("addevent").style.display = 'none';
		
	}, false); // Bind the callback to the load event
	xmlHttp.send(); // Send the data
	welcome();
	displayCalendar(month,year);
}