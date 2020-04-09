<?php
require_once("../../commonclass.php");
pre($_POST);
$fabric_data = $objPdtPrice->fabricOnCol($_POST['c_id'],$_POST['pid'],$_POST['sid']);
echo '<option value="">Select Fabric</option>';
for($i=0;$i<count($fabric_data);$i++){
	$Fabric = $objFabric->GetRowContent($fabric_data[$i]['fabric_id']);
	echo '<option value="'.$Fabric['id'].'">'.$Fabric['title'].'</option>';
}
?>