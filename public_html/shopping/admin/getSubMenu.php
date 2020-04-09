<?php 
include('../init.php');
$string=$_GET["parent_id"];

$sql="SELECT * FROM menu WHERE parent_id = '".$string."'";
$result = mysql_query($sql);
$myarray=array();
$str='<select name="menu_id" id="menu_id" class="form-control">';
while($result_category=mysql_fetch_array($result))
{
$str=$str . '<option value="'.$result_category['id'].'">'.$result_category['title'].'</option>';
}
$str=$str .'</select>';
echo $str;/*Stop hiding from IE Mac */
?>