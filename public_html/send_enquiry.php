<?php 
	// include('Smtp/SMTPconfig.php');
	// include('Smtp/SMTPClass.php');
	date_default_timezone_set('Etc/UTC');
	
	require_once '../PHPMailer-master/PHPMailerAutoload.php';
	
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
	$mail->Host = 'smtp.gmail.com';
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
	
	
    $contactname=  $_POST['contactname'];
    $email=  $_POST['email'];
    $subject=  $_POST['subject'];
    $message=  $_POST['message'];
	
    $from='no-reply@dreamuniforms.ae';
    $subject2='Dream Uniforms - Enquiry Received';
    $content  = "
	<table>
	<tr>
	<td>Dear ".$contactname.", </td>
	</tr> 
	<tr>
	<td>
	<p>Your enquiry has received.We will contact you soon</p>                        
	</td>
	</tr> 
	<tr>
	<td><p>Thank You,<br>Dream Uniforms</p></td>
	</tr>                    
	</table>";
    $to= $email;
	$Cc="";
	$Bcc="";
    $headers  = "From: Dream Uniforms<".$from."> \r\n";
    $headers= 'MIME-Version: 1.0' . "\r\n";
    $headers.= "Content-type: text/html; charset=utf-8\r\n";
	//Set who the message is to be sent from
	$mail->setFrom($from, 'Dreamuniforms.ae');
	
	//Set an alternative reply-to address
	// $mail->addReplyTo('itinfo@Dreamuniforms.ae', 'Dreamuniforms.ae');
	
	//Set who the message is to be sent to
	$mail->addAddress($to);
	
	$mail->addCC($Cc);
	
	//Set the subject line
	$mail->Subject = $subject2;
	
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
	$mail->msgHTML($content);
	
	
	// $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $Cc, $Bcc, $subject2, $content, $headers);
	$SMTPChat = $mail->send();
    if($SMTPChat){
		$mail->ClearAllRecipients();
        $to     = 'enquiry@dreamuniforms.ae';
        $from   = 'no-reply@dreamuniforms.ae';
        //$subject= 'Enquiry Recieved';
        $msg  = "<table>
		<tr>
		<td>Admin, </td>
		</tr> 
		<tr>
		<td>
		<p>A new enquiry received</p>
		<p>Please find the following details:</p>
		</td>
		</tr>
		<tr>
		<td>  Name :  </td>
		<td>  $contactname  </td>
		</tr>
		<tr>
		<td> Email : </td>
		<td> $email </td>
		</tr>
		<tr>
		<td> Subject : </td>
		<td> $subject </td>
		</tr>
		<tr>
		<td> Message :  </td>
		<td> $message </td>
		</tr>               
		</table>";
		$headers= 'MIME-Version: 1.0' . "\r\n";
		$headers.= "Content-type: text/html; charset=utf-8\r\n";
		$mail1 = clone $mail;
		
		
		//Set who the message is to be sent from
		$mail1->setFrom($from, 'Dreamuniforms.ae');
		
		//Set an alternative reply-to address
		// $mail1->addReplyTo('itinfo@Dreamuniforms.ae', 'Dreamuniforms.ae');
		
		//Set who the message is to be sent to
		$mail1->addAddress($to);
		
		$mail1->addCC($Cc);
		$mail1->addBCC($Bcc);
		
		//Set the subject line
		$mail1->Subject = $subject;
		
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		$mail1->msgHTML($msg);
		
		
		
		// $SMTPMail2 = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $Cc, $Bcc, $subject, $msg, $headers);
		$SMTPChat2 = $mail1->send();
        if($SMTPChat2){
			echo "send";                
		}
	}
	
