<?php
header("Content-Type: application/json");
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
$title =  htmlentities($_POST['title']);
$category = htmlentities($_POST['category']);
$date =  htmlentities($_POST['date']);
$time =  htmlentities($_POST['time']);
$month_year = htmlentities($_POST['month_year']);
$username = $_SESSION['username'];

$stmt = $mysqli->prepare("insert into events (username, title, date, time, category,month_year) values (?,?,?,?,?,?)");
if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
}
    
$stmt->bind_param('ssssss', $username, $title, $date, $time, $category,$month_year);
 
if($stmt->execute()){
     echo json_encode(array(
		"success" => true
	 ));
     exit;
}
else{
     echo json_encode(array(
		"success" => false
	 ));
     exit;
}
$stmt->close();
    
exit;
          
?>