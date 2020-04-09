<?php 
session_start();
ob_start();

require_once("../commonclass.php");
$res = $objUsers->ForgotPassword($_POST['email']);
if($res['password'] != ''){
	$content='<table width="650" height="132"  border="0" cellpadding="0" cellspacing="0" style="border:1px solid #e1c055">
				<tr>
					<td align="center"><h1 style="font-size:20px;color:#c69e20;"><strong>Forgot Password</strong></h1></td>
				</tr>
				<tr>
					<td height="19" align="center">Login Details 
						<br>
							Password: '.$res['password'].'<br>
						<br>
					</td>
				</tr>
				<tr>
					<td height="40" align="center" valign="middle" bgcolor="#EEAF3B"><strong>Copyright info@dreamuniform.com. All Rights Reserved </strong></td>
				</tr>
			</table>';
	$to = $_POST['email'];
	$subject = "Forgot Password";
	$by="Dreamuniform";
	$from='info@dreamuniform.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: =?UTF-8?B?". base64_encode($by)."?= <".$from.">\r\n";
	
	$send=mail($to,$subject,$content,$headers);
	if($send){
		echo 1;
	}else{
		echo 2;
	}
	
}else{
	echo 3;
}
?>