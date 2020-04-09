<?php 
session_start();
ob_start();
require_once '../init.php'; 
$objSchoolGal = load_class('SchoolGal');
$res = $objSchoolGal->DelRowContent($_POST['id']);
echo $res;
?>
