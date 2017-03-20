<?php
 
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
require 'database.php'; 
ini_set("session.cookie_httponly", 1);
session_start();
$_SESSION['date'] = htmlentities( $_POST['date']);
$date = $_SESSION['date'];
$username = $_SESSION['username'];



$stmt1 = $mysqli->prepare("select fromname from share where toname=?");
if(!$stmt1){
  printf("Failed: %s\n",$mysqli->error);
  exit;
}
$stmt1->bind_param('s', $username);
// Bind the results
$stmt1->execute(); 
$stmt1->bind_result($fromname);
$stmt1->store_result(); 
$num_rows1 = $stmt1->num_rows;
$total_row =0;
if($num_rows1 > 0){

   while($stmt1->fetch()){
          //echo"$fromname";
        $stmt = $mysqli->prepare("select title,time,category,id from events where username=? and date=?");
        if(!$stmt){
               printf("Failed: %s\n",$mysqli->error);
               exit;
        }
        $stmt->bind_param('ss', $fromname, $date);
        // Bind the results
        $stmt->execute(); 
        $stmt->bind_result($title,$time,$category,$id);
        $stmt->store_result(); 
        $num_rows = $stmt->num_rows;
        $total_row += $num_rows;
        if($num_rows > 0){
                while($stmt->fetch()){
                         $event[] = array(
		                      "title" => htmlentities($title),
		                      "time" => htmlentities($time),
		                      "category" => htmlentities($category),
		                      "date" => htmlentities($date),
		                      "username" => htmlentities($fromname),
		                      "id" => htmlentities($id)
	                     );
	
	
	
                }
         }

         $stmt->close();
	   
       
   }

}

$stmt1->close();
      //select events whose category is "group"
      if ($username != ''){
        $group = "group";
        $stmt2 = $mysqli->prepare("select title,time,category,id,username from events where date= ? and category= ?  ");
        if(!$stmt2){
               printf("Failed: %s\n",$mysqli->error);
               exit;
        }
        $stmt2->bind_param('ss',$date,$group);
        // Bind the results
        $stmt2->execute(); 
        $stmt2->bind_result($title2,$time2,$category2,$id2,$groupname);
        
        $stmt2->store_result(); 
        $groupnum_rows = $stmt2->num_rows;
        if($groupnum_rows > 0){
                while($stmt2->fetch()){
                         $groupevent[] = array(
		                      "title" => htmlentities($title2),
		                      "time" => htmlentities($time2),
		                      "category" => htmlentities($category2),
		                      "date" => htmlentities($date),
		                      "username" => htmlentities($groupname),
		                      "id" => htmlentities($id2)
		                     
	                     );
	
	 $title2=htmlentities($title2);
	
                }
         }
         
         else{
         $groupevent[] = array();
         }
         $stmt2->close();
    }    
	   

$stmt = $mysqli->prepare("select title,time,category,id from events where username=? and date=?");
if(!$stmt){
  printf("Failed: %s\n",$mysqli->error);
  exit;
}
$stmt->bind_param('ss', $username, $date);
// Bind the results
$stmt->execute(); 
$stmt->bind_result($title1,$time1,$category1,$id1);
$stmt->store_result(); 
$num_rows2 = $stmt->num_rows;
 $total_row += $num_rows2;
if($num_rows2 > 0){
while($stmt->fetch()){
  $event[] = array(
		"title" => htmlentities($title1),
		"time" => htmlentities($time1),
		"category" => htmlentities($category1),
		"date" => htmlentities($date),
		"username" => htmlentities($username),
		"id" => htmlentities($id1)
	);
	
	
	
 }
 echo json_encode(array(
		"success"=>true,
		"event"=>$event,
		"groupevent"=>$groupevent,
		"num_rows"=> htmlentities($total_row),
		"groupnum_rows" => htmlentities($groupnum_rows),
		"title2" =>  $title2
		));
 exit;
}
else{
 $event[] = array(
		"title" => '',
		"time" => '',
		"category" => '',
		"date" => '',
		"username" => '',
		"id" => ''
		
	);
	echo json_encode(array(
		"success"=>true,
		"event"=>$event,
		"groupevent"=>$groupevent,
		"num_rows"=> htmlentities($total_row),
		"groupnum_rows" => htmlentities($groupnum_rows)
	));
	exit;
}

$stmt->close();
?>