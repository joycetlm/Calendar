<?php
 
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
require 'database.php'; 
ini_set("session.cookie_httponly", 1);
session_start();
//$_SESSION['date'] = (string) $_POST['date'];
$month_year = htmlentities( $_POST['month_year']);
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
          $stmt = $mysqli->prepare("select category,date from events where username=? and month_year=? ");
       if(!$stmt){
         printf("Failed: %s\n",$mysqli->error);
      exit;
     }
   $stmt->bind_param('ss', $fromname, $month_year);
  // Bind the results
   $stmt->execute(); 
   $stmt->bind_result($category,$date);
   $stmt->store_result(); 
   $num_rows = $stmt->num_rows;
     if($num_rows > 0){
     while($stmt->fetch()){
     $tag[] = array(
		"category" => htmlentities($category),
		"date" => htmlentities($date),
	);
	
	
	
    }
 }
    else{
    $tag[] = array(
		"category" => htmlentities($category),
		"date" => $date,
		
	);
	
}

   $total_row +=$num_rows;     
   $stmt->close();
	   
      
   
   }

}

$stmt1->close();

    if($username !=''){
        $group = "group";
        $stmt2 = $mysqli->prepare("select category,date from events where category= ? and month_year=? ");
        if(!$stmt2){
               printf("Failed: %s\n",$mysqli->error);
               exit;
        }
        $stmt2->bind_param('ss',$group,$month_year);
        // Bind the results
        $stmt2->execute(); 
        $stmt2->bind_result($category2,$date);
        
        $stmt2->store_result(); 
        $groupnum_rows = $stmt2->num_rows;
        $total_row +=$groupnum_rows; 
        //echo"$groupnum_rows";
        if($groupnum_rows > 0){
                while($stmt2->fetch()){
                         $tag[] = array(
		                      "category" => htmlentities($category2),
		                      "date" => htmlentities($date)
		                     
	                     );
	
	 //$title2=htmlentities($title2);
	
                }
         }
         
         else{
         $groupevent[] = array();
         }
         $stmt2->close();
    }
         
$stmt = $mysqli->prepare("select category,date from events where username=? and month_year=? ");
if(!$stmt){
  printf("Failed: %s\n",$mysqli->error);
  exit;
}
$stmt->bind_param('ss', $username,$month_year);
// Bind the results
$stmt->execute(); 
$stmt->bind_result($category,$date);
$stmt->store_result(); 
$num_rows = $stmt->num_rows;
 $total_row +=$num_rows; 
if($num_rows > 0){
while($stmt->fetch()){
  $tag[] = array(
		"category" => htmlentities($category),
		"date" => htmlentities($date),
	);
	
	
	
 }
 echo json_encode(array(
		"success"=>true,
		"tag"=>$tag,
		"num_rows"=> $total_row
		));
 exit;
}
else{
 $tag[] = array(
		"category" => htmlentities($category),
		"date" => $date,
		
	);
	echo json_encode(array(
		"success"=>true,
		"tag"=>$tag,
		"num_rows"=> $total_row
	));
	exit;
}

$stmt->close();
?>