<?php 
include('../init.php');
$objPdtPrice = load_class('ProductPrice');
$res = $objPdtPrice->DelRowContent($_POST['id']);
echo $res;
?>