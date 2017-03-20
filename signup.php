<?php
header("Content-Type: application/json");
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
$username = htmlentities( $_POST['username']);
$password1= htmlentities( $_POST['password']);

//Fetch user information from database 

   $stmt = $mysqli->prepare("select username, password from user_info order by username");
   if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
   }
 
   $stmt->execute();
   $stmt->bind_result($user, $pass);
 
 //encode the password 
   $password2 = password_hash($password1,PASSWORD_BCRYPT);
   
   while($stmt->fetch()){
	   if($username == $user ){
	         echo json_encode(array(
		"success" => false,
		"message" => "The username has been used, please enter another one!"
	));
             exit;
        }
   }
   $stmt = $mysqli->prepare("insert into user_info (username, password) values (?, ?)");
   if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
    }
 
    $stmt->bind_param('ss', $username,$password2);
 
    $stmt->execute();
 
    $stmt->close();
    $_SESSION['username']=$username ;
    echo json_encode(array(
		"success" => true
	));
    exit;
          
?>