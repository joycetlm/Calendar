function signup(event){
	var username = document.getElementById("username2").value; // Get the username from the form
	var password = document.getElementById("password2").value; // Get the password from the form
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "signup.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("Sign up successfully!");
			document.getElementById("username2").style.display = 'none';
			document.getElementById("password2").style.display = 'none';
			document.getElementById("signup_btn").style.display = 'none';
			document.getElementById("username").style.display = 'none';
			document.getElementById("password").style.display = 'none';
			document.getElementById("login_btn").style.display = 'none';
			//show "welcome, user" information		
	        //document.getElementById("welcome_info").style.display = 'inline';
			//show logout button
			document.getElementById("logout_btn").style.display = 'inline';
		}else{
			alert("Fail to sign up.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
