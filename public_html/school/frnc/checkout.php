<?php
include('header_inner.php');
if($_SESSION['dream']['user_id']=="" || empty($_SESSION['dream'])) {
    header('location:logout.php');
}
include("banner.php");

$userid=$_SESSION['dream']['user_id'];

if(empty($_SESSION['cart']))
{
    header('Location:cart.php?fail=fail');
}

if($_SESSION['dream']['type'] == 'user'){
	$row=$objUsers->GetRowContent($userid);
	$fname=$row['first_name'];
}
if($_SESSION['dream']['type'] == 'school'){
	$row=$objSchool->GetRowContent($userid);
	$fname=$row['name'];
}
if($_SESSION['dream']['type'] == 'corporate'){
	$row=$objCorporate->GetRowContent($userid);
	$fname=$row['name'];
}
$lname=$row['lname'];
$email=$row['email'];
$phone=$row['phone'];
$city=$row['city'];
$state=$row['state'];
$countrycode=$row['country'];
$zip='';
$address=$row['address'];
?>
<div class="container">
<div class="clearfix">
    <div>
        <div class="product-inner">
            <div class="content">
                <!-- <div class="breadcrumb"><a href="#">Home</a> / <a href="#">Perfume Category</a> / <span>Current Page</span></div> -->
                <div class="list-title">Adresse de livraison</div>
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<form name="userform" method="post" action="payment.php" id="checkout">
                        <div class="checkout-form row">
                            <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg'];  unset($_SESSION['msg']); }?>
                            <div class="check-ip col-xs-6">
                                <label>Prénom</label>
                                <input type="text" name="fname" class="form-control" required="" value="<?php echo $fname;  ?>">
                            </div>
                            <div class="check-ip col-xs-6">
                                <label>Nom de famille</label>
                                <input type="text" name="lname" class="form-control" required="" value="<?php echo $lname?>">
                            </div>
                            <div class="check-ip col-xs-6">
                                <label>Email Id</label>
                                <input type="email" name="email" class="form-control" required="" value="<?php echo $email;?>">
                            </div>
                            <div class="check-ip col-xs-6">
                                <label>Numéro de contact</label>
                                <input type="text" name="phone" class="form-control" required="" value="<?php echo $phone;?>">
                            </div>
                            <div class="check-ip col-xs-6">
                                <label>Ville</label>
                                <input type="text" name="city" class="form-control" required="" value="<?php echo $city;?>">
                            </div>
                            <div class="check-ip col-xs-6">
                                <label>Etat</label>
                                <input type="text" name="state" class="form-control" required value="<?php echo $state;?>">
                            </div>
                            <div class="check-ip col-xs-6">
                                <label>Pays</label>
                                <Select class="form-control"  name="country" required >
							<?php 
								if (!empty($getAllCountry)) {
									for ($i = 0; $i < count($getAllCountry); $i++){
									    if($getAllCountry[$i]['id']=='234')
									    {
										$select="selected";
									    }else
									    {
										$select="";
									    }
							?>
								<option  value="<?php echo $getAllCountry[$i]['id'] ?>" <?php echo $select;?>><?php echo $getAllCountry[$i]['name'] ?></option>
							<?php 
									} 
								} 
							?>

                               </Select>
                            </div>
                               <div class="check-ip col-xs-6">
									<label>Remarque</label>
									<!--<input type="text" name="pin" class="form-control" required="" value="<?php echo $zip; ?>">-->
									<textarea name="remark" class="form-control"></textarea>
									</div>
                            <div class="check-ip col-xs-6">
                                <label>Adresse</label>
                                <textarea  rows="1" name="address" class="form-control" required="" minlength="10" style="margin: 0px 0px 20px;height: 34px;"><?php echo $address; ?></textarea>
                            </div>
                            <div class="check-ip col-xs-6">
				<div class="plc-or">
                                <input type="submit" name="paylater" class="cont-ship" value="Passer la commande" />
                                <!--<input type="submit" name="paylater" class="cont-ship" value="Pay Later" />-->
				</div>
                            </div>
                        </div>
                    </form>
                </table>
        </div>
    </div>
</div>
<br><br>
</div>
</div>
</div>
</div>
<?php include('footer_inner.php');?>