<?php
require_once("../../commonclass.php");
pre($_POST);
$size_data = $objPdtPrice->sizeOnCol($_POST['c_id'],$_POST['pid']);
echo '<option value="">Select Size</option>';
for($i=0;$i<count($size_data);$i++){
	$size = $objSize->GetRowContent($size_data[$i]['size_id']);
	echo '<option value="'.$size['id'].'">'.$size['title'].'</option>';
}
?>