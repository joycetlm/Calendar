<?php
 require 'database.php';
 ini_set("session.cookie_httponly", 1);
 session_start();
 $id=htmlentities($_POST['id']);
 $category=htmlentities($_POST['category']);
 $title=htmlentities($_POST['title']);
 $time=htmlentities($_POST['time']);
 
//store the updated story into the database
 $stmt = $mysqli->prepare("update events set title=?, time=?, category=? where id=?");
 if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
 }
 $stmt->bind_param('ssss',$title, $time, $category, $id); 
 $stmt->execute();
 $stmt->close();
 echo json_encode(array(
		"success" => true
	));
 exit;


?>