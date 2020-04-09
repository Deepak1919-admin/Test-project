<?php
require_once("../commonclass.php");
$price_data = $objPdtPrice->priceOnCol($_POST['c_id'],$_POST['pid'],$_POST['sid'],$_POST['fid']);
$array = array(
    "price_id" => $price_data[0]['id'],
    "price"  => $price_data[0]['price'],
);
print json_encode($array);
?>