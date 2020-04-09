<?php
include '../commonclass.php';

if(isset($_POST['send'])){
	
	$row = $objProduct->GetRowContent($_POST['proer_id']);
	if($row['user_id'] == 1){
		$rowAddress = $objContact->GetRowContent(1);
	}else{
		$rowAddress = $objUser->GetRowContent($row['user_id']);
	}
	$email=$_POST['email'];
	$subject = $row['title'];
	$msg = "Contact Details"."\n"." Property :".$row['title']."\n"." Name :".$_POST['name']."\n"." Phone :".$_POST['phone']."\n"." Email :".$_POST['email']."\n"."Message :".$_POST['message']."";
	$headers  = "From: $email  \r\n";
	$headers .= "Content-type: text/html\r\n";
	$headers .= "Content-type: text/plain; charset=UTF-8\r\n"; 
	$to2=$rowAddress["email"];
	$headers .= 'BCC: '. $to2. "\r\n";	
	$to = $rowAddress["email"];
	if(mail($to, $subject, $msg, $headers)){
		//$objClintContact->setArrData($_POST);
		//$res = $objClintContact->insert();
		$mesg = 1;
	}
	else{
		$mesg = 2;
	}
	echo $mesg;
}
?>