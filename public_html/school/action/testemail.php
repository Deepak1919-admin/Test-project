<?php 
session_start();
ob_start();
include '../commonclass.php';
include('../Smtp/SMTPconfig.php');
include('../Smtp/SMTPClass.php'); 
echo "ffdd";



        $subject="Dream Uniform";
	$content= "Contact Details";
	$from='no-reply@dreamuniforms.ae';
	$headers= 'MIME-Version: 1.0' . "\r\n";
	 $headers.= "Content-type: text/html; charset=utf-8\r\n";
	//$to2=$rowAddress["email"];
	//$headers .= 'BCC: '. $to2. "\r\n";	
	$to = "cijipixel@gmail.com";
          $Cc="";
          $Bcc="";

$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $Cc, $Bcc, $subject, $content, $headers);
$SMTPChat = $SMTPMail->SendMail();




?>