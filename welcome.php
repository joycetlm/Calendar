 <?php
 ini_set("session.cookie_httponly", 1);
 session_start();
    $name=$_SESSION['username'];
     echo json_encode(array(
		"name" => $name
	));
	exit;
     
?>