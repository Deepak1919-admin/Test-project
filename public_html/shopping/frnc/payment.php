<?php
session_start();
ob_start();
include '../commonclass.php';

$userdetails=$objUsers->GetRowContent($_SESSION['dream']['user_id']);


if($_SESSION['dream']['user_id']=="" || empty($_SESSION['dream'])) {
    header('location:logout.php');
}
// $uniqueId = time().'-'.mt_rand();
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//$uniqueId=generateRandomString(13);
$getoid=$objOrder->generateorderid();
if($getoid!="")
{
    $uniqueId=$getoid['order_id']+1;
}
else
{
    $uniqueId="1600";
}



if(isset($_REQUEST['paynow'])) {
    $b = trim($_POST['address']);
    if (strlen($b) < 10) {
        $_SESSION['msg'] = '<span style="color:red">Please Enter Address More Than 10 Character</span>';
        header('Location:checkout.php');
    }
	else
	{

		if($userdetails['address']=="")
		{
			$address="address";
		}
		else
		{
			$address=$userdetails['address'];
		}
		$name=$userdetails['fname'];
		if($userdetails['city']=="")
		{
			$city="city";
		}
		else{
			$city=$userdetails['city'];
		}
		$state=$userdetails['state'];
		$country="AE";
		$phone=$userdetails['phone'];
		$email=$userdetails['email'];
		$dat=date("Y-m-d H:i:s");
		$invoice_amount=$_SESSION['total'];
    
		$_POST['ship_lname']=$_POST['lname'];
		$_POST['ship_fname']=$_POST['fname'];
		$_POST['ship_address']=$_POST['address'];
		$_POST['ship_email']=$_POST['email'];
		$_POST['ship_city']=$_POST['city'];
		$_POST['ship_state']=$_POST['state'];
		$_POST['ship_country']=$_POST['country'];
		$_POST['ship_phone']=$_REQUEST['phone'];
		$_POST['ship_charge']=$_SESSION['shipcost'];
		$_POST['total']=$_SESSION['total'];
                $_SESSION['ship_address']=$_POST['ship_address'];
                $_SESSION['ship_city']=$_POST['ship_city'];
                $_SESSION['ship_state'] = $_POST['ship_state'];
                $_SESSION['ship_email'] = $_POST['email'];
                $_SESSION['ship_country'] = $_POST['ship_country'];
                $_SESSION['ship_phone'] = $_POST['ship_phone'];
                $_SESSION['remark'] = $_POST['remark'];

		$_POST['order_id']=$uniqueId;
		$_POST['userid']=$_SESSION['dream']['user_id'];
		$_SESSION['order_id']=$uniqueId;
		$date = date("d/m/Y");
		$time = date("h:i:s");
		$_POST['date']=$date;
		$_POST['time']=$time;


		$objOrder->setArrData($_POST);
		$res = $objOrder->insert();
		foreach ($_SESSION['cart'] as $prodid => $products) {

			$later=array();
			$later['orderid'] = $objOrder->maxid();
			$later['prid'] = $products['prid'];
			$later['pid'] = $products['pid'];
			$later['price'] = $products['price'];
			$later['quantity'] = $products['quantity'];
			$later['pname'] = $products['pname'];
			$later['image'] = $products['image'];
			$later['size'] = $products['size'];
			$later['color'] = $products['color'];

			$objOrderDetails->setArrData($later);
			$res = $objOrderDetails->insert();

		}   

		$EMAIL=$_POST['email'];
		$amount_total=$invoice_amount*100;
		$ORDERID=$uniqueId;
		$d='http://a2itsolutions.com/alex_new/thankyou.php';
		$e='http://a2itsolutions.com/alex_new/cart.php';
		$link="vgIUVbVFFBFwbaccess_code=tOUyK5El9MChhs7sqH3Tamount=".$amount_total."command=AUTHORIZATIONcurrency=AEDcustomer_email=".$EMAIL."language=enmerchant_identifier=dQecaANLmerchant_reference=".$ORDERID."order_description=itemreturn_url=".$d."vgIUVbVFFBFwb";
		$signt=hash('sha1', $link); 
		$requestParams = array(
			'access_code' => 'tOUyK5El9MChhs7sqH3T',
			'amount' => $amount_total,
			'currency' => 'AED',
			'customer_email' => $EMAIL,
			'merchant_reference' => $ORDERID,
			'order_description' => 'item',
			'language' => 'en',
			'merchant_identifier' => 'dQecaANL',
			'return_url'=>$d,
			'signature' => $signt,
			'command' => 'AUTHORIZATION',
		);

   
		$redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';

		echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
		echo "<form action='$redirectUrl' method='post' name='frm'>\n";

		foreach ($requestParams as $a => $b) {
			echo "\t<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>\n";
		}

		echo "\t<script type='text/javascript'>\n";
		echo "\t\tdocument.frm.submit();\n";
		echo "\t</script>\n";
		echo "</form>\n</body>\n</html>";
	}
}

if(isset($_REQUEST['paylater']))
{
    $b=trim($_POST['address']);
    if (strlen($b) < 1) {
        $_SESSION['msg'] = '<span style="color:red">Please Enter Address </span>';
        header('Location:checkout.php');
    }
    else
    {
		$_POST['ship_lname'] = $_POST['lname'];
		$_POST['ship_fname'] = $_POST['fname'];
		$_POST['ship_address'] = $_POST['address'];
		$_POST['ship_email'] = $_POST['email'];
		$_POST['ship_city'] = $_POST['city'];
		$_POST['ship_state'] = $_POST['state'];
		$_POST['ship_country'] = $_POST['country'];
		$_POST['remark'] = $_POST['remark'];
		$_POST['ship_phone'] = $_REQUEST['phone'];
		$_POST['ship_charge'] = $_SESSION['shipcost'];
		$_POST['total'] = $_SESSION['total'];
		$_POST['order_id'] = $uniqueId;
		$_POST['userid'] = $_SESSION['dream']['user_id'];
		$_POST['user_type'] = $_SESSION['dream']['type'];
		$_SESSION['order_id'] = $uniqueId;
		$_SESSION['newname']=$_POST['fname'];
		$_SESSION['ship_address']=$_POST['ship_address'];
                $_SESSION['ship_city']=$_POST['ship_city'];
                $_SESSION['ship_state'] = $_POST['ship_state'];
                $_SESSION['ship_email'] = $_POST['email'];
                $_SESSION['ship_country'] = $_POST['ship_country'];
                $_SESSION['ship_phone'] = $_POST['ship_phone'];
                $_SESSION['remark'] = $_POST['remark'];
		$date = date("d/m/Y");
		$time = date("h:i:s");
		$_POST['date'] = $date;
		$_POST['time'] = $time;
		$st = "Pay Later";
		$_POST['status']=	$st;
		$objOrder->setArrData($_POST);
		$res = $objOrder->insert();

//    ----------------update order details------------------
		foreach ($_SESSION['cart'] as $prodid => $products) {
          if($products['price']!=null) {
			$later=array();
			$later['orderid'] = $objOrder->maxid();
			$later['pid'] = $products['pid'];
			$later['prid'] = $products['prid'];
			$later['price'] = $products['price'];
			$later['quantity'] = $products['quantity'];
			$later['pname'] = $products['pname'];
			$later['image'] = $products['image'];
			$later['size'] = $products['size'];
			$later['color'] = $products['color'];

			$getStk=$objPdtPrice->GetRowContent($later['prid']);
			$oldstk=$getStk['stock'];
			$newstk=$oldstk-$products['quantity'];
			$sqlstk = "update product_price set stock=$newstk where id=".$products['prid'];
			$restk = mysql_query($sqlstk);
			$objOrderDetails->setArrData($later);
			$res = $objOrderDetails->insert();

		} }
		header('location:thankyou.php?paylater='.$uniqueId);
	}
}
?>
<script>
    $( document ).ready(function() {
        if($('#sha').val()!=""){
            $( "#form1" ).submit();
        }
    });
</script>