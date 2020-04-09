<?php
	// ini_set()
	// error_reporting( E_ALL );
	require_once("../commonclass.php");
	$contact = $objContact->GetRowContent(1);
	// include('../Smtp/SMTPconfig.php');
	// include('../Smtp/SMTPClass.php'); 
	//var_dump($contact);
	/*Php mailer */
	
	date_default_timezone_set('Etc/UTC');
	
	require_once '../../../PHPMailer-master/PHPMailerAutoload.php';
	
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	
	//Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';
	
	//Set the hostname of the mail server
	//$mail->Host = 'smtp.gmail.com';
        $mail->Host = 'relay-hosting.secureserver.net';
	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6
	
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;
	
	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';
	
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "dreamuniformllc@gmail.com";
	
	//Password to use for SMTP authentication
	$mail->Password = "veeru0005";
	
	
	/*Php mailer */
	
	if(isset($_POST['register'])){
		$email = $objUsers->GetRowContentByEmail($_POST['email']);
		if($email){
			echo "1";
			exit;
		}
		$upload_img_dir = '../multimedia/agent/';
		$_POST['status'] = '1';
		$objUsers->setArrData($_POST);
		$res = $objUsers->insert();
		if($res=="done"){
			
			$msg="<div style='margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family:Arial, Helvetica, sans-serif;font-size:12px;!important;' id='printdiv'>
			
			<div style='border:1px solid #ccc;width:624px;margin:12px auto;padding:12px;!important;'>
			
			<table width='100%' border='0' align='center' cellpadding='5' cellspacing='0'>
			
			<style></style>
			
			<tbody>
			
			<tr>
			<td align='left' style='border-bottom:1px solid #ccc;!important;'>
			<img src='http://dreamuniforms.ae/shopping/images/in-logo.png' width='' height='' class='CToWUd'>
			</td>
			</tr>
			<tr>
			<td height='250' align='left' valign='top'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tbody>
			
			<tr>
			<td>Hi, </td>
			</tr>
			<tr>
			<td>Thank You for Registering with DreamUniforms  </td>
			</tr>
			<tr>
			<td>Username: ".$_POST['email']." </td>
			</tr>
			<tr>
			<td>Password: ".$_POST['password']." </td>
			</tr>
			<tr>
			<td height='120' align='left'>
			Regards,<br><strong style='color:#0f353e;'>DreamUniforms</strong></td>
			</tr>
			</tbody>
			</table>
			</td></tr>
			<tr>
			<td height='30' align='center' bgcolor='#F4F4F4'> <strong>T</strong> :+971 4 3340494  |  <strong>E</strong> - <a href='' style='text-decoration:none;color:#0f353e;!important;' target='_blank'>enquiry@dreamuniforms.ae</a></td>
			</tr><tr>
			<td height='30' align='center' bgcolor='#0f353e' style='color:#ffffff;!important;'><strong>&copy; 2016 Dream Uniform LLC. All Rights Reserved.</strong></td>
			</tr>
			</tbody>
			</table>
			<div class='yj6qo'>
			</div><div class='adL'>
			</div>
			</div>
			</div>
			</div></div></div>";
			$from=$contact['email'];
			$headers1  = 'MIME-Version: 1.0' . "\r\n";
			$headers1 .= "Content-type: text/html; charset=utf-8\r\n";
			$subject="www.dreamuniforms.ae Registration";
			$to = $_POST['email'];
			$Cc="";
			$Bcc="";
			//Set who the message is to be sent from
			$mail->setFrom($from, 'Dreamuniforms.ae');
			
			//Set an alternative reply-to address
			$mail->addReplyTo('itinfo@Dreamuniforms.ae', 'Dreamuniforms.ae');
			
			//Set who the message is to be sent to
			$mail->addAddress($to);
			
			$mail->addBCC("schoolcustomers@dullc.ae");
			$mail->addBCC("schoollog@dullc.ae");
			
			//Set the subject line
			$mail->Subject = $subject;
			
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			$mail->msgHTML($msg);
			$mail->send();
			$mail->ClearAllRecipients();

			// $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $Cc, $Bcc, $subject, $msg, $headers1);
			// $SMTPChat = $SMTPMail->SendMail();
			
			//if(mail($to, $subject, $msg, $headers)){
			$msgcontent  = "<table>
			<tr>
			<td> New User Registered </td>		   
			</tr>
			
			<tr>
			<td>Email : ".$_POST['email']." </td>
			</tr>
			
			</table>";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$subjects = "Client Registration";
			$tos = "";
			$Bcc="";
		
			$mail1 = clone $mail;
		
			//Set who the message is to be sent from
			$mail1->setFrom($from, 'Dreamuniforms.ae');
			
			//Set an alternative reply-to address
			$mail1->addReplyTo('no-reply@Dreamuniforms.ae', 'Dreamuniforms.ae');
			
			//Set who the message is to be sent to
			$mail1->addAddress("schoolcustomers@dullc.ae");
			
			$mail1->addCC("schoollog@dullc.ae");
			
			//Set the subject line
			$mail1->Subject = $subjects;
			
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			$mail1->msgHTML($msgcontent);
			$mail1->send();
			
			// $SMTPMail1 = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $tos, $Cc, $Bcc, $subjects, $msgcontent, $headers);
			// $SMTPChat1 = $SMTPMail1->SendMail();
			//mail($tos, $subjects, $msgcontent, $headers);
			//}
			echo "3";
			}else{
			echo "4";
		}
	}
?>