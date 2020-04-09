<?php 
session_start();
ob_start();
include '../commonclass.php';
$rowAddress = $objContact->GetRowContent(1);
if(isset($_POST['submit'])){
	$email=$_POST['email'];
	$subject = "Contact Details"."\n"." Name :".$_POST['name']."\n"." Phone :".$_POST['mobile']."\n"." Email :".$_POST['email']."\n"."Message :".$_POST['message']."";
	
	$headers  = "From: $email \r\n";
	$headers .= "Content-type: text/html\r\n";
	$headers .= "Content-type: text/plain; charset=UTF-8\r\n"; 
	$to2=$rowAddress["email"];
	$headers .= 'BCC: '. $to2. "\r\n";	
	$to = $rowAddress["email"];
	if(mail($to, $subject, $msg, $headers)){
		$objClintContact->setArrData($_POST);
		$res = $objClintContact->insert();
		$to = $email;
		$subject="Global Heritage Properties";
		$msg  = "Hi ".$_POST['fname'].",<br> Thank you for contacting Global Heritage Properties. We will contact you soon..<br/>";
		mail($to, $subject, $msg, $headers);
		$_SESSION['msg']="Thank You For Contacting Global Heritage Properties...";
		header('Location: ../contact.php?mid=7');
	}
	else{
		$_SESSION['msg']="Message Delivery Failed...";
		header('Location: ../contact.php?mid=7');
	}
}
?>