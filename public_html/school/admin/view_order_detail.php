<?php
ob_start();
//$page='view_menu';
include 'header.php';
$objOrder = load_class('Order');
$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$id=$_REQUEST['id'];

$objProduct = load_class('Product');

$objCorporate = load_class('Corporate');
$objSchool = load_class('School');
$objUsers = load_class('Users');

$objProductGallery = load_class('ProductGallery');
$objColor = load_class('Color');
$objAdmin = load_class('Admin');
$objOrderDetails=load_class('OrderDetails');
$objSize=load_class('Size');
$objCountry=load_class('Country');




if(isset($_POST['submit']))
{
  //pre($_POST);
  //exit;
$objOrder->setArrData($_POST);

        $res = $objOrder->update();

        if ($res==1) {

            $msg = "<div class='alert alert-success'>

                        <button data-dismiss='alert' class='close' type='button'>x</button>

                        <strong>Well done!</strong>Saved successfully.

                    </div>";

            $log = "1";

        } else {

            $msg = "<div class='alert alert-error'>

                        <button data-dismiss='alert' class='close' type='button'>x</button>

                        <strong>Oh snap!</strong>Not Saved.

                    </div>";

            $log = "1";

        }
}
$GetOrder=$objOrder->GetRowContent($id);
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<!-- content starts -->
<div class="page-content">
    <!-- begin PAGE TITLE ROW -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>View Product

                </h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active"><a href="view_orders.php">All Orders</a></li>
                    <li class="active"><a href="<?php echo currenturl() ?>">View Order Details</a></li>
                </ol>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- end PAGE TITLE ROW -->
    
  <form method="post">
    <?php
    echo $msg;
    ?>
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <table class="table table-striped table-bordered ">
		<thead>
			<tr>
				<td>User</td>
				<td>
					<?php 
						if($GetOrder['user_type'] == "school"){
							$user = $objSchool->GetRowContent($GetOrder['userid']);
							$userName = $user['name'];
						}
						if($GetOrder['user_type'] == "corporate"){
							$user = $objCorporate->GetRowContent($GetOrder['userid']);
							$userName = $user['name'];
						}
						if($GetOrder['user_type'] == "user"){
							$user = $objUsers->GetRowContent($GetOrder['userid']);
							$userName = $user['first_name'];
						}echo  $userName; 
					?>
				</td>
			</tr>
			<tr>
				<td>Product</td>
				<td>
					<table>
						<tr>
							<td>Name &nbsp;</td>
							<td>Price &nbsp;</td>
							<td>Quantity &nbsp;</td>
							<td>Size &nbsp;</td>
							<td>Color &nbsp;</td>
							<td>Image &nbsp;</td>
						</tr>
		<?php $Det=$objOrderDetails->SelectOrderDetails($id);
				for($i=0;$i<count($Det);$i++){
					$GetSize=$objSize->GetRowContent($Det[$i]['size']);?>
                <tr>


		            <td><?php echo $Det[$i]['pname'];?> &nbsp;&nbsp;</td>
                    <td><?php echo $Det[$i]['price'];?> &nbsp;&nbsp;</td>
                    <td><?php echo $Det[$i]['quantity'];?> &nbsp;&nbsp;</td>
		            <td><?php echo $Det[$i]['size'];?> &nbsp;&nbsp;</td>
                    <td><?php echo $Det[$i]['color'];?> &nbsp;&nbsp;</td>
                    <td>  <img src="../multimedia/product/<?php echo $Det[$i]['image']; ?>" width="70" height="53" ></td>
		        </tr>
				 <?php } ?>
			 </table>		  
					 </td>
                    </tr>
		   <tr>
                      <td>Total</td>
                      <td><?php echo $GetOrder['total'];?></td>
                    </tr>
					
                      <tr>
                      <td>Shipping First Name</td>
                      <td>
					  <?php echo $GetOrder['ship_fname'];?>
					</td>
					</tr>
                     <tr>
                      <td>Shippinging Last Name</td>
                      <td><?php echo $GetOrder['ship_lname'];?></td>
                    </tr>
					 <tr>
                      <td>Shipping Address</td>
                      <td><?php echo $GetOrder['ship_address'];?></td>
                    </tr>
					 <tr>
                      <td>Shipping City</td>
                      <td><?php echo $GetOrder['ship_city'];?></td>
                    </tr>
					 <tr>
                      <td>Shipping State</td>
                      <td><?php echo $GetOrder['ship_state'];?></td>
                    </tr>
					 <tr>
                      <td>Shipping Country </td>
                      <td><?php
		      $GetCntry=$objCountry->GetRowContent($GetOrder['ship_country']);
		      echo $GetCntry['name']; ?>
		      </td>
                    </tr>

					 <tr>
                      <td>Shipping Phone</td>
                      <td><?php echo $GetOrder['ship_phone'];?></td>
                    </tr>
					<tr>
                      <td>Shipping Email</td>
                      <td><?php echo $GetOrder['ship_email'];?></td>
                    </tr>
					<?php if($GetOrder['transactionid']){ ?>
					<tr>
                      <td>Transaction No.</td>
                      <td>
					  <?php echo $GetOrder['transactionid'];?>
					</td>
					</tr>
					<?php } ?>
			<tr>
                      <td>Remark</td>
                      <td>
					  <?php echo $GetOrder['remark'];?>
					</td>
					</tr>
                      <tr>
                    <td>Status</td>
		      <td><?php echo $GetOrder['status'];?></td>
                    </tr>
	    
		    <tr>
			<td>Special note about order</td>
			<td><textarea class="ckeditor" name="speal_note" cols="10" rows="10"><?php disp_var($GetOrder['speal_note']); ?></textarea></td>
		    </tr>
		    <tr>
			<td>Payment receipt on</td>
			<td>
			    <input type="text" placeholder="Payment receipt on" class="form-control" name="recept_on" value="<?php echo $GetOrder['recept_on'];?>" />
			</td>
		    </tr>
		    <tr>
			<td>Payment receipt by</td>
			<td>
			    <input type="text" placeholder="Payment receipt by" class="form-control" name="recept_by" value="<?php echo $GetOrder['recept_by'];?>" />
			</td>
		    </tr>
		    <tr>
			<td>Payment Receipt number</td>
			<td>
			    <input type="text" placeholder="Payment Receipt number" class="form-control" name="recept_no" value="<?php echo $GetOrder['recept_no'];?>" />
			</td>
		    </tr>
		    <tr>
			<td>Shipment sent though</td>
			<td>
			    <input type="text" placeholder="Shipment sent though" class="form-control" name="shipment_sent_through" value="<?php echo $GetOrder['shipment_sent_through'];?>"/>
			</td>
		    </tr>
		    <tr>
			<td>Shipment number</td>
			<td>
			    <input type="text" placeholder="Shipment number" class="form-control" name="shipment_no" value="<?php echo $GetOrder['shipment_no'];?>"/>
			</td>
		    </tr>
		    <tr>
			<td></td>
			<td>
			   <a href="view_orders.php" class="btn btn-primary">Back</a>
			   <input type="submit" name="submit" value="save" class="btn btn-primary">
			</td>
		    </tr>
					
                </table>
  </form>
	
<?php include 'footer.php';?>