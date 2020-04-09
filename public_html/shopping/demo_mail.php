<?php 

require_once('lib/class.phpmailer.php');
$mail= new PHPMailer(); // defaults to using php "mail()"

	$email="annciji@gmail.com";
        $address="test addresss";

$content	=	'<table cellpadding="5" cellspacing="0" width="500" style="border:1px solid #ccc; font-size:12px; font-family:Arial;">
								<tr bgcolor="#666666">
									<td colspan="2" style="color:#fff;"><strong>Contact From ghjgj</strong></td>
								</tr>
								
								<tr valign="top">
									<td>Message :</td>
									<td>ghjhgj</td>
								</tr>
							</table>';
	
							
			$mail->AddReplyTo("website@dreamuniforms.ae","dream");
			$mail->SetFrom($email,$name);		
			$mail->AddReplyTo("website@dreamuniforms.ae","dream");		
			$address = "website@dreamuniforms.ae";
			$mail->AddAddress($address, "dream");		
			$mail->Subject    = "dream Contact";		
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test		
			$mail->MsgHTML($content);
			
			//$mail->AddAttachment("images/phpmailer.gif");      // attachment
			//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
			
			if(!$mail->Send()) {
			// add_msg("Error occure.., try again..",0);
echo "error";
			} else {
			  // add_msg("Mail Sent successfully..",1);
echo "send";
			}				
?>

