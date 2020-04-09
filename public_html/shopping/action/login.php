<?php
require_once("../commonclass.php");
if(isset($_POST['submit'])){
	/*$objUsers->setArrData($_POST);
	$res = $objUsers->login(); */

        $objSchool->setArrData($_POST);
	$res = $objSchool->direct_login();
	echo $res;
}
?>