<?php 
require('lib/class.phpmailer.php');
$mail = new PHPMailer();

$email = 'subink.mgd@gmail.com';

    $sendmail = "$email";

    $mail->AddAddress($sendmail,"Subject");
    $mail->Subject = "Subject"; 
    $mail->Body    = $content;      

    if(!$mail->Send()) { 
        echo $msg="Unknown Error has Occured. Please try again Later.";
    }
    else {
        echo $msg="Your Message has been sent. We'll keep in touch with you soon.";
    }   


?>