<?php 
include('header_inner.php');
$objShippingCost=load_class('ShippingCost');
$getShipping=$objShippingCost->SelectAll();
if($_SESSION['dream']['user_id']=="" || empty($_SESSION['dream'])) {
    header('location:logout.php');
}
include("banner.php");
?>
<div class="container">
    <div class="cart-page">
	<div class="product-inner">
	    <div class="content">
		<div class="list-title">سلتي</div>
		<form name="cartform" method="post" action="action/cartaction.php">
		    <table class="table cart-box">
			<thead class="cart-titles">
			    <tr>
				<td class="cart-col">المنتج</td>
				<td class="cart-col">إزالة</td>
				<td class="cart-col">كمية</td>
				<td class="cart-col">معدل</td>
				<td class="cart-col">مجموع</td>
			    </tr>
			</thead>
			<?php
			
			if(empty($_SESSION['cart']))
			{
			    $_SESSION['total']=0; $_SESSION['shipcost']=0;
			}
			if(isset($_SESSION['cart']))
			{
			    $counts=0;$qn=0;
			    foreach($_SESSION['cart'] as $prodid => $products)
			    {
				if($products['quantity']!=0)
				{
				    $counts=$counts+$products['quantity'];
				}
			    }
			}
			$nitm=$counts;
			if($nitm!=0)
			{
			    $_SESSION['total']=0;$sumtot=0;$total=0;
			    foreach($_SESSION['cart'] as $prodid => $products)
			    {
				if($products != null)
				{
				    $ids[]=$products['prid'];
				    $pdts[]=$products['pname'];
				    $qts[]=$products['quantity'];
				    $price[]=$products['price'];
				    $image[]=$products['image'];
				    $size[]=$products['size'];
				    $color[]=$products['color']; ?>
				    <tr class="cart-details">
					<td class="cart-col">
					    <table>
						<tr>
						    <td><img src="../multimedia/product/<?php echo $products['image'];?>" alt="" /></td>
						    <td>
							<?php echo $products['pname'];?>
							<p><!--Color:<?php echo $products['color'];?><br>-->
							حجم:<?php echo $products['size'];?><br>
						    </td>
						</tr>
					    </table>
					</td>
					<td class="cart-col">
					    <a href="action/cartaction.php?prid=<?php echo $products['prid'];?>" onclick="return confirm('هل أنت متأكد أنك تريد إزالة هذا البند؟');">
					    <i class="fa fa-trash fa-1x"></i>
					    </a>
					</td>
					<td class="cart-col">
					    <input type="text" class="ip-qty" value="<?php echo $products['quantity'];?>" disabled="true" />
					</td>
					<td class="cart-col"><?php echo $products['price'];?> AED</td>
					<td class="cart-col"><?php echo $total=$products['price']* $products['quantity'];?> AED</td>
				    </tr>
				    <?php
				    $qn=$qn+$products['quantity'];
				    $_SESSION['quantity']=$qn;
				    $idarray= implode(",", $ids);
				    $parray= implode(",", $pdts);
				    $_SESSION['pname']=$parray;
				    $qarray= implode(",", $qts);
				    $_SESSION['quantity']=$qarray;
				    $prarray= implode(",", $price);
				    $_SESSION['price']=$prarray;
				    $prarray= implode(",", $image);
				    $_SESSION['image']=$prarray;
				}
				$sumtot=$sumtot+$total;
				$_SESSION['total']=number_format((float)$sumtot, 2, '.', '');
			    }
			}
		    ?>
		    <input type="hidden" name="idarray" value="<?php echo $idarray;?>">
		    <!------------------------Shipping Charge------------------->
		    <?php
		    $total=$_SESSION['total'];
		    $shippingprice=0;
		    $_SESSION['shipcost']=0;
		    if($getShipping!="")
		    {
			foreach($getShipping as $shipping)
			{
			    $from_range=$shipping['range_from'];
			    $to_range=$shipping['range_to'];
			    if(round($_SESSION['total']) > $from_range && round($_SESSION['total']) < $to_range)
			    {
				$shippingprice=$shipping['price'];
				$_SESSION['shipcost']=$shipping['price'];
				$_SESSION['total']=$_SESSION['total']+$shipping['price'];
			    }
			}
		    }
		?>
		<!------------------------Shipping Charge Ends------------------->
		    </table>
		    <div class="cart-total">
			<div class="ct-inner">
			    <div class="ct-sub">حاصل الجمع:<?php echo $total?> AED </div>
			    <div class="ct-ship">الشحن الشحن: <?php echo $_SESSION['shipcost'];?> AED </div>
			    <div class="ct-total">مجموع: <?php echo $_SESSION['total'];?> AED </div>
			</div>
		    </div>
		    <div class="cart-bottom clearfix hh">
			<div class="go-check col-xs-6 col-sm-push-6">
			    <a href="javascript:void(0)"<?php if($_SESSION['dream']['user_id']!=""){ ?> onclick="checkout();" <?php }else{  ?> onclick="checklogin();" <?php } ?>>باشرالخروج من الفندق</a>
			</div>
			<div class="cont-ship col-xs-6 col-sm-pull-6"><a href="list.php">متابعة التسوق</a></div>
		    </div>
		</form>
	    </div>
	</div>
    </div>
</div>
</div>
<?php
include('footer_inner.php');
?>
<script>
    function checkout()
    {
        $('.hh').html('<input type="hidden" name="checkout">');
        document.forms.cartform.submit();
    }
    function checklogin()
    {
        $('#login-modal').modal('show');
    }
</script>