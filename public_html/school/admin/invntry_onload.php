<?php
include('../init.php');
$ObjProduct= load_class('Product');

$objOrder = load_class('Order');
$objOrderDetails=load_class('OrderDetails');

$getDet=$objOrderDetails->GetSoldPdtGroupByonly();
if($getDet){
for($k=0;$k<count($getDet);$k++){ 
$getPdtName=$ObjProduct->GetRowContent($getDet[$k]['pid']);
?>
<tr>
<td><?php echo $getPdtName['title'] ;?>
<td><?php echo  $getDet[$k]['sum'];?>  </td>
</tr>
<?php }} ?>