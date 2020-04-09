<?php 
error_reporting(0);
header('Content-Type: application/json');
define('DBHOST', 'localhost');
define('DBUSER', 'dreamuni_dream');
define('DBPASS', 'Hello@1985');
define('DBNAME', 'dreamuni_shopping');
/*define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'drmunifo_shopping');*/

mysql_connect(DBHOST,DBUSER,DBPASS) or die('DB connection faied');
mysql_select_db(DBNAME);

$dated = $_REQUEST['dated'];

$or ="SELECT o.id,o.invoice_id,s.name as school,o.date,o.time,o.ship_fname,o.ship_lname,o.ship_city,o.ship_address,o.ship_state,c.name as country,c.name,o.ship_phone,o.ship_email,o.ship_charge,o.total,o.vat_value as vat FROM tblorder o left join countries c on c.id=o.ship_country left join school s on o.school_id = s.id where o.date = '".$dated."'";
// echo $or;

$rs_order= mysql_query($or);

$num = mysql_num_rows($rs_order) or die(mysql_error().$or);

$orders = array();

while($order = mysql_fetch_assoc($rs_order)){
	$order_id = $order['id'];
	$order['products']=array();
	$pr = 'select quantity,pname,size,color,price from order_details where orderid='.$order_id;
	// echo $pr;
	$rs_products=mysql_query($pr) or die(mysql_error());
	$count = mysql_num_rows($rs_products);
	while($product =mysql_fetch_assoc($rs_products)){
		$order['products'][] = $product;
	}	
	$order['products']['count']= $count;
	$orders[] = $order;
}
$orders['count']= $num;	
echo json_encode($orders);
?>