<?php
require_once("../commonclass.php");
$price_data = $objPdtPrice->priceOnsize($_POST['pid'],$_POST['sid']);
$array = array(
    "price_id" => $price_data[0]['id'],
    "price"  => $price_data[0]['price'],
);
print json_encode($array);
?>