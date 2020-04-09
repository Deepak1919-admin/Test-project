<?php
ob_start();
include 'header.php';
$objOrder = load_class('Order');
$objOrderDetails=load_class('OrderDetails');

$objCorporate = load_class('Corporate');
$objSchool = load_class('School');
$objUsers = load_class('Users');

$GetAllOrders = $objOrder->getLatest();
$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {
    $ObjProduct->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
if (isset($_POST['change_disp_pos'])) {
    $ObjProduct->ChangePosition($_POST['cur_disp_pos'], $_POST['change_disp_pos']);
}
// $getallProduct = $ObjProduct->SelectAll();
// $getCount = count($getallProduct);
?>

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
                    <li class="active"><a href="<?php echo currenturl() ?>">View Orders</a></li>
                </ol>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- end PAGE TITLE ROW -->

    <!-- begin ADVANCED TABLES ROW -->
    <div class="row">

        <div class="col-lg-12">

            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>View Product</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                            <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>product</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($GetAllOrders){

                                for ($i = 0; $i < count($GetAllOrders); $i++) {
									if($GetAllOrders[$i]['user_type'] == "school"){
										$user = $objSchool->GetRowContent($GetAllOrders[$i]['userid']);
										$userName = $user['name'];
									}
									if($GetAllOrders[$i]['user_type'] == "corporate"){
										$user = $objCorporate->GetRowContent($GetAllOrders[$i]['userid']);
										$userName = $user['name'];
									}
									if($GetAllOrders[$i]['user_type'] == "user"){
										$user = $objUsers->GetRowContent($GetAllOrders[$i]['userid']);
										$userName = $user['first_name'];
									}?>
                                    <tr class="odd gradx">
                                        <td><?php echo $userName; ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td><?php
                                            $pid = $GetAllOrders[$i]['id'];
                                            $Det = $objOrderDetails->SelectOrderDetails($pid);

                                            for($k=0;$k<count($Det);$k++) {
                                                $oid = $Det[$k]['orderid'];
                                                $qn = $Det[$k]['quantity'];
                                                $pr = $Det[$k]['price'];
                                                $oidarray = explode(",", $oid);
                                                $qnarray = explode(",", $qn);
                                                $prarray = explode(",", $pr);

                                                for ($j = 0; $j < count($oidarray); $j++) {
                                                    $oid1 = $oidarray[$j];
                                                    $price = number_format((float)$prarray[$j], 2, '.', '');

                                                    echo $name = $Det[$k]['pname'] . " ( Qnt: " . $qnarray[$j] . ", AED " . $price . " )<br> ";
                                                }}
                                            ?></td>
                                        <td><?php echo $GetAllOrders[$i]['total'] ?></td>
                                        <?php if ($GetAllOrders[$i]['status'] == "Paid") { ?>
                                            <td style="color:green;"><?php echo $GetAllOrders[$i]['status'] ?></td>
                                        <?php
                                        } else { ?>
                                            <td style="color:red;"><?php echo $GetAllOrders[$i]['status'] ?></td>
                                        <?php
                                        }
                                        ?>
                                        <td><?php echo $GetAllOrders[$i]['date'] ?></td>
                                        <td><?php echo $GetAllOrders[$i]['time'] ?></td>
                                        <td class="center">

                                            <a  href="view_order_detail.php?id=<?php echo $pid; ?>"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                }
                                ?>
                                </tbody>
                            </table>

                        <form name="frm1" action="">
                            <input type="hidden" id="hidDelete" name="hidDelete" value="" />
                        </form>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.portlet-body -->
            </div>
            <!-- /.portlet -->

        </div>
        <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

</div>
<?php include("footer.php"); ?>
<script>
    function delportfolio(id, thisform)
    {
        var agree = confirm("Are you sure you want to delete this Product?");
        if (agree) {
            document.getElementById("hidDelete").value = id;
            thisform.submit();
        } else {
            return false;
        }
    }
</script>