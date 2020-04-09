<?php
include('../init.php');
$ObjProduct= load_class('Product');

$objOrder = load_class('Order');
$objOrderDetails=load_class('OrderDetails');
if($_POST['t_date']!="" && $_POST['f_date']!="")
{
$tdate=date("d/m/Y",strtotime($_POST['t_date']));
$fdate=date("d/m/Y",strtotime($_POST['f_date']));


$getDet=$objOrderDetails->GetSoldPdtGroupBy($tdate,$fdate);
if($getDet){
for($k=0;$k<count($getDet);$k++){ 
$getPdtName=$ObjProduct->GetRowContent($getDet[$k]['pid']);
?>
<tr>
<td><?php echo $getPdtName['title'] ;?>
<td><?php echo  $getDet[$k]['sum'];?>  </td>
</tr>
<?php }} }else{
$getDet=$objOrderDetails->GetSoldPdtGroupByonly();
if($getDet){
for($k=0;$k<count($getDet);$k++){ 
$getPdtName=$ObjProduct->GetRowContent($getDet[$k]['pid']);
?>
<tr>
<td><?php echo $getPdtName['title'] ;?>
<td><?php echo  $getDet[$k]['sum'];?>  </td>
</tr>
<?php }} }?>