<?php
$to="annciji@gmail.com";
$fn="Fisrt Name";
$ln="Last Name";
$name=$fn.' '.$ln;
$from="website@dreamuniforms.ae";
$subject = "Welcome to Website";
$message = "Dear $name, 


Your Welcome Message.


Thanks
www.website.com
";

include('smtpwork.php');

?>