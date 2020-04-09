<?php
//include('header_thk.php');
include('header_inner.php');
include("banner.php");
session_start();
ob_start();

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
    echo $successmsg="<p style='font-size:15px;color:red; border:1px solid #ccc;padding:10px;'>Thank You For Placing Order With DreamUniform</p>";

}
else
{
if($_REQUEST['response_message']=="Transaction declined")
{
echo $errormsg="<p style='font-size:15px;color:red; border:1px solid #ccc;padding:10px;'>Your Transaction has been Rejected and Declined</p>";
}
else
{
echo $errormsg="<p style='font-size:15px;color:red; border:1px solid #ccc;padding:10px;'>".$_REQUEST['response_message']."</p>";

}
}


if($_REQUEST['response_message']=="Success" || $_GET['paylater']){

	$gettemp="SELECT * FROM `tblorder` WHERE order_id='".$orderid."'";
	$Getresulttemp=mysql_query($gettemp);
	$numrow=mysql_num_rows($Getresulttemp);
	if($numrow>0)
	{
		$rowtemp=mysql_fetch_array($Getresulttemp);
		if($_SESSION['dream']['type'] == 'user'){
			$Getuser=$objUsers->GetRowContent($rowtemp['userid']);
			$userName=$Getuser['first_name'];
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
		$GetOrderDet=$objOrderDetails->SelectOrder($rowtemp['id']);
	//------------------mail message----------------------------
		if($GetOrderDet) {
			$ms = "<div style='margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family:Arial, Helvetica, sans-serif;font-size:12px;!important;' id='printdiv'>
			<div style='border:1px solid #ccc;width:624px;margin:12px auto;padding:12px;!important;'>
			<table width='100%' border='0' align='center' cellpadding='5' cellspacing='0'>
			<style></style>
			<tbody>
				<tr>
					<td align='left' style='border-bottom:1px solid #ccc;!important;'>
						<img src='http://a2itsolutions.com/dreamuniform/images/in-logo.png' width='260' height='83' class='CToWUd'>
					</td>
				</tr>
				<tr>
					<td height='250' align='left' valign='top'>
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tbody>
						<tr>
							<td height='35' align='left'><h2 style='color:rgb(107, 2, 51);margin:0 0;!important;'>DreamUniform Order Details</h2></td>
						</tr>
						<tr>
							<td height='34' align='left'><h3><strong>Hi " . $userName . "</strong></h3></td>
						</tr>
						<tr>
							<td height='80' align='left' valign='top'>
							</td>
						</tr>
						<tr>
							<td height='60' align='left' valign='top'>
							<table width='590' border='0' cellspacing='0' cellpadding='5'>
								<tr>
									<td width='30%' height='25' bgcolor='#DB1C5D' style='color:#FFFFFF; padding:5px;'><strong>Item</strong></td>
									<td  align='center' bgcolor='#DB1C5D' style='color:#FFFFFF; padding:5px;'><strong>Quantity</strong></td>
									<td  align='center' bgcolor='#DB1C5D' style='color:#FFFFFF; padding:5px;'><strong>Price</strong></td>
									<td width='13%' align='center' bgcolor='#DB1C5D' style='color:#FFFFFF; padding:5px;'><strong>Color</strong></td>
									<td width='13%' align='center' bgcolor='#DB1C5D' style='color:#FFFFFF; padding:5px;'><strong>Size</strong></td>
									<td width='13%' align='center' bgcolor='#DB1C5D' style='color:#FFFFFF; padding:5px;'><strong>Total Price</strong></td>
								</tr>";
		foreach ($GetOrderDet as $products) {
			$GetSize=$objSize->GetRowContent($products['size']);
			$ms .= "<tr>
					   <td style='border-bottom:1px solid #ccc' height='25' " . $bg . " style='padding:5px;'>" . $products['pname'] . "</td>
					   <td align='center' " . $bg . " style='padding:5px; border-bottom:1px solid #ccc'>" . $products['quantity'] . "</td>
									   <td align='center' " . $bg . " style='padding:5px; border-bottom:1px solid #ccc'>" . $products['price'] . "</td>
					   <td align='center' " . $bg . " style='padding:5px; border-bottom:1px solid #ccc'>" . $products['color'] . "</td>
					   <td align='center' " . $bg . " style='padding:5px; border-bottom:1px solid #ccc'>" . $GetSize['title'] . "</td>
					   <td align='center' " . $bg . " style='padding:5px; border-bottom:1px solid #ccc'>" . $products['price'] * $products['quantity'] . "</td>
					   </tr>";
		}
		$ms .= "<tr>
					<td style='background-color:#FFFFFF; color:#DB1C5D;border-bottom:1px solid #ccc'  >Shipping Charge</td>
					<td style='background-color:#FFFFFF; color:#DB1C5D;border-bottom:1px solid #ccc' align='center' >&nbsp;</td>
					<td style='background-color:#FFFFFF; color:#DB1C5D;border-bottom:1px solid #ccc' align='center' >&nbsp;</td>
					<td style='background-color:#FFFFFF; color:#DB1C5D;border-bottom:1px solid #ccc' align='center' >&nbsp;</td>
					<td style='background-color:#FFFFFF; color:#DB1C5D;border-bottom:1px solid #ccc' align='center' >&nbsp;</td>
					<td style='background-color:#FFFFFF; color:#DB1C5D;border-bottom:1px solid #ccc' align='center'>" . $rowtemp['ship_charge'] . "</td>
				</tr>
				<tr>
					<td ><strong>Grand Total</strong></td>
					<td align='center' >&nbsp;</td>
					<td align='center' >&nbsp;</td>
					<td align='center' >&nbsp;</td>
					<td align='center' >&nbsp;</td>
					<td align='center'  >" . $rowtemp['total'] . "</td>
				</tr>";
		$ms .= "</table>
					</td>
						</tr>
						<tr>
							<td height='120' align='left'>
								Regards,<br><strong style='color:#DB1C5D;'>DreamUniform</strong></td>
						</tr>
					</tbody>
				</table>
			</td></tr>
			<tr>
				<td height='30' align='center' bgcolor='#F4F4F4'> <strong>T</strong> : +971 4 3340494  |  <strong>E</strong> - <a href='#' style='text-decoration:none;color:#DB1C5D;!important;' target='_blank'>info@dreamuniform.com</a></td>
			</tr>
			<tr>
				<td height='30' align='center' bgcolor='#DB1C5D' style='color:#ffffff;!important;'><strong>&copy; 2016 DreamUniform. All Rights Reserved.</strong></td>
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
	echo '<div style="text-align:center;"><button onclick="PrintDiv()">Print</button></div>';
}
//--------------------mail msg Ends-----------------------------------
if($_REQUEST['response_message']=="Success" || $_GET['paylater']) {
	if (!isset($_SESSION["visits"]))
        $_SESSION["visits"] = 0;
	
	echo $_SESSION["visits"] = $_SESSION["visits"] + 1;
	if ($_SESSION["visits"] == 1)
	{
		$by="DreamUniform";
		$from=$_SESSION['email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: =?UTF-8?B?". base64_encode($by)."?= <".$from.">\r\n";
		$to=$AllEmail['to_email_address'];
		$subject ="Instant Payment Notification - Recieved Payment";
		mail($to, $subject, $ms, $headers);					
		$from1=$AllEmail['to_email_address'];			                          
		$headers1  = 'MIME-Version: 1.0' . "\r\n";
		$headers1 .= "Content-type: text/html; charset=utf-8\r\n";
		$headers1 .= "From: =?UTF-8?B?". base64_encode($by)."?= <".$from1.">\r\n";
		$headers1 .="Bcc:".$mulemail."\r\n" .
		$to1 = $_SESSION['email']; 
		$subject1 = "DreamUniform Order Details";
		mail($to1 ,$subject1 ,$ms,$headers1);
	}
}	
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
</script>