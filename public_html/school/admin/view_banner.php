<?php
ob_start();
include 'header.php';
$objBanner = load_class('Banner');

$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {

    $objBanner->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
if (isset($_POST['change_disp_pos'])) {
    $objBanner->ChangePosition($_POST['cur_disp_pos'], $_POST['change_disp_pos']);
}
$GetAllBanner = $objBanner->SelectAll();
$getBannerCount = count($GetAllBanner);
?>

    <div class="page-content">
        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1>View Category

                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active"><a href="<?php echo currenturl() ?>">Banner</a></li>
                        <li class="active"><a href="<?php echo currenturl() ?>">View Banner</a></li>
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
                            <h4>View Category</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <?php if(!empty($GetAllBanner)){ ?>
                                <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>

                                        <th>Title </th>
										<th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    for ($i = 0; $i < count($GetAllBanner); $i++) {


                                        ?>
                                        <tr class="odd gradx">
                                            <td><?php echo $GetAllBanner[$i]['title'] ?></td>
                                            <td class="center"><img src="<?php echo "../multimedia/banner/".$GetAllBanner[$i]['image'] ?>" width="50"></td>
                                            <td><?php echo $GetAllBanner[$i]['description'] ?></td>
											<td>
												<form name="frmDisplay" method="post" style="width: 50px;float:left;margin:0 10px 0 0">
													<input type="hidden" name="cur_disp_pos" value="<?php echo $GetAllBanner[$i]['display_order'] ?>">
													<?php
														echo "<select clas='form-control' style='width:50px' name='change_disp_pos' onChange='this.form.submit()'>";
														for ($j = 1; $j <= $getBannerCount; $j++) {
															if ($GetAllBanner[$i]['display_order'] == $j) {
																$selected = 'selected';
															} else {
																$selected = '';
															}
															echo '<option ' . $selected . ' value="' . $j . '">' . $j . '</option>';
														}
														echo '</select>';
													?>
												</form>
											</td>
                                            <td class="center">
                                                <a  href="add_edit_banner.php?id=<?php echo $GetAllBanner[$i]['id'] ?>"><i class="fa fa-edit"></i></a>
                                                <a  href="#" onclick="delportfolio('<?php echo $GetAllBanner[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                    ?>
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
            var agree = confirm("Are you sure you want to delete this Banner?");
            if (agree) {
                document.getElementById("hidDelete").value = id;
                thisform.submit();
            } else {
                return false;
            }
        }
    </script>

