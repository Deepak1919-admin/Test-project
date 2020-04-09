<?php
ob_start();
//$page='view_menu';
include 'header.php';

$objshipping = load_class('ShippingCost');

$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {
    $getRowContent = $objshipping->GetRowContent($_REQUEST['hidDelete']);
    if($objshipping->DelRowContent($_REQUEST['hidDelete'])){
        unlink($upload_dir.$getRowContent['image']);
    }
    header("location:$pagename");
}

$GetAll = $objshipping->SelectAll();
?>
	<div class="page-content">
		<!-- begin PAGE TITLE ROW -->
		<div class="row">
			<div class="col-lg-12">
				<div class="page-title">
					<h1>View Shipping charge</h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active"><a href="<?php echo currenturl() ?>">Shipping charge</a></li>
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
                            <h4>View Shipping charge</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                            <?php
                            if($GetAll)
                            { ?>
                            <thead>
                                <tr>
                                    <th>Range From</th>
                                     <th>Range To</th>
                                     <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php for ($i = 0; $i < count($GetAll); $i++)
                            {?>
                            <tr>
                                <td><?php echo $GetAll[$i]['range_from'] ?></td>
                                <td><?php echo $GetAll[$i]['range_to'] ?></td>
                                <td><?php echo $GetAll[$i]['price'] ?></td>
                                <td class="center">
                                    <div style="float: left">
                                        <a  href="add_edit_shipping.php?id=<?php echo $GetAll[$i]['id'] ?>"><i class="fa fa-edit"></i></a>
                                        <a  href="#" onclick="delportfolio('<?php echo $GetAll[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php }
                            echo '</tbody>';
                            }else{
                                echo '<tr class="odd gradx"><td colspan="5"><div class="alert alert-info">No results found</div></td></tr>';
                                } ?>
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
function delportfolio(id, thisform){
	var agree = confirm("Are you sure you want to Fabric?");
	if (agree) {
		document.getElementById("hidDelete").value = id;
		thisform.submit();
	} else {
		return false;
	}
}
</script>


