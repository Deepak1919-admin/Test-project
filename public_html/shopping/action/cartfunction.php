<?php
function  add_to_cart($pid,$prid,$price,$qnt,$size,$color,$fabric,$pname,$image)
{
	$exist=0 ;
	if(count($_SESSION['cart'])>0)
	{
		foreach($_SESSION['cart'] as $prodid => $product) 
		{
			if($product['prid']==$prid)
			{
				$_SESSION['cart'][$prid]['quantity'] = $product['quantity']+$qnt;
				$exist=1;
			}
		}
	}  
 
	if(($exist==0) || sizeof($_SESSION['cart'])==0)
	{
		$_SESSION['cart'][$prid]['pid'] = $pid;
		$_SESSION['cart'][$prid]['prid'] = $prid;
		$_SESSION['cart'][$prid]['price'] = $price;
		$_SESSION['cart'][$prid]['quantity'] = $qnt;
		$_SESSION['cart'][$prid]['pname'] = $pname;
		$_SESSION['cart'][$prid]['image'] = $image;
		$_SESSION['cart'][$prid]['size'] = $size;
		$_SESSION['cart'][$prid]['color'] = $color;
		$_SESSION['cart'][$prid]['fabric'] = $fabric;
	}
	return true;
}

function print_cart() 
{
  	foreach($_SESSION['cart'] as $prodid => $product) 
  	{
		echo "<br>";
		echo "prid =".$product['prid'];	
		echo "price =".$product['price'];
		echo "quantity =".$product['quantity'];
		echo "name =".$product['pname'];
		echo "image =".$product['image'];
   }
}



function remove_from_cart($prid)
{
  foreach($_SESSION['cart'] as $prodid => $product) 
 {
    if($product['prid']==$prid) 
	 {
	   $t=$product['quantity']*$product['price']; 
       $_SESSION['total']=$_SESSION['total']-$t;
	 } 
 }
unset($_SESSION['cart'][$prid]);
}


function remove_from_cart_capacity($subid)
{
    foreach($_SESSION['cart'] as $prodid => $product)
    {
        if($product['subid']==$subid)
        {
            $t=$product['quantity']*$product['price'];
            $_SESSION['total']=$_SESSION['total']-$t;
        }
    }
    unset($_SESSION['cart'][$subid]);
}
?>
