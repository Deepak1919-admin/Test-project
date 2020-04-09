<?php
include('../init.php');
$objUser = load_class('User');
$rsl = $objUser->GetRowContentByUn($_POST['username']);
if($rsl){
	echo false;
}
?>