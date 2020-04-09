<?php
ob_start();
include 'header.php';
$ObjProduct= load_class('Product');
$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {
    $ObjProduct->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}

$getallProduct = $ObjProduct->SelectAll();
$getCount = count($getallProduct);
?>
	<div class="page-content">
		<!-- begin PAGE TITLE ROW -->
			<div class="row">
				<div class="col-lg-12">
					<div class="page-title">
						<h1>View Product
                                
                            </h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                                </li>
                                <li class="active"><a href="<?php echo currenturl() ?>">Product</a></li>
                                 <li class="active"><a href="<?php echo currenturl() ?>">View Product</a></li>
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
                                <?php if(!empty($getallProduct)){ ?>
                                    <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Product Code</th>
												<th>Image</th>
                                                <th>Added On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					<?php for ($i = 0; $i < count($getallProduct); $i++) {?>
                            <tr class="odd gradx">
                                <td><?php echo $getallProduct[$i]['title'] ?></td>
                                <td><?php echo $getallProduct[$i]['product_code'] ?></td>
								<td><img src="../multimedia/product/<?php echo $getallProduct[$i]['image']; ?>" width="60"></td>
                                <td class="center"><?php echo date_format_list($getallProduct[$i]['date_added']) ?></td>
								<td class="center">
									<a  href="add_edit_product.php?id=<?php echo $getallProduct[$i]['id'] ?>"><i class="fa fa-edit"></i></a> 
									<a  href="#" onclick="delportfolio('<?php echo $getallProduct[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
								</td>
							</tr>
					<?php }?>
                                        </tbody>
                                    </table>
                                    <?php }else{

                        echo '<tr class="odd gradx"><td colspan="5"><div class="alert alert-info">No results found</div></td></tr>';
                      } ?>
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