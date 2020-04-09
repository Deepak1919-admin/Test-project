<?php 
session_start();
error_reporting(0);
include("cartfunction.php");

if(isset($_POST['cart']))
{
 $qnt=$_POST['quantity'];
 $prid=$_POST['pid'];
 $price=$_POST['price'];
 $pname=$_POST['pname'];
 $image=$_POST['image'];

$shipping_charge=$_POST['shipping_charge'];
 for($i=0;$i<count($prid);$i++)
 	 {
		 $pid=$prid[$i];
		 $quantity=$qnt[$i];
		 $price=$price[$i];
		 $pname=$pname[$i];
		 $image=$image[$i];
		 $shipping_charge=$shipping_charge[$i];
		
		 add_to_cart($galid,$pid,$price,$quantity,$pname,$image,$size,$color,$shipping_charge);

	 }
	 //print_r($_SESSION['cart']);exit;
 //header('location:../mycart.php?cpid='.$_POST['pid'][0]);
 $id_ret=$_POST["pid"][0];
 header('location:../cart.php?id='.$id_ret.'&succ=succ');
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



if(isset($_GET['pid']))
{
	$pid=$_GET['pid'];
  	remove_from_cart($pid);
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