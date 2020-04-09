<?php
	//include('header_thk.php');
	include('header_inner.php');
	include("banner.php");
	session_start();
	// var_dump($_SESSION);
	
	ob_start();
	// include('Smtp/SMTPconfig.php');
	// include('Smtp/SMTPClass.php'); 
	$orderdate = date("d/m/Y");
	
	/*Php mailer */
	
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
	
	
	$AllEmail=$objEmail->GetRowContent(1);
	
	if($_REQUEST['response_message']=="Success") {
		if ($_REQUEST['merchant_reference']) {
			$orderid = $_REQUEST['merchant_reference'];
			echo $successmsg = "<p style='font-size:15px;color:red; border:1px solid #ccc;padding:10px;'>Thank You Purchasing</p>";
		}
		$chkqry=mysql_query("SELECT * FROM `tblorder` WHERE transactionid=".$_REQUEST['fort_id']);
		$numrow1=mysql_num_rows($chkqry); 
		if(!$numrow1>0)
		{
			$date = date("d/m/Y");
			$time = date("h:i:s");
			$transid=$_REQUEST['fort_id'];
			$st="paid";
			$upqry="Update `tblorder` set date='$date',time='$time',transactionid='$transid',status='$st' where order_id='$orderid'";
			mysql_query($upqry);
			$getodr=$objOrder->GetRowContentOid($_REQUEST['merchant_reference']);
			$uid=$getodr['userid'];
			$getuser=$objUser->GetRowContent($uid);
			$_SESSION['useremail']=$getuser['email'];
			$getorderDet=$objOrderDetails->SelectOrderDetails($getodr['id']);
			
			foreach($getorderDet as $ODetails)
			{
				$getStk=$ObjProductPrice->GetRowContent($ODetails['mainId']);
				$oldstk=$getStk['stock'];
				$newstk=$oldstk-$ODetails['quantity'];
				$sqlstk = "update product_price set stock=$newstk where id=".$ODetails['mainId'];
				$restk = mysql_query($sqlstk);
			}
			$getCntry=$objCounrty->GetRowContent($getuser['country']);
			$curl = curl_init();
			curl_setopt_array(
			$curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://parzel.com/vendor/T0215.php',
			CURLOPT_USERAGENT => 'PARZEL EXPRESS',
			CURLOPT_POST => 1,
			CURLOPT_FOLLOWLOCATION =>1,
			CURLOPT_POSTFIELDS => array(
			'orderid' => $_REQUEST['merchant_reference'],
			'consignee' => $getuser['fname'],
			'consigneecperson' => $getuser['lname'],
			'consigneeaddress1' => $getuser['address'],
			'consigneeaddress2' => $getuser['address'],
			'consigneephone' => $getuser['phone'],
			'consigneecity' => $getuser['city'],
			'consigneecountry' => $getCntry['name'],
			'price' => $_SESSION['total'],
			'weight' => '0',
			'quantity' => $_SESSION['quantity'],
			'paymentmethod' => 'CC',  
			'goodsdescription' => 'AS PER ORDER ID',
			'specialinstruction' => 'Delivery',
			)
			)
			);
			$response = curl_exec($curl);
			echo $response;
			curl_close($curl); 
			if(!curl_exec($curl)){
				die('Error:"' . curl_error($curl) . '" - Code ' . curl_errono($curl));
			} 
		}
	}
	elseif($_GET['paylater'])
	{
		
		$orderid= $_GET['paylater'];
		echo $successmsg="<p style='font-size:15px;color:green;border-bottom:1px solid #ccc;padding: 20px;text-align: center;font-weight: 600;font-size: 20px;letter-spacing: 0.04em;'>Thank You For Placing Order With DreamUniform</p>";
		
	}
	else
	{
		if($_REQUEST['response_message']=="Transaction declined")
		{
			echo $errormsg="<p style='font-size:15px;color:red;border-bottom:1px solid #ccc;padding: 20px;text-align: center;font-weight: 600;font-size: 20px;letter-spacing: 0.04em;'>Your Transaction has been Rejected and Declined</p>";
		}
		else
		{
			echo $errormsg="<p style='font-size:15px;color:red;border-bottom:1px solid #ccc;padding: 20px;text-align: center;font-weight: 600;font-size: 20px;letter-spacing: 0.04em;'>".$_REQUEST['response_message']."</p>";
			
		}
	}
	
	
	if($_REQUEST['response_message']=="Success" || $_GET['paylater'])
	{
		
		$gettemp="SELECT * FROM `tblorder` WHERE order_id='".$orderid."'";
		$Getresulttemp=mysql_query($gettemp);
		$numrow=mysql_num_rows($Getresulttemp);
		if($numrow>0)
		{
			$rowtemp=mysql_fetch_array($Getresulttemp);
			if($_SESSION['dream']['type'] == 'user'){
				$Getuser=$objUsers->GetRowContent($rowtemp['userid']);
				$userName=$Getuser['first_name'];
				$SchoolDet=$objSchool->GetRowBycode($_SESSION["dream"]["code"]);
			}
			if($_SESSION['dream']['type'] == 'school'){
				$Getuser=$objSchool->GetRowContent($rowtemp['userid']);
				$userName=$Getuser['name'];
				$mulemail=$Getuser['mul_email'];
			}
			else
			{
				$mulemail="";
			} 
			if($_SESSION['dream']['type'] == 'corporate'){
				$Getuser=$objCorporate->GetRowContent($rowtemp['userid']);
				$userName=$Getuser['name'];
			}
			$newname=$_SESSION['newname'];
			$GetOrderDet=$objOrderDetails->SelectOrder($rowtemp['id']);
			$getCntry=$objCounrty->GetRowContent($_SESSION['ship_country']);
			//------------------mail message----------------------------
			if($GetOrderDet) {
				$gtot=number_format((float)$rowtemp['total'], 2, '.', ''); 
				$ms = "<div style='margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family:Arial, Helvetica, sans-serif;font-size:12px' id='printdiv'>
				<div style='width: 650px;margin:12px auto;padding: 15px;font-size: 14px;'>
				<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>			
				<tbody>
				<tr>
				<td style='vertical-align: top;border-bottom: 2px solid #444; padding: 0;'>
				<table style='width: 100%; margin-bottom: 20px;'>
				<tbody>
				<tr>
				<td style='vertical-align: top; line-height: 1.5em;  font-size: 15px;  letter-spacing: 0.02em;'>
				<b> BILL FROM:</b><br>
				Dream Uniform<br>
				P.O.Box: 52345<br>
				Dubai <br>
				UAE    
				</td>					<td align='right'>
				<img src='http://dreamuniforms.ae/shopping/images/in-logo.png' width='260' height='83' class='CToWUd'>
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				
				</tr>
				
				<tr>
				<td height='20' align='left' valign='top'>
				</td>
				</tr>
				
				
				<tr>
				<td height='250' align='left' valign='top'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tbody>
				
				<tr>
				<td>
				<table width='100%'>
				<tbody>
				<tr>
				<td style='vertical-align: top;'>
				<b>BILL TO:</b><br>
				" . $newname . " (".$_SESSION['ship_phone'].")<br>
				" . $_SESSION['ship_address'] . "<br>
				" . $_SESSION['ship_city'] . ",<br>
				" . $_SESSION['ship_state'] . ",<br>
				" . $getCntry['name'] . "<br>
				" . $_SESSION['ship_email'] . "<br>
				
				</td>
				<td align='right' style=' vertical-align: top;'>
				<div style=' width: 200px;  text-align: left;'>Invoice #<span style='float:right'>" . $orderid . "</span></div>
				
				<div style=' width: 200px; text-align: left; margin: 2px 0;'>Invoice Date: <span style='float:right'>" . $orderdate . "</span></div>
				
				<div style=' width: 200px;  text-align:left;  background: #eee;  padding: 2px 10px; font-weight: 600;'>Amount Due: <span style='float:right'>" . $gtot . " AED</span></div>
<div style=' width: 200px; text-align: left; margin: 2px 0;'><b>Payment Terms: Cash on Delivery with Aramex </b></div>
<div> <img src='http://dreamuniforms.ae/shopping/images/Aramex new.jpg' width='100' height='50' class='CToWUd'> </div>

                               </td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>	
				
				<tr>
				<td height='50' align='left' valign='top'>
				</td>
				</tr>
				
				<tr>
				<td align='left' valign='top'>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr>
				<td width='25%' bgcolor='#dddddd' style='color:#000000;padding: 8px 10px;text-align:left'><strong>Item</strong></td>
				<td width='15%' bgcolor='#dddddd' style='color:#000000;padding: 8px 10px;text-align:right'><strong>Quantity</strong></td>
				<td width='15%' bgcolor='#dddddd' style='color:#000000;padding: 8px 10px;text-align:right'><strong>Price</strong></td>
				<td width='20%' bgcolor='#dddddd' style='color:#000000;padding: 8px 10px;text-align:left'><strong>Color</strong></td>
				<td width='10%' bgcolor='#dddddd' style='color:#000000;padding: 8px 10px;text-align:left'><strong>Size</strong></td>
				<td width='15%' bgcolor='#dddddd' style='color:#000000;padding: 8px 10px;text-align:right'><strong>Total Price</strong></td>
				</tr>";
				foreach ($GetOrderDet as $products) {
					$shptot=number_format((float)$rowtemp['ship_charge'], 2, '.', ''); 
					$ms .= "<tr>
					<td width='25%' style='border-bottom:1px solid #ccc; padding: 10px 10px; text-align:left' height='25' " . $bg . " style='padding: 10px 10px;'>" . $products['pname'] . "</td>
					<td width='15%' " . $bg . " style='padding: 10px 10px; border-bottom:1px solid #ccc; text-align:right'>" . $products['quantity'] . "</td>
					<td width='15%' " . $bg . " style='padding: 10px 10px; border-bottom:1px solid #ccc; text-align:right'>" . $products['price'] . "</td>
					<td width='20%' " . $bg . " style='padding: 10px 10px; border-bottom:1px solid #ccc;text-align:left'>" . $products['color'] . "</td>
					<td width='10%' " . $bg . " style='padding: 10px 10px; border-bottom:1px solid #ccc; text-align:left'>" . $products['size']. "</td>
					<td width='15%' " . $bg . " style='padding: 10px 10px; border-bottom:1px solid #ccc;text-align:right'>" . $products['price'] * $products['quantity'] . "</td>
					</tr>";
				}
				$ms .= "</table></td></tr>
				<tr><td height='30' align='left' valign='top' style='border-bottom: 4px solid #ddd;'></td>
				</tr>
				<tr>
				<td>
				<table width='100%' style=' float: right;  margin-top: 10px;  max-width: 250px;'>
				<tr>					<td style='background-color:#FFFFFF;border-bottom:1px solid #ccc; padding:8px 0px;'  >Shipping Charges:</td>
				<td style='background-color:#FFFFFF;border-bottom:1px solid #ccc; padding:8px 0px;' align='right'>" . $shptot . "</td>
				</tr>
				<tr>
				<td style='background-color:#FFFFFF;border-bottom:1px solid #ccc; padding:8px 0px;'><strong>Grand Total</strong></td>
				<td style='background-color:#FFFFFF;border-bottom:1px solid #ccc; padding:8px 0px;' align='right'  >" . $gtot . " AED</td>
				</tr>
				</table>
				</td>
				</tr>";
				$ms .= "<tr>
				<td height='80' align='left'>
				Regards,<br><strong style='color:#000;'>Dream Uniform LLC</strong>
				</td>
				</tr>
				<tr>
				<td height='60' align='left'>
				<strong>Remarks:-</strong>".$_SESSION['remark']."
				</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				
				<tr>
				<td height='35' align='center' bgcolor='#F0f0f0'> <strong>T</strong> : +971 4 3340494  |  <strong>E</strong> - <a href='#' style='text-decoration:none;color:#000;!important;' target='_blank'> enquiry@dreamuniforms.ae</a></td>
				</tr>
				<tr>
				<td height='40' align='center' bgcolor='#ddd' style='color:#000!important;'><strong>&copy;  2016 Dream Uniform LLC. All Rights Reserved.</strong></td>
				</tr>
				</tr>
				</tbody>
				</table>
				<div class='yj6qo'></div>
				<div class='adL'></div>
				</div>
				</div>
				</div>
				</div>
				</div>";
			}
		}
		echo $ms;
		echo '<div style="text-align:center; margin-bottom:30px;"><button onclick="PrintDiv()">Print</button></div>';
	}
	//--------------------mail msg Ends-----------------------------------
	if($_REQUEST['response_message']=="Success" || $_GET['paylater']) {
		if (!isset($_SESSION["visits"]))
        $_SESSION["visits"] = 0;
		
		$schl_name=$SchoolDet['name'];
		$mulemail=$SchoolDet['mul_email'];
		//$schoolemail=$SchoolDet['email'];
		$schoolemail=$_SESSION['ship_email'];
		
		$inv_amt=$gtot;
		$Cc="website@dreamuniforms.ae";
		
		$from="website@dreamuniforms.ae";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$to="enquiry@dreamuniforms.ae";
		// $to="developer.singhsaurabh@gmail.com";
		//  $to="cijiabrahamannie@yahoo.com";
		
		//$subject ="DreamUniform Order Details";
		$subject ="Dream Uniform Order Details,".$schoolname.",".$inv_amt.",".$schoolemail;
		
		$Bcc="yogesh@dream-hospitality.com; pankaj@dreamuniforms.ae";
		
		//Set who the message is to be sent from
		$mail->setFrom($from, 'Dreamuniforms.ae');
		
		//Set an alternative reply-to address
		$mail->addReplyTo('itinfo@Dreamuniforms.ae', 'Dreamuniforms.ae');
		
		//Set who the message is to be sent to
		$mail->addAddress($to);
		
		$mail->addCC("yogesh@dream-hospitality.com");
		$mail->addCC("website@dreamuniforms.ae");
		$mail->addBCC("schoolorders@dullc.ae");
		$mail->addBCC("pankaj@dreamuniforms.ae");
		$mail->addBCC("schoollog@dullc.ae");
		
		//Set the subject line
		$mail->Subject = $subject;
		
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		$mail->msgHTML($ms);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			//echo "Message 1 sent!";
		}
		$mail->ClearAllRecipients();
		// $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to,$Cc,$Bcc, $subject, $ms, $headers);
		// $SMTPChat = $SMTPMail->SendMail();
		
		
		
		
		//mail($to, $subject, $ms, $headers);					
		$from1="website@dreamuniforms.ae";		                          
		$headers1  = 'MIME-Version: 1.0' . "\r\n";
		$headers1 .= "Content-type: text/html; charset=utf-8\r\n";
		
		//$headers1 .="Bcc:".$mulemail."\r\n";
		//$headers1 .= "BCC: miyas.mohammed@gmail.com";
		//$headers1 .= 'Bcc: miyas.mohammed@gmail.com,lekshmisreee@gmail.com' . "\r\n";
		// $headers1 .= "Bcc: cijipixel@gmail.com";
		//$to1 = "subink.mgd@gmail.com";
		//	$to1 = $_SESSION['dream']['email'];
		// $to1 = "bbaagla@hotmail.com";
		$to1 =  strtoupper(trim($_SESSION['ship_email']));
		$t1 =  trim($_SESSION['ship_email']);
		//$to1 = "subink.mgd@gmail.com,ajithvmtvm@gmail.com";
		$subject1 = "DreamUniform Order Details";
		//$Bcc="cijipixel@gmail.com,ajithvmtvm@gmail.com";
		
		$subject1 ="Dream Uniform LLC Order Details";
		$Cc=strtoupper(trim($_SESSION['dream']['email']));
		if($to1!=$Cc){
			$Cc=trim($_SESSION['dream']['email']);
		}else{
			$Cc='';
		}
		//$Bcc=$mulemail;
		
		
		
		/*Php mailer */
		
		// date_default_timezone_set('Etc/UTC');
		
		// require '../PHPMailer-master/PHPMailerAutoload.php';
		
		//Create a new PHPMailer instance
		/*
			//Tell PHPMailer to use SMTP
			$mail11->isSMTP();
			
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail1->SMTPDebug = 2;
			
			//Ask for HTML-friendly debug output
			$mail1->Debugoutput = 'html';
			
			//Set the hostname of the mail server
			$mail1->Host = 'smtp.gmail.com';
			// use
			// $mail->Host = gethostbyname('smtp.gmail.com');
			// if your network does not support SMTP over IPv6
			
			//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$mail1->Port = 587;
			
			//Set the encryption system to use - ssl (deprecated) or tls
			$mail1->SMTPSecure = 'tls';
			
			//Whether to use SMTP authentication
			$mail1->SMTPAuth = true;
			
			//Username to use for SMTP authentication - use full email address for gmail
			$mail1->Username = "dreamuniformllc@gmail.com";
			
			//Password to use for SMTP authentication
			$mail1->Password = "veeru0005";
		/*Php mailer */
	
		$mail1 = clone $mail;
	
		
		//Set who the message is to be sent from
		$mail1->setFrom($from1, 'Dreamuniforms.ae');
		
		//Set an alternative reply-to address
		$mail1->addReplyTo('itinfo@Dreamuniforms.ae', 'Dreamuniforms.ae');
		
		//Set who the message is to be sent to
		$mail1->addAddress($t1);
		
		$mail1->addCC($Cc);
		$mail1->addBCC("website@dreamuniforms.ae");
		$mail1->addBCC("schoollog@dullc.ae");
		
		//Set the subject line
		$mail1->Subject = $subject1;
		
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
		$mail1->msgHTML($ms);
		
		// $mail1->send();
		
		if (!$mail1->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
			//echo "Message 2 sent!";
		}
		
		// $SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from1, $to1,$Cc,$Bcc, $subject1, $ms, $headers1);
		// $SMTPChat = $SMTPMail->SendMail();
		
		//echo $Bcc;
		
		//}
	}	
	//pre($_SESSION);
	include('footer_thk.php');
	$_SESSION['cart']="";
	$_SESSION['total']="";
	$_SESSION['shipcost']="";
	unset($_SESSION['cart']);
	unset($_SESSION['total']);
	unset($_SESSION['shipcost']);
	unset($_SESSION['quantity']);
	unset($_SESSION['pname']);
	unset($_SESSION['price']);
	unset($_SESSION['image']);
	unset($_SESSION['order_id']);
	
	
	
?>

<script type="text/javascript">
    function PrintDiv() {
        var divToPrint = document.getElementById('printdiv');
        var popupWin = window.open('', '_blank', 'width=900,height=700');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }
    
     $(window).load(function(){
        $('#responseModal').modal('show');
    });
</script>
<div id="responseModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">                
                <h4 class="modal-title">Thank you for placing order with Dream Uniform LLC</h4>
            </div>
            <div class="modal-body mod-response">
                <p>Please check your registered email for order confirmation</p>
            </div>
            <div class="modal-footer">
                <button id="okbtn" type="button" class="btn btn-warning" data-dismiss="modal">Okay</button>
            </div>
        </div>

    </div>
</div>