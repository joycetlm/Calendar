<?php
header("Content-Type: application/json");
require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
$toname1 = htmlentities( $_POST['toname']);
$fromname = $_SESSION['username'];
$stmt = $mysqli->prepare("select password from user_info where username=?");
$stmt->bind_param('s', $toname1);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
   }
// Bind the results
$stmt->bind_result($password);
$stmt->execute(); 

$stmt->fetch();
$stmt->close();
if($password !=''){

//Fetch user information from database 
if($toname1 ==$fromname){
     echo json_encode(array(
		"success" => false,
		"message" => "You cannot share your own events with yourself!"
	));
             exit;

     }
else{
   $stmt = $mysqli->prepare("select toname from share where fromname = ? ");
   $stmt->bind_param('s', $fromname);
   if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
   }
 
   $stmt->execute();
   $stmt->bind_result($toname2);
   
   while($stmt->fetch()){
	   if($toname2 == $toname1){
	         echo json_encode(array(
		"success" => false,
		"message" => "Your have shared your events with this user!"
	));
             exit;
        }
   }
   $stmt->close();         
   $stmt = $mysqli->prepare("insert into share (toname, fromname) values (?, ?)");
   if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
    }
 
    $stmt->bind_param('ss', $toname1, $fromname);
 
    $stmt->execute();
 
    $stmt->close();
    echo json_encode(array(
		"success" => true
	));
    exit;
}

}
else{
      echo json_encode(array(
      "success" => false,
     "message" => "The username you entered does not exist!"
	));
    exit;
      
}

  
?>