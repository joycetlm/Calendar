<?php
 
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
require 'database.php'; 
ini_set("session.cookie_httponly", 1);
session_start();
$_SESSION['eventid'] = htmlentities( $_POST['eventid']);
$eventid = $_SESSION['eventid'];
$username1 = $_SESSION['username'];
$stmt = $mysqli->prepare("select username from events where id=?");
if(!$stmt){
  printf("Failed: %s\n",$mysqli->error);
  exit;
}
$stmt->bind_param('s', $eventid);
// Bind the results
$stmt->execute(); 
$stmt->bind_result($username2);
$stmt->fetch();
if($username1==$username2){
    echo json_encode(array(
		"success"=>true	
	));
}
else{
    echo json_encode(array(
		"success"=>false
	));
}
$stmt->close();
if($username1==$username2){
    $stmt = $mysqli->prepare("delete from events where id=?");
    if(!$stmt){
         printf("Failed: %s\n",$mysqli->error);
         exit;
    }
    $stmt->bind_param('s', $eventid);
    $stmt->execute(); 
    $stmt->close();
}

?>