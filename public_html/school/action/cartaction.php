<?php 
session_start();
include("cartfunction.php");
require_once("../commonclass.php");
//include('../init.php');
if(isset($_POST['checkout']))
{
	header("Location:../checkout.php");
}
if(isset($_POST['cart'])){
	$siz_dt = $objSize->GetRowContent($_POST['size_id']);
	$fab_dt = $objFabric->GetRowContent($_POST['fabric_id']);
	$cor_dt = $objColor->GetRowContent($_POST['color_id']);
	
	$qnt = $_POST['quantity'];
	$pid = $_POST['pid'];
	$prid = $_POST['p_id'];
	$price = $_POST['price'];
	$pname = $_POST['pname'];
	$image = $_POST['image'];
	$size = $siz_dt['title'];
	$color = $cor_dt['title'];
	$fabric = $cor_dt['title'];
	
	add_to_cart($pid,$prid,$price,$qnt,$size,$color,$fabric,$pname,$image);
	header('location:../cart.php');
}


if(isset($_POST['updatecart_x']))
{
	$idarray=$_POST['idarray'];
	if(!empty($idarray)) 
	{
		$idarray=explode(",", $idarray);
	
		foreach($idarray as $IDVal)
		{ 
			if($_POST['quantity'.$IDVal]==0) 
			{ 
				remove_from_cart($IDVal);
			}
			else
			{ 
				$_SESSION['cart'][$IDVal]['quantity']=$_POST['quantity'.$IDVal];
			}
		}
		header('location:../cart.php');
	}
}


if(isset($_GET['prid']))
{
	$prid=$_GET['prid'];
  	remove_from_cart($prid);
	header("Location:../cart.php");
}


if(isset($_POST['clearcart_x']))
{
	unset($_SESSION['cart']);
	$_SESSION['cart']="";
	$_SESSION['cart']=null;
	unset($_SESSION['total']);
	$_SESSION['total']="";
	unset($_SESSION['gtotal']);
	$_SESSION['gtotal']="";
	header('location:../cart.php');
}