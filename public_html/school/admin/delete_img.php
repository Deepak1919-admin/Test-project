<?php 
session_start();
ob_start();
require_once '../init.php'; 
$ObjProductGallery = load_class('ProductGallery');
$res = $ObjProductGallery->DelRowContent($_POST['id']);
echo $res;
?>
