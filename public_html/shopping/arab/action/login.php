<?php
require_once("../../commonclass.php");
if(isset($_POST['submit'])){
	$objUsers->setArrData($_POST);
	$res = $objUsers->login();
	echo $res;
}
?>