<?php
require_once("../commonclass.php");
if(isset($_POST['submit'])){
	$objCorporate->setArrData($_POST);
	$res = $objCorporate->login();
	echo $res;
}
?>