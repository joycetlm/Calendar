<?php
 
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

require 'database.php'; 

ini_set("session.cookie_httponly", 1);
session_start();
$_SESSION['username'] = htmlentities($_POST['username']);
$username = $_SESSION['username'];
$password = htmlentities($_POST['password']);
$stmt = $mysqli->prepare("select password from user_info where username=?");
$stmt->bind_param('s', $username);
// Bind the results
$stmt->bind_result($pwd_hash);
$stmt->execute(); 
$stmt->fetch();

// Compare the submitted password to the actual password hash 
if( password_verify($password,$pwd_hash)){
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
 
	echo json_encode(array(
		"success" => true
	));
	exit;
}
 else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}
$stmt->close();


$stmt = $mysqli->prepare("select category,date from events where username=? and date=?");
if(!$stmt){
  printf("Failed: %s\n",$mysqli->error);
  exit;
}
$stmt->bind_param('ss', $username, $date);
// Bind the results
$stmt->execute(); 
$stmt->bind_result($title,$time,$category,$id);
$stmt->store_result(); 
$num_rows = $stmt->num_rows;
if($num_rows > 0){
while($stmt->fetch()){
  $event[] = array(
		"title" => htmlentities($title),
		"time" => htmlentities($time),
		"category" => htmlentities($category),
		"date" => htmlentities($date),
		"username" => htmlentities($username),
		"id" => htmlentities($id)
	);
	
	
	
 }
 echo json_encode(array(
		"success"=>true,
		"event"=>htmlentities($event),
		"num_rows"=>htmlentities($num_rows)
		));
 exit;
}
else{
 $event[] = array(
		"title" => htmlentities($title),
		"time" => htmlentities($time),
		"category" => htmlentities($category),
		"date" => htmlentities($date),
		"username" => htmlentities($username),
		"id" => htmlentities($id)
		
	);
	echo json_encode(array(
		"success"=>true,
		"event"=>htmlentities($event),
		"num_rows"=> htmlentities($num_rows)
	));
	exit;
}

$stmt->close();
?>