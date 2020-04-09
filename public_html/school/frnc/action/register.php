<?php
require_once("../../commonclass.php");
$contact = $objContact->GetRowContent(1);

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
			<tbody>
				<tr>
					<td align='left' style='border-bottom:1px solid #ccc;!important;'>
					</td>
				</tr>
				<tr>
					<td height='250' align='left' valign='top'>
						<table width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tbody>
								<tr>
									<td>Thank you for registering with. </td>
								</tr>
								<tr>
									<td height='120' align='left'>Regards,<br><strong style='color:#DB1C5D;'>Dreamuniform </strong></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td height='30' align='center' bgcolor='#F4F4F4'> <strong>T</strong> :+971 4 123 4567   |  <strong>E</strong> - <a href='' style='text-decoration:none;color:#DB1C5D;!important;' target='_blank'>info@dreamuniform.com</a></td>
				</tr>
				<tr>
					<td height='30' align='center' bgcolor='#DB1C5D' style='color:#ffffff;!important;'><strong>&copy; 2016 Dreamuniform. All Rights Reserved.</strong></td>
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
		$headers  = "From: $from \r\n";
		$headers.= "Content-type: text/html\r\n"; 
		$subject="Registration";
		$to = $_POST['email'];
		if(mail($to, $subject, $msg, $headers)){
			$msgcontent  = "<table>
								<tr>
									<td> New Agent Registered </td>		   
								</tr>
								<tr>
									<td> Name : ".$_POST['first_name']." </td>
								</tr> 
								<tr>
									<td>Email : ".$_POST['email']." </td>
								</tr>
								<tr>
									<td>Telephone : ".$_POST['telephone']." </td>
								</tr>
							</table>";
			$headerss  = "From: $to  \r\n";
			$headerss.= "Content-type: text/html\r\n";
			$subjects = "Client Registration";
			$tos = $contact['email'];;
			mail($tos, $subjects, $msgcontent, $headers);
		}
		echo "3";
	}else{
		echo "4";
    }
}

?>