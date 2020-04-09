<?php 
include('../init.php');
$objPdtPrice = load_class('ProductPrice');
$objPdtPrice->setArrData($_POST);
$respdt = $objPdtPrice->update();
echo $respdt;
?>