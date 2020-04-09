<?
include('Smtp/SMTPconfig.php');
include('Smtp/SMTPClass.php');  
$to = "annciji@gmail.com";
$from = "cijipixel@gmail.com";
$subject = "ABC";
$body = "EFG";
$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body);
$SMTPChat = $SMTPMail->SendMail();


?>