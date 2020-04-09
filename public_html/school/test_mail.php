<?php
include("Mail.php");
/* mail setup recipients, subject etc */
//$recipients = "itinfo@dreamuniforms.ae";
//$headers["From"] = "website@dreamuniforms.ae";
//$headers["To"] = "itinfo@dreamuniforms.ae";
//$headers["Subject"] = "User feedback";
//$mailmsg = "Hello, This is a test using SMTP authentication.";
/* SMTP server name, port, user/passwd */
//$smtpinfo["host"] = "ssl://lnxind3.cloudhostdns.net ";
//$smtpinfo["port"] = "465";
//$smtpinfo["auth"] = true;
//$smtpinfo["username"] = "website@dreamuniforms.ae";
//$smtpinfo["password"] = "Hello@1985";
/* Create the mail object using the Mail::factory method */
//$mail_object =& Mail::factory("smtp", $smtpinfo);
/* Ok send mail */
//$mail_object->send($recipients, $headers, $mailmsg);

echo "PHP is Fun!";

/* mail setup recipients, subject etc */
$recipients = "developer.singhsaurabh@gmail.com";
$headers["From"] = "birbal@dreamuniforms.biz";
$headers["To"] = "bbaagla@yahoo.com";
$headers["Subject"] = "User feedback";
$mailmsg = "Hello, This is a test using SMTP authentication.";
/* SMTP server name, port, user/passwd */
$smtpinfo["host"] = "ssl://lnxind3.cloudhostdns.net ";
$smtpinfo["port"] = "465";
$smtpinfo["auth"] = true;
$smtpinfo["username"] = "birbal@dreamuniforms.biz";
$smtpinfo["password"] = "veeru0005";
/* Create the mail object using the Mail::factory method */
$mail_object =& Mail::factory("smtp", $smtpinfo);
/* Ok send mail */
if($mail_object->send($recipients, $headers, $mailmsg)){
	echo "ok done";
}
if(mail("developer.singhsaurabh@gmail.com","subject","message dummy")){
	echo "mail ok";
}else{
 echo "no";

}
?>